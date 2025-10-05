<?php
/**
 * twelor テーマの機能
 */

// テーマのセットアップ
function twelor_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
   
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
   
    // メニューの登録
    register_nav_menus(array(
        'primary' => __('ヘッダーメニュー', 'twelor'),
        'footer_menu' => __('フッターメニュー', 'twelor'),
        'footer_design' => __('フッターデザイン', 'twelor'),
    ));
}
add_action('after_setup_theme', 'twelor_setup');

// スタイルシートとスクリプトの読み込み
function twelor_scripts() {
    // Google Fonts - Lobster
    wp_enqueue_style('google-fonts-lobster', 'https://fonts.googleapis.com/css2?family=Lobster&display=swap', array(), null);
   
    // Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
   
    // テーマのスタイルシート
    wp_enqueue_style('twelor-style', get_stylesheet_uri(), array(), '1.0.0');
   
    // カスタムCSS
    wp_enqueue_style('twelor-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0.0');
   
    // Bootstrap JavaScript
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
   
    // カスタムJavaScript
    wp_enqueue_script('twelor-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'twelor_scripts');

// デフォルトの管理メニューを削除
function twelor_remove_default_menu_items() {
    remove_menu_page('edit.php');           // 投稿
    remove_menu_page('edit-comments.php');  // コメント
}
add_action('admin_menu', 'twelor_remove_default_menu_items');

// タイトルプレイスホルダーのカスタマイズ
function twelor_change_title_placeholder($title, $post) {
    if ($post->post_type === 'gallery') {
        $title = 'ギャラリー名を入力';
    } elseif ($post->post_type === 'coupon') {
        $title = 'クーポン名称を入力';
    } elseif ($post->post_type === 'banner') {
        $title = 'バナー名を入力';
    } elseif ($post->post_type === 'home') {
        $title = 'SEOに適した画像タイトル入力(例：パラジェル専門店 twelor)';
    }
    return $title;
}
add_filter('enter_title_here', 'twelor_change_title_placeholder', 10, 2);

// Intuitive Custom Post Order プラグインのサポート
function twelor_enable_custom_post_order() {
    add_post_type_support('gallery', 'page-attributes');
    add_post_type_support('coupon', 'page-attributes');
    add_post_type_support('qa', 'page-attributes');
}
add_action('init', 'twelor_enable_custom_post_order');

// カスタム投稿タイプ: ギャラリー
function twelor_register_gallery_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'ギャラリー',
        'labels' => array(
            'name' => 'ギャラリー',
            'singular_name' => 'ギャラリー',
            'add_new' => '新規追加',
            'add_new_item' => '新規ギャラリーを追加',
            'edit_item' => 'ギャラリーを編集',
        ),
        'supports' => array('title', 'thumbnail','page-attributes'),
        'menu_icon' => 'dashicons-format-gallery',
        'has_archive' => true,
        'rewrite' => array('slug' => 'gallery'),
        'hierarchical' => false,
        'show_in_menu' => true,
    );
    register_post_type('gallery', $args);
}
add_action('init', 'twelor_register_gallery_post_type');

// カスタム投稿タイプ: サブカテゴリー
function twelor_register_course_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'サブカテゴリー',
        'labels' => array(
            'name' => 'サブカテゴリー',
            'singular_name' => 'サブカテゴリー',
            'add_new' => '新規追加',
            'add_new_item' => 'サブカテゴリーを追加',
            'edit_item' => 'サブカテゴリーを編集',
        ),
        'supports' => array('custom-fields'),
        'menu_icon' => 'dashicons-category',
        'has_archive' => true,
        'rewrite' => array('slug' => 'course'),
        'hierarchical' => false,
        'show_in_menu' => true,
    );
    register_post_type('course', $args);
}
add_action('init', 'twelor_register_course_post_type');

// サブカテゴリーを取得する関数
function twelor_get_course_choices($main_category) {
    $choices = array();
   
    $courses = get_posts(array(
        'post_type' => 'course',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'course_main_category',
                'value' => $main_category,
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));
   
    foreach ($courses as $course) {
        $course_name = get_field('course_name', $course->ID);
        $course_slug = get_field('course_slug', $course->ID);
        $choices[$course_slug] = $course_name;
    }
   
    return $choices;
}

// サブカテゴリー名を取得する関数
function twelor_get_sub_category_name($main_category, $sub_category) {
    $choices = twelor_get_course_choices($main_category);
    return isset($choices[$sub_category]) ? $choices[$sub_category] : $sub_category;
}

// メインカテゴリー名を取得する関数
function twelor_get_main_category_name($main_category) {
    $categories = array(
        'hand' => 'Hand Design',
        'foot' => 'Foot Design',
        'guest' => 'Guest Design',
        'arts-parts' => 'Arts & Parts'
    );
    return isset($categories[$main_category]) ? $categories[$main_category] : $main_category;
}


// カスタム投稿タイプ: クーポン
function twelor_register_coupon_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'クーポン',
        'labels' => array(
            'name' => 'クーポン',
            'singular_name' => 'クーポン',
            'add_new' => '新規追加',
            'add_new_item' => '新規クーポンを追加',
            'edit_item' => 'クーポンを編集',
        ),
        'supports' => array('title', 'thumbnail', 'page-attributes'),
        'menu_icon' => 'dashicons-tickets-alt',
        'has_archive' => true,
        'rewrite' => array('slug' => 'coupons'),
    );
    register_post_type('coupon', $args);
}
add_action('init', 'twelor_register_coupon_post_type');

// カスタム投稿タイプ: お知らせ
function twelor_register_info_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'お知らせ',
        'labels' => array(
            'name' => 'お知らせ',
            'singular_name' => 'お知らせ',
            'add_new' => '新規追加',
            'add_new_item' => '新規お知らせを追加',
            'edit_item' => 'お知らせを編集',
        ),
        'supports' => array('custom-fields'),
        'menu_icon' => 'dashicons-megaphone',
        'has_archive' => true,
        'rewrite' => array('slug' => 'info'),
    );
    register_post_type('info', $args);
}
add_action('init', 'twelor_register_info_post_type');

// カスタム投稿タイプ: ネイリスト
function twelor_register_nailist_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'ネイリスト',
        'labels' => array(
            'name' => 'ネイリスト',
            'singular_name' => 'ネイリスト',
            'add_new' => '新規追加',
            'add_new_item' => '新規ネイリストを追加',
            'edit_item' => 'ネイリストを編集',
        ),
        'supports' => array('custom-fields', 'page-attributes'),
        'menu_icon' => 'dashicons-admin-users',
        'has_archive' => true,
        'rewrite' => array('slug' => 'nailist'),
        'hierarchical' => false,
    );
    register_post_type('nailist', $args);
}
add_action('init', 'twelor_register_nailist_post_type');

// ネイリストの選択肢を動的に生成する関数
function twelor_get_nailist_choices() {
    $choices = array();
   
    $nailists = get_posts(array(
        'post_type' => 'nailist',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));
   
    foreach ($nailists as $nailist) {
        $nailist_name = get_field('nailist_name', $nailist->ID);
        $roman_slug = get_field('nailist_slug', $nailist->ID);
        $choices[$roman_slug] = $nailist_name;
    }
   
    return $choices;
}

// カスタム投稿タイプ: バナー
function twelor_register_banner_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'バナー',
        'labels' => array(
            'name' => 'バナー',
            'singular_name' => 'バナー',
            'add_new' => '新規追加',
            'add_new_item' => '新規バナーを追加',
            'edit_item' => 'バナーを編集',
        ),
        'supports' => array('title', 'thumbnail', 'custom-fields', 'page-attributes'),
        'menu_icon' => 'dashicons-images-alt2',
        'has_archive' => false,
        'rewrite' => array('slug' => 'banner'),
        'show_in_menu' => true,
        'hierarchical' => false,
    );
    register_post_type('banner', $args);
}
add_action('init', 'twelor_register_banner_post_type');

