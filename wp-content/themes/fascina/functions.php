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

// カスタム投稿タイプ: 口コミ
function fascina_register_review_post_type() {
    $args = array(
        'public' => true,
        'label'  => '口コミ',
        'labels' => array(
            'name' => '口コミ',
            'singular_name' => '口コミ',
            'add_new' => '新規追加',
            'add_new_item' => '新規口コミを追加',
            'edit_item' => '口コミを編集',
        ),
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-testimonial',
        'has_archive' => true,
        'rewrite' => array('slug' => 'review'),
    );
    register_post_type('review', $args);
}
add_action('init', 'fascina_register_review_post_type');

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
        'supports' => array('title', 'editor', 'thumbnail'),
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

// ACFフィールドの登録
function fascina_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        // ギャラリー用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_gallery',
            'title' => 'ギャラリー詳細',
            'fields' => array(
                array(
                    'key' => 'field_gallery_description',
                    'label' => '説明',
                    'name' => 'gallery_description',
                    'type' => 'textarea',
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
        
        // 口コミ用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_review',
            'title' => '口コミ詳細',
            'fields' => array(
                array(
                    'key' => 'field_review_rating',
                    'label' => '評価',
                    'name' => 'review_rating',
                    'type' => 'number',
                    'min' => 1,
                    'max' => 5,
                ),
                array(
                    'key' => 'field_review_author',
                    'label' => '投稿者',
                    'name' => 'review_author',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_review_date',
                    'label' => '投稿日',
                    'name' => 'review_date',
                    'type' => 'date_picker',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'review',
                    ),
                ),
            ),
        ));

        // お知らせ用フィールド
        acf_add_local_field_group(array(
            'key' => 'group_info',
            'title' => 'お知らせ詳細',
            'fields' => array(
                array(
                    'key' => 'field_info_period',
                    'label' => '期間',
                    'name' => 'info_period',
                    'type' => 'date_picker',
                    'required' => 1,
                    'display_format' => 'Y/m/d',
                    'return_format' => 'Y/m/d',
                ),
                array(
                    'key' => 'field_info_description',
                    'label' => '説明',
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
                    'key' => 'field_coupon_price',
                    'label' => '価格',
                    'name' => 'coupon_price',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_coupon_expiry',
                    'label' => '有効期限',
                    'name' => 'coupon_expiry',
                    'type' => 'date_picker',
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
        ));
    }
}

// ウィジェットエリアの登録
function fascina_widgets_init() {
    register_sidebar(array(
        'name'          => __('サイドバー', 'fascina'),
        'id'            => 'sidebar-1',
        'description'   => __('サイドバーウィジェットエリア', 'fascina'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name'          => __('フッター', 'fascina'),
        'id'            => 'footer-1',
        'description'   => __('フッターウィジェットエリア', 'fascina'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'fascina_widgets_init');

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

// ギャラリーのカテゴリータクソノミーを登録
function fascina_register_gallery_taxonomies() {
    // メインカテゴリー
    register_taxonomy('gallery_main_category', 'gallery', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'メインカテゴリー',
            'singular_name' => 'メインカテゴリー',
            'menu_name' => 'メインカテゴリー',
            'all_items' => 'すべてのメインカテゴリー',
            'edit_item' => 'メインカテゴリーを編集',
            'view_item' => 'メインカテゴリーを表示',
            'update_item' => 'メインカテゴリーを更新',
            'add_new_item' => '新しいメインカテゴリーを追加',
            'new_item_name' => '新しいメインカテゴリー名',
            'parent_item' => '親メインカテゴリー',
            'parent_item_colon' => '親メインカテゴリー:',
            'search_items' => 'メインカテゴリーを検索',
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'gallery-category'),
    ));
    
    // サブカテゴリー
    register_taxonomy('gallery_sub_category', 'gallery', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => 'サブカテゴリー',
            'singular_name' => 'サブカテゴリー',
            'menu_name' => 'サブカテゴリー',
            'all_items' => 'すべてのサブカテゴリー',
            'edit_item' => 'サブカテゴリーを編集',
            'view_item' => 'サブカテゴリーを表示',
            'update_item' => 'サブカテゴリーを更新',
            'add_new_item' => '新しいサブカテゴリーを追加',
            'new_item_name' => '新しいサブカテゴリー名',
            'parent_item' => '親サブカテゴリー',
            'parent_item_colon' => '親サブカテゴリー:',
            'search_items' => 'サブカテゴリーを検索',
        ),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'gallery-subcategory'),
    ));
}
add_action('init', 'fascina_register_gallery_taxonomies');

