<?php
/**
 * Template Name: 月替わりクーポン
 */

get_header();

// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// 現在時刻を取得
$current_time = current_time('mysql');

// クーポンの投稿を取得
$coupon_query = fascina_get_coupon_page_posts(9, $paged);
?>

<div class="coupon-container">
    <div class="coupon-header">
        <h2 class="coupon-title">月替わりクーポン</h2>
    </div>

    <?php if ($coupon_query->have_posts()) : ?>
        <div class="coupon-grid">
            <div class="row">
                <?php while ($coupon_query->have_posts()) : $coupon_query->the_post(); 
                    $period = get_field('coupon_period', get_the_ID());
                    $price = get_field('coupon_price', get_the_ID());
                    $guidance = get_field('coupon_guidance', get_the_ID());
                    $description = get_field('coupon_description', get_the_ID());
                ?>
                    <div class="col-lg-4-0 col-md-6 col-12">
                        <div class="coupon-item">
                            <div class="coupon-content">
                                <h2 class="coupon-name"><?php the_title(); ?></h2>
                                <?php if ($guidance) : ?>
                                    <p class="coupon-guidance"><?php echo nl2br(esc_html($guidance)); ?></p>
                                <?php endif; ?>
                                <?php if ($description) : ?>
                                    <p class="coupon-description"><?php echo nl2br(esc_html($description)); ?></p>
                                <?php endif; ?>
                                <?php if ($price) : ?>
                                    <p class="coupon-price"><?php echo esc_html($price); ?></p>
                                <?php endif; ?>
                                <?php if (has_post_thumbnail()) : ?>
                                <div class="coupon-image">
                                    <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                </div>
                                <?php endif; ?>
                                <?php 
                                $start_date = get_field('coupon_period_start_date', get_the_ID());
                                $end_date = get_field('coupon_period_end_date', get_the_ID());
                                if ($start_date && $end_date) : 
                                    $start_date_formatted = date_i18n('Y年m月d日H時i分', strtotime($start_date));
                                    $end_date_formatted = date_i18n('Y年m月d日H時i分', strtotime($end_date));
                                ?>
                                    <p class="coupon-period"><?php echo esc_html($start_date_formatted); ?>～<?php echo esc_html($end_date_formatted); ?>迄</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- ページネーション -->
        <?php if ($coupon_query->max_num_pages > 1) : ?>
            <div class="pagination-container">
                <div class="pagination custom-pagination">
                    <?php
                    $big = 999999999;
                    $links = paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'current' => max(1, $paged),
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
    .coupon-container {
        padding: 30px 0;
    }
    .coupon-header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .coupon-title {
        font-size: 24px;
        color: #333;
        font-weight: normal;
    }
    .coupon-grid {
        margin: 30px;
    }
    .coupon-item {
        margin-bottom: 40px;
        padding: 0 10px;
    }
    .coupon-item:hover {
        transform: translateY(-5px);
    }
    .coupon-image {
        background-color: #fff;
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s ease;
        padding: 5px;
    }
    .coupon-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    .coupon-content {
        padding: 20px;
        background: #f1f1f1;
    }
    .coupon-name {
        font-size: 16px;
        margin: 0 0 5px;
        color: #333;
    }
    .coupon-period {
        font-size: 14px;
        color: #666;
        text-align: center;
    }
    .coupon-price {
        font-size: 18px;
        color: #e75a87;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .coupon-guidance {
        font-size: 15px;
        color: #444;
        margin-bottom: 10px;
    }
    .coupon-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 0;
    }
    .no-coupons-found {
        text-align: center;
        padding: 50px 0;
        color: #666;
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
        border: 1px solid #e75a87;
        color: #e75a87;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .pagination-link:hover {
        background-color: #e75a87;
        color: #fff;
        border-color: #e75a87;
    }
    .pagination-link.active {
        background-color: #e75a87;
        color: #fff;
        border-color: #e75a87;
        font-weight: 600;
    }
    .pagination-link:active {
        transform: scale(0.98);
    }
    .col-lg-4-0 { 
        flex: 0 0 33.3333%;
        max-width: 33.3333%;
    }

    /* カスタムグリッドクラス */
    @media (max-width: 991px) {
        .coupon-item {
            max-width: 100%;
        }
        .coupon-title {
            font-size: 20px;
        }
        .coupon-name {
            font-size: 15px;
        }
        .coupon-price {
            font-size: 15px;
        }
        .col-lg-4-0 { 
            flex: 0 0 50%;
            max-width: 50%; 
        }
    }
    @media (max-width: 767px) {
        .coupon-item {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .coupon-title {
            font-size: 18px;
        }
        .coupon-content {
            padding: 15px;
        }
        .coupon-name {
            font-size: 14px;
        }
        .coupon-period {
            font-size: 12px;
        }
        .coupon-price {
            font-size: 14px;
        }
        .coupon-guidance {
            font-size: 12px;
        }
        .coupon-description {
            font-size: 12px;
        }
        .col-lg-4-0 { 
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<?php get_footer(); ?>