<?php
/**
 * Fascina テーマの機能
 */

// テーマのセットアップ
function fascina_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // メニューの登録
    register_nav_menus(array(
        'primary' => __('メインメニュー', 'fascina'),
        'footer' => __('フッターメニュー', 'fascina'),
    ));
}
add_action('after_setup_theme', 'fascina_setup');

// スタイルシートとスクリプトの読み込み
function fascina_scripts() {
    // Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    
    // テーマのスタイルシート
    wp_enqueue_style('fascina-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // カスタムCSS
    wp_enqueue_style('fascina-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0.0');
    
    // Bootstrap JavaScript
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    
    // カスタムJavaScript
    wp_enqueue_script('fascina-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'fascina_scripts');

// デフォルトの管理メニューを削除
function fascina_remove_default_menu_items() {
    remove_menu_page('edit.php');           // 投稿
    remove_menu_page('upload.php');         // メディア
    remove_menu_page('edit-comments.php');  // コメント
}
add_action('admin_menu', 'fascina_remove_default_menu_items');

// タイトルプレイスホルダーのカスタマイズ
function fascina_change_title_placeholder($title, $post) {
    if ($post->post_type === 'gallery') {
        $title = 'ギャラリー名を入力';
    } elseif ($post->post_type === 'coupon') {
        $title = 'クーポン名称を入力';
    } elseif ($post->post_type === 'ranking') {
        $title = 'ギャラリー名を入力';
    }
    return $title;
}
add_filter('enter_title_here', 'fascina_change_title_placeholder', 10, 2);

// カスタム投稿タイプ: ギャラリー
function fascina_register_gallery_post_type() {
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
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-format-gallery',
        'has_archive' => true,
        'rewrite' => array('slug' => 'gallery'),
    );
    register_post_type('gallery', $args);
}
add_action('init', 'fascina_register_gallery_post_type');

// カスタム投稿タイプ: クーポン
function fascina_register_coupon_post_type() {
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
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-tickets-alt',
        'has_archive' => true,
        'rewrite' => array('slug' => 'coupon'),
    );
    register_post_type('coupon', $args);
}
add_action('init', 'fascina_register_coupon_post_type');

// カスタム投稿タイプ: ランキング
function fascina_register_ranking_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'ランキング',
        'labels' => array(
            'name' => 'ランキング',
            'singular_name' => 'ランキング',
            'add_new' => '新規追加',
            'add_new_item' => '新規ランキングを追加',
            'edit_item' => 'ランキングを編集',
        ),
        'supports' => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-awards',
        'has_archive' => false,
    );
    register_post_type('ranking', $args);
}
add_action('init', 'fascina_register_ranking_post_type');

