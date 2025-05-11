    <?php get_header(); ?>

    <!-- ランキングセクション -->
    <section class="ranking-section">
        <h3 class="fascina-section-title">
            <span class="ranking-title">Ranking</span>
        </h3>

        <div class="ranking-slider-container">
            <div class="ranking-slider">
                <?php
                $ranking_args = array(
                    'post_type' => 'ranking',
                    'posts_per_page' => 10,
                    'meta_key' => 'ranking_position',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                );
                $ranking_query = new WP_Query($ranking_args);

                if ($ranking_query->have_posts()) :
                    $ranking_posts = array();

                    while ($ranking_query->have_posts()) : $ranking_query->the_post();
                        $position = get_field('ranking_position');
                ?>
                    <div class="ranking-slide">
                        <div class="ranking-item">
                            <div class="ranking-number"><?php echo esc_html($position); ?> 位</div>
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo "<script>console.log('ランキング投稿が存在しません');</script>";
                endif;
                ?>
            </div>
            
            <!-- ナビゲーションボタン -->
            <button class="ranking-prev" aria-label="前へ">&#10094;</button>
            <button class="ranking-next" aria-label="次へ">&#10095;</button>
        </div>
    </section>

    <!-- お知らせセクション -->
    <section class="info-section">
        <h2 class="fascina-section-title">Info</h2>
        <div class="info-box">
            <?php
            $info_args = array(
                'post_type' => 'info',
                'posts_per_page' => 3,
            );
            $info_query = new WP_Query($info_args);

            if ($info_query->have_posts()) :
                while ($info_query->have_posts()) : $info_query->the_post();
                    $period = get_field('info_period');
                    $description = get_field('info_description');
            ?>
                <div class="info-item">
                    <div class="info-period"><?php echo esc_html(acf_format_date($period, 'Y/m/d')); ?></div>
                    <div class="info-description"><?php echo esc_html($description); ?></div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="col-12">
                    <p style="text-align: center;">お知らせはありません。</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- HANDデザインセクション -->
    <section class="hand-design-section">
        <h2 class="fascina-section-title">HANDデザイン</h2>
        <ul class="hand-design-box">
            <?php
            $hand_args = array(
                'post_type' => 'gallery',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'gallery_main_category',
                        'field' => 'slug',
                        'terms' => 'hand',
                    ),
                ),
            );
            $hand_query = new WP_Query($hand_args);
            echo '<script>console.log(' . json_encode($hand_query) . ');</script>';
            if ($hand_query->have_posts()) :
                while ($hand_query->have_posts()) : $hand_query->the_post();
            ?>
                <li class="card">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                    </a>
                    <p class="card-title"><?php the_title(); ?></p>
                </li>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="col-12 text-center">
                    <p class="text-muted">HANDデザインはありません。</p>
                </div>
            <?php endif; ?>
        </ul>
        <div class="text-center py-4">
            <a href="<?php echo esc_url(home_url('/gallery-category/hand/')); ?>" class="btn more-button">
                もっと見る <i class="fas fa-chevron-right ms-2"></i>
            </a>
        </div>
    </section>

    <!-- (GUEST)ギャラリーセクション -->

    <!-- クーポンセクション -->

    <!-- ブログセクション -->

    <?php get_footer(); ?>