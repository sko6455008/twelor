<?php
/**
 * Template Name: 月替わりクーポン
 */

get_header();

// 現在のページ番号を取得
$current_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// 1ページあたりの表示数
$posts_per_page = 51;

// 現在時刻を取得
$current_time = current_time('mysql');

//ネイリスト情報を取得
$nailist = get_query_var('nailist');

// クーポンの投稿を取得
$coupon_query = twelor_get_coupon_page_posts($posts_per_page, $current_paged, $nailist);

$nailist_navigation = twelor_get_nailist_navigation($nailist);

// 総ページ数を計算
$total_posts = $coupon_query->found_posts;
$total_pages = ceil($total_posts / $posts_per_page);
?>

<div class="page-header">
    <div class="headline-area">
        <h1 class="headline">Coupon</h1>
        <p class="title">月替わりクーポン</p>
    </div>
</div>

<div class="coupon-container">
    <div class="nailist-navigation">
        <div class="row">
            <?php 
            foreach ($nailist_navigation as $nav_item) : 
            ?>
                <div class="col-md-4 col-6">
                    <a href="<?php echo esc_url($nav_item['url']); ?>" class="nailist-nav-item <?php echo $nav_item['active'] ? 'active' : ''; ?>">
                        <?php echo esc_html($nav_item['name']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- カテゴリータイトル -->
    <div class="category-title">
        <?php if ($total_pages > 0): ?>
            <div class="page-indicator">
                <span class="page-number"><?php echo $current_paged; ?>ページ目</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- ギャラリー本体 -->
    <?php if ($coupon_query->have_posts()) : ?>
        <div class="coupon-box">
            <?php while ($coupon_query->have_posts()) : $coupon_query->the_post(); 
                $price = get_field('coupon_price', get_the_ID());
                $description = get_field('coupon_description', get_the_ID());
            ?>
                <div class="coupon fade-in-section">
                    <h2 class="coupon-title"><?php the_title(); ?></h2>
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="coupon-image-box">
                        <?php the_post_thumbnail('large', array('class' => 'coupon-image')); ?>
                        <?php if (twelor_should_show_new_tag(get_the_ID())): ?>
                            <?php echo twelor_get_new_tag_html(); ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($description) : ?>
                        <p class="coupon-description"><?php echo nl2br(esc_html($description)); ?></p>
                    <?php endif; ?>
                    <?php if ($price) : ?>
                        <p class="coupon-price"><?php echo esc_html($price); ?></p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- ページネーション -->
        <?php if ($coupon_query->max_num_pages > 1) : ?>
            <div class="pagination-container">
                <div class="pagination custom-pagination">
                    <?php
                    $big = 999999999;
                    $links = paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'current' => max(1, $current_paged),
                        'total' => $coupon_query->max_num_pages,
                        'prev_text' => '&laquo; 前へ',
                        'next_text' => '次へ &raquo;',
                        'type' => 'array'
                    ));

                    if ($links) {
                        foreach ($links as $link) {
                            // アクティブページには active クラスを付与
                            if (strpos($link, 'current') !== false) {
                                echo str_replace('page-numbers', 'pagination-link active', $link);
                            } else {
                                echo str_replace('page-numbers', 'pagination-link', $link);
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="no-coupons-found">
            <p>現在、有効なクーポンはありません。</p>
        </div>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</div>

<style>
    /* ページヘッダー */
    .page-header {
        background: url("<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coupon.jpg") no-repeat center center;
        background-size: cover;
        width: 100%;
        height: 420px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 70px;
    }
    .headline-area {
        max-width: 800px;
        position: relative;
        z-index: 1;
        text-align: center;
        color: #fff;
    }
    .headline,.title {
        text-shadow: 1px 1px 5px #735E59;
    }

    /* couponセクション */
    .coupon-container {
        padding: 50px 0;
    }
    .nailist-navigation {
        margin-bottom: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .nailist-nav-item {
        display: block;
        background-color: #f8f8f8;
        padding: 12px;
        margin-bottom: 10px;
        text-align: center;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
        transition: all 0.3s;
        border: 1px solid #eee;
        font-size: 13px;
    }
    .nailist-nav-item:hover, .nailist-nav-item.active {
        background-color: #95bac3;
        color: #fff;
        border-color: #95bac3;
    }
    .no-coupons-found {
        text-align: center;
        padding: 50px 0;
        color: #666;
    }
    .category-title {
        display: flex;
        justify-content: center;
        margin: 20px 0px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .page-indicator {
        font-size: 14px;
        color: #666;
    }
    .coupon-box {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        list-style: none;
        padding: 0 5%;
        margin: 0;
    }
    .pagination-container {
        text-align: center;
        margin: 40px 0;
    }
    .pagination.custom-pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .pagination-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        background-color: #fff;
        border: 1px solid #95bac3;
        color: #95bac3;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .pagination-link:hover {
        background-color: #95bac3;
        color: #fff;
        border-color: #95bac3;
    }
    .pagination-link.active {
        background-color: #95bac3;
        color: #fff;
        border-color: #95bac3;
        font-weight: 600;
    }
    .pagination-link:active {
        transform: scale(0.98);
    }
    /* レスポンシブ対応 */
    @media (max-width: 1024px) {
        .nailist-navigation {
            margin: 0 5%;
        }
    }
    @media (max-width: 991px) {
        .category-title h2 {
            font-size: 16px;
        }
    }
    .new-tag-wrapper {
        position: absolute;
        top: 0;
        left: -75px;
        width: 200px;
        height: 40px;
        overflow: hidden;
        transform: rotate(-45deg);
    }

    .new-tag {
        position: absolute;
        display: block;
        width: 100%;
        padding: 8px 0;
        background-color: #95bac3;;
        color: #fff;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        z-index: 1;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    @media (max-width: 768px) {
        .coupon-box {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 425px) {
        .new-tag-wrapper {
            left: -80px;
        }
        .new-tag {
            padding: 2px 0;
            font-size: 10px;
        }
    }
</style>

<?php get_footer(); ?>