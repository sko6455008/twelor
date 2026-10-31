<?php
/**
 * Template Name: ネイルカタログ
 * Template Post Type: page
 *
 * 既存ギャラリーの各一覧へ案内するカテゴリーページ。
 */

get_header();

$catalog_cards = array(
    'hand' => array(
        'label' => 'HAND',
        'title' => '30種類から選ぶHANDデザイン',
        'description' => '指先を彩る、お気に入りのデザインを。',
        'path' => '/gallery_hand_design/list/',
        'image' => 'hand-h1198.png',
        'image_alt' => 'ブラウンのニュアンス柄とゴールドの縁取りのハンドネイルチップ',
    ),
    'foot' => array(
        'label' => 'FOOT',
        'title' => '30種類から選ぶFOOTデザイン',
        'description' => '足元にも、あなたらしい彩りを。',
        'path' => '/gallery_foot_design/footsimple/',
        'image' => 'foot-light-red-magnet.png',
        'image_alt' => 'ライトレッドのマグネットネイルを施したフットデザイン',
    ),
    'guest' => array(
        'label' => 'GUEST',
        'title' => 'GUESTデザイン',
        'description' => 'お客様のネイルから、次のデザイン探し。',
        'path' => '/gallery_guest_nail/list/',
        'image' => 'guest-brown-stones.png',
        'image_alt' => 'ブラウンのグラデーションにパールとストーンを飾ったお客様のハンドネイル',
    ),
);
?>

<main id="main-content" class="nail-catalog" aria-labelledby="nail-catalog-title">
    <div class="nail-catalog__inner">
        <div class="nail-catalog__heading">
            <p class="nail-catalog__eyebrow" lang="en">Nail Catalog</p>
            <h1 id="nail-catalog-title">ネイルデザインカタログ</h1>
            <p class="nail-catalog__intro">あなたの日常に、好きな彩りを。</p>
        </div>

        <div class="nail-catalog__cards">
            <?php foreach ($catalog_cards as $category => $card) : ?>
                <a class="nail-catalog-card nail-catalog-card--<?php echo esc_attr($category); ?>"
                   href="<?php echo esc_url(home_url($card['path'])); ?>"
                   aria-labelledby="catalog-<?php echo esc_attr($category); ?>-title">
                    <div class="nail-catalog-card__photos">
                        <img class="nail-catalog-card__image"
                             src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/nail-catalog/' . $card['image']); ?>"
                             alt="<?php echo esc_attr($card['image_alt']); ?>"
                             width="640" height="480"
                             loading="eager">
                    </div>
                    <div class="nail-catalog-card__body">
                        <span class="nail-catalog-card__label" lang="en"><?php echo esc_html($card['label']); ?></span>
                        <h2 id="catalog-<?php echo esc_attr($category); ?>-title"><?php echo esc_html($card['title']); ?></h2>
                        <p><?php echo esc_html($card['description']); ?></p>
                        <span class="nail-catalog-card__arrow" aria-hidden="true">&#8250;</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <p class="nail-catalog__note">気になるカテゴリーから、デザインをご覧ください。</p>
    </div>
</main>

<?php get_footer(); ?>