// カスタム投稿タイプ: お知らせ
function fascina_register_info_post_type() {
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
add_action('init', 'fascina_register_info_post_type');

// ACFフィールドの登録
function fascina_register_acf_fields() {
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
                        'hand' => 'HAND定額コース',
                        'foot' => 'FOOT定額コース',
                        'guest' => 'GUESTギャラリー',
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
                    'choices' => array(
                        // HANDとFOOT定額コース用
                        'simple' => 'シンプル定額コース',
                        'popular' => '一番人気定額コース',
                        'special' => 'こだわり定額コース',
                        'clean' => 'キレイめ定額コース',
                        'onehon-s' => 'ワンホンS定額コース',
                        'onehon-m' => 'ワンホンM定額コース',
                        'onehon-l' => 'ワンホンL定額コース',
                        'nuance-s' => 'ニュアンスS定額コース',
                        'nuance-m' => 'ニュアンスM定額コース',
                        'nuance-l' => 'ニュアンスL定額コース',
                        'nuance-xl' => 'ニュアンスXL定額コース',
                        // アートパーツ用
                        'lame-holo-seal' => 'ラメ・ホロ・シール',
                        'stone-studs-pearl' => 'ストーン・スタッズ・パール',
                        'parts' => 'パーツ',
                        'color' => 'カラー'
                    ),
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

        
        // ランキング用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_ranking',
            'title' => 'ランキング詳細',
            'fields' => array(
                array(
                    'key' => 'field_ranking_position',
                    'label' => '順位',
                    'name' => 'ranking_position',
                    'type' => 'number',
                    'required' => 1,
                    'min' => 1,
                    'max' => 10,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ranking',
                    ),
                ),
            ),
        ));
        
        // クーポン用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_coupon',
            'title' => 'クーポン詳細',
            'fields' => array(
                array(
                    'key' => 'field_coupon_period',
                    'label' => 'クーポン表示期間',
                    'name' => 'coupon_period',
                    'type' => 'group',
                    'required' => 1,
                    'layout' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_coupon_period_start',
                            'label' => '開始日時',
                            'name' => 'start_date',
                            'type' => 'date_time_picker',
                            'required' => 1,
                            'display_format' => 'Y年m月d日H時i分',
                            'return_format' => 'Y-m-d H:i:s',
                            'first_day' => 1,
                        ),
                        array(
                            'key' => 'field_coupon_period_end',
                            'label' => '終了日時',
                            'name' => 'end_date',
                            'type' => 'date_time_picker',
                            'required' => 1,
                            'display_format' => 'Y年m月d日H時i分',
                            'return_format' => 'Y-m-d H:i:s',
                            'first_day' => 1,
                        ),
                    ),
                ),
                array(
                    'key' => 'field_coupon_price',
                    'label' => 'クーポン価格',
                    'name' => 'coupon_price',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => '例: ¥1,000'
                ),
                array(
                    'key' => 'field_coupon_guidance',
                    'label' => '案内文',
                    'name' => 'coupon_guidance',
                    'type' => 'textarea',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_coupon_description',
                    'label' => '説明文',
                    'name' => 'coupon_description',
                    'type' => 'textarea',
                    'required' => 1,
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

// ギャラリーのカテゴリー,サブカテゴリー連動機能用JavaScript
function fascina_gallery_category_script() {
    if (get_post_type() !== 'gallery') return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        const handCategories = [
            'simple', 'popular', 'special', 'clean',
            'onehon-s', 'onehon-m', 'onehon-l', 'bridal',
            'nuance-s', 'nuance-m', 'nuance-l', 'nuance-xl'
        ];
        
        const footCategories = [
            'simple', 'popular', 'special', 'clean'
        ];
        
        const artPartsCategories = [
            'lame-holo-seal', 'stone-studs-pearl',
            'parts', 'color'
        ];

        function updateSubCategories() {
            const mainSelected = $('[name="acf[field_gallery_main_category]"]:checked').val();
            const $subCategories = $('[name="acf[field_gallery_sub_category]"]');

            // すべてのラジオボタンを一旦無効化
            $subCategories.prop('disabled', true).closest('li').hide();
            
            if (mainSelected === 'hand') {
                // HAND定額コースが選択された場合
                handCategories.forEach(category => {
                    $(`[name="acf[field_gallery_sub_category]"][value="${category}"]`)
                        .prop('disabled', false)
                        .closest('li')
                        .show();
                });
            }
            else if (mainSelected === 'foot') {
                // FOOT定額コースが選択された場合
                footCategories.forEach(category => {
                    $(`[name="acf[field_gallery_sub_category]"][value="${category}"]`)
                        .prop('disabled', false)
                        .closest('li')
                        .show();
                });
            }
            else if (mainSelected === 'arts-parts') {
                // アートパーツが選択された場合
                artPartsCategories.forEach(category => {
                    $(`[name="acf[field_gallery_sub_category]"][value="${category}"]`)
                        .prop('disabled', false)
                        .closest('li')
                        .show();
                });
            }

            // 非表示のラジオボタンが選択されている場合、選択を解除
            if ($subCategories.filter(':checked').prop('disabled')) {
                $subCategories.prop('checked', false);
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
add_action('admin_footer', 'fascina_gallery_category_script');

# -------------------------------
# 管理画面一覧のカスタマイズ
# -------------------------------
// ギャラリー一覧のカラムをカスタマイズ
function fascina_add_gallery_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['thumbnail'] = '画像';
        }
        $new_columns[$key] = $value;
    }
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
add_filter('manage_gallery_posts_columns', 'fascina_add_gallery_columns');

// ギャラリー一覧のカラム内容を表示
function fascina_gallery_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'main_category') {
        $main_category = get_field('gallery_main_category', $post_id);
        $categories = array(
            'hand' => 'HAND定額コース',
            'foot' => 'FOOT定額コース',
            'guest' => 'GUESTギャラリー',
            'arts-parts' => 'アートパーツ'
        );
        echo isset($categories[$main_category]) ? $categories[$main_category] : '';
    } elseif ($column_name === 'sub_category') {
        $sub_category = get_field('gallery_sub_category', $post_id);
        $categories = array(
            'simple' => 'シンプル定額コース',
            'popular' => '一番人気定額コース',
            'special' => 'こだわり定額コース',
            'clean' => 'キレイめ定額コース',
            'onehon-s' => 'ワンホンS定額コース',
            'onehon-m' => 'ワンホンM定額コース',
            'onehon-l' => 'ワンホンL定額コース',
            'nuance-s' => 'ニュアンスS定額コース',
            'nuance-m' => 'ニュアンスM定額コース',
            'nuance-l' => 'ニュアンスL定額コース',
            'nuance-xl' => 'ニュアンスXL定額コース',
            'lame-holo-seal' => 'ラメ・ホロ・シール',
            'stone-studs-pearl' => 'ストーン・スタッズ・パール',
            'parts' => 'パーツ',
            'color' => 'カラー'
        );
        echo isset($categories[$sub_category]) ? $categories[$sub_category] : '';
    } elseif ($column_name === 'bridal') {
        $is_bridal = get_field('gallery_is_bridal', $post_id);
        echo $is_bridal ? '✓' : '－';
    } elseif ($column_name === 'description') {
        echo get_field('gallery_description', $post_id);
    }
}
add_action('manage_gallery_posts_custom_column', 'fascina_gallery_column_content', 10, 2);

