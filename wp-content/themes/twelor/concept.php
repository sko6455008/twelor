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
        <h2 class="concept-heading">忙しい毎日を送るあなたへ、指先から心を満たす特別なひとときを</h2>
        <div class="concept-row">
            <div class="concept-text">
                <p>
                    当店は、落ち着いた大人の女性のためのプライベートネイルサロンです。
                </p>
                <p>
                    経験豊富なネイリストが、あなたのライフスタイルやファッションに合わせた、品のある洗練されたデザインをご提案します。
                </p>
                <p>
                    丁寧に時間をかけたケアと施術で、思わず触れたくなるような美しい指先へと導きます。
                </p>
                    完全予約制のプライベート空間で、ゆったりと流れる時間をお楽しみください。 自分だけの「ご褒美時間」を過ごしに、ぜひお越しください。
                </p>
            </div>
            <div class="concept-image">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/concept1.jpeg" alt="コンセプト画像1">
            </div>
        </div>
    </section>

    <section class="concept-section">
        <h2 class="concept-heading">お客様の「なりたい」を叶える豊富なカラーとメニュー</h2>
        <div class="concept-row reverse">
             <div class="concept-text">
                <p>
                    豊富なカラーバリエーションと、トレンドから定番まで幅広く揃えたメニューが自慢のネイルサロンです。
                </p>
                <p>
                    「この色、他のお店にはなかった！」 「やりたかったデザインが、理想通りに仕上がった！」<br>
                    お客様からそんな嬉しいお声をいただくたびに、私たちも喜びを感じています。
                </p>
                <p>
                    当店では、380種類以上のカラーをご用意。 お客様一人ひとりの肌色や雰囲気に合わせて、ぴったりの色をご提案します。
                    オフィス向けの上品なデザインから、個性あふれるアートまで、どんな「なりたい」にもお応えできるメニューを揃えています。
                </p>
                <p>
                    ぜひ、あなたの指先を美しく彩るお手伝いをさせてください。 
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