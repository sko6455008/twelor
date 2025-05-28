<?php
/**
 * Template Name: 料金メニュー
 */
get_header();
?>

<div class="container">
    <h1 class="menu-section-title">料金メニュー</h1>
    
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h2 class="h5 mb-0 text-center fw-bold">ケア</h2>
                    <p class="mb-0 small text-center">ネイルの基本ケアです</p>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">ネイルケア</span>
                                    <p class="small mb-0 mt-1">フィンガーバス＋甘皮処理＋整爪＋バッフィング＋シャイニング</p>
                                </td>
                                <td>¥5,480/30分</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">ウォーターケア</span>
                                    <p class="small mb-0 mt-1">甘皮処理</p>
                                </td>
                                <td>¥3,240/30分</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">ファイリング</span>
                                    <p class="small mb-0 mt-1">爪の形を整えます</p>
                                </td>
                                <td>¥540</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">バッフィング</span>
                                    <p class="small mb-0 mt-1">爪の表面の凸凹を滑らかにします（+￥110でシャイニング）</p>
                                </td>
                                <td>¥540</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">ベース＆トップ仕上げ</span>
                                </td>
                                <td>¥540</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">パラフィンパック</span>
                                    <p class="small mb-0 mt-1">高濃度保湿パックで、肌を柔らかくすべすべにしてくれます</p>
                                </td>
                                <td>¥1,080/30分</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">メンズケア</span>
                                    <p class="small mb-0 mt-1">フィンガーバス＋甘皮処理＋整爪＋バッフィング（+￥1,000でパラフィンパック）</p>
                                </td>
                                <td>¥3.740/30分</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="fw-bold border-bottom border-secondary">自爪強化剤</span>
                                    <p class="small mb-0 mt-1">オフの後には必須オススメ　ベースコートにしても可</p>
                                </td>
                                <td>¥1,100/30分</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="small">※オフ代込み、長さ出し+¥550/本</p>
                </div>
            </div>
        </div>
        
        <div class="col-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
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
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
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

<style>
    .menu-section-title {
        text-align: center;
        color: #333;
        font-size: 24px;
        margin-bottom: 50px;
        padding-bottom: 10px;
        width: 100%;
        border-bottom: 1px solid #ddd;
    }
    .card-header {
        background-color:#f5dfee;
        color: white;
    }
</style>

<?php get_footer(); ?>