// バナーの取得用関数
function twelor_get_banner_posts() {
    $args = array(
        'post_type' => 'banner',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    return get_posts($args);
}

// カスタム投稿タイプ: Q&A
function twelor_register_qa_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Q&A',
        'labels' => array(
            'name' => 'Q&A',
            'singular_name' => 'Q&A',
            'add_new' => '新規追加',
            'add_new_item' => '新規Q&Aを追加',
            'edit_item' => 'Q&Aを編集',
        ),
        'supports' => array('custom-fields'),
        'menu_icon' => 'dashicons-editor-help',
        'has_archive' => true,
        'rewrite' => array('slug' => 'qa'),
        'show_in_menu' => true,
    );
    register_post_type('qa', $args);
}
add_action('init', 'twelor_register_qa_post_type');

// カスタム投稿タイプ: ホーム画像
function twelor_register_home_image_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'ホーム画像',
        'labels' => array(
            'name' => 'ホーム画像',
            'singular_name' => 'ホーム画像',
            'add_new' => '新規追加',
            'add_new_item' => '新規ホーム画像を追加',
            'edit_item' => 'ホーム画像を編集',
        ),
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-home',
        'has_archive' => true,
        'rewrite' => array('slug' => 'home'),
        'show_in_menu' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
    );
    register_post_type('home', $args);
}
add_action('init', 'twelor_register_home_image_post_type');

// ホーム画像の登録を1つに制限
function twelor_limit_home_image_posts() {
    global $typenow, $pagenow;

    if($typenow === 'home' && $pagenow === 'post-new.php') {
        $existing_posts = get_posts(array(
            'post_type' => 'home',
            'posts_per_page' => 1,
            'post_status' => array('publish', 'draft', 'pending'),
        ));
       
        if(!empty($existing_posts)) {
           wp_die(
                'ホーム画像は既に登録されています。新しい画像を登録するには、既存のホーム画像を編集または削除してください。',
                'ホーム画像の制限',
                array('back_link' => true)
           );
        }
    }
}
add_action('admin_init', 'twelor_limit_home_image_posts');

// ホーム画像を取得する関数
function twelor_get_home_image() {
    $home_images = get_posts(array(
        'post_type' => 'home',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
    ));
   
    if (!empty($home_images)) {
        return $home_images[0];
    }
    return null;
}

