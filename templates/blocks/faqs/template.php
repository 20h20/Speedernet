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

// Catégorie sélectionnée via ?faq_cat=slug
$active_cat = null;
if ( ! empty($_GET['faq_cat']) ) {
    $requested_slug = sanitize_title( wp_unslash( $_GET['faq_cat'] ) );
    foreach ($categories as $cat) {
        if ($cat->slug === $requested_slug) {
            $active_cat = $cat;
            break;
        }
    }
}

// Comptage des questions par catégorie
$cat_posts = array();
$loop_categories = $active_cat ? array($active_cat) : $categories;

foreach ($loop_categories as $cat) {
    $cat_posts[$cat->term_id] = get_posts(array(
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
}

?>

<section class="cbo-faqs<?php echo $active_cat ? '' : ' cbo-faqs--categories'; ?>"<?php echo $anchor; ?><?php echo $active_cat ? ' itemscope itemtype="https://schema.org/FAQPage"' : ''; ?>>
    <div class="faqs-inner cbo-container">

        <?php if ($active_cat): ?>
            <aside class="faqs-sidebar">
                <?php if ($sidebar_title || $button1 || $button2): ?>
                    <div class="sidebar-ctas slide-up">
                        <?php if ($sidebar_title): ?>
                            <p class="cta-title cbo-title-4"><?php echo esc_html($sidebar_title); ?></p>
                        <?php endif; ?>

                        <?php if ($sidebar_content): ?>
                            <p class="cta-content"><?php echo esc_html($sidebar_content); ?></p>
                        <?php endif; ?>

                        <?php if ( $button1 || $button2 ) : ?>
                            <div class="cta-buttons">
                                <?php if ( $button1 ) : ?>
                                    <?php get_part('button/template', [
                                        'url'    => $button1['url'],
                                        'label'  => $button1['title'],
                                        'target' => $button1['target'] ?: '_self',
                                        'class'  => 'cbo-button button--white',
                                    ]); ?>
                                <?php endif; ?>
                                <?php if ( $button2 ) : ?>
                                    <?php get_part('button/template', [
                                        'url'    => $button2['url'],
                                        'label'  => $button2['title'],
                                        'target' => $button2['target'] ?: '_self',
                                        'class'  => 'cbo-button button--blue',
                                    ]); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </aside>
        <?php endif; ?>

        <div class="faqs-content">
            <?php if ($active_cat):
                $faq_posts = $cat_posts[$active_cat->term_id];
                $count     = count($faq_posts);
            ?>
                <a href="<?php echo esc_url( remove_query_arg('faq_cat') ); ?>" class="faqs-backlink slide-up">
                    <i class="icon icon--arrow-prev" aria-hidden="true"></i>
                    <?php pll_e('Retour aux catégories'); ?>
                </a>

                <?php if ($faq_posts): ?>
                    <div
                        class="content-category"
                        id="faq-cat-<?php echo esc_attr($active_cat->slug); ?>"
                        data-cat="<?php echo esc_attr($active_cat->slug); ?>"
                    >
                        <div class="category-header slide-up">
                            <h2 class="category-title cbo-title-3">
                                <?php echo esc_html($active_cat->name); ?>
                            </h2>
                            <span class="category-count cbo-tag tag--blue">
                                <?php echo esc_html( $count ); ?> <?php echo esc_html( pll__('question') ); ?><?php echo $count > 1 ? 's' : ''; ?>
                            </span>
                        </div>

                        <div class="faq-list">
                            <?php global $post;
                            foreach ($faq_posts as $index => $faq):
                                $post = $faq;
                                setup_postdata($post);
                                set_query_var('faq_index', $index);
                                set_query_var('faq_section_id', 'faq-cat-' . $active_cat->slug);
                                get_template_part('templates/parts/faq/template');
                            endforeach;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="faqs-categories">
                    <?php foreach ($categories as $cat):
                        $count = count($cat_posts[$cat->term_id]);
                        if (!$count) continue;
                    ?>
                        <a
                            href="<?php echo esc_url( add_query_arg('faq_cat', $cat->slug) ); ?>"
                            class="category-card slide-up"
                        >
                            <span class="category-card-title cbo-title-4"><?php echo esc_html($cat->name); ?></span>
                            <span class="category-card-count cbo-tag tag--blue">
                                <?php echo esc_html( $count ); ?> <?php echo esc_html( pll__('question') ); ?><?php echo $count > 1 ? 's' : ''; ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>