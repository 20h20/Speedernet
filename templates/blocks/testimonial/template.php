<?php

$picture  = get_field('testimonial_picture');
$name  = get_field('testimonial_name');
$function  = get_field('testimonial_function');
$content  = get_field('testimonial_content');

?>

<section class="cbo-testimonial">
    <div class="testimonial-inner cbo-container container--small container--nomargin container--padding">
        <div class="testimonial-infos">
            <div class="infos-picture slide-up">
                <div class="picture-inner cbo-picture-cover">
                    <img
                        src="<?php echo esc_url($picture['sizes']['small']); ?>"
                        srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w"
                        sizes="(max-width: 768px) 54px, 54px"
                        alt="<?php echo esc_attr($picture['alt']); ?>"
                        width="<?php echo esc_attr($picture['sizes']['small-width']); ?>"
                        height="<?php echo esc_attr($picture['sizes']['small-height']); ?>"
                        decoding="async"
                        loading="lazy"
                    >
                </div>
            </div>
                
            <div class="infos-content">
                <?php if ($name): ?>
                    <div class="content-name slide-up">
                        <?php echo wp_kses_post($name); ?>
                    </div>
                <?php endif; ?>

                <?php if ($function): ?>
                    <div class="content-function slide-up">
                        <?php echo wp_kses_post($function); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="testimonial-content slide-up">
            <i class="icon icon--top-quote slide-up" aria-hidden="true"></i>
            <?php echo wp_kses_post($content); ?>
            <i class="icon icon--bottom-quote slide-up" aria-hidden="true"></i>
        </div>
    </div>

    <div class="cbo-blob testimonial-blob" aria-hidden="true"></div>
</section>