// ギャラリーのメインカテゴリー,サブカテゴリー自動登録
function fascina_register_default_terms() {
    // メインカテゴリーの作成
    $main_categories = array(
        'hand' => 'HAND定額コース',
        'foot' => 'FOOT定額コース',
        'guest' => 'GUESTギャラリー',
        'art-parts' => 'アートパーツ'
    );
    
    foreach ($main_categories as $slug => $name) {
        if (!term_exists($name, 'gallery_main_category')) {
            wp_insert_term($name, 'gallery_main_category', array('slug' => $slug));
        }
    }
    
    // HANDとFOOT定額コースのサブカテゴリー
    $hand_foot_subcategories = array(
        'simple' => 'シンプル定額コース',
        'popular' => '一番人気定額コース',
        'special' => 'こだわり定額コース',
        'clean' => 'キレイめ定額コース',
        'onehon-s' => 'ワンホンS定額コース',
        'onehon-m' => 'ワンホンM定額コース',
        'onehon-l' => 'ワンホンL定額コース',
        'bridal' => 'ブライダルデザイン',
        'nuance-s' => 'ニュアンスS定額コース',
        'nuance-m' => 'ニュアンスM定額コース',
        'nuance-l' => 'ニュアンスL定額コース',
        'nuance-xl' => 'ニュアンスXL定額コース'
    );
    
    // アートパーツのサブカテゴリー
    $art_parts_subcategories = array(
        'lame-holo-seal' => 'ラメ・ホロ・シール',
        'stone-studs-pearl' => 'ストーン・スタッズ・パール',
        'parts' => 'パーツ',
        'color' => 'カラー'
    );
    
    // サブカテゴリーの登録
    foreach ($hand_foot_subcategories as $slug => $name) {
        if (!term_exists($name, 'gallery_sub_category')) {
            wp_insert_term($name, 'gallery_sub_category', array('slug' => $slug));
        }
    }
    
    foreach ($art_parts_subcategories as $slug => $name) {
        if (!term_exists($name, 'gallery_sub_category')) {
            wp_insert_term($name, 'gallery_sub_category', array('slug' => $slug));
        }
    }
}
add_action('init', 'fascina_register_default_terms');

// ギャラリー登録のACFフィールド(メインカテゴリー,サブカテゴリー)を追加
function fascina_add_gallery_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_gallery_categories',
            'title' => 'ギャラリーカテゴリー設定',
            'fields' => array(
                array(
                    'key' => 'field_gallery_main_category',
                    'label' => 'メインカテゴリー',
                    'name' => 'gallery_main_category',
                    'type' => 'taxonomy',
                    'instructions' => 'メインカテゴリーを選択してください',
                    'required' => 1,
                    'taxonomy' => 'gallery_main_category',
                    'field_type' => 'select',
                    'allow_null' => 0,
                    'add_term' => 0,
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'id',
                    'multiple' => 0,
                ),
                array(
                    'key' => 'field_gallery_sub_category',
                    'label' => 'サブカテゴリー',
                    'name' => 'gallery_sub_category',
                    'type' => 'taxonomy',
                    'instructions' => 'サブカテゴリーを選択してください',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_gallery_main_category',
                                'operator' => '!=',
                                'value' => '',
                            ),
                        ),
                    ),
                    'taxonomy' => 'gallery_sub_category',
                    'field_type' => 'select',
                    'allow_null' => 1,
                    'add_term' => 0,
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'id',
                    'multiple' => 0,
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
    }
}
add_action('acf/init', 'fascina_add_gallery_acf_fields');

