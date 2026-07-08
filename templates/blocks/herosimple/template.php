<?php

$picture = $args['picture'] ?? get_field('herosimple_picture');
$title   = $args['title']   ?? get_field('herosimple_title');
$chapo   = $args['chapo']   ?? get_field('herosimple_chapo');
$button  = $args['button']  ?? get_field('herosimple_button');
$button2 = $args['button2'] ?? get_field('herosimple_button2');

?>

<section class="cbo-herosimple" itemscope itemtype="https://schema.org/WPHeader">
    <div class="herosimple-inner cbo-container">

        <?php if ($picture): ?>
            <div class="herosimple-picture cbo-picture-contain">
                <img
                    src="<?php echo esc_url($picture['sizes']['large']); ?>"
                    srcset="<?php echo esc_url($picture['sizes']['medium']); ?> 768w,
                    <?php echo esc_url($picture['sizes']['large']); ?> 1024w,
                    <?php echo esc_url($picture['url']); ?> <?php echo esc_attr($picture['width']); ?>w"
                    alt="<?php echo esc_attr($picture['alt']); ?>"
                    sizes="(min-width: 1024px) 50vw, (min-width: 768px) 60vw, 100vw"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                    width="<?php echo esc_attr($picture['width']); ?>"
                    height="<?php echo esc_attr($picture['height']); ?>"
                >
            </div>
        <?php endif; ?>

        <?php if ($title): ?>
            <h1 class="herosimple-title cbo-title-1" data-word-anim itemprop="headline">
                <?php echo wp_kses_post( preg_replace('/<\/?p[^>]*>/', '', $title) ); ?>
            </h1>
        <?php endif; ?>

        <?php if ($chapo): ?>
            <div class="herosimple-chapo cbo-chapo slide-up">
                <?php echo wp_kses_post($chapo); ?>
            </div>
        <?php endif; ?>

        <?php if ( $button || $button2 ) : ?>
            <div class="herosimple-buttons slide-up">
                <?php if ( $button ) : ?>
                    <?php get_part('button/template', [
                        'url'    => $button['url'],
                        'label'  => $button['title'],
                        'target' => $button['target'] ?: '_self',
                    ]); ?>
                <?php endif; ?>
                <?php if ( $button2 ) : ?>
                    <?php get_part('button/template', [
                        'url'    => $button2['url'],
                        'label'  => $button2['title'],
                        'target' => $button2['target'] ?: '_self',
                        'class'  => 'cbo-button button--white',
                    ]); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="cbo-blob blob--blue" aria-hidden="true"></div>
    <div class="cbo-blob blob--yellow blob--left" aria-hidden="true"></div>
</section>