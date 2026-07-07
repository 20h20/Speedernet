<?php

$uptitle  = get_field('casestudies_uptitle');
$uptitlepic  = get_field('casestudies_uptitlepicture');
$title  = get_field('casestudies_title');
$chapo  = get_field('casestudies_chapo');
$textslide  = get_field('casestudies_textslide');
$button = get_field('casestudies_bouton');
$last   = get_field('casestudies_last');
$type  = get_field('casestudies_category');
$archive_page_id = (int) get_option('cbo_casestudies_archive_page');
$is_casestudies_page    = is_post_type_archive('casestudies') || is_tax('casestudies_cat') || ( $archive_page_id && is_page( $archive_page_id ) );
$is_listing_context     = $is_casestudies_page || ( $archive_page_id && is_admin() && (int) get_the_ID() === $archive_page_id );

?>

<section class="cbo-casestudies cbo-overflow-container <?php echo !$is_listing_context ? 'casestudies--relationship' : ''; ?>">
    <div class="casestudies-inner cbo-container">

        <?php
            if ($is_casestudies_page) :
                $cs_archive_id = (int) get_option('cbo_casestudies_archive_page');
                get_part('filters/template', [
                    'taxonomy'   => 'casestudies_cat',
                    'post_type'  => 'casestudies',
                    'base_url'   => $cs_archive_id ? get_permalink($cs_archive_id) : home_url('/nos-etudes-de-cas'),
                    'aria_label' => pll__('Filtrer les études de cas par catégorie'),
                    'singular'   => pll__('%d étude de cas'),
                    'plural'     => pll__('%d études de cas'),
                ]);
            endif;
        ?>

        <?php if ($title || $uptitle || $chapo) : ?>
            <div class="casestudies-head">
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
                    <div class="casestudies-title cbo-title-2 slide-up">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>

                 <?php if ($chapo): ?>
                    <div class="casestudies-chapo slide-up">
                        <?php echo wp_kses_post($chapo); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="casestudies-list">
            <?php
                if ($last) {
                    if ($is_casestudies_page) {
                        if (have_posts()) :
                            while (have_posts()) : the_post();
                            get_part('casestudy/template');
                            endwhile;
                        else:
                            echo '<p class="casestudies-empty">' . pll__('Aucune étude de cas trouvée.') . '</p>';
                        endif;
                    } else {
                        $args = [
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'post_type'      => 'casestudies',
                            'no_found_rows'  => true,
                        ];
                        if ( ! empty( $type ) ) {
                            $args['tax_query'] = [
                                [
                                    'taxonomy' => 'casestudies_cat',
                                    'field'    => 'term_id',
                                   'terms' => is_object($type) ? (int) $type->term_id : (int) $type,
                                ],
                            ];
                        }
                        $posts_query = new WP_Query($args);
                        if ($posts_query->have_posts()) :
                            while ($posts_query->have_posts()) : $posts_query->the_post();
                            get_part('casestudy/template');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                } else {
                    $acf_posts = get_field('casestudies_articleslist');
                    if (!$is_casestudies_page && !empty($acf_posts)):
                        global $post;
                        foreach ($acf_posts as $post):
                            setup_postdata($post);
                            get_part('casestudy/template');
                        endforeach;
                        wp_reset_postdata();
                    endif;
                }
            ?>
        </div>

        <?php if ( $is_casestudies_page && $last ) : ?>
            <?php get_part('pagination/template'); ?>
        <?php endif; ?>

        <?php if ($button): ?>
            <div class="casestudies-button">
                <a
                    class="cbo-button"
                    href="<?php echo esc_url($button['url']); ?>"
                    target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                    <?php if (($button['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
                >
                    <?php echo esc_html($button['title']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($textslide): ?>
        <div class="casestudies-textslide">
            <div class="textslide-track" aria-hidden="true">
                <span class="textslide-item"><?php echo esc_html($textslide); ?></span>
                <span class="textslide-item"><?php echo esc_html($textslide); ?></span>
                <span class="textslide-item"><?php echo esc_html($textslide); ?></span>
            </div>
        </div>
    <?php endif; ?>

</section>