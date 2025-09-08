<?php
/**
 * Template Name: Concept
 * Template Post Type: page
 */

get_header();
?>

<div class="page-header">
    <div class="headline-area">
        <h1 class="headline">Concept</h1>
        <p class="title">コンセプト</p>
    </div>
</div>

<div class="container">

    <section class="concept-section">
        <h2 class="concept-heading">光あふれる、北欧風プライベートサロン</h2>
        <div class="concept-row">
            <div class="concept-text">
                <p>
                    温かみのある木材と柔らかな光に包まれた店内。
                </p>
                <p>
                    都心の喧騒から離れ、心からリラックスできるプライベートネイルサロンです。
                </p>
                <p>
                    光と風を感じる空間：大きな窓から差し込む光が、店内に穏やかな安らぎをもたらします。明るく開放的な空間で、日常の忙しさから解放されるひとときをお届けします。
                </p>
                <p>
                    北欧の自然から生まれるデザイン：当サロンのネイルは、自然の温もりや洗練されたシンプルさを大切にしています。肌馴染みの良いカラーや繊細なアートで、あなたの指先を美しく彩ります。
                </p>
            </div>
            <div class="concept-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/concept1.jpeg" alt="コンセプト画像1">
            </div>
        </div>
    </section>

    <section class="concept-section">
        <h2 class="concept-heading">インスピレーションを得たデザイン</h2>
        <div class="concept-row reverse">
             <div class="concept-text">
                <p>
                    肌に馴染むニュアンスカラー：自然の色合いを基調とした、優しく温かみのあるカラー。
                </p>
                <p>
                    繊細でミニマルなアート：シンプルながらも個性が光る、大人のためのアート。
                </p>
                <p>
                    自然な美しさを引き出すケア：爪の健康を第一に考えた丁寧な施術で、あなたの指先本来の美しさを引き出します。
                </p>
                <p>
                    お客様一人ひとりのライフスタイルや好みに合わせた丁寧なカウンセリングで、あなただけの特別なデザインを一緒に創り上げていきます。
                </p>
            </div>
            <div class="concept-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/concept2.jpg" alt="コンセプト画像2">
            </div>
        </div>
    </section>

    <section class="concept-section">
        <h2 class="concept-heading">お客様の「安心」を守る、徹底した衛生管理</h2>
        <div class="concept-row">
            <div class="concept-text">
                <p>
                    美しい指先は、安心と安全があってこそ。<br>
                    当店では、お客様に心からリラックスしてネイルを楽しんでいただくために、徹底した衛生管理に取り組んでいます。
                </p>
                <p>
                    ・器具の消毒・滅菌: 施術に使用するすべての器具は、アルコール消毒、UV殺菌装置を用いて、細心の注意を払い消毒・滅菌しています。
                </p>
                <p>
                    ・衛生環境の維持: 施術スペースは、常に清潔な状態を保ち、定期的な換気と消毒を行っています。
                </p>
                <p>
                    ・ネイリストの健康管理: 毎日の検温や体調管理を徹底し、施術前には必ず手指消毒を行います。
                </p>
                <p>
                    お客様の健康と安全を第一に考え、安心して施術を受けていただける環境づくりに努めています。<br>
                </p>
            </div>
            <div class="concept-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/concept3.jpeg" alt="コンセプト画像3">
            </div>
        </div>
    </section>

</div>

<style>
     /* ページヘッダー */
    .page-header {
        background: url("<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/concept.jpeg") no-repeat center center;
        background-size: cover;
        width: 100%;
        height: 420px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 70px;
    }
    .headline-area {
        max-width: 800px;
        position: relative;
        z-index: 1;
        text-align: center;
        color: #fff;
    }
    .headline,.title {
        text-shadow: 1px 1px 5px #735E59;
    }

    /* コンセプトセクション */
    .container {
        padding: 100px 0px;
    }
    .concept-section {
        margin-bottom: 100px;
    }
    .concept-heading {
        font-size: 26px;
        font-weight: 600;
        margin: 30px 0px 35px;
        text-align: center;
        color: #735E59;
        font-family: "ヒラギノ角ゴ W3", "游ゴシック体", "Yu Gothic", "メイリオ", sans-serif;
    }
    .concept-row {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }
    .concept-row.reverse {
        flex-direction: row-reverse;
    }
    .concept-text {
        flex: 1 1 350px;
        font-size: 1.1rem;
        color: #333;
        padding: 30px;
        font-family: "ヒラギノ角ゴ W3", "游ゴシック体", "Yu Gothic", "メイリオ", sans-serif;
    }
    .concept-image {
        flex: 1 1 350px;
        text-align: center;
    }
    .concept-image img {
        max-width: 300px;
        width: 100%;
        height: auto;
        box-shadow: 0 8px 24px rgba(115,94,89,0.6);
        transition: max-width 0.3s;
    }
    @media (max-width: 768px) {
        .concept-heading {
            margin-bottom: 20px;
        }
        .concept-text {
            flex: 1 1 350px;
        }
    }
    @media (max-width: 600px) {
        .concept-image img {
            max-width: 90vw;
        }
    }

</style>

<?php get_footer(); ?>