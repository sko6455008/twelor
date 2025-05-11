<?php
/**
 * Template Name: 口コミ
 */
get_header();

// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// 口コミの投稿を取得
$args = array(
    'post_type' => 'review',
    'posts_per_page' => 10,
    'paged' => $paged,
    'meta_key' => 'review_date',
    'orderby' => 'meta_value',
    'order' => 'DESC',
);
$review_query = new WP_Query($args);
?>

<div class="container py-5">
    <h1 class="fascina-section-title mb-4">お客様の声</h1>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h2 class="h4 mb-3" style="color: #ff69b4;">お客様満足度</h2>
                            <div class="d-flex align-items-center mb-2">
                                <div class="h1 me-3">4.8</div>
                                <div>
                                    <div class="text-warning mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div>5段階中の平均評価</div>
                                </div>
                            </div>
                            <p>多くのお客様にご満足いただいております。<br>皆様のご意見を参考に、さらにサービス向上に努めてまいります。</p>
                        </div>
                        <div class="col-md-6">
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 85%; background-color: #ff69b4;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">5★ (85%)</div>
                            </div>
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 10%; background-color: #ff69b4;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">4★ (10%)</div>
                            </div>
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 5%; background-color: #ff69b4;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">3★ (5%)</div>
                            </div>
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%; background-color: #ff69b4;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">2★ (0%)</div>
                            </div>
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%; background-color: #ff69b4;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">1★ (0%)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <?php
        if ($review_query->have_posts()) :
            while ($review_query->have_posts()) : $review_query->the_post();
                $rating = get_field('review_rating');
                $author = get_field('review_author');
                $date = get_field('review_date');
        ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #fff;">
                        <h5 class="mb-0"><?php echo esc_html($author); ?></h5>
                        <div class="text-warning">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if ($i <= $rating) : ?>
                                    <i class="fas fa-star"></i>
                                <?php else : ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <div class="card-text"><?php the_content(); ?></div>
                    </div>
                    <div class="card-footer text-muted">
                        <?php echo esc_html($date); ?>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else :
        ?>
            <div class="col-12">
                <p>口コミはまだありません。</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination-wrapper mt-4">
        <nav aria-label="口コミページネーション">
            <?php
            $big = 999999999;
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, $paged),
                'total' => $review_query->max_num_pages,
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
                    <h2 class="h5 mb-0">口コミを投稿する</h2>
                </div>
                <div class="card-body">
                    <p>お客様の声をお聞かせください。サービス向上のために、貴重なご意見をお待ちしております。</p>
                    <p>口コミは以下のいずれかの方法で投稿いただけます：</p>
                    <ul>
                        <li>Google マップでの口コミ</li>
                        <li>Instagram での投稿（ハッシュタグ #fascinanail をつけてください）</li>
                        <li>LINE での直接メッセージ</li>
                    </ul>
                    <div class="mt-3">
                        <a href="https://g.page/r/fascinanail/review" target="_blank" class="btn me-2" style="background-color: #ff69b4; color: white;">Google で口コミを書く</a>
                        <a href="https://page.line.me/421zexkf?openQrModal=true" class="btn" style="background-color: #ff69b4; color: white;">LINE で送る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>