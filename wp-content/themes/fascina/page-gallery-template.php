<?php
/**
 * Template Name: ギャラリーテンプレート
 * 
 * ギャラリーを表示するテンプレートファイル
 */

get_header(); 

// 現在のページ番号を取得
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;

// メインカテゴリーとサブカテゴリーを取得
$main_category = get_query_var('gallery_main_category');
$sub_category = get_query_var('gallery_sub_category');

// 1ページあたりの表示数
$posts_per_page = 3;

// ギャラリー投稿を取得
$args = array(
    'post_type' => 'gallery',
    'posts_per_page' => $posts_per_page,
    'paged' => $current_page,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'gallery_main_category',
            'value' => $main_category,
            'compare' => '='
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC'
);

// GUESTギャラリー以外の場合のみサブカテゴリーの条件を追加
if ($main_category !== 'guest') {
    $args['meta_query'][] = array(
        'key' => 'gallery_sub_category',
        'value' => $sub_category,
        'compare' => '='
    );
}

$gallery_query = new WP_Query($args);

// 総ページ数を計算
$total_posts = $gallery_query->found_posts;
$total_pages = ceil($total_posts / $posts_per_page);

// カテゴリー名を取得
$main_category_name = '';
switch ($main_category) {
    case 'hand':
        $main_category_name = 'HAND定額コース';
        break;
    case 'foot':
        $main_category_name = 'FOOT定額コース';
        break;
    case 'guest':
        $main_category_name = 'GUESTギャラリー';
        break;
    case 'arts-parts':
        $main_category_name = 'アート・パーツ';
        break;
}

$sub_category_name = '';
switch ($sub_category) {
    case 'simple':
        $sub_category_name = 'シンプル定額コース';
        break;
    case 'popular':
        $sub_category_name = '一番人気定額コース';
        break;
    case 'special':
        $sub_category_name = 'こだわり定額コース';
        break;
    case 'clean':
        $sub_category_name = 'キレイめ定額コース';
        break;
    case 'onehon-s':
        $sub_category_name = 'ワンホンS定額コース';
        break;
    case 'onehon-m':
        $sub_category_name = 'ワンホンM定額コース';
        break;
    case 'onehon-l':
        $sub_category_name = 'ワンホンL定額コース';
        break;
    case 'bridal':
        $sub_category_name = 'ブライダルデザイン';
        break;
    case 'nuance-s':
        $sub_category_name = 'ニュアンスS定額コース';
        break;
    case 'nuance-m':
        $sub_category_name = 'ニュアンスM定額コース';
        break;
    case 'nuance-l':
        $sub_category_name = 'ニュアンスL定額コース';
        break;
    case 'nuance-xl':
        $sub_category_name = 'ニュアンスXL定額コース';
        break;
    case 'lame-holo-seal':
        $sub_category_name = 'ラメ・ホロ・シール';
        break;
    case 'stone-studs-pearl':
        $sub_category_name = 'ストーン・スタッズ・パール';
        break;
    case 'parts':
        $sub_category_name = 'パーツ';
        break;
    case 'color':
        $sub_category_name = 'カラー';
        break;
}
?>

