<?php 
/**
 * Template Name: トップページ
 * Template Post Type: page
 */

get_header(); ?>
<!-- ヒーローセクション -->
<section>
    <div>
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slide.jpg" alt="パラジェル専門店 Twelor" class="hero-image">
    </div>
</section>

<!-- バナー -->


<!-- お知らせセクション -->
<section class="info-section">
    <h1 class="twelor-section-title">news</h1>
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
                <p style="text-align: center;">newsはありません。</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Hand Designセクション -->
<section class="hand-design-section fade-in-section">
    <h1 class="twelor-section-title">Hand Design</h1>
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
            $delay_counter = 0;
            while ($hand_query->have_posts()) : $hand_query->the_post();
                $delay_counter++;
                $delay_class = 'delay-' . ($delay_counter % 3 + 1);
        ?>
            <div class="fade-in-section <?php echo $delay_class; ?>">
                <?php the_post_thumbnail('large', array('class' => 'image')); ?>
                <p class="design-title"><?php the_title(); ?></p>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <div class="no-designs">
                <p style="text-align: center;">Hand Designはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4">
        <a href="<?php echo esc_url(home_url('/gallery_hand_design/simple/')); ?>" class="btn more-button">
            More <i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>
</section>

<!-- Guest Designセクション -->
<section class="guest-design-section fade-in-section">
    <h1 class="twelor-section-title">Guest Design<h1>
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
            $delay_counter = 0;
            while ($guest_query->have_posts()) : $guest_query->the_post();
                $delay_counter++;
                $delay_class = 'delay-' . ($delay_counter % 3 + 1);
        ?>
            <div class="fade-in-section <?php echo $delay_class; ?>">
                <?php the_post_thumbnail('large', array('class' => 'image')); ?>
                <p class="design-title"><?php the_title(); ?></p>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <div class="no-designs">
                <p style="text-align: center;">Guest Designはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4">
        <a href="<?php echo esc_url(home_url('/gallery_guest_nail/')); ?>" class="btn more-button">
            More <i class="fas fa-chevron-right ms-2"></i>
        </a>
    </div>
</section>

<!-- クーポンセクション -->
<section class="coupon-section fade-in-section">
    <h1 class="twelor-section-title">Coupon</h1>
    <div class="design-box">
        <?php
        $coupon_query = twelor_get_top_coupon_posts(9);

        if ($coupon_query->have_posts()) :
            $delay_counter = 0;
            while ($coupon_query->have_posts()) : $coupon_query->the_post();
                $delay_counter++;
                $delay_class = 'delay-' . ($delay_counter % 3 + 1);
                $coupon_period = get_field('coupon_period');
                $coupon_price = get_field('coupon_price');
                $coupon_description = get_field('coupon_description');
        ?>
                <div class="coupon fade-in-section <?php echo $delay_class; ?>">
                    <div class="coupon-title"><?php the_title(); ?></div>
                    <div class="coupon-image-box">
                        <?php the_post_thumbnail('large', array('class' => 'coupon-image')); ?>
                    </div>
                    <div class="coupon-description"><?php echo nl2br(esc_html($coupon_description)); ?></div>   
                    <div class="coupon-price"><?php echo esc_html($coupon_price); ?></div>
                    <?php 
                    $start_date = get_field('coupon_period_start_date', get_the_ID());
                    $end_date = get_field('coupon_period_end_date', get_the_ID());
                    if ($start_date && $end_date) : 
                        $start_date_formatted = date_i18n('Y年m月d日', strtotime($start_date));
                        $end_date_formatted = date_i18n('Y年m月d日', strtotime($end_date));
                    ?>
                        <p class="coupon-period">期間:<?php echo esc_html($start_date_formatted); ?>～<?php echo esc_html($end_date_formatted); ?></p>
                    <?php endif; ?>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <div class="no-designs">
                <p style="text-align: center;">Couponはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="text-center py-4">
        <a href="<?php echo esc_url(home_url('/coupon/')); ?>" class="more-button">
            More
        </a>
    </div>
</section>

<?php get_footer(); ?>