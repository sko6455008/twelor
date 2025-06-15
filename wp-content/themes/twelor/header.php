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
                    <div class="phone-number">050-5305-3298</div>
                </div>

                <address>東京都豊島区池袋2-40-13 VORT | 池袋ビル 3F</address>

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

    <nav class="sp-menu">
        <ul>
            <li><a href="<?php echo esc_url(home_url('/')); ?>">トップ</a></li>
            <li><a href="<?php echo esc_url(home_url('/first/')); ?>">初めての方へ</a></li>
            <li><a href="<?php echo esc_url(home_url('/menu/')); ?>">料金メニュー</a></li>
            <li><a href="<?php echo esc_url(home_url('/qa/')); ?>">Q&A</a></li>
            <li><a href="<?php echo esc_url(home_url('/access/')); ?>">アクセス</a></li>
            <li><a href="<?php echo esc_url(home_url('/recruit/')); ?>">リクルート</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_hand_design/simple/')); ?>">HAND定額コース</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_foot_design/simple/')); ?>">FOOT定額コース</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_guest_nail/simple-guest')); ?>">GUESTギャラリー</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_arts_parts/lame-holo-seal/')); ?>">アート・パーツ</a></li>
            <li><a href="<?php echo esc_url(home_url('/coupon/')); ?>">月替わりクーポン</a></li>
            <li><a href="<?php echo esc_url(home_url('/care/')); ?>">グリーンネイルについて</a></li>
        </ul>

        <div class="sns-icons">
            <a href="https://www.instagram.com/twelornailsalon/" target="_blank">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/instagram-icon.png" alt="Instagram">
            </a>
        </div>
    </nav>

    <div class="menu-overlay"></div>

    <!-- ナビゲーション -->
    <nav class="global-nav">
        <ul>
            <li><a href="<?php echo esc_url(home_url('/')); ?>">トップ</a></li>
            <li><a href="<?php echo esc_url(home_url('/first/')); ?>">初めての方へ</a></li>
            <li><a href="<?php echo esc_url(home_url('/menu/')); ?>">料金メニュー</a></li>
            <li><a href="<?php echo esc_url(home_url('/qa/')); ?>">Q&A</a></li>
            <li><a href="<?php echo esc_url(home_url('/access/')); ?>">アクセス</a></li>
            <li><a href="<?php echo esc_url(home_url('/recruit/')); ?>">リクルート</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_hand_design/simple/')); ?>">HAND定額コース</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_foot_design/simple/')); ?>">FOOT定額コース</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_guest_nail/simple-guest')); ?>">GUESTギャラリー</a></li>
            <li><a href="<?php echo esc_url(home_url('/gallery_arts_parts/lame-holo-seal/')); ?>">アート・パーツ</a></li>
            <li><a href="<?php echo esc_url(home_url('/coupon/')); ?>">月替わりクーポン</a></li>
            <li><a href="<?php echo esc_url(home_url('/care/')); ?>">グリーンネイルについて</a></li>
        </ul>
    </nav>