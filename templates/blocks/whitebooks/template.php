<?php

$title   = get_field('whitebooks_title');

?>

<section class="cbo-whitebooks">
    <div class="whitebooks-inner cbo-container">

        <?php if ( $title ) : ?>
            <div class="whitebooks-title cbo-title-2 slide-up">
                <?php echo wp_kses_post($title); ?>
            </div>
        <?php endif; ?>

        <div class="whitebooks-list">
            <?php
                $query = new WP_Query([
                    'post_type'      => 'whitebook',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'no_found_rows'  => true,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);

                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                        get_part('whitebook/template');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="whitebooks-empty">' . pll__('Aucun livre blanc disponible pour le moment.') . '</p>';
                endif;
            ?>
        </div>

    </div>
</section>
