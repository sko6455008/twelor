<?php
/**
 * Template Name: アクセス
 */
get_header();
?>

<div class="container py-5">
    <h1 class="access-section-title">アクセス</h1>
    
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="store-info"> 
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-map-marker-alt"></i>
                        住所
                    </h3>
                    <p class="info-content">
                        東京都豊島区池袋2-40-13 VORT池袋ビル 3F
                    </p>
                </div>
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-phone"></i>
                        電話番号
                    </h3>
                    <p class="info-content">
                        <a href="tel:050-5305-3298" class="phone-link">050-5305-3298</a>
                    </p>
                    <p class="info-content">
                        9時 ～ 22時（土日祝は10:00～）受付可
                    </p>
                </div>
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-clock"></i>
                        営業時間
                    </h3>
                    <p class="info-content">
                        11:00 ～ 23：00（土日祝は10:00～）※年中無休
                    </p>
                </div>
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-credit-card"></i>
                        支払い方法
                    </h3>
                    <div class="info-content">
                        <div class="payment-list">
                            <span class="payment-item">現金</span>
                            <span class="payment-item">クレジットカード</span>
                            <span class="payment-item">電子マネー</span>
                            <span class="payment-item">QRコード決済</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="store-images">
                <h2 class="section-title">店舗画像</h2>
                <div class="image-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide3.jpg" alt="店舗内観" class="img-fluid">
                    <div class="image-caption">店舗内観</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="map-section">
                <h2 class="section-title">マップ</h2>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3238.7086482756745!2d139.70674961534667!3d35.73338328018222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188d5ef5ffc2e9%3A0x45a6139e479940e8!2z77ymYXNjaW5h!5e0!3m2!1sja!2sjp!4v1561524155592!5m2!1sja!2sjp" 
                        width="100%" 
                        height="500" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.access-section-title {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin: 30px auto;
    padding-bottom: 10px;
    width: 100%;
    border-bottom: 1px solid #ddd;
}

.store-info {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    height: 100%;
}

.store-name {
    font-size: 1.8rem;
    color: #ff69b4;
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #ff69b4;
}

.info-section {
    margin: 30px 0;
}

.info-title {
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.info-title i {
    color: #ff69b4;
    margin-right: 10px;
    width: 20px;
}

.info-content {
    color: #666;
    line-height: 1.6;
    margin-left: 30px;
}

.phone-link {
    color: #ff69b4;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
}

.phone-link:hover {
    color: #ff1493;
}

.hours-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.day {
    font-weight: 600;
    color: #333;
}

.time {
    color: #666;
}

.holiday-note {
    color: #28a745;
    font-weight: 600;
    margin-top: 10px;
    text-align: center;
}

.payment-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.payment-item {
    background: #e64893;
    color: #fff;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: 500;
}

/* グループ2: 店舗画像 */
.store-images {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    height: 100%;
}

.section-title {
    font-size: 1.5rem;
    color: #333;
    text-align: center;
    margin-bottom: 50px;
    font-weight: 600;
}

.images-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.image-item {
    text-align: center;
}

.image-item img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.image-caption {
    margin-top: 8px;
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
}

.map-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.map-container {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

@media (max-width: 992px) {
    .store-info,
    .store-images {
        margin-bottom: 30px;
    }
}

@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .store-info,
    .store-images,
    .map-section {
        padding: 20px;
    }
    
    .store-name {
        font-size: 1.5rem;
    }
    
    .info-content {
        margin-left: 0;
        margin-top: 10px;
    }
    
    .hours-row {
        flex-direction: column;
        text-align: center;
    }
    
    .payment-list {
        justify-content: center;
    }
    
    .images-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .image-item img {
        height: 200px;
    }
}

@media (max-width: 576px) {
    .container {
        padding: 0 15px;
    }
    
    .page-title {
        font-size: 1.8rem;
        margin-bottom: 2rem;
    }
    
    .store-info,
    .store-images,
    .map-section {
        padding: 15px;
    }
    
    .info-title {
        font-size: 1rem;
    }
    
    .payment-item {
        font-size: 0.8rem;
        padding: 4px 10px;
    }
}
</style>

<?php get_footer(); ?>