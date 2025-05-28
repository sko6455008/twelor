    <footer class="site-footer">
        <div class="footer-container">
            <section class="footer-left">
                <div class="footer-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="Fascinaロゴ">
                    <a href="https://lin.ee/GOjVh5W" class="footer-contact-btn" target="_blank">お問い合わせ</a>
                </div>
            </section>
            <section class="footer-middle">
                <div class="footer-address-group">
                    <p><strong>■ADDRESS</strong><br>東京都豊島区池袋2-40-13 VORT池袋ビル 3F</p>
                    <p><strong>■営業時間</strong><br>平日11：00 〜 21:00<br>土日祝10：00 〜 20:00</p>
                    <p><strong>■ ご予約・お問い合わせ</strong><br>9：00 〜 22：00（ご予約受付時間）</p>
                </div>
            </section>
            <article class="footer-right">
                <div class="footer-menu">
                  <div class="footer-menu-column">
                    <p><strong>■メニュー</strong></p>
                    <ul>
                      <li><a href="<?php echo esc_url(home_url('/')); ?>">トップ</a></li>
                      <li><a href="<?php echo esc_url(home_url('/first/')); ?>">初めての方へ</a></li>
                      <li><a href="<?php echo esc_url(home_url('/menu/')); ?>">料金メニュー</a></li>
                      <li><a href="<?php echo esc_url(home_url('/qa/')); ?>">Q&A</a></li>
                      <li><a href="<?php echo esc_url(home_url('/access/')); ?>">アクセス</a></li>
                      <li><a href="<?php echo esc_url(home_url('/recruit/')); ?>">リクルート</a></li>
                      <li><a href="https://fascina.jp/care.html#here" target="_blank">グリーンネイルについて</a></li>
                    </ul>
                  </div>
                  <div class="footer-menu-column">
                    <p><strong>■ネイル</strong></p>
                    <ul>
                      <li><a href="<?php echo esc_url(home_url('/gallery_hand_design/simple/')); ?>">HAND定額コース</a></li>
                      <li><a href="<?php echo esc_url(home_url('/gallery_foot_design/simple/')); ?>">FOOT定額コース</a></li>
                      <li><a href="<?php echo esc_url(home_url('/gallery_guest_nail/')); ?>">GUESTギャラリー</a></li>
                      <li><a href="<?php echo esc_url(home_url('/gallery_arts_parts/lame-holo-seal/')); ?>">アート・パーツ</a></li>
                      <li><a href="<?php echo esc_url(home_url('/coupon/')); ?>">月替わりクーポン</a></li>
                    </ul>
                  </div>
                </div>
            </article>
        </div>

        <div class="footer-bottom">
            <p>&copy; fascina All Rights Reserved.</p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>