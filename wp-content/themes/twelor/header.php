<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header>
        <div class="row">
            <div class="col-2">
                <button class="menu-toggle">&#9776;</button>
            </div>
            <div class="col-8 logo-container">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="Fascina">
                </a>
            </div>
            <div class="col-2 right-icons">
                <div class="right-container">
                    <a href="https://lin.ee/yW1QATC" target="_blank" class="inquiry-link">
                        問い合わせ
                    </a>
                    <a href="https://071f0f.b-merit.jp/R3dKhM/web/" target="_blank" class="reservation-link">
                        Web予約
                    </a>
                </div>
            </div>
        </div>
    </header>

    <nav class="sp-menu" role="navigation" aria-label="メインナビゲーション">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => '',
            'fallback_cb' => false,
            'items_wrap' => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>'
        ));
        ?>
    </nav>

    <div class="menu-overlay"></div>
    