<?php

$title  = get_field('heropicture_title');
$chapo  = get_field('heropicture_chapo');

?>

<section class="cbo-heropicture">
    <div class="heropicture-inner cbo-container">

        <?php if ($title): ?>
            <h1 class="heropicture-title cbo-title-1" data-word-anim>
                <?php echo wp_kses_post( preg_replace('/<\/?p[^>]*>/', '', $title) ); ?>
            </h1>
        <?php endif; ?>

        <?php if ($chapo): ?>
            <div class="heropicture-chapo cbo-chapo slide-up">
                <?php echo wp_kses_post($chapo); ?>
            </div>
        <?php endif; ?>

    </div>

    <?php if( have_rows('heropicture_list') ): ?>
        <ul class="heropicture-list cbo-container" role="list">
            <?php
            $index = 0;
            while ( have_rows('heropicture_list') ) : the_row();
                $picture = get_sub_field('picture');
                $index++;
            ?>
                <li class="list-el list-el--<?php echo $index; ?> herorich-animate" role="listitem">
                    <span class="el-inner cbo-picture-cover">
                        <img
                            src="<?php echo esc_url($picture['sizes']['medium']); ?>"
                            srcset="
                                <?php echo esc_url($picture['sizes']['small']); ?> 320w,
                                <?php echo esc_url($picture['sizes']['medium']); ?> 768w,
                                <?php echo esc_url($picture['sizes']['large']); ?> 1024w"
                            sizes="(min-width: 1024px) 30vw, 90vw"
                            alt="<?php echo esc_attr($picture['alt']); ?>"
                            width="<?php echo esc_attr($picture['sizes']['medium-width']); ?>"
                            height="<?php echo esc_attr($picture['sizes']['medium-height']); ?>"
                            decoding="async"
                            loading="eager"
                            fetchpriority="high"
                        >
                    </span>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>

</section>