// メインカテゴリーに基づいてサブカテゴリーを動的に制限するJavaScript
function fascina_admin_gallery_script() {
    global $post_type;
    if ($post_type !== 'gallery') return;
    
    ?>
    <script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            // メインカテゴリーのセレクトボックス
            var $mainCategory = $('#acf-field_gallery_main_category');
            // サブカテゴリーのセレクトボックス
            var $subCategory = $('#acf-field_gallery_sub_category');
            
            // メインカテゴリーが変更されたときの処理
            $mainCategory.on('change', function() {
                var selectedMainCategory = $(this).val();
                var selectedMainCategoryText = $(this).find('option:selected').text();
                
                // すべてのオプションを一旦非表示
                $subCategory.find('option').hide();
                $subCategory.find('option[value=""]').show();
                
                // メインカテゴリーに応じてサブカテゴリーを表示
                if (selectedMainCategoryText.indexOf('HAND定額コース') !== -1 || 
                    selectedMainCategoryText.indexOf('FOOT定額コース') !== -1) {
                    // HANDとFOOT定額コースのサブカテゴリー
                    $subCategory.find('option').each(function() {
                        var text = $(this).text();
                        if (text.indexOf('定額コース') !== -1 || text.indexOf('ブライダルデザイン') !== -1) {
                            $(this).show();
                        }
                    });
                } else if (selectedMainCategoryText.indexOf('アートパーツ') !== -1) {
                    // アートパーツのサブカテゴリー
                    $subCategory.find('option').each(function() {
                        var text = $(this).text();
                        if (text.indexOf('ラメ') !== -1 || 
                            text.indexOf('ストーン') !== -1 || 
                            text.indexOf('パーツ') !== -1 || 
                            text.indexOf('カラー') !== -1) {
                            $(this).show();
                        }
                    });
                } else if (selectedMainCategoryText.indexOf('GUESTギャラリー') !== -1) {
                    // GUESTギャラリーはサブカテゴリーなし
                    $subCategory.val('');
                    $subCategory.closest('.acf-field').hide();
                    return;
                }
                
                // サブカテゴリーフィールドを表示
                $subCategory.closest('.acf-field').show();
            });
            
            // 初期表示時にも実行
            $mainCategory.trigger('change');
        });
    })(jQuery);
    </script>
    <?php
}
add_action('admin_footer', 'fascina_admin_gallery_script');

// カスタムリライトルールの追加
function fascina_add_rewrite_rules() {
    // HAND定額コース
    add_rewrite_rule(
        'gallery_hand_design([1-3])_([0-9]+)\.html$',
        'index.php?pagename=gallery-template&category=hand&design_type=$matches[1]&page_num=$matches[2]',
        'top'
    );
    
    // FOOT定額コース
    add_rewrite_rule(
        'gallery_foot_design([1-3])_([0-9]+)\.html$',
        'index.php?pagename=gallery-template&category=foot&design_type=$matches[1]&page_num=$matches[2]',
        'top'
    );
    
    // ブライダルデザイン
    add_rewrite_rule(
        'gallery_bridal_design_([0-9]+)\.html$',
        'index.php?pagename=gallery-template&category=bridal&page_num=$matches[1]',
        'top'
    );
    
    // アート・パーツ
    add_rewrite_rule(
        'gallery_arts_parts([6-8])_([0-9]+)\.html$',
        'index.php?pagename=gallery-template&category=arts-parts&parts_type=$matches[1]&page_num=$matches[2]',
        'top'
    );
}
add_action('init', 'fascina_add_rewrite_rules');

// クエリ変数の追加
function fascina_add_query_vars($vars) {
    $vars[] = 'gallery_main_category';
    $vars[] = 'gallery_sub_category';
    $vars[] = 'page_num';
    return $vars;
}
add_filter('query_vars', 'fascina_add_query_vars');

// パーマリンク更新時にリライトルールをフラッシュ
function fascina_flush_rewrite_rules() {
    fascina_add_rewrite_rules();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'fascina_flush_rewrite_rules');