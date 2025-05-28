<?php
/**
 * Template Name: ギャラリーテンプレート
 * 
 * ギャラリーを表示するテンプレートファイル
 */

get_header(); 

// 現在のページ番号を取得
$current_page = get_query_var('paged') ? get_query_var('paged') : 1;

// メインカテゴリーとサブカテゴリーを取得
$main_category = get_query_var('gallery_main_category');
$sub_category = get_query_var('gallery_sub_category');

// 1ページあたりの表示数
$posts_per_page = 20;

// ギャラリー投稿を取得
$args = array(
    'post_type' => 'gallery',
    'posts_per_page' => $posts_per_page,
    'paged' => $current_page,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'gallery_main_category',
            'value' => $main_category,
            'compare' => '='
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC'
);

// GUESTギャラリー以外の場合のみサブカテゴリーの条件を追加
if ($main_category !== 'guest') {
    $args['meta_query'][] = array(
        'key' => 'gallery_sub_category',
        'value' => $sub_category,
        'compare' => '='
    );
}

$gallery_query = new WP_Query($args);

// 総ページ数を計算
$total_posts = $gallery_query->found_posts;
$total_pages = ceil($total_posts / $posts_per_page);

// カテゴリー名を取得
$main_category_name = '';
switch ($main_category) {
    case 'hand':
        $main_category_name = 'HAND定額コース';
        break;
    case 'foot':
        $main_category_name = 'FOOT定額コース';
        break;
    case 'guest':
        $main_category_name = 'GUESTギャラリー';
        break;
    case 'arts-parts':
        $main_category_name = 'アート・パーツ';
        break;
}

$sub_category_name = '';
switch ($sub_category) {
    case 'simple':
        $sub_category_name = 'シンプル定額コース';
        break;
    case 'popular':
        $sub_category_name = '一番人気定額コース';
        break;
    case 'special':
        $sub_category_name = 'こだわり定額コース';
        break;
    case 'clean':
        $sub_category_name = 'キレイめ定額コース';
        break;
    case 'onehon-s':
        $sub_category_name = 'ワンホンS定額コース';
        break;
    case 'onehon-m':
        $sub_category_name = 'ワンホンM定額コース';
        break;
    case 'onehon-l':
        $sub_category_name = 'ワンホンL定額コース';
        break;
    case 'bridal':
        $sub_category_name = 'ブライダルデザイン';
        break;
    case 'nuance-s':
        $sub_category_name = 'ニュアンスS定額コース';
        break;
    case 'nuance-m':
        $sub_category_name = 'ニュアンスM定額コース';
        break;
    case 'nuance-l':
        $sub_category_name = 'ニュアンスL定額コース';
        break;
    case 'nuance-xl':
        $sub_category_name = 'ニュアンスXL定額コース';
        break;
    case 'lame-holo-seal':
        $sub_category_name = 'ラメ・ホロ・シール';
        break;
    case 'stone-studs-pearl':
        $sub_category_name = 'ストーン・スタッズ・パール';
        break;
    case 'parts':
        $sub_category_name = 'パーツ';
        break;
    case 'color':
        $sub_category_name = 'カラー';
        break;
}
?>

