<?php
/**
 * Template Name: ギャラリーテンプレート
 */
get_header();

// クエリ変数から情報を取得
$category = get_query_var('category', '');
$design_type = get_query_var('design_type', '');
$parts_type = get_query_var('parts_type', '');
$page_num = get_query_var('page_num', 1);

// カテゴリー名の設定
$category_name = '';
switch ($category) {
    case 'hand':
        $category_name = 'HAND定額コース';
        break;
    case 'foot':
        $category_name = 'FOOT定額コース';
        break;
    case 'bridal':
        $category_name = 'ブライダルデザイン';
        break;
    case 'arts-parts':
        $category_name = 'アート・パーツ';
        break;
    case 'guest':
        $category_name = 'ゲストネイルギャラリー';
        break;
    default:
        $category_name = 'ギャラリー';
}

// デザインタイプの設定
$design_type_name = '';
if ($category == 'hand' || $category == 'foot') {
    switch ($design_type) {
        case '1':
            $design_type_name = 'シンプル定額コース';
            break;
        case '2':
            $design_type_name = '一番人気コース';
            break;
        case '3':
            $design_type_name = 'こだわりコース';
            break;
    }
}

// パーツタイプの設定
$parts_type_name = '';
if ($category == 'arts-parts') {
    switch ($parts_type) {
        case '6':
            $parts_type_name = 'ストーン・スタッズ・パール';
            break;
        case '7':
            $parts_type_name = 'ラメ・ホロ・シール';
            break;
        case '8':
            $parts_type_name = 'パーツ';
            break;
    }
}

// タクソノミークエリの構築
$tax_query = array('relation' => 'AND');

if ($category) {
    $tax_query[] = array(
        'taxonomy' => 'gallery_category',
        'field' => 'slug',
        'terms' => $category,
    );
}

if ($design_type && ($category == 'hand' || $category == 'foot')) {
    $tax_query[] = array(
        'taxonomy' => 'design_type',
        'field' => 'slug',
        'terms' => 'design' . $design_type,
    );
}

if ($parts_type && $category == 'arts-parts') {
    $tax_query[] = array(
        'taxonomy' => 'parts_type',
        'field' => 'slug',
        'terms' => 'parts' . $parts_type,
    );
}

// ギャラリーの投稿を取得
$args = array(
    'post_type' => 'gallery',
    'posts_per_page' => 12,
    'paged' => $page_num,
    'tax_query' => $tax_query,
);
$gallery_query = new WP_Query($args);
?>

<div class="container py-5">
    <h1 class="fascina-section-title mb-4"><?php echo esc_html($category_name); ?></h1>
    
    <?php if ($design_type_name) : ?>
    <h2 class="h4 mb-4" style="color: #ff69b4;"><?php echo esc_html($design_type_name); ?></h2>
    <?php endif; ?>
    
    <?php if ($parts_type_name) : ?>
    <h2 class="h4 mb-4" style="color: #ff69b4;"><?php echo esc_html($parts_type_name); ?></h2>
    <?php endif; ?>
    
    <?php if ($category == 'hand') : ?>
    <!-- HAND定額コースのタブ -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($design_type == '1') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_hand_design1_1.html')); ?>#here">シンプル定額コース</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($design_type == '2') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_hand_design2_1.html')); ?>#here">一番人気コース</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($design_type == '3') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_hand_design3_1.html')); ?>#here">こだわりコース</a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($category == 'foot') : ?>
    <!-- FOOT定額コースのタブ -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($design_type == '1') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_foot_design1_1.html')); ?>#here">シンプル定額コース</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($design_type == '2') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_foot_design2_1.html')); ?>#here">一番人気コース</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($design_type == '3') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_foot_design3_1.html')); ?>#here">こだわりコース</a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($category == 'guest') : ?>
    <!-- ゲストネイルギャラリーのタブ -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo esc_url(home_url('/gallery_guest_nail_1.html')); ?>#here">ゲストネイル</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/gallery_hand_design1_1.html')); ?>#here">ハンドデザイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/gallery_foot_design1_1.html')); ?>#here">フットデザイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/gallery_bridal_design_1.html')); ?>#here">ブライダルデザイン</a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($category == 'arts-parts') : ?>
    <!-- アート・パーツのタブ -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($parts_type == '7') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_arts_parts7_1.html')); ?>#here">ラメ・ホロ・シール</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($parts_type == '6') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_arts_parts6_1.html')); ?>#here">ストーン・スタッズ・パール</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($parts_type == '8') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/gallery_arts_parts8_1.html')); ?>#here">パーツ</a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    
    <div id="here" class="row">
        <?php
        if ($gallery_query->have_posts()) :
            while ($gallery_query->have_posts()) : $gallery_query->the_post();
        ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php the_title(); ?></h5>
                        <?php if (function_exists('get_field')) : ?>
                            <p class="card-text"><?php echo esc_html(get_field('gallery_price')); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn-sm" style="background-color: #ff69b4; color: white;">詳細を見る</a>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else :
        ?>
            <div class="col-12">
                <p>ギャラリーはありません。</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- ページネーション -->
    <div class="pagination-wrapper mt-4">
        <nav aria-label="ギャラリーページネーション">
            <?php
            // 現在のURLパターンを取得
            $current_url_base = '';
            if ($category == 'hand') {
                $current_url_base = 'gallery_hand_design' . $design_type . '_';
            } elseif ($category == 'foot') {
                $current_url_base = 'gallery_foot_design' . $design_type . '_';
            } elseif ($category == 'bridal') {
                $current_url_base = 'gallery_bridal_design_';
            } elseif ($category == 'arts-parts') {
                $current_url_base = 'gallery_arts_parts' . $parts_type . '_';
            } elseif ($category == 'guest') {
                $current_url_base = 'gallery_guest_nail_';
            }
            
            // カスタムページネーションリンクの生成
            $total_pages = $gallery_query->max_num_pages;
            if ($total_pages > 1) {
                echo '<ul class="pagination">';
                
                // 前のページへのリンク
                if ($page_num > 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/' . $current_url_base . ($page_num - 1) . '.html') . '#here">&laquo;</a></li>';
                } else {
                    echo '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
                }
                
                // ページ番号リンク
                $start_page = max(1, $page_num - 2);
                $end_page = min($total_pages, $page_num + 2);
                
                if ($start_page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/' . $current_url_base . '1.html') . '#here">1</a></li>';
                    if ($start_page > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }
                
                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $page_num) {
                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="' . home_url('/' . $current_url_base . $i . '.html') . '#here">' . $i . '</a></li>';
                    }
                }
                
                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/' . $current_url_base . $total_pages . '.html') . '#here">' . $total_pages . '</a></li>';
                }
                
                // 次のページへのリンク
                if ($page_num < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="' . home_url('/' . $current_url_base . ($page_num + 1) . '.html') . '#here">&raquo;</a></li>';
                } else {
                    echo '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
                }
                
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>