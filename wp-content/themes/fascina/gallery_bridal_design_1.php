<?php
/**
 * Template Name: ブライダルデザイン
 */
get_header();

// 現在のページ番号を取得
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// ギャラリーの投稿を取得
$args = array(
    'post_type' => 'gallery',
    'posts_per_page' => 12,
    'paged' => $paged,
    'tax_query' => array(
        array(
            'taxonomy' => 'gallery_category',
            'field' => 'slug',
            'terms' => 'bridal',
        ),
    ),
);
$gallery_query = new WP_Query($args);
?>

<div class="container py-5">
    <h1 class="fascina-section-title mb-4">ブライダルデザイン</h1>
    
    <div class="row">
        <?php
        if ($gallery_query->have_posts()) :
            while ($gallery_query->have_posts()) : $gallery_query->the_post();
        ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <?php if (function_exists('get_field')) : ?>
                            <p class="card-text"><?php echo esc_html(get_field('gallery_price')); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn-sm" style="background-color: #ff69b4; color: white;">詳細を見る</a>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else :
        ?>
            <div class="col-12">
                <p>ギャラリーはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination-wrapper mt-4">
        <nav aria-label="ギャラリーページネーション">
            <?php
            // カスタムページネーションリンクの生成
            $total_pages = $gallery_query->max_num_pages;
            if ($total_pages > 1) {
                echo '<ul class="pagination">';
                
                // 前のページへのリンク
                if ($paged > 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/gallery_bridal_design_' . ($paged - 1) . '.html') . '#here">&laquo;</a></li>';
                } else {
                    echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
                }
                
                // ページ番号リンク
                $start_page = max(1, $paged - 2);
                $end_page = min($total_pages, $paged + 2);
                
                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/gallery_bridal_design_1.html') . '#here">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }
                
                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $paged) {
                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="' . home_url('/gallery_bridal_design_' . $i . '.html') . '#here">' . $i . '</a></li>';
                    }
                }
                
                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/gallery_bridal_design_' . $total_pages . '.html') . '#here">' . $total_pages . '</a></li>';
                }
                
                // 次のページへのリンク
                if ($paged < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/gallery_bridal_design_' . ($paged + 1) . '.html') . '#here">&raquo;</a></li>';
                } else {
                    echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
                }
                
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>