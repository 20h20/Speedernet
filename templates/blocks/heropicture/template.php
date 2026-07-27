<?php

$title = $args['title'] ?? get_field('heropicture_title');
$chapo = $args['chapo'] ?? get_field('heropicture_chapo');

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

    <?php
    $hp_pictures = [];
    if ( have_rows('heropicture_list') ) {
        while ( have_rows('heropicture_list') ) {
            the_row();
            $p = get_sub_field('picture');
            if ( $p ) $hp_pictures[] = $p;
        }
    }
    $hp_count = count( $hp_pictures );
    ?>

    <?php if ( $hp_count > 0 ): ?>
        <ul class="heropicture-list cbo-container heropicture-list--count-<?php echo $hp_count; ?>" role="list">
            <?php foreach ( $hp_pictures as $index => $picture ): ?>
                <li class="list-el list-el--<?php echo ( $index + 1 ); ?> herorich-animate" role="listitem">
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
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</section>