// ACFフィールドの登録
function twelor_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        // ギャラリー用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_gallery',
            'title' => 'ギャラリー設定',
            'fields' => array(
                array(
                    'key' => 'field_gallery_main_category',
                    'label' => 'メインカテゴリー',
                    'name' => 'gallery_main_category',
                    'type' => 'radio',
                    'required' => 1,
                    'choices' => array(
                        'hand' => 'Handデザイン',
                        'foot' => 'Footデザイン',
                        'guest' => 'Guestデザイン',
                        'arts-parts' => 'アートパーツ'
                    ),
                    'return_format' => 'value',
                    'layout' => 'vertical'
                ),
                array(
                    'key' => 'field_gallery_sub_category',
                    'label' => 'サブカテゴリー',
                    'name' => 'gallery_sub_category',
                    'type' => 'radio',
                    'required' => 1,
                    'choices' => array(),
                    'return_format' => 'value',
                    'layout' => 'vertical'
                ),
                array(
                    'key' => 'field_gallery_is_bridal',
                    'label' => 'ブライダルデザイン',
                    'name' => 'gallery_is_bridal',
                    'type' => 'true_false',
                    'instructions' => 'ブライダルデザインとしても登録する場合はチェックしてください',
                    'required' => 0,
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => 'はい',
                    'ui_off_text' => 'いいえ',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_gallery_main_category',
                                'operator' => '==',
                                'value' => 'hand',
                            ),
                        ),
                    ),
                ),
                array(
                    'key' => 'field_gallery_description',
                    'label' => '説明',
                    'name' => 'gallery_description',
                    'type' => 'textarea',
                    'instructions' => 'ギャラリーの説明を入力してください',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_gallery_display_top',
                    'label' => 'トップページに表示',
                    'name' => 'gallery_display_top',
                    'type' => 'true_false',
                    'instructions' => 'トップページに表示する場合はチェックしてください',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                    'ui_on_text' => '表示する',
                    'ui_off_text' => '表示しない'
                ),
                array(
                    'key' => 'field_gallery_display_gallery',
                    'label' => 'ギャラリーページに表示',
                    'name' => 'gallery_display_gallery',
                    'type' => 'true_false',
                    'instructions' => 'ギャラリーページに表示する場合はチェックしてください',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                    'ui_on_text' => '表示する',
                    'ui_off_text' => '表示しない'
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'gallery',
                    ),
                ),
            ),
        ));

        // サブカテゴリーフィールド
        acf_add_local_field_group(array(
            'key' => 'group_course',
            'title' => 'サブカテゴリー詳細',
            'fields' => array(
                array(
                    'key' => 'field_course_main_category',
                    'label' => 'メインカテゴリー',
                    'name' => 'course_main_category',
                    'type' => 'radio',
                    'required' => 1,
                    'choices' => array(
                        'hand' => 'Handデザイン',
                        'foot' => 'Footデザイン',
                        'guest' => 'Guestデザイン',
                        'arts-parts' => 'アートパーツ',
                    ),
                    'return_format' => 'value',
                    'layout' => 'vertical'
                ),
                array(
                    'key' => 'field_course',
                    'label' => 'サブカテゴリー名',
                    'name' => 'course_name',
                    'type' => 'text',
                    'instructions' => 'サブカテゴリー名を入力してください',
                    'required' => 1,
                    'placeholder' => '例: シンプル 定額,ニュアンスM 定額'
                ),
                array(
                    'key' => 'field_course_slug',
                    'label' => 'スラッグ',
                    'name' => 'course_slug',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => 'URLに使う半角英数字・ハイフンのみ',
                    'placeholder' => '例: simple,popular'
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'course',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        // お知らせ用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_info',
            'title' => 'お知らせ詳細',
            'fields' => array(
                array(
                    'key' => 'field_info_period',
                    'label' => '日付',
                    'name' => 'info_period',
                    'type' => 'date_picker',
                    'required' => 1,
                    'display_format' => 'Y/m/d',
                    'return_format' => 'Y/m/d',
                ),
                array(
                    'key' => 'field_info_description',
                    'label' => '案内文',
                    'name' => 'info_description',
                    'type' => 'textarea',
                    'required' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'info',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        // バナー用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_banner',
            'title' => 'バナー詳細',
            'fields' => array(
                array(
                    'key' => 'field_banner_url',
                    'label' => 'URL',
                    'name' => 'banner_url',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => '例: https://twelor.jp/coupon/tanaka/',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'banner',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        // ネイリスト用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_nailist',
            'title' => 'ネイリスト設定',
            'fields' => array(
                array(
                    'key' => 'field_nailist_name',
                    'label' => 'ネイリスト名',
                    'name' => 'nailist_name',
                    'type' => 'text',
                    'instructions' => 'ネイリストの名前を入力してください',
                    'required' => 1,
                    'placeholder' => '例: 田中,佐藤'
                ),
                array(
                    'key' => 'field_nailist_slug',
                    'label' => 'ローマ字スラッグ',
                    'name' => 'nailist_slug',
                    'type' => 'text',
                    'instructions' => 'URLに使う半角英数字・ハイフンのみ（例: tanaka, sato）。',
                    'required' => 1,
                    'placeholder' => '例: tanaka,sato'
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'nailist',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));

        acf_add_local_field_group(array(
            'key' => 'group_qa',
            'title' => 'Q&A詳細',
            'fields' => array(
                array(
                    'key' => 'field_qa_type',
                    'label' => '種別',
                    'name' => 'qa_type',
                    'type' => 'radio',
                    'choices' => array(
                        'service' => '施術について',
                        'reservation' => '予約について',
                        'other' => 'その他',
                    ),
                    'layout' => 'horizontal',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_qa_question',
                    'label' => '質問',
                    'name' => 'qa_question',
                    'type' => 'textarea',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_qa_answer',
                    'label' => '答え',
                    'name' => 'qa_answer',
                    'type' => 'textarea',
                    'required' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'qa',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
       
        // クーポン用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_coupon',
            'title' => 'クーポン詳細',
            'fields' => array(
                array(
                    'key' => 'field_coupon_nailist',
                    'label' => 'ネイリスト',
                    'name' => 'coupon_nailist',
                    'type' => 'checkbox',
                    'required' => 1,
                    'choices' => twelor_get_nailist_choices(),
                    'return_format' => 'value',
                    'layout' => 'vertical',
                    'allow_custom' => 0,
                    'save_custom' => 0,
                    'toggle' => 0,
                    'other_choice' => 0
                ),
                array(
                    'key' => 'field_coupon_price',
                    'label' => 'クーポン価格',
                    'name' => 'coupon_price',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => '例: 初回5510円/リピ6510円'
                ),
                array(
                    'key' => 'field_coupon_description',
                    'label' => '詳細',
                    'name' => 'coupon_description',
                    'type' => 'textarea',
                    'required' => 1,
                     'instructions' => '例: お色変更無料',
                ),
                array(
                    'key' => 'field_coupon_display_top',
                    'label' => 'トップページに表示',
                    'name' => 'coupon_display_top',
                    'type' => 'true_false',
                    'instructions' => 'トップページに表示する場合はチェックしてください',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                    'ui_on_text' => '表示する',
                    'ui_off_text' => '表示しない'
                ),
                array(
                    'key' => 'field_coupon_display_coupon',
                    'label' => 'クーポンページに表示',
                    'name' => 'coupon_display_coupon',
                    'type' => 'true_false',
                    'instructions' => 'クーポンページに表示する場合はチェックしてください',
                    'required' => 0,
                    'default_value' => 1,
                    'ui' => 1,
                    'ui_on_text' => '表示する',
                    'ui_off_text' => '表示しない'
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'coupon',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }
}

// ACFフィールドの選択肢を動的に更新
function twelor_load_gallery_sub_category_choices($field) {
    if ($field['name'] === 'gallery_sub_category') {
        // 現在選択されているメインカテゴリーを取得
        $main_category = '';
       
        // 編集画面の場合
        if (isset($_GET['post']) && $_GET['post']) {
            $main_category = get_field('gallery_main_category', $_GET['post']);
        }
        // 新規作成画面の場合
        elseif (isset($_POST['acf']['field_gallery_main_category'])) {
            $main_category = $_POST['acf']['field_gallery_main_category'];
        }

        // メインカテゴリーが選択されている場合、対応するサブカテゴリーを取得
        if ($main_category) {
            $sub_categories = twelor_get_course_choices($main_category);
            $field['choices'] = $sub_categories;
        } else {
            // デフォルトでHandデザインのサブカテゴリーを表示
            $field['choices'] = twelor_get_course_choices('hand');
        }
    }
    return $field;
}
add_filter('acf/load_field/name=gallery_sub_category', 'twelor_load_gallery_sub_category_choices');

// ACFフィールドの選択肢を動的に更新
function twelor_load_nailist_field_choices($field) {
    if ($field['name'] === 'coupon_nailist') {
        $field['choices'] = twelor_get_nailist_choices();
    }
    return $field;
}
add_filter('acf/load_field/name=coupon_nailist', 'twelor_load_nailist_field_choices');

// nailist_slug バリデーション（半角英字小文字のみ）
function twelor_validate_nailist_slug($valid, $value, $field, $input) {
    if ($valid !== true) {
        return $valid;
    }
    if (!is_string($value)) {
        return 'ローマ字小文字（a〜z）のみで入力してください。';
    }
    if (!preg_match('/^[a-z]+$/', $value)) {
        return 'ローマ字小文字（a〜z）のみで入力してください。';
    }
    return $valid;
}
add_filter('acf/validate_value/key=field_nailist_slug', 'twelor_validate_nailist_slug', 10, 4);

function twelor_get_nailist_display_name_by_value($value) {
    // choices（ローマ字スラッグ or post_name キー）に存在すればその表示名を返す
    $choices = twelor_get_nailist_choices();
    if (isset($choices[$value])) {
        return $choices[$value];
    }
    return;
}

// ネイリスト保存時にタイトルを同期
function twelor_auto_generate_nailist_slug($post_id) {
    if (get_post_type($post_id) !== 'nailist') {
        return;
    }
   
    // 無限ループを防ぐ
    remove_action('save_post', 'twelor_auto_generate_nailist_slug');
   
    $nailist_name = get_field('nailist_name', $post_id);
    $nailist_slug = get_field('nailist_slug', $post_id);
   
    if (!empty($nailist_name)) {
        wp_update_post(array(
            'ID' => $post_id,
            'post_title' => $nailist_name,
            'post_name' => $nailist_slug,
        ));
    }
   
    // アクションを再度追加
    add_action('save_post', 'twelor_auto_generate_nailist_slug');
}
add_action('save_post', 'twelor_auto_generate_nailist_slug');

// ネイリスト削除時、割り当て済みクーポンからネイリストの値を削除
function twelor_remove_nailist_from_coupons_on_delete($post_id) {
    if (get_post_type($post_id) !== 'nailist') return;
    $post = get_post($post_id);
    $slug = $post ? $post->post_name : '';
    
    $query = new WP_Query(array(
        'post_type' => 'coupon',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'coupon_nailist',
                'value' => (string)$post_id,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'coupon_nailist',
                'value' => $slug,
                'compare' => 'LIKE'
            )
        ),
        'fields' => 'ids'
    ));
    
    if ($query->have_posts()) {
        foreach ($query->posts as $coupon_id) {
            $current_nailists = get_field('coupon_nailist', $coupon_id);
            
            if (is_array($current_nailists)) {
                // 配列から該当するネイリストを削除
                $updated_nailists = array();
                foreach ($current_nailists as $nailist_value) {
                    if ($nailist_value !== (string)$post_id && $nailist_value !== $slug) {
                        $updated_nailists[] = $nailist_value;
                    }
                }
                
                // 更新されたネイリストリストを保存
                if (empty($updated_nailists)) {
                    // ネイリストが空になった場合は空の配列を保存
                    update_field('coupon_nailist', array(), $coupon_id);
                } else {
                    update_field('coupon_nailist', $updated_nailists, $coupon_id);
                }
            } else {
                // 単一値の場合
                if ($current_nailists === (string)$post_id || $current_nailists === $slug) {
                    update_field('coupon_nailist', array(), $coupon_id);
                }
            }
        }
    }
}
add_action('before_delete_post', 'twelor_remove_nailist_from_coupons_on_delete');
add_action('trashed_post', 'twelor_remove_nailist_from_coupons_on_delete');

// デフォルトのクエリでカスタムオーダーを使用
function twelor_set_default_gallery_order($query) {
    // 管理画面ではない場合のみ適用
    if (!is_admin() && $query->is_main_query()) {
        // ギャラリーのアーカイブページまたはカスタムクエリの場合
        if (is_post_type_archive('gallery') || $query->get('post_type') === 'gallery') {
            $query->set('orderby', 'menu_order');
            $query->set('order', 'ASC');
        }
        // クーポンの場合
        if (is_post_type_archive('coupon') || $query->get('post_type') === 'coupon') {
            $query->set('orderby', 'menu_order');
            $query->set('order', 'ASC');
        }
        // バナーの場合
        if (is_post_type_archive('banner') || $query->get('post_type') === 'banner') {
            $query->set('orderby', 'menu_order');
            $query->set('order', 'ASC');
        }
    }
}
add_action('pre_get_posts', 'twelor_set_default_gallery_order');

// 明示的な並び順指定がないときでも管理画面の投稿一覧でカスタムオーダーを適用
function twelor_admin_gallery_order($query) {
    if (is_admin() && $query->is_main_query()) {
        $post_type = $query->get('post_type');
       
        if (in_array($post_type, array('gallery', 'coupon', 'banner', 'nailist'))) {
            if (!$query->get('orderby')) {
                $query->set('orderby', 'menu_order');
                $query->set('order', 'ASC');
            }
        }
    }
}
add_action('pre_get_posts', 'twelor_admin_gallery_order');

// ギャラリーのメインカテゴリー,サブカテゴリー連動機能用JavaScript
function twelor_gallery_category_script() {
    if (get_post_type() !== 'gallery') return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        function updateSubCategories() {
            const mainSelected = $('[name="acf[field_gallery_main_category]"]:checked').val();
            const $subCategories = $('[name="acf[field_gallery_sub_category]"]');
           
            if (mainSelected) {
                const currentlySelected = $subCategories.filter(':checked').val();
               
                // AJAXでサブカテゴリーを取得
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'get_course_choices',
                        main_type: mainSelected,
                        nonce: '<?php echo wp_create_nonce("get_course_choices"); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // 既存の選択肢をクリア
                            $subCategories.prop('checked', false);
                           
                            // サブカテゴリーの選択肢を完全に再構築
                            const $subCategoryContainer = $subCategories.first().closest('.acf-field-radio');
                            const $ul = $subCategoryContainer.find('ul.acf-radio-list');
                            
                            // 既存の選択肢をクリア
                            $ul.empty();
                            
                            // 新しい選択肢を追加
                            $.each(response.data, function(value, label) {
                                const $li = $('<li>');
                                const $label = $('<label>');
                                const $input = $('<input>', {
                                    type: 'radio',
                                    name: 'acf[field_gallery_sub_category]',
                                    value: value
                                });
                                
                                $label.append($input);
                                $label.append('<span>' + label + '</span>');
                                $li.append($label);
                                $ul.append($li);
                            });
                            
                            // 更新されたサブカテゴリーの要素を再取得
                            const $newSubCategories = $('[name="acf[field_gallery_sub_category]"]');
                           
                            // 以前選択されていたサブカテゴリーが利用可能な場合は選択を維持
                            if (currentlySelected && $newSubCategories.filter('[value="' + currentlySelected + '"]').length > 0) {
                                $newSubCategories.filter('[value="' + currentlySelected + '"]').prop('checked', true);
                            } else {
                                // 最初のサブカテゴリーを選択
                                const firstVisible = $newSubCategories.first();
                                if (firstVisible.length) {
                                    firstVisible.prop('checked', true);
                                }
                            }
                        }
                    }
                });
            } else {
                // メインカテゴリーが選択されていない場合、サブカテゴリーをクリア
                const $subCategoryContainer = $subCategories.first().closest('.acf-field-radio');
                const $ul = $subCategoryContainer.find('ul.acf-radio-list');
                $ul.empty();
            }
        }

        // メインカテゴリーの変更時にサブカテゴリーを更新
        $('[name="acf[field_gallery_main_category]"]').on('change', updateSubCategories);

        // 初期表示時にも実行
        updateSubCategories();
    });
    </script>
    <?php
}
add_action('admin_footer-post.php', 'twelor_gallery_category_script');
add_action('admin_footer-post-new.php', 'twelor_gallery_category_script');

# -------------------------------
# 管理画面一覧のカスタマイズ
# -------------------------------
// ギャラリー一覧のカラムをカスタマイズ
function twelor_add_gallery_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['thumbnail'] = '画像';
        }
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['menu_order'] = '表示順';
        }
    }
    $new_columns['display_settings'] = '表示設定';
    $new_columns['main_category'] = 'メインカテゴリー';
    $new_columns['sub_category'] = 'サブカテゴリー';
    $new_columns['bridal'] = 'ブライダル';
    $new_columns['description'] = '説明';
    if (isset($new_columns['date'])) {
        $date = $new_columns['date'];
        unset($new_columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_gallery_posts_columns', 'twelor_add_gallery_columns');

// ギャラリー一覧のカラム内容を表示
function twelor_gallery_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    } elseif ($column_name === 'main_category') {
        $main_category = get_field('gallery_main_category', $post_id);
        $categories = array(
            'hand' => 'Handデザイン',
            'foot' => 'Footデザイン',
            'guest' => 'Guestデザイン',
            'arts-parts' => 'アートパーツ'
        );
        echo isset($categories[$main_category]) ? $categories[$main_category] : '';
    } elseif ($column_name === 'sub_category') {
        $main_category = get_field('gallery_main_category', $post_id);
        $sub_category = get_field('gallery_sub_category', $post_id);
        if ($main_category && $sub_category) {
            $sub_categories = twelor_get_course_choices($main_category);
            echo isset($sub_categories[$sub_category]) ? $sub_categories[$sub_category] : $sub_category;
        }
    } elseif ($column_name === 'display_settings') {
        $display_top = get_field('gallery_display_top', $post_id);
        $display_gallery = get_field('gallery_display_gallery', $post_id);
        $display_text = array();
        if ($display_top) {
            $display_text[] = 'トップページ';
        }
        if ($display_gallery) {
            $display_text[] = 'ギャラリーページ';
        }
        echo implode(' / ', $display_text);
    } elseif ($column_name === 'bridal') {
        $is_bridal = get_field('gallery_is_bridal', $post_id);
        echo $is_bridal ? '✓' : '－';
    } elseif ($column_name === 'description') {
        echo get_field('gallery_description', $post_id);
    }
}
add_action('manage_gallery_posts_custom_column', 'twelor_gallery_column_content', 10, 2);

// サブカテゴリー一覧のカラムをカスタマイズ
function twelor_add_course_columns($columns) {
    unset($columns['title']);
    $new_columns = array();
    $new_columns['menu_order'] = '表示順';
    $new_columns['course_main_category'] = 'メインカテゴリー名';
    $new_columns['course_name'] = 'サブカテゴリー名';
    $new_columns['course_slug'] = 'スラッグ';
    if (isset($columns['date'])) {
        $date = $columns['date'];
        unset($columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_course_posts_columns', 'twelor_add_course_columns');

// サブカテゴリー一覧のカラム内容を表示
function twelor_course_column_content($column_name, $post_id) {
    if ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    } elseif ($column_name === 'course_main_category') {
        $main_category = get_field('course_main_category', $post_id);
        $main_categories = array(
            'hand' => 'Handデザイン',
            'foot' => 'Footデザイン',
            'guest' => 'Guestデザイン',
            'arts-parts' => 'アートパーツ',
        );
        echo isset($main_categories[$main_category]) ? $main_categories[$main_category] : '';
    } elseif ($column_name === 'course_name') {
        echo get_field('course_name', $post_id);
    } elseif ($column_name === 'course_slug') {
        echo get_field('course_slug', $post_id);
    }
}
add_action('manage_course_posts_custom_column', 'twelor_course_column_content', 10, 2);

// クーポン一覧のカラムをカスタマイズ
function twelor_add_coupon_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['thumbnail'] = '画像';
        }
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['menu_order'] = '表示順';
        }
    }
    $new_columns['display_settings'] = '表示設定';
    $new_columns['nailist'] = 'ネイリスト';
    $new_columns['price'] = 'クーポン価格';
    $new_columns['description'] = '説明文';
    if (isset($new_columns['date'])) {
        $date = $new_columns['date'];
        unset($new_columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_coupon_posts_columns', 'twelor_add_coupon_columns');

// クーポン一覧のカラム内容を表示
function twelor_coupon_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'nailist') {
        $nailist_values = get_field('coupon_nailist', $post_id);
        if (is_array($nailist_values)) {
            $nailist_names = array();
            foreach ($nailist_values as $value) {
                $name = twelor_get_nailist_display_name_by_value($value);
                if ($name) {
                    $nailist_names[] = $name;
                }
            }
            echo esc_html(implode(', ', $nailist_names));
        } else {
            echo esc_html(twelor_get_nailist_display_name_by_value($nailist_values));
        }
    } elseif ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    } elseif ($column_name === 'price') {
        echo get_field('coupon_price', $post_id);
    } elseif ($column_name === 'description') {
        echo get_field('coupon_description', $post_id);
    } elseif ($column_name === 'display_settings') {
        $display_top = get_field('coupon_display_top', $post_id);
        $display_coupon = get_field('coupon_display_coupon', $post_id);
        $display_text = array();
        if ($display_top) {
            $display_text[] = 'トップページ';
        }
        if ($display_coupon) {
            $display_text[] = 'クーポンページ';
        }
        echo implode(' / ', $display_text);
    }
}
add_action('manage_coupon_posts_custom_column', 'twelor_coupon_column_content', 10, 2);

