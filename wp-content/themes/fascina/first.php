<?php
/**
 * Template Name: 初めての方へ
 */
get_header();
?>

<div class="container py-5">
    <h1 class="fascina-section-title mb-4">初めての方へ</h1>
    
    <div class="row mb-5">
        <div class="col-md-6">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/first-time.jpg" alt="初めての方へ" class="img-fluid rounded">
        </div>
        <div class="col-md-6">
            <h2 class="h4 mb-3" style="color: #ff69b4;">Fascinaネイルサロンへようこそ</h2>
            <p>Fascinaネイルサロンは、自爪を傷めないパラジェル専門店です。ナチュラルスタイリッシュな空間で、リラックスしながら美しいネイルをお楽しみいただけます。</p>
            <p>初めてのお客様にも安心してご利用いただけるよう、丁寧なカウンセリングと施術を心がけております。</p>
            <p>当サロンでは、お客様一人ひとりに合わせたデザインをご提案し、長持ちするネイルをご提供いたします。</p>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h4 mb-3" style="color: #ff69b4;">ご予約の流れ</h2>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">STEP 1: ご予約</h5>
                    <p class="card-text">お電話、LINE、またはウェブサイトからご予約ください。</p>
                    <a href="https://071f0f.b-merit.jp/pJ3MHW/web" class="btn" style="background-color: #ff69b4; color: white;">ウェブ予約はこちら</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">STEP 2: ご来店</h5>
                    <p class="card-text">ご予約時間の5分前にはご来店ください。</p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">STEP 3: カウンセリング</h5>
                    <p class="card-text">お客様のご希望をお伺いし、最適なデザインをご提案いたします。</p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">STEP 4: 施術</h5>
                    <p class="card-text">丁寧な施術で美しいネイルに仕上げます。</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">STEP 5: お会計</h5>
                    <p class="card-text">施術後、お会計となります。現金、クレジットカード、電子マネーがご利用いただけます。</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <h2 class="h4 mb-3" style="color: #ff69b4;">よくあるご質問</h2>
            <div class="accordion" id="firstTimeAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            初めてでも大丈夫ですか？
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#firstTimeAccordion">
                        <div class="accordion-body">
                            はい、もちろんです。初めての方にも安心してご利用いただけるよう、丁寧なカウンセリングと施術を心がけております。不安なことがございましたら、お気軽にスタッフにお尋ねください。
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            施術時間はどのくらいかかりますか？
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#firstTimeAccordion">
                        <div class="accordion-body">
                            施術内容によって異なりますが、一般的なジェルネイルで約60〜90分、フットネイルで約60分程度です。デザインの複雑さによって時間は前後いたします。
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            予約のキャンセルはできますか？
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#firstTimeAccordion">
                        <div class="accordion-body">
                            予約のキャンセルは、予約時間の24時間前までにご連絡いただければ可能です。それ以降のキャンセルについては、キャンセル料が発生する場合がございますので、ご了承ください。
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>