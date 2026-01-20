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
$posts_per_page = 50;

// ギャラリー投稿を取得
$gallery_query = twelor_get_gallery_page_posts($main_category, $sub_category, $posts_per_page, $current_page);

// 総ページ数を計算
$total_posts = $gallery_query->found_posts;
$total_pages = ceil($total_posts / $posts_per_page);

// カテゴリー名を動的に取得
$main_category_name = twelor_get_main_category_name($main_category);
$sub_category_name = twelor_get_sub_category_name($main_category, $sub_category);
?>

<div class="page-header">
    <div class="headline-area">
        <h1 class="headline"><?php echo esc_html($main_category_name); ?></h1>
        <p class="title">ギャラリー</p>
    </div>
</div>

<div class="gallery-container">
    <!-- 無料お色変更の案内 -->
    <div class="color-change-notice">
        <p>※お色変更無料※</p>
    </div>

    <!-- コースカテゴリーナビゲーション -->
    <?php if ($main_category === 'hand'): ?>
    <div class="course-navigation">
        <?php
        $sub_categories = twelor_get_course_choices($main_category);
        $chunks = array_chunk($sub_categories, 4, true);
        foreach ($chunks as $chunk): ?>
        <div class="row">
            <?php foreach ($chunk as $slug => $name): ?>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/' . $slug . '/'); ?>" class="course-nav-item <?php echo ($sub_category == $slug) ? 'active' : ''; ?>">
                    <?php echo esc_html($name); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php elseif ($main_category === 'foot'): ?>
    <div class="course-navigation">
        <?php
        $sub_categories = twelor_get_course_choices($main_category);
        $chunks = array_chunk($sub_categories, 3, true);
        foreach ($chunks as $chunk): ?>
        <div class="row">
            <?php foreach ($chunk as $slug => $name): ?>
            <div class="col-md-4 col-6">
                <a href="<?php echo home_url('/gallery_' . $main_category . '_design/' . $slug . '/'); ?>" class="course-nav-item <?php echo ($sub_category == $slug) ? 'active' : ''; ?>">
                    <?php echo esc_html($name); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php elseif ($main_category === 'guest'): ?>
    <div class="course-navigation">
        <?php
        $sub_categories = twelor_get_course_choices($main_category);
        $chunks = array_chunk($sub_categories, 4, true);
        foreach ($chunks as $chunk): ?>
        <div class="row">
            <?php foreach ($chunk as $slug => $name): ?>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_guest_nail/' . $slug . '/'); ?>" class="course-nav-item <?php echo ($sub_category == $slug) ? 'active' : ''; ?>">
                    <?php echo esc_html($name); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php elseif ($main_category === 'arts-parts'): ?>
    <div class="course-navigation">
        <?php
        $sub_categories = twelor_get_course_choices($main_category);
        $chunks = array_chunk($sub_categories, 4, true);
        foreach ($chunks as $chunk): ?>
        <div class="row">
            <?php foreach ($chunk as $slug => $name): ?>
            <div class="col-md-3 col-6">
                <a href="<?php echo home_url('/gallery_arts_parts/' . $slug . '/'); ?>" class="course-nav-item <?php echo ($sub_category == $slug) ? 'active' : ''; ?>">
                    <?php echo esc_html($name); ?>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
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
                            <div class="gallery-item fade-in-section">
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
                                        <?php if (twelor_should_show_new_tag(get_the_ID())): ?>
                                            <?php echo twelor_get_new_tag_html(); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="gallery-caption">
                                    <h2 class="gallery-title"><?php echo $title; ?></h2>
                                    <p class="publish" style="display:none;"><?php echo get_the_date('Y/m/d H:i:s'); ?></p>
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
                        $base_url = home_url("gallery_guest_nail/{$sub_category}/page/%#%/");
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

<style>
    /* ページヘッダー */
    .page-header {
        background: url("<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/gallery.jpeg") no-repeat center center;
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

    /* gelleryセクション */
    .gallery-container {
        padding: 30px 0;
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
        font-size: 13px;
    }
    .course-nav-item:hover, .course-nav-item.active {
        background-color: #95bac3;
        color: #fff;
        border-color: #95bac3;
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
        position: relative;
    }
    
    .new-tag-wrapper {
        position: absolute;
        top: 0;
        left: -75px;
        width: 200px;
        height: 40px;
        overflow: hidden;
        transform: rotate(-45deg);
    }

    .new-tag {
        position: absolute;
        display: block;
        width: 100%;
        padding: 8px 0;
        background-color: #95bac3;;
        color: #fff;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        z-index: 1;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .gallery-image img {
        width: 100%;
        height: auto;
        aspect-ratio: 4 / 3;
        object-fit: cover;
    }
    .gallery-image:hover img {
        transform: scale(1.05);
    }
    .gallery-caption {
        padding-top: 10px;
        background: #fff;
    }
    .gallery-caption h2 {
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
        border: 1px solid #95bac3;
        color: #95bac3;
        font-size: 16px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    .pagination-link:hover {
        background-color: #95bac3;
        color: #fff;
        border-color: #95bac3;
    }
    .pagination-link.active {
        background-color: #95bac3;
        color: #fff;
        border-color: #95bac3;
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
        padding: 0px;
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

    @media (max-width: 1024px) {
        .course-navigation {
            margin: 0 5%;
        }
    }
    /* レスポンシブ対応 */
    @media (max-width: 991px) {
        .col-lg-2-4 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0px;
        }
        .category-title h2 {
            font-size: 18px;
        }
        .gallery-caption h2 {
            font-size: 15px;
        }
    }
    
    @media (max-width: 767px) {
        .category-title h2 {
            font-size: 16px;
        }
        .gallery-caption h2 {
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

    @media (max-width: 425px) {
        .new-tag-wrapper {
            left: -80px;
        }
        .new-tag {
            padding: 2px 0;
            font-size: 10px;
        }
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