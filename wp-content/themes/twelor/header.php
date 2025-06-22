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
        <div class="backstretch">
            <div id="sns_pc">
                <a href="https://www.instagram.com/twelornailsalon/" target="_blank">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/instagram-icon.png" alt="Instagram">
                </a>
            </div>

            <div class="headinfo">
                <div class="info">
                    <div class="logo">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="Twelorロゴ">
                    </div>
                    <a href="https://071f0f.b-merit.jp/pJ3MHW/web" class="reservation-btn" target="_blank">ご予約</a>
                    <a href="https://lin.ee/yW1QATC" class="contact-btn" target="_blank">お問い合わせ</a>
                    <div class="phone-number">050-5305-3314</div>
                </div>

                <address>東京都豊島区西池袋5-2-3　平凡立教前ビル6F</address>

                <h2 class="open-close">
                    <strong>■営業時間【年中無休】</strong><br>
                    11：00 - 22：00<br>
                    土日祝10：00 - 20：00
                </h2>

                <h2 class="contact-top">
                    <strong>■ご予約・お問い合わせ</strong><br>
                    9：00 - 22：00
                </h2>
            </div>

            <div class="main-visual">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slide3.jpg" alt="Twelorメインビジュアル">
            </div>
        </div>
    </header>

    <!-- ３点リーダー -->
    <button class="menu-toggle">&#9776;</button>

    <nav class="sp-menu" role="navigation" aria-label="スマートフォンメニュー">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container' => false,
            'menu_class' => '',
            'fallback_cb' => false,
            'items_wrap' => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>'
        ));
        ?>

        <div class="sns-icons">
            <a href="https://www.instagram.com/twelornailsalon/" target="_blank">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/instagram-icon.png" alt="Instagram">
            </a>
        </div>
    </nav>

    <div class="menu-overlay"></div>

    <!-- ナビゲーション -->
    <nav class="global-nav" role="navigation" aria-label="メインナビゲーション">
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