<div class="gallery-container">
    <!-- ヘッダータイトル -->
    <div class="gallery-header">
        <h1 class="gallery-title"><?php echo esc_html($main_category_name); ?></h1>
    </div>

    <!-- オーダーメイドボタン -->
    <div class="custom-order-button">
        <a href="<?php echo home_url('/order-made'); ?>" class="btn btn-primary">オーダーメイドのコースはこちらから</a>
    </div>

    <!-- 無料お色変更の案内 -->
    <div class="color-change-notice">
        <p>※お色変更無料※</p>
    </div>

    <!-- コースカテゴリーナビゲーション -->
    <?php if ($main_category === 'hand'): ?>
    <div class="course-navigation">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/simple/'); ?>" class="course-nav-item <?php echo ($sub_category == 'simple') ? 'active' : ''; ?>">
                    シンプル定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/popular/'); ?>" class="course-nav-item <?php echo ($sub_category == 'popular') ? 'active' : ''; ?>">
                    一番人気定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/special/'); ?>" class="course-nav-item <?php echo ($sub_category == 'special') ? 'active' : ''; ?>">
                    こだわり定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/clean/'); ?>" class="course-nav-item <?php echo ($sub_category == 'clean') ? 'active' : ''; ?>">
                    キレイめ定額コース
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/onehon-s/'); ?>" class="course-nav-item <?php echo ($sub_category == 'onehon-s') ? 'active' : ''; ?>">
                    ワンホンS定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/onehon-m/'); ?>" class="course-nav-item <?php echo ($sub_category == 'onehon-m') ? 'active' : ''; ?>">
                    ワンホンM定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/onehon-l/'); ?>" class="course-nav-item <?php echo ($sub_category == 'onehon-l') ? 'active' : ''; ?>">
                    ワンホンL定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/bridal/'); ?>" class="course-nav-item <?php echo ($sub_category == 'bridal') ? 'active' : ''; ?>">
                    ブライダルデザイン
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-s/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-s') ? 'active' : ''; ?>">
                    ニュアンスS定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-m/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-m') ? 'active' : ''; ?>">
                    ニュアンスM定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-l/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-l') ? 'active' : ''; ?>">
                    ニュアンスL定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/nuance-xl/'); ?>" class="course-nav-item <?php echo ($sub_category == 'nuance-xl') ? 'active' : ''; ?>">
                    ニュアンスXL定額コース
                </a>
            </div>
        </div>
    </div>
    <?php elseif ($main_category === 'foot'): ?>
    <div class="course-navigation">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/simple/'); ?>" class="course-nav-item <?php echo ($sub_category == 'simple') ? 'active' : ''; ?>">
                    シンプル定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/popular/'); ?>" class="course-nav-item <?php echo ($sub_category == 'popular') ? 'active' : ''; ?>">
                    一番人気定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/special/'); ?>" class="course-nav-item <?php echo ($sub_category == 'special') ? 'active' : ''; ?>">
                    こだわり定額コース
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/clean/'); ?>" class="course-nav-item <?php echo ($sub_category == 'clean') ? 'active' : ''; ?>">
                    キレイめ定額コース
                </a>
            </div>
        </div>
    </div>
    <?php elseif ($main_category === 'arts-parts'): ?>
    <div class="course-navigation">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/lame-holo-seal/'); ?>" class="course-nav-item <?php echo ($sub_category == 'lame-holo-seal') ? 'active' : ''; ?>">
                    ラメ・ホロ・シール
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/stone-studs-pearl/'); ?>" class="course-nav-item <?php echo ($sub_category == 'stone-studs-pearl') ? 'active' : ''; ?>">
                    ストーン・スタッズ・パール
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/parts/'); ?>" class="course-nav-item <?php echo ($sub_category == 'parts') ? 'active' : ''; ?>">
                    パーツ
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/color/'); ?>" class="course-nav-item <?php echo ($sub_category == 'color') ? 'active' : ''; ?>">
                    カラー
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- カテゴリータイトル -->
    <div class="category-title">
        <?php if ($total_pages > 0): ?>
            <div class="page-indicator">
                <span class="page-number"><?php echo $current_page; ?>ページ目</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- ギャラリー本体 -->
    <?php if ($gallery_query->have_posts()): ?>
        <div class="gallery-grid">
            <div class="row">
                <?php
                    $gallery_items = [];
                    while ($gallery_query->have_posts()): $gallery_query->the_post();
                        $gallery_items[] = [
                            'img' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                            'title' => get_the_title(),
                            'desc' => get_field('gallery_description') ?: '',
                        ];
                    endwhile;
                    $gallery_query->rewind_posts();
                    $index = 0;
                    while ($gallery_query->have_posts()): $gallery_query->the_post();
                        $img = esc_url($gallery_items[$index]['img']);
                        $title = esc_html($gallery_items[$index]['title']);
                        $desc = esc_html($gallery_items[$index]['desc']);
                    ?>
                        <div class="col-lg-2-4 col-md-6 col-12">
                            <div class="gallery-item">
                                <?php if ($img): ?>
                                    <div class="gallery-image">
                                        <img
                                            src="<?php echo $img; ?>"
                                            alt="<?php echo $title; ?>"
                                            class="gallery-modal-trigger"
                                            data-index="<?php echo $index; ?>"
                                            data-title="<?php echo $title; ?>"
                                            data-desc="<?php echo $desc; ?>"
                                            data-img="<?php echo $img; ?>"
                                        />
                                    </div>
                                <?php endif; ?>
                                <div class="gallery-caption">
                                    <h3 class="gallery-title"><?php echo $title; ?></h3>
                                </div>
                            </div>
                        </div>
                <?php $index++; endwhile; ?>         
            </div>
        </div>

        <!-- モーダル -->
        <div id="gallery-modal" class="gallery-modal">
            <div class="gallery-modal-content">
                <button class="gallery-modal-close">&times;</button>
                <button class="gallery-modal-prev">&#10094;</button>
                <button class="gallery-modal-next">&#10095;</button>
                <div class="gallery-modal-image-wrap">
                    <img id="gallery-modal-img" src="" alt="">
                </div>
                <div class="gallery-modal-title" id="gallery-modal-title"></div>
                <div class="gallery-modal-desc" id="gallery-modal-desc"></div>
            </div>
        </div>

        <!-- ページネーション -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination-container">
                <div class="pagination custom-pagination">
                    <?php
                    // カテゴリーに応じてベースURLを設定
                    $base_url = '';
                    if ($main_category === 'guest') {
                        $base_url = home_url("gallery_guest_nail/page/%#%/");
                    } elseif ($main_category === 'arts-parts') {
                        $base_url = home_url("gallery_arts_parts/{$sub_category}/page/%#%/");
                    } else {
                        $base_url = home_url("gallery_{$main_category}_design/{$sub_category}/page/%#%/");
                    }

                    $links = paginate_links(array(
                        'base' => $base_url,
                        'current' => $current_page,
                        'total' => $total_pages,
                        'prev_text' => '&laquo; 前へ',
                        'next_text' => '次へ &raquo;',
                        'type' => 'array',
                    ));
                    if ($links) {
                        foreach ($links as $link) {
                            // アクティブページには active クラスを付与
                            if (strpos($link, 'current') !== false) {
                                echo str_replace('page-numbers', 'pagination-link active', $link);
                            } else {
                                echo str_replace('page-numbers', 'pagination-link', $link);
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="no-posts-found">
            <p>現在、このカテゴリーにはデザインがありません。</p>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

<!-- ギャラリー用のスタイル -->
<style>
    .gallery-container {
        padding: 30px 0;
    }
    .gallery-header {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .gallery-title {
        font-size: 24px;
        color: #333;
    }
    .custom-order-button {
        text-align: center;
        margin-bottom: 20px;
    }
    .custom-order-button .btn {
        background-color: #e75a87;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .custom-order-button .btn:hover {
        background-color: #d44d7a;
    }
    .color-change-notice {
        text-align: center;
        margin-bottom: 30px;
        font-size: 15px;
    }
    .course-navigation {
        margin-bottom: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .course-nav-item {
        display: block;
        background-color: #f8f8f8;
        padding: 12px;
        margin-bottom: 10px;
        text-align: center;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
        transition: all 0.3s;
        border: 1px solid #eee;
    }
    .course-nav-item:hover, .course-nav-item.active {
        background-color: #e75a87;
        color: #fff;
        border-color: #e75a87;
    }
    .category-title {
        display: flex;
        justify-content: center;
        margin: 20px 0px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .page-indicator {
        font-size: 14px;
        color: #666;
    }
    .gallery-grid {
        margin: 30px;
    }
    .gallery-item {
        margin-bottom: 40px;
        padding: 0 10px;
    }
    .gallery-item:hover {
        transform: translateY(-5px);
    }
    .gallery-image {
        background-color: #fff;
        border: 1px solid #eee;
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    .gallery-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
    .gallery-image:hover img {
        transform: scale(1.05);
    }
    .gallery-caption {
        padding-top: 10px;
        background: #fff;
    }
    .gallery-caption h3 {
        font-size: 16px;
        margin: 0 0 5px;
        color: #333;
    }
    .pagination-container {
        text-align: center;
        margin: 40px 0;
    }
    .pagination.custom-pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .pagination-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        background-color: #fff;
        border: 1px solid #e75a87;
        color: #e75a87;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .pagination-link:hover {
        background-color: #e75a87;
        color: #fff;
        border-color: #e75a87;
    }
    .pagination-link.active {
        background-color: #e75a87;
        color: #fff;
        border-color: #e75a87;
        font-weight: 600;
    }
    .pagination-link:active {
        transform: scale(0.98);
    }
    .no-posts-found {
        text-align: center;
        padding: 50px 0;
        color: #666;
    }
    
    /* カスタムグリッドクラス */
    .col-lg-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
    }

    /* モーダル用 */
    .gallery-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0; 
        top: 0; 
        width: 100vw; 
        height: 100vh;
        background: rgba(0,0,0,0.85);
        justify-content: center;
        align-items: center;
    }
    .gallery-modal.open { display: flex; }
    .gallery-modal-content {
        position: relative;
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        max-width: 600px;
        width: 90vw;
        box-shadow: 0 4px 32px rgba(0,0,0,0.3);
        text-align: center;
    }
    .gallery-modal-image-wrap {
        margin-bottom: 15px;
    }
    .gallery-modal-image-wrap img {
        max-width: 100%;
        max-height: 60vh;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    .gallery-modal-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .gallery-modal-desc {
        font-size: 15px;
        color: #444;
        margin-bottom: 10px;
    }
    .gallery-modal-close {
        position: absolute;
        top: 10px; 
        right: 10px;
        background: none;
        border: none;
        font-size: 32px;
        color: #333;
        cursor: pointer;
    }
    .gallery-modal-prev, .gallery-modal-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 36px;
        color: #333;
        cursor: pointer;
        z-index: 2;
    }
    .gallery-modal-prev { left: 10px; }
    .gallery-modal-next { right: 10px; }
    
    /* レスポンシブ対応 */
    @media (max-width: 991px) {
        .col-lg-2-4 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .gallery-title {
            font-size: 20px;
        }
        .custom-order-button .btn {
            font-size: 14px;
            padding: 8px 15px;
        }
        .category-title h2 {
            font-size: 18px;
        }
        .gallery-caption h3 {
            font-size: 15px;
        }
    }
    
    @media (max-width: 767px) {
        .col-lg-2-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .gallery-title {
            font-size: 18px;
        }
        .custom-order-button .btn {
            font-size: 13px;
            padding: 7px 12px;
        }
        .category-title h2 {
            font-size: 16px;
        }
        .gallery-caption h3 {
            font-size: 14px;
        }
        .gallery-description {
            font-size: 12px;
        }
        .gallery-item {
            padding: 0 5px;
        }
        .pagination-link {
            min-width: 50px;
            height: 50px;
            font-size: 14px;
            padding: 0 8px;
        }
    }

    @media (max-width: 600px) {
        .gallery-modal-content { padding: 10px; }
        .gallery-modal-title { font-size: 16px; }
        .gallery-modal-desc { font-size: 13px; }
    }
</style>

<!-- モーダル制御用JS -->
<script>
jQuery(function($){
    var items = [];
    $('.gallery-modal-trigger').each(function(){
        items.push({
            img: $(this).data('img'),
            title: $(this).data('title'),
            desc: $(this).data('desc')
        });
    });

    function openModal(idx) {
        if(items[idx]) {
            $('#gallery-modal-img').attr('src', items[idx].img);
            $('#gallery-modal-title').text(items[idx].title);
            $('#gallery-modal-desc').text(items[idx].desc);
            $('#gallery-modal').addClass('open').data('idx', idx);
        }
    }
    function closeModal() {
        $('#gallery-modal').removeClass('open');
    }
    function showPrev() {
        var idx = $('#gallery-modal').data('idx');
        idx = (idx > 0) ? idx - 1 : items.length - 1;
        openModal(idx);
    }
    function showNext() {
        var idx = $('#gallery-modal').data('idx');
        idx = (idx < items.length - 1) ? idx + 1 : 0;
        openModal(idx);
    }

    $('.gallery-modal-trigger').on('click', function(){
        openModal($(this).data('index'));
    });
    $('.gallery-modal-close').on('click', closeModal);
    $('.gallery-modal-prev').on('click', showPrev);
    $('.gallery-modal-next').on('click', showNext);
    $('#gallery-modal').on('click', function(e){
        if(e.target === this) closeModal();
    });
    $(document).on('keydown', function(e){
        if(!$('#gallery-modal').hasClass('open')) return;
        if(e.key === 'Escape') closeModal();
        if(e.key === 'ArrowLeft') showPrev();
        if(e.key === 'ArrowRight') showNext();
    });
});
</script>

<?php get_footer(); ?>