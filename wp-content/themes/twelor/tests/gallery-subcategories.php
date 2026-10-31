<?php
// Run with the local site's PHP configuration. Fixtures are rolled back.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
define('WP_ADMIN', true);
require dirname(__DIR__, 4) . '/wp-load.php';

function check_subcategories($condition, $message) {
    if (!$condition) {
        throw new RuntimeException($message);
    }
    echo "PASS: $message\n";
}

global $wpdb;
foreach (array($wpdb->posts, $wpdb->postmeta, $wpdb->options) as $table) {
    $engine = $wpdb->get_var($wpdb->prepare(
        'SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = %s', $table
    ));
    if ($engine !== 'InnoDB') {
        throw new RuntimeException('Transactional tables are required for this test.');
    }
}
if (wp_using_ext_object_cache()) {
    throw new RuntimeException('Run against a local site without persistent object caching.');
}

$wpdb->query('START TRANSACTION');
try {
    $prefix = 'test-subcategories-' . bin2hex(random_bytes(5));
    $first = $prefix . '-first';
    $second = $prefix . '-second';
    $renamed = $prefix . '-renamed';
    $field = acf_get_field('field_gallery_sub_category');
    check_subcategories($field['type'] === 'checkbox', 'ACF field accepts multiple selections');

    $courses = array();
    foreach (array($first => 'First course', $second => 'Second course') as $slug => $name) {
        $id = wp_insert_post(array('post_type' => 'course', 'post_status' => 'publish', 'post_title' => $prefix));
        update_field('field_course_main_category', 'hand', $id);
        update_field('field_course_slug', $slug, $id);
        update_field('field_course', $name, $id);
        $courses[$slug] = $id;
    }
    $fixtures = array();
    foreach (array('legacy' => $first, 'multi' => array($first, $second), 'prefix' => array($first . '-extra')) as $kind => $value) {
        $id = wp_insert_post(array('post_type' => 'gallery', 'post_status' => 'publish', 'post_title' => $prefix . '-' . $kind));
        update_field('field_gallery_main_category', 'hand', $id);
        update_post_meta($id, 'gallery_display_gallery', '1');
        update_post_meta($id, '_gallery_sub_category', 'field_gallery_sub_category');
        update_post_meta($id, 'gallery_sub_category', $value);
        $fixtures[$kind] = $id;
    }
    check_subcategories(get_field('gallery_sub_category', $fixtures['legacy']) === array($first), 'Legacy scalar is preserved as one checked value');
    acf_save_post($fixtures['multi'], array('field_gallery_sub_category' => array($first, $second)));
    check_subcategories(get_post_meta($fixtures['multi'], 'gallery_sub_category', true) === array($first, $second), 'ACF saves both selections');

    $field['value'] = get_field('gallery_sub_category', $fixtures['multi']);
    $field['choices'] = array($first => 'First course', $second => 'Second course');
    $field['name'] = 'acf[field_gallery_sub_category]';
    ob_start();
    acf_render_field($field);
    $html = ob_get_clean();
    check_subcategories(substr_count($html, 'type="checkbox"') === 2 && substr_count($html, 'checked="checked"') === 2, 'Editor renders two checked checkboxes');

    $results = twelor_get_gallery_page_posts('hand', $first, -1);
    $ids = wp_list_pluck($results->posts, 'ID');
    check_subcategories(in_array($fixtures['legacy'], $ids) && in_array($fixtures['multi'], $ids), 'Category search finds both old and new storage formats');
    check_subcategories(!in_array($fixtures['prefix'], $ids), 'Search excludes partial slug matches');
    check_subcategories(count($ids) === 2, 'Matching gallery appears only once');
    $ids = wp_list_pluck(twelor_get_gallery_page_posts('hand', $second, -1)->posts, 'ID');
    check_subcategories($ids === array($fixtures['multi']), 'Gallery also appears in its second category');
    update_post_meta($fixtures['multi'], 'gallery_display_gallery', '0');
    check_subcategories(twelor_get_gallery_page_posts('hand', $second, -1)->post_count === 0, 'Hidden galleries remain hidden');
    update_post_meta($fixtures['multi'], 'gallery_display_gallery', '1');
    check_subcategories(twelor_get_sub_category_display_name_by_value('hand', array($first, $second)) === 'First course / Second course', 'Both category names display');
    $list_ids = wp_list_pluck(twelor_get_gallery_page_posts('hand', 'list', -1)->posts, 'ID');
    check_subcategories(count(array_intersect($list_ids, $fixtures)) === 3, 'All-categories list still includes every visible gallery');

    global $pagenow, $typenow, $wp_the_query;
    $pagenow = 'edit.php';
    $typenow = 'gallery';
    $_GET['main_category'] = 'hand';
    $_GET['sub_category'] = $second;
    $wp_the_query = new WP_Query();
    $wp_the_query->query(array('post_type' => 'gallery', 'posts_per_page' => -1));
    check_subcategories(wp_list_pluck($wp_the_query->posts, 'ID') === array($fixtures['multi']), 'Admin category filter includes multi-category galleries');
    check_subcategories(isset(twelor_get_course_choices('hand')[$first]), 'Admin filter does not interfere with course choices');
    unset($_GET['main_category'], $_GET['sub_category']);
    $pagenow = '';
    $typenow = '';

    acf_save_post($courses[$first], array('field_course_slug' => $renamed));
    check_subcategories(get_post_meta($fixtures['multi'], 'gallery_sub_category', true) === array($renamed, $second), 'Renaming one category preserves the other selection');
    check_subcategories(get_post_meta($fixtures['legacy'], 'gallery_sub_category', true) === array($renamed), 'Renaming also updates legacy single values');
    check_subcategories(twelor_get_gallery_page_posts('hand', $first, -1)->post_count === 0, 'Old slug no longer matches');
    wp_trash_post($courses[$first]);
    check_subcategories(get_post_meta($fixtures['multi'], 'gallery_sub_category', true) === array($second), 'Trashing one category preserves the other selection');
    check_subcategories(get_post_meta($fixtures['legacy'], 'gallery_sub_category', true) === array(), 'Removing the last category leaves an empty selection');
    check_subcategories(get_post_meta($fixtures['multi'], 'gallery_display_gallery', true) === '1', 'Category removal preserves visibility setting');
    wp_delete_post($courses[$second], true);
    check_subcategories(get_post_meta($fixtures['multi'], 'gallery_sub_category', true) === array(), 'Permanent category deletion removes only its assignment');

    // Switching the main category also changes cardinality and editor controls.
    foreach (array('foot', 'arts-parts') as $main_category) {
        $_POST['acf'] = array('field_gallery_main_category' => $main_category);
        $single_field = twelor_load_gallery_sub_category_choices(array_replace($field, array('name' => 'gallery_sub_category')));
        check_subcategories($single_field['type'] === 'radio', "$main_category uses single-select radio controls");
        $single_field['choices'] = array($first => 'First course', $second => 'Second course');
        $single_field['value'] = $first;
        ob_start();
        acf_render_field($single_field);
        $html = ob_get_clean();
        check_subcategories(substr_count($html, 'type="radio"') === 2 && substr_count($html, 'checked="checked"') === 1, "$main_category renders one selected radio");
        acf_save_post($fixtures['multi'], array(
            'field_gallery_main_category' => $main_category,
            'field_gallery_sub_category' => array($first, $second),
        ));
        check_subcategories(get_post_meta($fixtures['multi'], 'gallery_sub_category', true) === $first, "$main_category persists only one selection");
    }
    acf_save_post($fixtures['multi'], array(
        'field_gallery_main_category' => 'hand',
        'field_gallery_sub_category' => array($first, $second),
    ));
    check_subcategories(get_post_meta($fixtures['multi'], 'gallery_sub_category', true) === array($first, $second), 'Switching back to HAND restores multiple selection');
    check_subcategories(twelor_load_gallery_sub_category_choices(array_replace($field, array('name' => 'gallery_sub_category')))['type'] === 'checkbox', 'HAND renders checkbox controls after switching');
} catch (Throwable $error) {
    $failure = $error;
} finally {
    $wpdb->query('ROLLBACK');
    echo "Test fixtures rolled back.\n";
}
if (isset($failure)) {
    fwrite(STDERR, $failure->getMessage() . "\n");
    exit(1);
}
