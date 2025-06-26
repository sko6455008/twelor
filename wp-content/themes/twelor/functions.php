<?php
/**
 * Twelor テーマの機能
 */

// テーマのセットアップ
function twelor_setup() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // メニューの登録
    register_nav_menus(array(
        'primary' => __('ヘッダーメニュー', 'fascina'),
        'footer_menu' => __('フッターメニュー', 'fascina'),
        'footer_design' => __('フッターデザイン', 'fascina'),
    ));
}
add_action('after_setup_theme', 'twelor_setup');

// スタイルシートとスクリプトの読み込み
function twelor_scripts() {
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
    } elseif ($post->post_type === 'ranking') {
        $title = 'ギャラリー名を入力';
    }
    return $title;
}
add_filter('enter_title_here', 'twelor_change_title_placeholder', 10, 2);

// Intuitive Custom Post Order プラグインのサポート
function twelor_enable_custom_post_order() {
    // ギャラリー投稿タイプでカスタムオーダーを有効化
    add_post_type_support('gallery', 'page-attributes');
    add_post_type_support('coupon', 'page-attributes');
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

// カスタム投稿タイプ: ランキング
function twelor_register_ranking_post_type() {
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
add_action('init', 'twelor_register_ranking_post_type');

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
                        'simple-guest' => 'シンプル',
                        'magnet' => 'マグネット',
                        'long' => '長さだし',
                        'short' => 'ショートネイル',
                        'foot' => 'フットネイル',
                        'hand-art' => '手書きアート',
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
                    'label' => '料金案内',
                    'name' => 'coupon_guidance',
                    'type' => 'textarea',
                    'required' => 1,
                    'instructions' => '例: 初回5510円/リピ6510円',
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
        // ランキングの場合
        if (is_post_type_archive('ranking') || $query->get('post_type') === 'ranking') {
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
        
        if (in_array($post_type, array('gallery', 'coupon', 'ranking'))) {
            if (!$query->get('orderby')) {
                $query->set('orderby', 'menu_order');
                $query->set('order', 'ASC');
            }
        }
    }
}
add_action('pre_get_posts', 'twelor_admin_gallery_order');

// ギャラリーのカテゴリー,サブカテゴリー連動機能用JavaScript
function twelor_gallery_category_script() {
    if (get_post_type() !== 'gallery') return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        const handCategories = [
            'simple','popular','special','clean',
            'onehon-s','onehon-m','onehon-l','bridal',
            'nuance-s','nuance-m','nuance-l','nuance-xl'
        ];
        
        const footCategories = [
            'simple','popular','special'
        ];
        
        const guestCategories = [
            'simple-guest','magnet','long','short','foot', 'hand-art'
        ];
        
        const artPartsCategories = [
            'lame-holo-seal', 'stone-studs-pearl',
            'parts', 'color'
        ];

        function updateSubCategories() {
            const mainSelected = $('[name="acf[field_gallery_main_category]"]:checked').val();
            const $subCategories = $('[name="acf[field_gallery_sub_category]"]');
            let defaultSubCategory = '';

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
                defaultSubCategory = 'simple';
            }
            else if (mainSelected === 'foot') {
                // FOOT定額コースが選択された場合
                footCategories.forEach(category => {
                    $(`[name="acf[field_gallery_sub_category]"][value="${category}"]`)
                        .prop('disabled', false)
                        .closest('li')
                        .show();
                });
                defaultSubCategory = 'simple';
            }
            else if (mainSelected === 'guest') {
                // GUESTギャラリーが選択された場合
                guestCategories.forEach(category => {
                    $(`[name="acf[field_gallery_sub_category]"][value="${category}"]`)
                        .prop('disabled', false)
                        .closest('li')
                        .show();
                });
                defaultSubCategory = 'simple-guest';
            }
            else if (mainSelected === 'arts-parts') {
                // アートパーツが選択された場合
                artPartsCategories.forEach(category => {
                    $(`[name="acf[field_gallery_sub_category]"][value="${category}"]`)
                        .prop('disabled', false)
                        .closest('li')
                        .show();
                });
                defaultSubCategory = 'lame-holo-seal';
            }

            // 非表示のラジオボタンが選択されている場合、選択を解除
            if ($subCategories.filter(':checked').prop('disabled')) {
                $subCategories.prop('checked', false);
            }

            // デフォルト値を設定（選択されていない場合のみ）
            if (!$subCategories.filter(':checked').length && defaultSubCategory) {
                $(`[name="acf[field_gallery_sub_category]"][value="${defaultSubCategory}"]`).prop('checked', true);
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
add_action('admin_footer', 'twelor_gallery_category_script');

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
            'simple-guest' => 'シンプル',
            'magnet' => 'マグネット',
            'long' => '長さだし',
            'short' => 'ショートネイル',
            'foot' => 'フットネイル',
            'hand-art' => '手書きアート',
            'lame-holo-seal' => 'ラメ・ホロ・シール',
            'stone-studs-pearl' => 'ストーン・スタッズ・パール',
            'parts' => 'パーツ',
            'color' => 'カラー'
        );
        echo isset($categories[$sub_category]) ? $categories[$sub_category] : '';
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

// 表示順列をソート可能にする
function twelor_sortable_gallery_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-gallery_sortable_columns', 'twelor_sortable_gallery_columns');

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
add_filter('manage_coupon_posts_columns', 'twelor_add_coupon_columns');

// クーポン一覧のカラム内容を表示
function twelor_coupon_column_content($column_name, $post_id) {
    if ($column_name === 'thumbnail') {
        if (has_post_thumbnail($post_id)) {
            echo get_the_post_thumbnail($post_id, array(60, 60));
        }
    } elseif ($column_name === 'menu_order') {
        $post = get_post($post_id);
        echo $post->menu_order;
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

// ランキング一覧のカラムをカスタマイズ
function twelor_add_ranking_columns($columns) {
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
add_filter('manage_ranking_posts_columns', 'twelor_add_ranking_columns');

// ランキング一覧のカラム内容を表示
function twelor_ranking_column_content($column_name, $post_id) {
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
add_action('manage_ranking_posts_custom_column', 'twelor_ranking_column_content', 10, 2);

// 表示順列をソート可能にする
function twelor_sortable_columns($columns) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-coupon_sortable_columns', 'twelor_sortable_columns');
add_filter('manage_edit-ranking_sortable_columns', 'twelor_sortable_columns');

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
        .column-guidance,
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
    
    // ギャラリー、クーポンの一覧ページでのみ読み込み
    if (in_array($post_type, array('gallery', 'coupon'))) {
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
        <p><?php _e('Twelorテーマは Advanced Custom Fields プラグインが必要です。インストールして有効化してください。', 'twelor'); ?></p>
    </div>
    <?php
}

# -------------------------------
# その他
# -------------------------------

// ギャラリーページのリライトルール
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
}
add_action('init', 'twelor_add_gallery_rewrite_rules');

// クエリ変数の追加
function twelor_add_gallery_query_vars($vars) {
    $vars[] = 'gallery_main_category';
    $vars[] = 'gallery_sub_category';
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
            'hand' => 'HAND定額コース',
            'foot' => 'FOOT定額コース',
            'guest' => 'GUESTギャラリー',
            'arts-parts' => 'アートパーツ'
        );

        // サブカテゴリーの選択肢
        $sub_categories = array(
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
            'simple-guest' => 'シンプル',
            'magnet' => 'マグネット',
            'long' => '長さだし',
            'short' => 'ショートネイル',
            'foot' => 'フットネイル',
            'hand-art' => '手書きアート',
            'lame-holo-seal' => 'ラメ・ホロ・シール',
            'stone-studs-pearl' => 'ストーン・スタッズ・パール',
            'parts' => 'パーツ',
            'color' => 'カラー'
        );

        // 現在選択されている値を取得
        $current_main = isset($_GET['main_category']) ? $_GET['main_category'] : '';
        $current_sub = isset($_GET['sub_category']) ? $_GET['sub_category'] : '';

        // メインカテゴリーのドロップダウン
        echo '<select name="main_category">';
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
        echo '<select name="sub_category">';
        echo '<option value="">サブカテゴリーを選択</option>';
        foreach ($sub_categories as $value => $label) {
            printf(
                '<option value="%s" %s>%s</option>',
                esc_attr($value),
                selected($current_sub, $value, false),
                esc_html($label)
            );
        }
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'twelor_add_gallery_filters');

// フィルター条件を適用
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
        $meta_query[] = array(
            'key' => 'gallery_sub_category',
            'value' => $sub_category,
            'compare' => '='
        );
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
function twelor_get_coupon_page_posts($posts_per_page = 9, $paged = 1) {
    $args = array(
        'post_type' => 'coupon',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'coupon_display_coupon',
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

// ギャラリー、クーポン登録時にmenu_orderの自動設定
function twelor_auto_set_menu_order($data, $postarr) {
    if (!in_array($data['post_type'], array('gallery', 'coupon'))) {
        return $data;
    }
    
    if ($data['post_status'] !== 'auto-draft' && 
        (!isset($postarr['menu_order']) || $postarr['menu_order'] == 0)) {
        
        global $wpdb;
        $max_order = $wpdb->get_var($wpdb->prepare(
            "SELECT MAX(menu_order) FROM {$wpdb->posts} WHERE post_type = %s AND post_status != 'trash'",
            $data['post_type']
        ));
        
        $data['menu_order'] = max(1, intval($max_order) + 1);
    }
    
    return $data;
}
add_filter('wp_insert_post_data', 'twelor_auto_set_menu_order', 10, 2);

// 新規登録、更新時の表示順フィールド削除
function twelor_hide_menu_order_field() {
    global $post_type;
    if (in_array($post_type, array('gallery', 'coupon'))) {
        echo '<style>
            #pageparentdiv,
            #pageparentdiv .inside {
                display: none !important;
            }
        </style>';
    }
}
add_action('admin_head', 'twelor_hide_menu_order_field');