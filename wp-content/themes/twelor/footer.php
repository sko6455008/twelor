    <footer class="site-footer">
        <div class="footer-container">
            <section class="footer-left">
                <div class="footer-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="Twelorロゴ">
                    <a href="https://lin.ee/yW1QATC" class="footer-contact-btn" target="_blank">お問い合わせ</a>
                </div>
            </section>
            <section class="footer-middle">
                <div class="footer-address-group">
                    <p><strong>■ADDRESS</strong><br>東京都豊島区西池袋5-2-3　平凡立教前ビル6F</p>
                    <p><strong>■営業時間</strong><br>平日11：00 〜 21:00<br>土日祝10：00 〜 20:00</p>
                    <p><strong>■ ご予約・お問い合わせ</strong><br>9：00 〜 22：00（ご予約受付時間）</p>
                </div>
            </section>
            <article class="footer-right">
                <div class="footer-menu">
                  <div class="footer-menu-column">
                    <p><strong>■メニュー</strong></p>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_menu',
                        'container' => false,
                        'menu_class' => '',
                        'fallback_cb' => false
                    ));
                    ?>
                  </div>
                  <div class="footer-menu-column">
                    <p><strong>■ネイル</strong></p>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer_design',
                        'container' => false,
                        'menu_class' => '',
                        'fallback_cb' => false
                    ));
                    ?>
                  </div>
                </div>
            </article>
        </div>

        <div class="footer-bottom">
            <p>&copy; twelor All Rights Reserved.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>