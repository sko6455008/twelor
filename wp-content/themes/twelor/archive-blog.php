<?php get_header(); ?>

<div class="page-header">
    <div class="headline-area">
        <h1 class="headline">Blog</h1>
        <p class="title">ブログ</p>
    </div>
</div>

<div class="blog-container">
    <div class="blog-content">
        <h2 class="blog-section-title">ブログ一覧</h2>
        <div class="post-list">
            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>
                    <article class="blog-post-item">
                        <a href="<?php the_permalink(); ?>" class="post-link">
                            <div class="post-thumbnail">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else: ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default.jpg" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="post-body">
                                <div class="post-meta">
                                    <span
                                        class="post-date"><?php echo get_the_time('Y.m.d') . ' (' . strtoupper(get_the_time('D')) . ')'; ?></span>
                                </div>
                                <h3 class="post-title"><?php the_title(); ?></h3>
                                <div class="post-excerpt">
                                    <?php
                                    $description = get_the_excerpt();
                                    echo wp_trim_words($description, 100, '...');
                                    ?>
                                </div>
                                <div class="post-more-btn">
                                    <span class="btn-text">この記事を読む</span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; endif; ?>
        </div>

        <?php
        // Pagination
        $args = array(
            'prev_text' => '&laquo; 前へ',
            'next_text' => '次へ &raquo;',
            'type' => 'array',
        );
        $links = paginate_links($args);
        if ($links):
            ?>
            <div class="pagination-container">
                <div class="pagination custom-pagination">
                    <?php
                    foreach ($links as $link) {
                        if (strpos($link, 'current') !== false) {
                            echo str_replace('page-numbers', 'pagination-link active', $link);
                        } else {
                            echo str_replace('page-numbers', 'pagination-link', $link);
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <?php wp_reset_postdata(); // メインループをリセット ?>
    <aside class="blog-sidebar">
        <div class="latest-box">
            <h3 class="sidebar-title">最新記事</h3>
            <div class="heart-divider">♥<span>･･････････････････････････</span>♥</div>
            <div class="latest-list">
                <?php
                $latest_query = new WP_Query(array(
                    'post_type' => array('post', 'blog'),
                    'posts_per_page' => 5,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($latest_query->have_posts()):
                    while ($latest_query->have_posts()):
                        $latest_query->the_post();
                        $post_id = get_the_ID();
                        $thumb_url = get_the_post_thumbnail_url($post_id, 'thumbnail');
                        ?>
                        <a href="<?php the_permalink(); ?>" class="latest-item">
                            <div class="latest-thumb">
                                <?php if ($thumb_url): ?>
                                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="latest-info">
                                <p class="latest-post-title"><?php the_title(); ?></p>
                            </div>
                        </a>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </aside>
</div>

<?php get_footer(); ?>

<style>
    /* ページヘッダー */
    .page-header {
        background: url("<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/blog.jpeg") no-repeat center center;
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

    .headline,
    .title {
        text-shadow: 1px 1px 5px #735E59;
    }

    /* ブログレイアウト全体 */
    .blog-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .blog-content {
        flex: 1;
        min-width: 0;
        max-width: 100%;
    }

    .blog-section-title {
        font-size: 27px;
        font-weight: 300;
        text-align: center;
        color: #333;
        letter-spacing: 0.1em;
    }

    /* 記事一覧 */
    .post-list {
        display: flex;
        flex-direction: column;
    }

    .blog-post-item {
        padding: 40px 0;
        border-top: 1px solid #eee;
    }

    .blog-post-item:first-child {
        border-top: none;
    }

    .post-link {
        display: flex;
        gap: 30px;
        text-decoration: none;
        color: inherit;
    }

    .post-link:hover {
        opacity: 0.8;
    }

    .post-thumbnail {
        width: 280px;
        flex-shrink: 0;
    }

    .post-thumbnail img {
        width: 100%;
        height: auto;
        display: block;
        aspect-ratio: 4 / 3;
        object-fit: cover;
    }

    .post-body {
        flex: 1;
        min-width: 0;
        /* フレックス内でのオーバーフロー防止 */
        position: relative;
    }

    .post-meta {
        margin-bottom: 10px;
    }

    .post-date {
        color: #95bac3;
        font-weight: bold;
        font-size: 14px;
    }

    .post-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        line-height: 1.5;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .post-excerpt {
        font-size: 14px;
        line-height: 1.8;
        color: #666;
        margin-bottom: 20px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* もっと読むボタン */
    .post-more-btn {
        display: flex;
        justify-content: flex-end;
    }

    .btn-text {
        background: #333;
        color: #fff;
        padding: 8px 15px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-text::after {
        content: "";
        display: block;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 5px 0 5px 8px;
        border-color: transparent transparent transparent #fff;
    }

    /* サイドバー */
    .blog-sidebar {
        width: 320px;
        flex-shrink: 0;
        position: sticky;
        top: 100px;
        align-self: flex-start;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .latest-box {
        background: #fff;
        padding: 30px 20px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
    }

    .sidebar-title {
        font-size: 18px;
        font-weight: 300;
        text-align: center;
        margin-bottom: 10px;
        color: #333;
    }

    .heart-divider {
        text-align: center;
        color: #333;
        font-size: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        white-space: nowrap;
    }

    .heart-divider span {
        letter-spacing: 2px;
    }

    .latest-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .latest-item {
        display: flex;
        gap: 15px;
        text-decoration: none;
        color: inherit;
        align-items: center;
    }

    .latest-item:hover {
        opacity: 0.7;
    }

    .latest-thumb {
        width: 100px;
        flex-shrink: 0;
    }

    .latest-thumb img {
        width: 100%;
        height: auto;
        aspect-ratio: 4 / 3;
        object-fit: cover;
    }

    .latest-post-title {
        font-size: 13px;
        font-weight: bold;
        line-height: 1.5;
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* レスポンシブ */
    @media (max-width: 1024px) {
        .post-thumbnail {
            width: 240px;
        }
    }

    @media (max-width: 991px) {
        .page-header {
            height: 320px;
        }

        .headline {
            font-size: 36px;
        }

        .blog-container {
            flex-direction: column;
            gap: 60px;
            margin: 40px auto;
            padding: 0 15px;
        }

        .blog-sidebar {
            width: 100%;
        }

        .latest-box {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            height: 280px;
        }

        .headline {
            font-size: 32px;
        }

        .post-link {
            gap: 20px;
        }

        .post-thumbnail {
            width: 180px;
        }

        .post-title {
            font-size: 18px;
        }

        .post-excerpt {
            font-size: 13px;
            -webkit-line-clamp: 3;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    }

    @media (max-width: 640px) {
        .page-header {
            height: 220px;
        }

        .headline {
            font-size: 28px;
        }

        .title {
            font-size: 14px;
        }

        .blog-section-title {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .post-link {
            flex-direction: column;
            gap: 0;
        }

        .post-thumbnail {
            width: 100%;
            margin-bottom: 15px;
        }

        .post-body {
            padding: 0 5px;
        }

        .post-title {
            font-size: 17px;
        }

        .post-excerpt {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .blog-post-item {
            padding: 25px 0;
        }

        .latest-thumb {
            width: 80px;
        }

        .latest-post-title {
            font-size: 12px;
        }
    }

    /* ページネーション */
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

    @media (max-width: 768px) {
        .pagination-link {
            min-width: 50px;
            height: 50px;
            font-size: 14px;
            padding: 0 8px;
        }
    }
</style>