<?php

$categories = get_terms(array(
    'taxonomy'   => 'faq_cat',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
));

if (is_wp_error($categories) || empty($categories)) return;

$sidebar_title   = get_field('block_faqs_sidebartitle');
$sidebar_content = get_field('block_faqs_sidebarchapo');
$button1         = get_field('block_faqs_sidebarbutton1');
$button2         = get_field('block_faqs_sidebarbutton2');

$anchor = !empty($block['anchor']) ? ' id="' . esc_attr($block['anchor']) . '"' : '';

?>

<section class="cbo-faqs"<?php echo $anchor; ?> itemscope itemtype="https://schema.org/FAQPage">
    <div class="faqs-inner cbo-container">

        <aside class="faqs-sidebar">
            <nav class="sidebar-nav" aria-label="<?php echo esc_attr(pll__('Catégories FAQ')); ?>">
                <?php foreach ($categories as $cat): ?>
                    <a
                        href="#faq-cat-<?php echo esc_attr($cat->slug); ?>"
                        class="sidebar-link cbo-title-5"
                        data-cat="<?php echo esc_attr($cat->slug); ?>"
                    >
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <?php if ($sidebar_title || $button1 || $button2): ?>
                <div class="sidebar-ctas slide-up">
                    <?php if ($sidebar_title): ?>
                        <p class="cta-title cbo-title-4"><?php echo esc_html($sidebar_title); ?></p>
                    <?php endif; ?>

                    <?php if ($sidebar_content): ?>
                        <p class="cta-content"><?php echo esc_html($sidebar_content); ?></p>
                    <?php endif; ?>

                    <?php if ($button1 || $button2): ?>
                        <div class="cta-buttons">
                            <?php if ($button1): ?>
                                <a
                                    href="<?php echo esc_url($button1['url']); ?>"
                                    class="cbo-button button--white"
                                    target="<?php echo esc_attr($button1['target'] ?: '_self'); ?>"
                                    <?php if (($button1['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
                                ><?php echo esc_html($button1['title']); ?></a>
                            <?php endif; ?>
                            <?php if ($button2): ?>
                                <a
                                    href="<?php echo esc_url($button2['url']); ?>"
                                    class="cbo-button button--blue"
                                    target="<?php echo esc_attr($button2['target'] ?: '_self'); ?>"
                                    <?php if (($button2['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
                                ><?php echo esc_html($button2['title']); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </aside>

        <div class="faqs-content">
            <?php foreach ($categories as $cat):
                $faq_posts = get_posts(array(
                    'post_type'      => 'faq',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'menu_order title',
                    'order'          => 'ASC',
                    'tax_query'      => array(array(
                        'taxonomy' => 'faq_cat',
                        'field'    => 'term_id',
                        'terms'    => $cat->term_id,
                    )),
                ));
                if (!$faq_posts) continue;
                $count = count($faq_posts);
            ?>
                <div
                    class="content-category"
                    id="faq-cat-<?php echo esc_attr($cat->slug); ?>"
                    data-cat="<?php echo esc_attr($cat->slug); ?>"
                >
                    <div class="category-header slide-up">
                        <h2 class="category-title cbo-title-3">
                            <?php echo esc_html($cat->name); ?>
                        </h2>
                        <span class="category-count cbo-tag tag--blue">
                            <?php echo $count; ?> <?php echo esc_attr(pll__('question')); ?><?php echo $count > 1 ? 's' : ''; ?>
                        </span>
                    </div>

                    <div class="faq-list">
                        <?php global $post;
                        foreach ($faq_posts as $index => $faq):
                            $post = $faq;
                            setup_postdata($post);
                            set_query_var('faq_index', $index);
                            set_query_var('faq_section_id', 'faq-cat-' . $cat->slug);
                            get_template_part('templates/parts/faq/template');
                        endforeach;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
