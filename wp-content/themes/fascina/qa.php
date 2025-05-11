<?php
/**
 * Template Name: 料金メニュー
 */
get_header();
?>

<div class="container py-5">
    <h1 class="fascina-section-title mb-4">料金メニュー</h1>
    
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background-color: #ff69b4; color: white;">
                    <h2 class="h5 mb-0">HAND定額コース</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>コース</th>
                                <th>料金（税込）</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ワンカラー</td>
                                <td>¥5,500</td>
                            </tr>
                            <tr>
                                <td>グラデーション</td>
                                <td>¥6,600</td>
                            </tr>
                            <tr>
                                <td>フレンチ</td>
                                <td>¥7,700</td>
                            </tr>
                            <tr>
                                <td>シンプルアート</td>
                                <td>¥8,800</td>
                            </tr>
                            <tr>
                                <td>デザインアート</td>
                                <td>¥9,900〜</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="small">※オフ代込み、長さ出し+¥550/本</p>
                    <a href="<?php echo esc_url(home_url('/gallery-category/hand/')); ?>" class="btn btn-sm" style="background-color: #ff69b4; color: white;">デザインを見る</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background-color: #ff69b4; color: white;">
                    <h2 class="h5 mb-0">FOOT定額コース</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>コース</th>
                                <th>料金（税込）</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ワンカラー</td>
                                <td>¥5,500</td>
                            </tr>
                            <tr>
                                <td>グラデーション</td>
                                <td>¥6,600</td>
                            </tr>
                            <tr>
                                <td>フレンチ</td>
                                <td>¥7,700</td>
                            </tr>
                            <tr>
                                <td>シンプルアート</td>
                                <td>¥8,800</td>
                            </tr>
                            <tr>
                                <td>デザインアート</td>
                                <td>¥9,900〜</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="small">※オフ代込み、巻き爪補正+¥550/本</p>
                    <a href="<?php echo esc_url(home_url('/gallery-category/foot/')); ?>" class="btn btn-sm" style="background-color: #ff69b4; color: white;">デザインを見る</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background-color: #ff69b4; color: white;">
                    <h2 class="h5 mb-0">オプションメニュー</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>メニュー</th>
                                <th>料金（税込）</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>長さ出し（1本）</td>
                                <td>¥550</td>
                            </tr>
                            <tr>
                                <td>ストーン（1粒）</td>
                                <td>¥110〜</td>
                            </tr>
                            <tr>
                                <td>パーツ（1個）</td>
                                <td>¥220〜</td>
                            </tr>
                            <tr>
                                <td>マットコート</td>
                                <td>¥550</td>
                            </tr>
                            <tr>
                                <td>ミラーネイル</td>
                                <td>¥1,100</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header" style="background-color: #ff69b4; color: white;">
                    <h2 class="h5 mb-0">ケアメニュー</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>メニュー</th>
                                <th>料金（税込）</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ハンドケア</td>
                                <td>¥3,300</td>
                            </tr>
                            <tr>
                                <td>フットケア</td>
                                <td>¥4,400</td>
                            </tr>
                            <tr>
                                <td>巻き爪補正（1本）</td>
                                <td>¥550</td>
                            </tr>
                            <tr>
                                <td>深爪補正（1本）</td>
                                <td>¥550</td>
                            </tr>
                            <tr>
                                <td>パラフィンパック</td>
                                <td>¥1,650</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header" style="background-color: #ff69b4; color: white;">
                    <h2 class="h5 mb-0">月替わりクーポン</h2>
                </div>
                <div class="card-body">
                    <p>毎月お得なクーポンをご用意しております。詳細は下記リンクからご確認ください。</p>
                    <a href="<?php echo esc_url(home_url('/coupon/')); ?>" class="btn" style="background-color: #ff69b4; color: white;">クーポンを見る</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>