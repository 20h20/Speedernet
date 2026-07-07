<?php

$uptitle  = get_field('testimonials_uptitle');
$uptitlepic  = get_field('testimonials_uptitlepicture');
$title  = get_field('testimonials_title');
$button = get_field('testimonials_bouton');
$last   = get_field('testimonials_last');
$type  = get_field('testimonials_category');
$testimonials_page_id = (int) get_option('cbo_testimonials_archive_page');
$current_page_id      = (int) get_queried_object_id();
$is_testimonials_page = is_post_type_archive('testimonial') || is_tax('testimonials_cat') || ( $testimonials_page_id && $current_page_id === $testimonials_page_id );

?>

<section class="cbo-testimonials <?php echo !$is_testimonials_page ? 'testimonials--relationship' : ''; ?> cbo-overflow-container<?php echo is_admin() ? ' is-admin' : ''; ?>">
    <div class="testimonials-inner cbo-container">

        <?php
            if ($is_testimonials_page) :
                get_part('filters/template', [
                    'taxonomy'   => 'testimonials_cat',
                    'post_type'  => 'testimonial',
                    'base_url'   => $testimonials_page_id ? get_permalink($testimonials_page_id) : home_url('/'),
                    'aria_label' => pll__('Filtrer les témoignages par catégorie'),
                    'singular'   => pll__('%d témoignage'),
                    'plural'     => pll__('%d témoignages'),
                    'flat'       => true,
                ]);
            endif;
        ?>

        <?php if ($title || $uptitle) : ?>
            <div class="testimonials-head">
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
                    <div class="testimonials-title cbo-title-2 slide-up">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="testimonials-list">
            <?php
                if ($last) {
                    if ($is_testimonials_page) {
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                            get_part('testimonial/template');
                            endwhile;

                            if (function_exists('page_navi')) {
                                page_navi();
                            } else {
                                the_posts_pagination();
                            }
                        else:
                            echo '<p>' . esc_html__('Aucun témoignage trouvé.', 'textdomain') . '</p>';
                        endif;
                    } else {
                        $args = [
                            'post_type' => 'testimonial',
                            'posts_per_page' => 3,
                            'post_status'    => 'publish',
                            'no_found_rows' => true,
                            'update_post_meta_cache' => false,
                        ];
                        if ( ! empty( $type ) ) {
                            $args['tax_query'] = [[
                                'taxonomy' => 'testimonials_cat',
                                'field'    => 'term_id',
                                'terms'    => is_object( $type ) ? $type->term_id : $type,
                            ]];
                        }
                        $posts_query = new WP_Query($args);
                        if ($posts_query->have_posts()) :
                            while ($posts_query->have_posts()) : $posts_query->the_post();
                                get_part('testimonial/template');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                } else {
                    $acf_posts = get_field('testimonials_articleslist');
                    if (!$is_testimonials_page && !empty($acf_posts)):
                        global $post;
                        foreach ($acf_posts as $post):
                            setup_postdata($post);
                            get_part('testimonial/template');
                        endforeach;
                        wp_reset_postdata();
                    endif;
                }
            ?>
        </div>

        <?php if ($button): ?>
            <div class="testimonials-button slide-up">
                <a class="cbo-button" href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target'] ?: '_self'); ?>">
                    <?php echo esc_html($button['title']); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="testimonials-bluebg"></div>
    </div>
</section>