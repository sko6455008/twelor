<?php
get_header();
?>
<div class="page-header">
    <div class="headline-area">
        <h1 class="headline">Q&A</h1>
        <p class="sub-title">よくある質問</p>
    </div>
</div>

<div class="container">
    <?php
    $types = array(
        'service' => '施術について',
        'reservation' => '予約について',
        'other' => 'その他'
    );
    foreach ($types as $type_key => $type_label) :
        $qa_query = new WP_Query(array(
            'post_type' => 'qa',
            'posts_per_page' => -1,
            'orderby' => array(
                'menu_order' => 'ASC',
                'date' => 'DESC'
            ),
            'meta_query' => array(
                array(
                    'key' => 'qa_type',
                    'value' => $type_key,
                    'compare' => '='
                )
            ),
        ));
        if ($qa_query->have_posts()):
    ?>
        <div class="row">
            <div class="col-12">
                <div class="accordion" id="faqAccordion_<?php echo esc_attr($type_key); ?>">
                    <h2 class="heading"><?php echo esc_html($type_label); ?></h2>
                    <?php
                    $count = 1;
                    while ($qa_query->have_posts()): $qa_query->the_post();
                        $question = get_field('qa_question');
                        $answer = get_field('qa_answer');
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo esc_attr($type_key . '_' . $count); ?>">
                                Q.<?php echo esc_html($question); ?>
                            </button>
                        </h2>
                        <div id="collapse_<?php echo esc_attr($type_key . '_' . $count); ?>" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="faq-item">
                                    <p class="mb-0">A.<?php echo esc_html($answer); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $count++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    <?php
        endif;
    endforeach;
    ?>
</div>

<style>
    /* ページヘッダー */
    .page-header {
        background: url("<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/qa.jpeg") no-repeat center center;
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
    .headline,.sub-title {
        text-shadow: 1px 1px 5px #735E59;
    }

    /* Q&Aセクション */
    .container {
        padding: 100px 0px;
    }
    .heading {
        background: rgba(10,34,72,.1);
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #5d5855;
    }
    .accordion-item {
        border: none;
        margin-bottom: 1rem;
    }
    .accordion-header {
        border-bottom: 1px solid #eee;
    }
    .accordion-button {
        background-color: #fff;
        color: #333;
    }
    .accordion-button:not(.collapsed) {
        background-color: #fff;
        color: #333;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .accordion-body {
        background-color: #fff;
    }
    .faq-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }
    .faq-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    @media (max-width: 768px) {
        .page-header {
            height: 200px;
        }
        .container {
            padding: 40px 0px;
        }
    }
    @media (max-width: 425px) {
        .container {
            padding: 20px 0px;
        }
    }
</style>

<?php get_footer(); ?>
