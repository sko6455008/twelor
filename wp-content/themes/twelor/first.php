<?php
/**
 * Template Name: 初めての方へ
 * Template Post Type: page
 */

get_header();
?>

<div class="container py-5">
    <h1 class="first-section-title">初めての方へ</h1>
    
    <div class="first-features">
        <ul class="feature-list">
            <li class="feature-item">
                <div class="feature-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/first1.jpg" alt="爪への優しさと持ちの良さ">
                </div>
                <p class="feature-text">
                    当店は爪への優しさと<br>
                    持ちの良さ･耐久性は抜群
                </p>
            </li>
            <li class="feature-item">
                <div class="feature-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/first2.jpg" alt="スピーディーで低価格">
                </div>
                <p class="feature-text">
                    スピーディーで低価格
                </p>
            </li>
            <li class="feature-item">
                <div class="feature-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/first3.jpg" alt="豊富なアート＆カラーサンプル">
                </div>
                <p class="feature-text">
                    豊富なアート＆カラーサンプル<br>
                    定額コース、オーダーメイドコース共に382色をご用意
                </p>
            </li>
        </ul>
    </div>
    <div class="mb-5">
        <h3 class="first-section-subtitle">衛生管理</h3>
        <p class="hygiene-intro">
            池袋ネイルサロン ファッシーナでは、お客様に安心してネイルサービスをお受け頂くために、<br>
            下記の衛生基準を守る事をお約束いたします。
        </p>
        <ul class="hygiene-list">
            <li>施術の前には、殺菌ソープでの洗浄とアルコール消毒</li>
            <li>器具はアルコール消毒、UV殺菌装置で保管</li>
            <li>テーブル、椅子、UVライト内外も店内は全てアルコール消毒</li>
            <li>アームレスト、マット部分のペーパータオルは新品</li>
            <li>提供ドリンクは缶製品タイプをご提供させて頂いております</li>
            <li>青カビ防止ネイルなどのお客様に使用したファイルは必ず処分</li>
        </ul>
    </div>
    <div class="mb-5">
        <h3 class="first-section-subtitle">お客様へのお願い</h3>
        <ul class="request-list">
            <li>
                ネイリストご指名可能。<br>
                何名かお試しの上、ご指名されることをお薦めいたします。
            </li>
            <li>
                ご予約時間の10分前にはサロンにお越しくださいます様にお願い申し上げます。<br>
                ご予約時間の変更やキャンセルについては必ずご連絡をくださいますようお願い申し上げます。
            </li>
            <li>
                15分以上遅刻されますと、ご希望の施術を行えない場合がございます。<br>
                30分以上ご連絡なく遅刻されてしまった場合施術内容の変更またはキャンセルさせていただく場合がございます。
            </li>
            <li>お客様のお爪や皮膚の状態により、ご希望の施術をお受けできない場合もございます。</li>
            <li>店内での携帯電話のご利用はご遠慮頂いております。</li>
            <li>乳幼児をお連れのお客様はご利用をご遠慮いただいております。</li>
            <li>全席禁煙とさせて頂いております。</li>
        </ul>
    </div>
</div>

<style>
.first-section-title {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin: 30px auto;
    padding-bottom: 10px;
    width: 100%;
    border-bottom: 1px solid #ddd;
}

.first-section-subtitle {
    font-size: 24px;
    margin: 55px 0;
    text-align: center;
    color: #333;
    position: relative;
}

.first-section-subtitle::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 1px;
    background: #333;
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 0 0 60px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 50px;
}

.feature-item {
    flex: 0 1 300px;
    margin: 0;
    padding: 0;
    text-align: center;
}

.feature-image {
    margin-bottom: 20px;
    width: 300px;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
}

.feature-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.feature-text {
    margin: 0;
    line-height: 1.8;
    font-size: 16px;
    color: #333;
}

.hygiene-intro {
    text-align: center;
    margin-bottom: 40px;
    line-height: 1.8;
    color: #333;
}

.hygiene-list,
.request-list {
    list-style: none;
    padding: 0;
    margin: 0 auto;
    max-width: 800px;
}

.hygiene-list li,
.request-list li {
    position: relative;
    padding-left: 1.5em;
    margin-bottom: 15px;
    line-height: 1.8;
    color: #333;
}

.hygiene-list li:before,
.request-list li:before {
    content: "•";
    position: absolute;
    left: 0.5em;
    color: #333;
}

@media (max-width: 768px) {   
    .first-section-title {
        font-size: 24px;
        margin: 30px auto;
    }

    .first-section-subtitle {
        font-size: 20px;
        margin: 30px 0 15px;
    }
    .feature-list {
        gap: 35px;
    }

    .feature-image {
        width: 300px;
        height: 300px;
    }

    .hygiene-intro br {
        display: none;
    }
}
</style>

<?php get_footer(); ?>