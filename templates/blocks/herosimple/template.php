<?php

$picture     = $args['picture'] ?? get_field('herosimple_picture');
$title       = $args['title']   ?? get_field('herosimple_title');
$chapo       = $args['chapo']   ?? get_field('herosimple_chapo');
$button       = $args['button']  ?? get_field('herosimple_button');
$buttoncolor  = get_field('herosimple_buttoncolor');
$button2      = $args['button2'] ?? get_field('herosimple_button2');
$button2color = get_field('herosimple_button2color');
$type        = get_field('herosimple_type');
$mainpicture = get_field('herosimple_mainpicture');

$is_bg_picture = ($type === 'heropicture' && $mainpicture);

?>

<section class="cbo-herosimple<?php echo $is_bg_picture ? ' herosimple--bg-picture' : ''; ?>" itemscope itemtype="https://schema.org/WPHeader">

    <?php if ($is_bg_picture): ?>
        <div class="herosimple-bg cbo-picture-cover" aria-hidden="true">
            <img
                src="<?php echo esc_url($mainpicture['sizes']['large'] ?? $mainpicture['url']); ?>"
                srcset="<?php echo esc_url($mainpicture['sizes']['medium'] ?? $mainpicture['url']); ?> 768w,
                    <?php echo esc_url($mainpicture['sizes']['large']  ?? $mainpicture['url']); ?> 1024w,
                    <?php echo esc_url($mainpicture['url']); ?> <?php echo esc_attr($mainpicture['width']); ?>w"
                alt=""
                sizes="100vw"
                loading="eager"
                fetchpriority="high"
                decoding="async"
                width="<?php echo esc_attr($mainpicture['width']); ?>"
                height="<?php echo esc_attr($mainpicture['height']); ?>"
            >
        </div>
    <?php endif; ?>

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
                        'class'  => 'cbo-button' . ( $buttoncolor ? ' button--' . esc_attr( $buttoncolor ) : '' ),
                    ]); ?>
                <?php endif; ?>
                <?php if ( $button2 ) : ?>
                    <?php get_part('button/template', [
                        'url'    => $button2['url'],
                        'label'  => $button2['title'],
                        'target' => $button2['target'] ?: '_self',
                        'class'  => 'cbo-button' . ( $button2color ? ' button--' . esc_attr( $button2color ) : '' ),
                    ]); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!$is_bg_picture): ?>
        <div class="cbo-blob blob--blue" aria-hidden="true"></div>
        <div class="cbo-blob blob--yellow blob--left" aria-hidden="true"></div>
    <?php endif; ?>

</section>