// クーポン一覧のカラムをカスタマイズ
function fascina_add_coupon_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['thumbnail'] = '画像';
        }
        $new_columns[$key] = $value;
    }
    $new_columns['period'] = '表示期間';
    $new_columns['price'] = 'クーポン価格';
    $new_columns['guidance'] = '案内文';
    $new_columns['description'] = '説明文';
    if (isset($new_columns['date'])) {
        $date = $new_columns['date'];
        unset($new_columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_coupon_posts_columns', 'fascina_add_coupon_columns');

// クーポン一覧のカラム内容を表示
function fascina_coupon_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'period') {
        $period = get_field('coupon_period', $post_id);
        if ($period) {
            echo date('Y/m/d H:i', strtotime($period['start_date'])) . ' 〜 ' . 
                 date('Y/m/d H:i', strtotime($period['end_date']));
        }
    } elseif ($column_name === 'price') {
        echo get_field('coupon_price', $post_id);
    } elseif ($column_name === 'guidance') {
        echo get_field('coupon_guidance', $post_id);
    } elseif ($column_name === 'description') {
        echo get_field('coupon_description', $post_id);
    }
}
add_action('manage_coupon_posts_custom_column', 'fascina_coupon_column_content', 10, 2);

// お知らせ一覧のカラムをカスタマイズ
function fascina_add_info_columns($columns) {
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
add_filter('manage_info_posts_columns', 'fascina_add_info_columns');

// お知らせ一覧のカラム内容を表示
function fascina_info_column_content($column_name, $post_id) {
    if ($column_name === 'period') {
        echo get_field('info_period', $post_id);
    } elseif ($column_name === 'description') {
        echo get_field('info_description', $post_id);
    }
}
add_action('manage_info_posts_custom_column', 'fascina_info_column_content', 10, 2);

// ランキング一覧のカラムをカスタマイズ
function fascina_add_ranking_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns['thumbnail'] = '画像';
        }
        $new_columns[$key] = $value;
    }
    $new_columns['position'] = '順位';
    if (isset($new_columns['date'])) {
        $date = $new_columns['date'];
        unset($new_columns['date']);
        $new_columns['date'] = $date;
    }
    return $new_columns;
}
add_filter('manage_ranking_posts_columns', 'fascina_add_ranking_columns');

