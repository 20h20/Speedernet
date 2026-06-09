<?php

$title           = get_field('accordion_title');
$last            = get_field('accordion_last');
$type            = get_field('accordion_category');
$archive_page_id = (int) get_option('cbo_faq_archive_page');
$is_faq_page     = is_post_type_archive('faq') || is_tax('faq_cat') || ( $archive_page_id && is_page( $archive_page_id ) );

?>

<section class="cbo-accordion <?php echo !$is_faq_page ? 'accordion--relationship' : ''; ?>">
    <div class="accordion-inner cbo-container container--small">

        <?php if ($title): ?>
            <div class="accordion-title cbo-title-2 slide-up">
                <?php echo wp_kses_post($title); ?>
            </div>
        <?php endif; ?>

        <div class="accordion-list">
            <?php
                if ($last) {
                    if ($is_faq_page) {

                        if (have_posts()) :
                            $faq_index = 0;
                            while (have_posts()) : the_post();
                                set_query_var('faq_index', $faq_index);
                                get_part('faq/template');
                                $faq_index++;
                            endwhile;

                            if (function_exists('page_navi')) {
                                page_navi();
                            } else {
                                the_posts_pagination();
                            }
                        else:
                            echo '<p>' . esc_html__('Aucune question trouvée.', 'textdomain') . '</p>';
                        endif;

                    } else {
                        $args = [
                            'post_type' => 'faq',
                            'posts_per_page'    => 3,
                            'post_status'   => 'publish',
                            'no_found_rows' => true,
                            'update_post_meta_cache' => false,
                        ];
                        if ( ! empty( $type ) ) {
                            $args['tax_query'] = [[
                                'taxonomy' => 'faq_cat',
                                'field'    => 'term_id',
                                'terms'    => is_object( $type ) ? $type->term_id : (int) $type,
                            ]];
                        }
                        $posts_query = new WP_Query($args);
                        if ($posts_query->have_posts()) :
                            $faq_index = 0;
                            while ($posts_query->have_posts()) : $posts_query->the_post();
                                set_query_var('faq_index', $faq_index);
                                get_part('faq/template');
                                $faq_index++;
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                } else {
                    $acf_posts = get_field('accordion_articleslist');
                    if (!$is_faq_page && !empty($acf_posts)):
                        global $post;
                        $faq_index = 0;
                        foreach ($acf_posts as $post):
                            setup_postdata($post);
                            set_query_var('faq_index', $faq_index);
                            get_part('faq/template');
                            $faq_index++;
                        endforeach;
                        wp_reset_postdata();
                    endif;
                }
            ?>
        </div>
    </div>
</section>