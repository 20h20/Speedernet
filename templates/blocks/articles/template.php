<?php

$related_to   = $args['related_to'] ?? null;
$title_arg    = $args['title']      ?? null;

$uptitle    = get_field('articles_uptitle');
$uptitlepic = get_field('articles_uptitlepicture');
$title      = $title_arg ?? get_field('articles_title');
$button     = get_field('articles_bouton');
$last       = get_field('articles_last');
$type       = get_field('articles_category');

$is_articles_page   = is_home() || is_category() || is_tag() || is_archive() || is_404();
$blog_page_id       = (int) get_option('page_for_posts');
$is_listing_context = $is_articles_page || ($blog_page_id && is_admin() && (int) get_the_ID() === $blog_page_id);

?>

<section class="cbo-articles <?php echo !$is_listing_context ? 'articles--relationship cbo-overflow-container' : ''; ?>">
    <div class="articles-inner cbo-container">

        <?php
            if ($is_articles_page) :
                $blog_page_id = (int) get_option('page_for_posts');
                get_part('filters/template', [
                    'taxonomy'   => 'category',
                    'post_type'  => 'post',
                    'base_url'   => $blog_page_id ? get_permalink($blog_page_id) : home_url('/'),
                    'aria_label' => pll__('Filtrer les articles par catégorie'),
                    'singular'   => pll__('%d article'),
                    'plural'     => pll__('%d articles'),
                ]);
            endif;
        ?>

        <?php if ($title || $uptitle) : ?>
            <div class="articles-head">
                <?php if($uptitle): ?>
                    <span class="cbo-tag tag--blue content-uptitle slide-up">
                        <?php echo esc_html($uptitle); ?>

                        <?php if($uptitlepic): ?>
                            <span class="tag-picture cbo-picture-contain">
                                <img
                                    src="<?php echo esc_url($uptitlepic['sizes']['small']); ?>"
                                    srcset="<?php echo esc_url($uptitlepic['sizes']['small']); ?> 320w"
                                    sizes="(max-width: 768px) 54px, 54px"
                                    alt=""
                                    width="<?php echo esc_attr($uptitlepic['sizes']['small-width']); ?>"
                                    height="<?php echo esc_attr($uptitlepic['sizes']['small-height']); ?>"
                                    decoding="async"
                                    loading="lazy"
                                >
                            </span>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>

                <?php if ($title): ?>
                    <div class="articles-title cbo-title-2 slide-up">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="articles-list">
            <?php
                if ($related_to) {
                    $related_terms = wp_get_post_terms($related_to, 'category');
                    $related_args  = [
                        'post_type'              => 'post',
                        'posts_per_page'         => 3,
                        'post_status'            => 'publish',
                        'post__not_in'           => [$related_to],
                        'no_found_rows'          => true,
                        'update_post_meta_cache' => false,
                    ];
                    if (!empty($related_terms) && !is_wp_error($related_terms)) {
                        $related_args['tax_query'] = [[
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $related_terms[0]->term_id,
                        ]];
                    }
                    $related_query = new WP_Query($related_args);
                    if ($related_query->have_posts()) :
                        while ($related_query->have_posts()) : $related_query->the_post();
                            get_part('article/template');
                        endwhile;
                        wp_reset_postdata();
                    endif;
                } elseif ($last) {
                    if ($is_articles_page) {
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                            get_part('article/template');
                            endwhile;

                            get_part('pagination/template');
                        else:
                            echo '<p>' . esc_html__('Aucun article trouvé.', 'textdomain') . '</p>';
                        endif;
                    } else {
                        $query_args = [
                            'post_type'              => 'post',
                            'posts_per_page'         => 3,
                            'post_status'            => 'publish',
                            'no_found_rows'          => true,
                            'update_post_meta_cache' => false,
                        ];
                        if (!empty($type)) {
                            $query_args['cat'] = is_object($type) ? $type->term_id : $type;
                        }
                        $posts_query = new WP_Query($query_args);
                        if ($posts_query->have_posts()) :
                            while ($posts_query->have_posts()) : $posts_query->the_post();
                            get_part('article/template');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                } else {
                    $acf_posts = get_field('articles_articleslist');
                    if (!$is_articles_page && !empty($acf_posts)):
                        global $post;
                        foreach ($acf_posts as $post):
                            setup_postdata($post);
                            get_part('article/template');
                        endforeach;
                        wp_reset_postdata();
                    endif;
                }
            ?>
        </div>

        <?php if ($button): ?>
            <div class="articles-button slide-up">
                <?php get_part('button/template', [
                    'url'    => $button['url'],
                    'label'  => $button['title'],
                    'target' => $button['target'] ?: '_self',
                    'class'  => 'cbo-button button--blue',
                ]); ?>
            </div>
        <?php endif; ?>

    </div>
</section>