// ネイリスト一覧のカラムをカスタマイズ
function twelor_add_nailist_columns($columns) {
    unset($columns['title']);
    $new_columns = array();
    $new_columns['menu_order'] = '表示順';
    $new_columns['nailist_name'] = 'ネイリスト名';
    $new_columns['nailist_slug'] = 'ローマ字スラッグ';
    if (isset($columns['date'])) {
        $date = $columns['date'];
        unset($columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_nailist_posts_columns', 'twelor_add_nailist_columns');

// ネイリスト一覧のカラム内容を表示
function twelor_nailist_column_content($column_name, $post_id) {
    if ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    } else if ($column_name === 'nailist_name') {
        echo get_field('nailist_name', $post_id);
    } else if ($column_name === 'nailist_slug') {
        echo get_field('nailist_slug', $post_id);
    }
}
add_action('manage_nailist_posts_custom_column', 'twelor_nailist_column_content', 10, 2);

// お知らせ一覧のカラムをカスタマイズ
function twelor_add_info_columns($columns) {
    unset($columns['title']); // タイトルカラムを非表示
    $new_columns = array();
    $new_columns['description'] = '案内文';
    $new_columns['period'] = '日付';
    if (isset($columns['date'])) {
        $date = $columns['date'];
        unset($columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_info_posts_columns', 'twelor_add_info_columns');

// お知らせ一覧のカラム内容を表示
function twelor_info_column_content($column_name, $post_id) {
    if ($column_name === 'period') {
        echo get_field('info_period', $post_id);
    } elseif ($column_name === 'description') {
        echo get_field('info_description', $post_id);
    }
}
add_action('manage_info_posts_custom_column', 'twelor_info_column_content', 10, 2);

// バナー一覧のカラムをカスタマイズ
function twelor_add_banner_columns($columns) {
    $new_columns = array();
    $new_columns['thumbnail'] = '画像';
    $new_columns['title'] = 'バナー名';
    $new_columns['menu_order'] = '表示順';
    $new_columns['banner_url'] = 'URL';
    if (isset($columns['date'])) {
        $date = $columns['date'];
        unset($columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_banner_posts_columns', 'twelor_add_banner_columns');

// バナー一覧のカラム内容を表示
function twelor_banner_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    } elseif ($column_name === 'banner_url') {
        echo get_field('banner_url', $post_id);
    }
}
add_action('manage_banner_posts_custom_column', 'twelor_banner_column_content', 10, 2);

// Q&A一覧のカラムをカスタマイズ
function twelor_add_qa_columns($columns) {
    unset($columns['title']); // タイトルカラムを非表示
    $new_columns = array();
    $new_columns['type'] = '種別';
    $new_columns['question'] = '質問';
    $new_columns['answer'] = '答え';
    if (isset($columns['date'])) {
        $date = $columns['date'];
        unset($columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_qa_posts_columns', 'twelor_add_qa_columns');

// Q&A一覧のカラム内容を表示
function twelor_qa_column_content($column_name, $post_id) {
    if ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
    } elseif ($column_name === 'type') {
        $type_key = get_field('qa_type', $post_id);
        $types = array(
            'service' => '施術について',
            'reservation' => '予約について',
            'other' => 'その他',
        );
        echo isset($types[$type_key]) ? $types[$type_key] : '';
    } elseif ($column_name === 'question') {
        echo get_field('qa_question', $post_id);
    } elseif ($column_name === 'answer') {
        echo get_field('qa_answer', $post_id);
    }
}
add_action('manage_qa_posts_custom_column', 'twelor_qa_column_content', 10, 2);

// ホーム画像のカラムをカスタマイズ
function twelor_add_home_columns($columns) {
    $new_columns = array();
    $new_columns['thumbnail'] = 'ホーム画像';
    $new_columns['title'] = '画像名';
    if (isset($columns['date'])) {
        $date = $columns['date'];
        unset($columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_home_posts_columns', 'twelor_add_home_columns');

// ホーム画像のカラム内容を表示
function twelor_home_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    }
}
add_action('manage_home_posts_custom_column', 'twelor_home_column_content', 10, 2);

// Q&Aの表示順列をソート可能にする
function twelor_sortable_qa_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-qa_sortable_columns', 'twelor_sortable_qa_columns');

// クーポンの表示順列をソート可能にする
function twelor_sortable_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-coupon_sortable_columns', 'twelor_sortable_columns');

// ギャラリーの表示順列をソート可能にする
function twelor_sortable_gallery_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-gallery_sortable_columns', 'twelor_sortable_gallery_columns');

// サブカテゴリーの表示順列をソート可能にする
function twelor_sortable_course_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-course_sortable_columns', 'twelor_sortable_course_columns');

// バナーの表示順列をソート可能にする
function twelor_sortable_banner_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-banner_sortable_columns', 'twelor_sortable_banner_columns');

// ネイリストの表示順列をソート可能にする
function twelor_sortable_nailist_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-nailist_sortable_columns', 'twelor_sortable_nailist_columns');

// 管理画面の一覧のスタイル調整
function twelor_admin_columns_style() {
    echo '<style>
        .column-thumbnail { width: 80px; }
        .column-thumbnail img {
            border-radius: 4px;
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .column-menu_order {
            width: 100px;
        }
        .column-nailist,
        .column-main_category,
        .column-sub_category,
        .column-price,
        .column-bridal {
            width: 150px;
        }
        .column-display_settings {
            width: 200px;
        }
        .column-title,
        .column-period,
        .column-position,
        .column-description {
            width: 300px;
        }
        .ui-sortable tr {
            cursor: move;
        }
        .ui-sortable tr:hover {
            background-color: #f0f0f0;
        }
        .ui-sortable-helper {
            background-color: #fff !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
    </style>';
}
add_action('admin_head', 'twelor_admin_columns_style');

// 管理画面カスタムオーダー用のスタイル
function twelor_custom_order_admin_script() {
    global $post_type;

    // ギャラリー、クーポン、サブカテゴリー、バナー、ネイリストの一覧ページでのみ読み込み
    if (in_array($post_type, array('gallery', 'coupon', 'course', 'banner', 'nailist'))) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // ドラッグ&ドロップの視覚的フィードバックを改善
            $('.wp-list-table tbody').addClass('ui-sortable');
           
            // ソート後の処理を改善
            $('.wp-list-table tbody').on('sortstop', function(event, ui) {
                // ソート完了後に行の背景色をリセット
                setTimeout(function() {
                    $('.wp-list-table tbody tr').css('background-color', '');
                }, 100);
            });
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'twelor_custom_order_admin_script');

# -------------------------------
# バリデーション
# -------------------------------
// ACFプラグインが有効かチェック
function twelor_check_acf() {
    if (!function_exists('acf_add_local_field_group')) {
        add_action('admin_notices', 'twelor_acf_notice');
    } else {
        // ACFフィールドの登録
        twelor_register_acf_fields();
    }
}
add_action('admin_init', 'twelor_check_acf');

// ACF通知
function twelor_acf_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e('twelorテーマは Advanced Custom Fields プラグインが必要です。インストールして有効化してください。', 'twelor'); ?></p>
    </div>
    <?php
}

// 動的ネイリストナビゲーションを生成する関数
function twelor_get_nailist_navigation($current_nailist = '') {
    $nailists = get_posts(array(
        'post_type' => 'nailist',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));
   
    $navigation = array();
   
    // 登録されたネイリストを追加（ローマ字スラッグ優先）
    foreach ($nailists as $nailist) {
        $nailist_name = get_field('nailist_name', $nailist->ID);
        $display_name = $nailist_name;
        $roman_slug = get_field('nailist_slug', $nailist->ID);
        $slug = $roman_slug !== '' ? sanitize_title($roman_slug) : $nailist->post_name;
        $navigation[] = array(
            'slug' => $slug,
            'name' => $display_name,
            'url' => home_url('/coupon/' . $slug . '/'),
            'active' => ($current_nailist === $slug)
        );
    }
   
    return $navigation;
}

// リライトルール
function twelor_add_gallery_rewrite_rules() {
    // HAND定額コース
    add_rewrite_rule(
        'gallery_hand_design/([^/]+)/page/([0-9]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=hand&gallery_sub_category=$matches[1]&paged=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'gallery_hand_design/([^/]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=hand&gallery_sub_category=$matches[1]',
        'top'
    );

    // FOOT定額コース
    add_rewrite_rule(
        'gallery_foot_design/([^/]+)/page/([0-9]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=foot&gallery_sub_category=$matches[1]&paged=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'gallery_foot_design/([^/]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=foot&gallery_sub_category=$matches[1]',
        'top'
    );

    // GUESTギャラリー
    add_rewrite_rule(
        'gallery_guest_nail/([^/]+)/page/([0-9]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=guest&gallery_sub_category=$matches[1]&paged=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'gallery_guest_nail/([^/]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=guest&gallery_sub_category=$matches[1]',
        'top'
    );

    // アート・パーツ
    add_rewrite_rule(
        'gallery_arts_parts/([^/]+)/page/([0-9]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=arts-parts&gallery_sub_category=$matches[1]&paged=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'gallery_arts_parts/([^/]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=arts-parts&gallery_sub_category=$matches[1]',
        'top'
    );

    // クーポン
    add_rewrite_rule(
        'coupon/([^/]+)/page/([0-9]+)/?$',
        'index.php?pagename=coupon&nailist=$matches[1]&paged=$matches[2]',
        'top'
    );
    add_rewrite_rule(
        'coupon/([^/]+)/?$',
        'index.php?pagename=coupon&nailist=$matches[1]',
        'top'
    );
}
add_action('init', 'twelor_add_gallery_rewrite_rules');

// クエリ変数の追加
function twelor_add_gallery_query_vars($vars) {
    $vars[] = 'gallery_main_category';
    $vars[] = 'gallery_sub_category';
    $vars[] = 'nailist';
    $vars[] = 'paged';
    return $vars;
}
add_filter('query_vars', 'twelor_add_gallery_query_vars');

// リライトルールの更新
function twelor_flush_gallery_rewrite_rules() {
    twelor_add_gallery_rewrite_rules();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'twelor_flush_gallery_rewrite_rules');

// 管理画面のギャラリー一覧にフィルターを追加
function twelor_add_gallery_filters() {
    global $typenow;
    if ($typenow === 'gallery') {
        // メインカテゴリーの選択肢
        $main_categories = array(
            'hand' => 'Handデザイン',
            'foot' => 'Footデザイン',
            'guest' => 'Guestデザイン',
            'arts-parts' => 'アートパーツ'
        );

        // 現在選択されている値を取得
        $current_main = isset($_GET['main_category']) ? $_GET['main_category'] : '';
        $current_sub = isset($_GET['sub_category']) ? $_GET['sub_category'] : '';

        // メインカテゴリーのドロップダウン
        echo '<select name="main_category" id="main-category-filter">';
        echo '<option value="">メインカテゴリーを選択</option>';
        foreach ($main_categories as $value => $label) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($value),
                selected($current_main, $value, false),
                esc_html($label)
            );
        }
        echo '</select>';

        // サブカテゴリーのドロップダウン
        echo '<select name="sub_category" id="sub-category-filter">';
        echo '<option value="">サブカテゴリーを選択</option>';
        if($current_main){
            $sub_categories = twelor_get_course_choices($current_main);
            foreach ($sub_categories as $value => $label) {
                // Guestギャラリーの場合は「all」を除外
                if ($current_main === 'guest' && $value === 'all') {
                    continue;
                }
                printf(
                    '<option value="%s" %s>%s</option>',
                    esc_attr($value),
                    selected($current_sub, $value, false),
                    esc_html($label)
                );
            }
        }
        echo '</select>';

        // 現在選択されているメインカテゴリーをJavaScriptに渡す
        echo '<script>
        jQuery(document).ready(function($) {
            var currentMain = "' . esc_js($current_main) . '";
            if (currentMain) {
                $("#main-category-filter").trigger("change");
            }
        });
        </script>';
    }
}
add_action('restrict_manage_posts', 'twelor_add_gallery_filters');

// ギャラリーのフィルター条件を適用
function twelor_apply_gallery_filters($query) {
    global $pagenow, $typenow;
   
    if ($pagenow === 'edit.php' && $typenow === 'gallery') {
        $meta_query = array('relation' => 'AND');

        // メインカテゴリーのフィルター
        if (!empty($_GET['main_category'])) {
            $meta_query[] = array(
                'key' => 'gallery_main_category',
                'value' => $_GET['main_category'],
                'compare' => '='
            );
        }

        // サブカテゴリーのフィルター
        if (!empty($_GET['sub_category'])) {
            $meta_query[] = array(
                'key' => 'gallery_sub_category',
                'value' => $_GET['sub_category'],
                'compare' => '='
            );
        }

        if (count($meta_query) > 1) {
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'twelor_apply_gallery_filters');

// 管理画面のクーポン一覧にフィルターを追加
function twelor_add_coupon_filters() {
    global $typenow;
    if ($typenow === 'coupon') {
        $choices = twelor_get_nailist_choices();
        $current_nailist = isset($_GET['coupon_nailist_filter']) ? $_GET['coupon_nailist_filter'] : '';
        echo '<select name="coupon_nailist_filter">';
        echo '<option value="">ネイリストで絞り込み</option>';
        foreach ($choices as $value => $label) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($value),
                selected($current_nailist, $value, false),
                esc_html($label)
            );
        }
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'twelor_add_coupon_filters');

// 管理画面のサブカテゴリー一覧にフィルターを追加
function twelor_add_course_filters() {
    global $typenow;
    if ($typenow === 'course') {
        // メインカテゴリーの選択肢
        $main_categories = array(
            'hand' => 'Handデザイン',
            'foot' => 'Footデザイン',
            'guest' => 'Guestデザイン',
            'arts-parts' => 'アートパーツ'
        );

        // 現在選択されている値を取得
        $current_main = isset($_GET['course_main_category_filter']) ? $_GET['course_main_category_filter'] : '';

        // メインカテゴリーのドロップダウン
        echo '<select name="course_main_category_filter">';
        echo '<option value="">メインカテゴリーで絞り込み</option>';
        foreach ($main_categories as $value => $label) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($value),
                selected($current_main, $value, false),
                esc_html($label)
            );
        }
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'twelor_add_course_filters');

// クーポンのフィルター条件を適用
function twelor_apply_coupon_filters($query) {
    global $pagenow, $typenow;
    if ($pagenow === 'edit.php' && $typenow === 'coupon' && is_admin() && $query->is_main_query()) {
        if (!empty($_GET['coupon_nailist_filter'])) {
            $meta_query = (array) $query->get('meta_query');
            if (empty($meta_query)) {
                $meta_query = array('relation' => 'AND');
            }
            $meta_query[] = array(
                'key' => 'coupon_nailist',
                'value' => $_GET['coupon_nailist_filter'],
                'compare' => 'LIKE'
            );
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'twelor_apply_coupon_filters');

// サブカテゴリーのフィルター条件を適用
function twelor_apply_course_filters($query) {
    global $pagenow, $typenow;
    if ($pagenow === 'edit.php' && $typenow === 'course' && is_admin() && $query->is_main_query()) {
        if (!empty($_GET['course_main_category_filter'])) {
            $meta_query = (array) $query->get('meta_query');
            if (empty($meta_query)) {
                $meta_query = array('relation' => 'AND');
            }
            $meta_query[] = array(
                'key' => 'course_main_category',
                'value' => $_GET['course_main_category_filter'],
                'compare' => '='
            );
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_posts', 'twelor_apply_course_filters');

// フィルターのスタイルを追加
function twelor_admin_filters_style() {
    global $typenow;
    if ($typenow === 'gallery') {
        ?>
        <style>
            .tablenav select[name="main_category"],
            .tablenav select[name="sub_category"] {
                float: left;
                margin: 0 8px 0 0;
                padding: 0 24px 0 8px;
                min-width: 200px;
                height: 30px;
                line-height: 30px;
                font-size: 13px;
                color: #2c3338;
                border-color: #8c8f94;
                border-radius: 3px;
                background-color: #fff;
                background-repeat: no-repeat;
                background-position: right 5px center;
                background-size: 16px 16px;
            }
            .tablenav select[name="main_category"]:focus,
            .tablenav select[name="sub_category"]:focus {
                border-color: #2271b1;
                box-shadow: 0 0 0 1px #2271b1;
                outline: 2px solid transparent;
            }
            .tablenav select[name="main_category"]:hover,
            .tablenav select[name="sub_category"]:hover {
                border-color: #2271b1;
            }
            .tablenav select[name="main_category"] option,
            .tablenav select[name="sub_category"] option {
                padding: 4px 8px;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'twelor_admin_filters_style');

// トップページのギャラリー表示制御
function twelor_get_top_gallery_posts($limit = 9) {
    $args = array(
        'post_type' => 'gallery',
        'posts_per_page' => $limit,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'gallery_display_top',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'DESC'
        )
    );
    return new WP_Query($args);
}

// ギャラリーページのギャラリー表示制御
function twelor_get_gallery_page_posts($main_category = '', $sub_category = '', $posts_per_page = 20, $paged = 1) {
    $meta_query = array('relation' => 'AND');
   
    // 表示設定の条件
    $meta_query[] = array(
        'key' => 'gallery_display_gallery',
        'value' => '1',
        'compare' => '='
    );
   
    // メインカテゴリーの条件
    if (!empty($main_category)) {
        $meta_query[] = array(
            'key' => 'gallery_main_category',
            'value' => $main_category,
            'compare' => '='
        );
    }
   
    // サブカテゴリーの条件（サブカテゴリーがbridalの場合はセットしない)
    if (!empty($sub_category) && $sub_category !== 'bridal') {
        // GuestギャラリーでAllが選択された場合は特別な処理
        if ($main_category === 'guest' && $sub_category === 'all') {
            // GuestギャラリーのAll以外のサブカテゴリーを取得
            $guest_sub_categories = twelor_get_course_choices('guest');
            $guest_slugs = array_keys($guest_sub_categories);
            
            
            // All以外のサブカテゴリーの条件を作成（Allも含める）
            $sub_category_conditions = array();
            foreach ($guest_slugs as $slug) {
                $sub_category_conditions[] = array(
                    'key' => 'gallery_sub_category',
                    'value' => $slug,
                    'compare' => '='
                );
            }
            
            if (!empty($sub_category_conditions)) {
                $or_condition = array('relation' => 'OR');
                foreach ($sub_category_conditions as $condition) {
                    $or_condition[] = $condition;
                }
                $meta_query[] = $or_condition;
                
            }
        } else {
            $meta_query[] = array(
                'key' => 'gallery_sub_category',
                'value' => $sub_category,
                'compare' => '='
            );
        }
    }

    // ブライダルデザインの条件
    if ($sub_category === 'bridal') {
        $meta_query[] = array(
            'key' => 'gallery_is_bridal',
            'value' => '1',
            'compare' => '='
        );
    }
   
    $args = array(
        'post_type' => 'gallery',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'meta_query' => $meta_query,
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'DESC'
        )
    );
    
   
    return new WP_Query($args);
}

// トップページのクーポン表示制御
function twelor_get_top_coupon_posts($limit = 9) {
    $args = array(
        'post_type' => 'coupon',
        'posts_per_page' => $limit,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'coupon_display_top',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'DESC'
        )
    );
    return new WP_Query($args);
}

// クーポンページのクーポン表示制御
function twelor_get_coupon_page_posts($posts_per_page = 9, $paged = 1, $nailist = '') {
    $meta_query = array('relation' => 'AND');
   
    // 表示設定の条件
    $meta_query[] = array(
        'key' => 'coupon_display_coupon',
        'value' => '1',
        'compare' => '='
    );
   
    if (!empty($nailist)) {
        $meta_query[] = array(
            'key' => 'coupon_nailist',
            'value' => $nailist,
            'compare' => 'LIKE'
        );
    }
   
    $args = array(
        'post_type' => 'coupon',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'meta_query' => $meta_query,
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'DESC'
        )
    );
    return new WP_Query($args);
}

// クイック編集フィールドの追加
function twelor_add_quick_edit_fields($column_name, $post_type) {
    if (!in_array($post_type, ['gallery', 'coupon']) || $column_name !== 'display_settings') return;
   
    $post_type_label = $post_type === 'gallery' ? 'ギャラリー' : 'クーポン';
    $field_name = $post_type . '_display_settings';
    ?>
    <fieldset class="inline-edit-col-display">
        <div class="inline-edit-col">
            <label class="alignleft">
                <span class="title">表示設定</span>
                <span class="input-text-wrap">
                    <select name="<?php echo esc_attr($field_name); ?>">
                        <option value="both">両方に表示</option>
                        <option value="top">トップページのみ</option>
                        <option value="<?php echo esc_attr($post_type); ?>"><?php echo esc_html($post_type_label); ?>ページのみ</option>
                        <option value="none">両方非表示</option>
                    </select>
                </span>
            </label>
        </div>
    </fieldset>
    <?php
}
add_action('quick_edit_custom_box', 'twelor_add_quick_edit_fields', 10, 2);

// クイック編集用のJavaScript
function twelor_quick_edit_script() {
    global $post_type;
    if (!in_array($post_type, ['gallery', 'coupon'])) return;
   
    $post_type_label = $post_type === 'gallery' ? 'ギャラリー' : 'クーポン';
    $field_name = $post_type . '_display_settings';
    ?>
    <script>
    jQuery(document).ready(function($) {
        var $wp_inline_edit = inlineEditPost.edit;
       
        inlineEditPost.edit = function(id) {
            $wp_inline_edit.apply(this, arguments);
           
            var post_id = 0;
            if (typeof(id) == 'object') {
                post_id = parseInt(this.getId(id));
            }
           
            if (post_id > 0) {
                var $post_row = $('#post-' + post_id);
                var $edit_row = $('#edit-' + post_id);
               
                // 表示設定の値を取得
                var display_text = $post_row.find('.column-display_settings').text();
                var display_top = display_text.indexOf('トップページ') !== -1;
                var display_page = display_text.indexOf('<?php echo esc_js($post_type_label); ?>ページ') !== -1;
               
                // 表示設定の選択値を設定
                var display_value = 'both';
                if (display_top && !display_page) {
                    display_value = 'top';
                } else if (!display_top && display_page) {
                    display_value = '<?php echo esc_js($post_type); ?>';
                } else if (!display_top && !display_page) {
                    display_value = 'none';
                }
               
                $edit_row.find('select[name="<?php echo esc_js($field_name); ?>"]').val(display_value);
            }
        };
    });
    </script>
    <?php
}
add_action('admin_footer-edit.php', 'twelor_quick_edit_script');

// クイック編集の保存処理
function twelor_save_quick_edit($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
   
    $post_type = get_post_type($post_id);
    if (!in_array($post_type, ['gallery', 'coupon'])) return;

    $field_name = $post_type . '_display_settings';
    if (isset($_POST[$field_name])) {
        $display_settings = $_POST[$field_name];
       
        // トップページ表示設定
        $display_top = ($display_settings === 'both' || $display_settings === 'top') ? '1' : '0';
        update_field($post_type . '_display_top', $display_top, $post_id);
       
        // ページ表示設定
        $display_page = ($display_settings === 'both' || $display_settings === $post_type) ? '1' : '0';
        update_field($post_type . '_display_' . $post_type, $display_page, $post_id);
    }
}
add_action('save_post', 'twelor_save_quick_edit');

// クイック編集のスタイル調整
function twelor_quick_edit_style() {
    global $post_type;
    if (!in_array($post_type, ['gallery', 'coupon'])) return;
    ?>
    <style>
        .inline-edit-col-left .inline-edit-col,
        .inline-edit-col-display .inline-edit-col {
            margin: 0 0 0 10px;
        }
        .inline-edit-col-left .inline-edit-col select,
        .inline-edit-col-display .inline-edit-col select {
            width: 100%;
            max-width: 200px;
        }
        /* 順序,ステータスフィールドとスラッグ,日付,パスワードフィールド非表示 */
        .inline-edit-col-right,
        .inline-edit-col-left .inline-edit-col fieldset,
        .inline-edit-col-left .inline-edit-col div {
            display: none;
        }
    </style>
    <?php
}
add_action('admin_head', 'twelor_quick_edit_style');

// ギャラリー、クーポン、サブカテゴリー登録時にmenu_orderの自動設定
function twelor_auto_set_menu_order($data, $postarr) {
    if (!in_array($data['post_type'], array('gallery', 'coupon', 'course', 'banner', 'nailist'))) {
        return $data;
    }

    if ($data['post_status'] !== 'auto-draft' &&
        (!isset($postarr['menu_order']) || $postarr['menu_order'] == 0)) {

        global $wpdb;
        $min_order = $wpdb->get_var($wpdb->prepare(
            "SELECT MIN(menu_order) FROM {$wpdb->posts} WHERE post_type = %s AND post_status != 'trash' AND post_status != 'auto-draft'",
            $data['post_type']
        ));

        $data['menu_order'] = max(0, intval($min_order));
    }
   
    return $data;
}
add_filter('wp_insert_post_data', 'twelor_auto_set_menu_order', 10, 2);

// 新規登録、更新時の表示順フィールド削除
function twelor_hide_menu_order_field() {
    global $post_type;
    if (in_array($post_type, array('gallery', 'coupon', 'course', 'banner', 'nailist'))) {
        echo '<style>
            #pageparentdiv,
            #pageparentdiv .inside {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'twelor_hide_menu_order_field');

// 管理画面のギャラリー一覧でメインカテゴリーを選択時サブカテゴリーを動的に更新する処理
function twelor_admin_filters_script() {
    global $typenow;
    if ($typenow === 'gallery') {
        $current_main = isset($_GET['main_category']) ? $_GET['main_category'] : '';
        $current_sub = isset($_GET['sub_category']) ? $_GET['sub_category'] : '';
        ?>
        <script>
        jQuery(document).ready(function($) {
            var currentMain = '<?php echo esc_js($current_main); ?>';
            var currentSub = '<?php echo esc_js($current_sub); ?>';
            
            function updateSubCategories(mainCategory, selectedValue) {
                var $subCategorySelect = $('#sub-category-filter');
                
                if (mainCategory) {
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'get_course_choices',
                            main_type: mainCategory,
                            nonce: '<?php echo wp_create_nonce("get_course_choices"); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                $subCategorySelect.html('<option value="">サブカテゴリーを選択</option>');
                                $.each(response.data, function(slug, name) {
                                    // Guestギャラリーの場合は「all」を除外
                                    if (mainCategory === 'guest' && slug === 'all') {
                                        return;
                                    }
                                    var selected = (selectedValue === slug) ? ' selected' : '';
                                    $subCategorySelect.append('<option value="' + slug + '"' + selected + '>' + name + '</option>');
                                });
                                $subCategorySelect.prop('disabled', false);
                            }
                        }
                    });
                } else {
                    $subCategorySelect.html('<option value="">サブカテゴリーを選択</option>').prop('disabled', true);
                }
            }

            // メインカテゴリー変更時の処理
            $('#main-category-filter').on('change', function() {
                var mainCategory = $(this).val();
                updateSubCategories(mainCategory, '');
            });

            // 初期表示時の処理
            if (currentMain) {
                updateSubCategories(currentMain, currentSub);
            }
        });
        </script>
        <?php
    }
}
add_action('admin_footer-edit.php', 'twelor_admin_filters_script');

// AJAXハンドラー
function twelor_ajax_get_course_choices() {
    check_ajax_referer('get_course_choices', 'nonce');
   
    $main_type = sanitize_text_field($_POST['main_type']);
    $sub_categories = twelor_get_course_choices($main_type);
   
    wp_send_json_success($sub_categories);
}
add_action('wp_ajax_get_course_choices', 'twelor_ajax_get_course_choices');