<?php
/**
 * Template Name: 月替わりクーポン
 */
get_header();

// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// クーポンの投稿を取得
$args = array(
    'post_type' => 'coupon',
    'posts_per_page' => 9,
    'paged' => $paged,
);
$coupon_query = new WP_Query($args);
?>

<div class="container py-5" id="here">
    <h1 class="fascina-section-title mb-4">月替わりクーポン</h1>
    
    <div class="row">
        <?php
        if ($coupon_query->have_posts()) :
            while ($coupon_query->have_posts()) : $coupon_query->the_post();
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <?php if (function_exists('get_field')) : ?>
                            <p class="card-text">価格: <?php echo esc_html(get_field('coupon_price')); ?></p>
                            <p class="card-text">有効期限: <?php echo esc_html(get_field('coupon_expiry')); ?></p>
                        <?php endif; ?>
                        <?php the_excerpt(); ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn-sm" style="background-color: #ff69b4; color: white;">詳細を見る</a>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else :
        ?>
            <div class="col-12">
                <p>現在、クーポンはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination-wrapper mt-4">
        <nav aria-label="クーポンページネーション">
            <?php
            $big = 999999999;
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, $paged),
                'total' => $coupon_query->max_num_pages,
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'type' => 'list',
                'end_size' => 3,
                'mid_size' => 3
            ));
            ?>
        </nav>
    </div>
    <?php wp_reset_postdata(); ?>
    
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: #ff69b4; color: white;">
                    <h2 class="h5 mb-0">クーポンのご利用方法</h2>
                </div>
                <div class="card-body">
                    <ol>
                        <li>ご予約時に「クーポンを利用したい」とお伝えください。</li>
                        <li>ご来店時にクーポンページをスタッフにご提示ください。</li>
                        <li>クーポンは有効期限内にご利用ください。</li>
                        <li>他のクーポンや割引との併用はできません。</li>
                        <li>一部対象外のメニューがある場合がございます。</li>
                    </ol>
                    <div class="alert alert-info mt-3">
                        <p class="mb-0">クーポンに関するご質問は、お気軽にお問い合わせください。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>