<div class="container gallery-container">
    <!-- ヘッダータイトル -->
    <div class="gallery-header">
        <h1 class="gallery-title"><?php echo esc_html($main_category_name); ?></h1>
    </div>

    <!-- オーダーメイドボタン -->
    <div class="custom-order-button">
        <a href="<?php echo home_url('/order-made'); ?>" class="btn btn-primary">オーダーメイドのコースはこちらから</a>
    </div>

    <!-- 無料お色変更の案内 -->
    <div class="color-change-notice">
        <p>※お色変更無料※</p>
    </div>

    <!-- コースカテゴリーナビゲーション -->
    <?php if ($main_category === 'hand'): ?>
    <div class="course-navigation">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/simple/'); ?>" class="course-nav-item <?php echo ($sub_category == 'simple') ? 'active' : ''; ?>">
                    シンプル定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/popular/'); ?>" class="course-nav-item <?php echo ($sub_category == 'popular') ? 'active' : ''; ?>">
                    一番人気定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/special/'); ?>" class="course-nav-item <?php echo ($sub_category == 'special') ? 'active' : ''; ?>">
                    こだわり定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/clean/'); ?>" class="course-nav-item <?php echo ($sub_category == 'clean') ? 'active' : ''; ?>">
                    キレイめ定額コース
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/onehon-s/'); ?>" class="course-nav-item <?php echo ($sub_category == 'onehon-s') ? 'active' : ''; ?>">
                    ワンホンS定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/onehon-m/'); ?>" class="course-nav-item <?php echo ($sub_category == 'onehon-m') ? 'active' : ''; ?>">
                    ワンホンM定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/onehon-l/'); ?>" class="course-nav-item <?php echo ($sub_category == 'onehon-l') ? 'active' : ''; ?>">
                    ワンホンL定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/bridal/'); ?>" class="course-nav-item <?php echo ($sub_category == 'bridal') ? 'active' : ''; ?>">
                    ブライダルデザイン
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-s/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-s') ? 'active' : ''; ?>">
                    ニュアンスS定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-m/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-m') ? 'active' : ''; ?>">
                    ニュアンスM定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-l/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-l') ? 'active' : ''; ?>">
                    ニュアンスL定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-xl/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-xl') ? 'active' : ''; ?>">
                    ニュアンスXL定額コース
                </a>
            </div>
        </div>
    </div>
    <?php elseif ($main_category === 'foot'): ?>
    <div class="course-navigation">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/simple/'); ?>" class="course-nav-item <?php echo ($sub_category == 'simple') ? 'active' : ''; ?>">
                    シンプル定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/popular/'); ?>" class="course-nav-item <?php echo ($sub_category == 'popular') ? 'active' : ''; ?>">
                    一番人気定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/special/'); ?>" class="course-nav-item <?php echo ($sub_category == 'special') ? 'active' : ''; ?>">
                    こだわり定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/clean/'); ?>" class="course-nav-item <?php echo ($sub_category == 'clean') ? 'active' : ''; ?>">
                    キレイめ定額コース
                </a>
            </div>
        </div>
    </div>
    <?php elseif ($main_category === 'arts-parts'): ?>
    <div class="course-navigation">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/lame-holo-seal/'); ?>" class="course-nav-item <?php echo ($sub_category == 'lame-holo-seal') ? 'active' : ''; ?>">
                    ラメ・ホロ・シール
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/stone-studs-pearl/'); ?>" class="course-nav-item <?php echo ($sub_category == 'stone-studs-pearl') ? 'active' : ''; ?>">
                    ストーン・スタッズ・パール
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/parts/'); ?>" class="course-nav-item <?php echo ($sub_category == 'parts') ? 'active' : ''; ?>">
                    パーツ
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/color/'); ?>" class="course-nav-item <?php echo ($sub_category == 'color') ? 'active' : ''; ?>">
                    カラー
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- カテゴリータイトル -->
    <div class="category-title">
        <h2><?php echo esc_html($main_category_name); ?></h2>
        <?php if ($total_pages > 0): ?>
            <div class="page-indicator">
                <span class="page-number"><?php echo $current_page; ?>ページ目</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- ギャラリー本体 -->
    <?php if ($gallery_query->have_posts()): ?>
        <div class="gallery-grid">
            <div class="row">
                <?php while ($gallery_query->have_posts()): $gallery_query->the_post(); ?>
                    <div class="col-md-4 col-6 gallery-item">
                        <div class="gallery-item-inner">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="gallery-image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="gallery-caption">
                                <h3 class="gallery-title"><?php the_title(); ?></h3>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- ページネーション -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination-container">
                <div class="pagination">
                    <?php
                    // カテゴリーに応じてベースURLを設定
                    $base_url = '';
                    if ($main_category === 'guest') {
                        $base_url = home_url("gallery_guest_nail/page/%#%/");
                    } elseif ($main_category === 'arts-parts') {
                        $base_url = home_url("gallery_arts_parts/{$sub_category}/page/%#%/");
                    } else {
                        $base_url = home_url("gallery_{$main_category}_design/{$sub_category}/page/%#%/");
                    }

                    echo paginate_links(array(
                        'base' => $base_url,
                        'format' => '',
                        'current' => $current_page,
                        'total' => $total_pages,
                        'prev_text' => '&laquo; 前へ',
                        'next_text' => '次へ &raquo;'
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="no-posts-found">
            <p>現在、このカテゴリーにはデザインがありません。</p>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

<!-- ギャラリー用のスタイル -->
<style>
    .gallery-container {
        padding: 30px 0;
    }
    .gallery-header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .gallery-title {
        font-size: 24px;
        font-weight: bold;
    }
    .custom-order-button {
        text-align: center;
        margin-bottom: 20px;
    }
    .custom-order-button .btn {
        background-color: #e75a87;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
    }
    .color-change-notice {
        text-align: center;
        margin-bottom: 30px;
        font-size: 14px;
    }
    .course-navigation {
        margin-bottom: 30px;
    }
    .course-nav-item {
        display: block;
        background-color: #f0f0f0;
        padding: 10px;
        margin-bottom: 10px;
        text-align: center;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
        transition: all 0.3s;
    }
    .course-nav-item:hover, .course-nav-item.active {
        background-color: #e75a87;
        color: #fff;
    }
    .category-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .category-title h2 {
        font-size: 20px;
        margin: 0;
    }
    .page-indicator {
        font-size: 14px;
        color: #666;
    }
    .gallery-grid {
        margin-bottom: 30px;
    }
    .gallery-item {
        margin-bottom: 30px;
    }
    .gallery-item-inner {
        border: 1px solid #eee;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .gallery-image img {
        width: 100%;
        height: auto;
        display: block;
    }
    .gallery-caption {
        padding: 10px;
    }
    .gallery-caption h3 {
        font-size: 16px;
        margin: 0 0 5px;
    }
    .gallery-description {
        font-size: 14px;
        color: #666;
    }
    .pagination-container {
        text-align: center;
        margin: 30px 0;
    }
    .pagination {
        display: inline-flex;
        justify-content: center;
    }
    .page-link {
        display: inline-block;
        padding: 5px 10px;
        margin: 0 3px;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 3px;
    }
    .page-link.active {
        background-color: #e75a87;
        color: #fff;
        border-color: #e75a87;
    }
    .page-link:hover {
        background-color: #f5f5f5;
    }
    .page-link.active:hover {
        background-color: #e75a87;
    }
    .no-posts-found {
        text-align: center;
        padding: 50px 0;
        color: #666;
    }
    
    /* レスポンシブ対応 */
    @media (max-width: 767px) {
        .gallery-title {
            font-size: 20px;
        }
        .custom-order-button .btn {
            font-size: 14px;
            padding: 8px 15px;
        }
        .category-title h2 {
            font-size: 18px;
        }
        .gallery-caption h3 {
            font-size: 14px;
        }
        .gallery-description {
            font-size: 12px;
        }
    }
</style>

<?php get_footer(); ?>