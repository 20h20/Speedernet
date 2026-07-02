<?php

$title   = get_field('webinaires_title');

?>

<section class="cbo-webinaires">
    <div class="webinaires-inner cbo-container">

        <?php if ( $title ) : ?>
            <div class="webinaires-title cbo-title-2">
                <?php echo wp_kses_post($title); ?>
            </div>
        <?php endif; ?>

        <div class="webinaires-list">
            <?php
                $query = new WP_Query([
                    'post_type'      => 'webinaires',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'no_found_rows'  => true,
                    'meta_query'     => [
                        'relation' => 'OR',
                        'date_future' => [
                            'key'     => 'webinair_date',
                            'value'   => date('Y-m-d H:i:s'),
                            'compare' => '>=',
                            'type'    => 'DATETIME',
                        ],
                        'date_not_set' => [
                            'key'     => 'webinair_date',
                            'compare' => 'NOT EXISTS',
                        ],
                    ],
                    'orderby'        => [
                        'date_future' => 'ASC',
                        'date'        => 'DESC',
                    ],
                ]);

                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                        get_part('webinaire/template');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="webinaires-empty">' . pll__('Aucun webinaire disponible pour le moment.') . '</p>';
                endif;
            ?>
        </div>

    </div>
</section>