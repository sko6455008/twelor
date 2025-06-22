<?php 
/**
 * Template Name: トップページ
 * Template Post Type: page
 */

get_header(); ?>

<!-- ランキングセクション -->
<section class="ranking-section">
    <h1 class="fascina-section-title"><?php echo esc_html(get_field('ranking') ?: 'ランキング'); ?></h1>

    <div class="ranking-slider-container">
        <div class="ranking-slider">
            <?php
            $ranking_args = array(
                'post_type' => 'ranking',
                'posts_per_page' => 10,
                'meta_key' => 'ranking_position',
                'orderby' => 'meta_value_num',
                'order' => 'ASC'
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
                            <?php the_post_thumbnail('large'); ?>
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
    <h1 class="fascina-section-title"><?php echo esc_html(get_field('info') ?: 'お知らせ'); ?></h1>
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

<!-- HAND定額コースセクション -->
<section class="hand-design-section">
    <h1 class="fascina-section-title"><?php echo esc_html(get_field('hand') ?: 'HAND定額コース'); ?></h1>
    <div class="design-box">
        <?php
        $hand_args = array(
            'post_type' => 'gallery',
            'posts_per_page' => 9,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'gallery_main_category',
                    'value' => 'hand',
                    'compare' => '='
                ),
                array(
                    'key' => 'gallery_display_top',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => array(
                'menu_order' => 'ASC',
                'date' => 'DESC'
            ),
        );
        $hand_query = new WP_Query($hand_args);
        if ($hand_query->have_posts()) :
            while ($hand_query->have_posts()) : $hand_query->the_post();
        ?>
            <div>
                <div class="image-box">
                    <?php the_post_thumbnail('large', array('class' => 'image')); ?>
                </div>
                <p class="design-title"><?php the_title(); ?></p>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <div class="no-designs">
                <p style="text-align: center;">HAND定額コースはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4">
        <a href="<?php echo esc_url(home_url('/gallery_hand_design/simple/')); ?>" class="btn more-button">
            もっと見る <i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>
</section>

<!-- GUESTギャラリーセクション -->
<section class="guest-design-section">
    <h1 class="fascina-section-title"><?php echo esc_html(get_field('guest') ?: 'GUESTギャラリー'); ?></h1>
    <div class="design-box">
        <?php
        $guest_args = array(
            'post_type' => 'gallery',
            'posts_per_page' => 9,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'gallery_main_category',
                    'value' => 'guest',
                    'compare' => '='
                ),
                array(
                    'key' => 'gallery_display_top',
                    'value' => '1',
                    'compare' => '='
                )
            ),
            'orderby' => array(
                'menu_order' => 'ASC',
                'date' => 'DESC'
            ),
        );
        $guest_query = new WP_Query($guest_args);
        if ($guest_query->have_posts()) :
            while ($guest_query->have_posts()) : $guest_query->the_post();
        ?>
            <div>
                <div class="image-box">
                    <?php the_post_thumbnail('large', array('class' => 'image')); ?>
                </div>
                <p class="design-title"><?php the_title(); ?></p>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <div class="no-designs">
                <p style="text-align: center;">GUESTギャラリーはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4">
        <a href="<?php echo esc_url(home_url('/gallery_guest_nail/')); ?>" class="btn more-button">
            もっと見る <i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>
</section>

<!-- クーポンセクション -->
<section class="coupon-section">
    <h1 class="fascina-section-title"><?php echo esc_html(get_field('coupon') ?: 'クーポン'); ?></h1>
    <div class="design-box">
        <?php
        $coupon_query = fascina_get_top_coupon_posts(9);

        if ($coupon_query->have_posts()) :
            while ($coupon_query->have_posts()) : $coupon_query->the_post();
                $coupon_period = get_field('coupon_period');
                $coupon_price = get_field('coupon_price');
                $coupon_guidance = get_field('coupon_guidance');
                $coupon_description = get_field('coupon_description');
        ?>
                <div class="coupon">
                    <div class="coupon-title"><?php the_title(); ?></div>
                    <div class="coupon-guidance"><?php echo nl2br(esc_html($coupon_guidance)); ?></div>
                    <div class="coupon-description"><?php echo nl2br(esc_html($coupon_description)); ?></div>   
                    <div class="coupon-price"><?php echo esc_html($coupon_price); ?></div>
                    <div class="coupon-image-box">
                        <?php the_post_thumbnail('large', array('class' => 'coupon-image')); ?>
                    </div>
                    <?php 
                    $start_date = get_field('coupon_period_start_date', get_the_ID());
                    $end_date = get_field('coupon_period_end_date', get_the_ID());
                    if ($start_date && $end_date) : 
                        $start_date_formatted = date_i18n('Y年m月d日', strtotime($start_date));
                        $end_date_formatted = date_i18n('Y年m月d日', strtotime($end_date));
                    ?>
                        <p class="coupon-period">期間:<?php echo esc_html($start_date_formatted); ?>～<?php echo esc_html($end_date_formatted); ?>迄</p>
                    <?php endif; ?>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <div class="no-designs">
                <p style="text-align: center;">クーポンはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4">
        <a href="<?php echo esc_url(home_url('/coupon/')); ?>" class="btn more-button">
            もっと見る <i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>
</section>

<?php get_footer(); ?>