// ランキング一覧のカラム内容を表示
function fascina_ranking_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'position') {
        $position = get_field('ranking_position', $post_id);
        if ($position) {
            echo $position . '位';
        }
    }
}
add_action('manage_ranking_posts_custom_column', 'fascina_ranking_column_content', 10, 2);

// 管理画面の一覧のスタイル調整
function fascina_admin_columns_style() {
    echo '<style>
        .column-thumbnail { width: 80px; }
        .column-thumbnail img { 
            border-radius: 4px;
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
        .column-main_category,
        .column-sub_category,
        .column-price,
        .column-bridal { 
            width: 150px; 
        }
        .column-period,
        .column-guidance,
        .column-position,
        .column-description { 
            width: 300px; 
        }
    </style>';
}
add_action('admin_head', 'fascina_admin_columns_style');

# -------------------------------
# バリデーション
# -------------------------------
// ACFプラグインが有効かチェック
function fascina_check_acf() {
    if (!function_exists('acf_add_local_field_group')) {
        add_action('admin_notices', 'fascina_acf_notice');
    } else {
        // ACFフィールドの登録
        fascina_register_acf_fields();
    }
}
add_action('admin_init', 'fascina_check_acf');

// ACF通知
function fascina_acf_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e('Fascinaテーマは Advanced Custom Fields プラグインが必要です。インストールして有効化してください。', 'fascina'); ?></p>
    </div>
    <?php
}

# -------------------------------
# その他
# -------------------------------
// SEO対策
function fascina_meta_description() {
    global $post;
    if (is_singular()) {
        $description = strip_tags(get_the_excerpt());
    } else {
        $description = get_bloginfo('description');
    }
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
}
add_action('wp_head', 'fascina_meta_description');

// OGPタグの追加
function fascina_add_ogp() {
    global $post;
    
    if (is_singular()) {
        // 記事のパーマリンク
        $ogp_url = get_permalink();
        // 記事のタイトル
        $ogp_title = get_the_title();
        // 記事の抜粋
        $ogp_description = strip_tags(get_the_excerpt());
        // アイキャッチ画像
        if (has_post_thumbnail()) {
            $ogp_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        } else {
            $ogp_image = get_template_directory_uri() . '/assets/images/default-ogp.jpg';
        }
    } else {
        // トップページなど
        $ogp_url = home_url('/');
        $ogp_title = get_bloginfo('name');
        $ogp_description = get_bloginfo('description');
        $ogp_image = get_template_directory_uri() . '/assets/images/default-ogp.jpg';
    }
    
    echo '<meta property="og:url" content="' . esc_url($ogp_url) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($ogp_title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($ogp_description) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($ogp_image) . '">' . "\n";
    echo '<meta property="og:type" content="' . (is_singular() ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($ogp_title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($ogp_description) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($ogp_image) . '">' . "\n";
}
add_action('wp_head', 'fascina_add_ogp');

// ギャラリーページのリライトルール
function fascina_add_gallery_rewrite_rules() {
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
        'gallery_guest_nail/page/([0-9]+)/?$',
        'index.php?pagename=gallery-template&gallery_main_category=guest&paged=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        'gallery_guest_nail/?$',
        'index.php?pagename=gallery-template&gallery_main_category=guest',
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
}
add_action('init', 'fascina_add_gallery_rewrite_rules');

// クエリ変数の追加
function fascina_add_gallery_query_vars($vars) {
    $vars[] = 'gallery_main_category';
    $vars[] = 'gallery_sub_category';
    $vars[] = 'paged';
    return $vars;
}
add_filter('query_vars', 'fascina_add_gallery_query_vars');

// リライトルールの更新
function fascina_flush_gallery_rewrite_rules() {
    fascina_add_gallery_rewrite_rules();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'fascina_flush_gallery_rewrite_rules');