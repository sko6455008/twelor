<?php get_header(); ?>

<div class="single-blog-wrapper">
    <div class="blog-container">
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <div class="blog-header-info">
                    <p class="post-date"><?php echo get_the_time('Y.m.d') . '(' . strtoupper(get_the_time('D')) . ')'; ?></p>
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </div>

                <div class="blog-layout">
                    <main class="blog-main-content">
                        <article class="post-content-box">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="post-featured-image">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="post-content">
                                <?php the_content(); ?>
                            </div>
                        </article>
                    </main>

                    <aside class="blog-sidebar">
                        <div class="latest-box">
                            <h3 class="sidebar-title">最新記事</h3>
                            <div class="heart-divider">♥<span>･･････････････････････････</span>♥</div>
                            <div class="latest-list">
                                <?php
                                $current_post_type = get_post_type() ? get_post_type() : 'post';
                                $latest_query = new WP_Query(array(
                                    'post_type' => array($current_post_type, 'post', 'blog'),
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
                                    <?php endwhile;
                                    wp_reset_postdata();
                                endif; ?>
                            </div>
                        </div>
                    </aside>
                </div>
            <?php endwhile; endif; ?>
    </div>
</div>

<?php get_footer(); ?>

<style>
    /* 全体背景 */
    .single-blog-wrapper {
        background-color: #fff;
        padding: 120px 0 80px;
        min-height: 100vh;
    }

    .blog-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* タイトルと日付 */
    .blog-header-info {
        margin-bottom: 30px;
    }

    .blog-header-info .post-date {
        color: #95bac3;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .blog-header-info .post-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        line-height: 1.4;
    }

    /* レイアウト */
    .blog-layout {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .blog-main-content {
        flex: 1;
        min-width: 0;
        /* フレックス内でのオーバーフロー防止 */
        max-width: 100%;
    }

    /* 記事本文の白いボックス */
    .post-content-box {
        background: #fff;
        padding: 50px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .post-featured-image {
        margin-bottom: 40px;
        text-align: center;
    }

    .post-featured-image img {
        max-width: 100%;
        height: auto;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .post-content {
        font-size: 16px;
        line-height: 2;
        color: #333;
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-break: break-word;
        max-width: 100%;
        overflow-x: hidden;
    }

    .post-content p {
        margin-bottom: 2em;
    }

    .post-content h2 {
        font-size: 22px;
        margin: 60px 0 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        font-weight: bold;
        line-height: 1.4;
    }

    .post-content h3 {
        font-size: 18px;
        margin: 40px 0 20px;
        font-weight: bold;
        line-height: 1.4;
    }

    .post-content ul,
    .post-content ol {
        margin: 20px 0;
        padding-left: 20px;
    }

    .post-content li {
        margin-bottom: 10px;
    }

    .post-content blockquote {
        margin: 30px 0;
        padding: 20px;
        background: #f9f9f9;
        border-left: 5px solid #95bac3;
        font-style: italic;
    }

    .post-content img {
        max-width: 100%;
        height: auto !important;
        margin: 30px auto;
        display: block;
        border-radius: 8px;
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
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
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
    @media (max-width: 991px) {
        .single-blog-wrapper {
            padding: 100px 0 60px;
        }

        .blog-container {
            padding: 0 15px;
        }

        .blog-layout {
            flex-direction: column;
            gap: 60px;
        }

        .blog-sidebar {
            width: 100%;
        }

        .post-content-box {
            padding: 40px 20px;
        }

        .latest-box {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .single-blog-wrapper {
            padding: 90px 0 50px;
        }

        .blog-header-info {
            margin-bottom: 20px;
        }

        .blog-header-info .post-title {
            font-size: 20px;
            line-height: 1.5;
        }

        .blog-header-info .post-date {
            font-size: 14px;
        }

        .post-content-box {
            padding: 25px 15px;
            border-radius: 10px;
        }

        .post-featured-image {
            margin-bottom: 30px;
        }

        .post-content {
            font-size: 15px;
            line-height: 1.9;
        }

        .post-content h2 {
            font-size: 18px;
            margin: 40px 0 20px;
        }

        .post-content h3 {
            font-size: 16px;
            margin: 30px 0 15px;
        }

        .post-content p {
            margin-bottom: 1.5em;
        }

        .latest-thumb {
            width: 80px;
        }

        .latest-post-title {
            font-size: 12px;
        }
    }
</style>