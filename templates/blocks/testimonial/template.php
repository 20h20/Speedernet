<?php

$picture  = get_field('testimonial_picture');
$name     = get_field('testimonial_name');
$function = get_field('testimonial_function');
$content  = get_field('testimonial_content');

?>

<section class="cbo-testimonial" aria-label="Témoignage" itemscope itemtype="https://schema.org/Quotation">
    <div class="testimonial-inner cbo-container container--small container--nomargin container--padding">

        <div class="testimonial-infos" itemprop="spokenByCharacter" itemscope itemtype="https://schema.org/Person">
            <?php if ($picture): ?>
                <div class="infos-picture slide-up">
                    <div class="picture-inner cbo-picture-cover">
                        <img
                            src="<?php echo esc_url($picture['sizes']['xsmall']); ?>"
                            srcset="<?php echo esc_url($picture['sizes']['xsmall']); ?> <?php echo esc_attr($picture['sizes']['xsmall-width']); ?>w"
                            sizes="(min-width: 1024px) 180px, 54px"
                            alt=""
                            width="<?php echo esc_attr($picture['sizes']['xsmall-width']); ?>"
                            height="<?php echo esc_attr($picture['sizes']['xsmall-height']); ?>"
                            decoding="async"
                            loading="lazy"
                            itemprop="image"
                        >
                    </div>
                </div>
            <?php endif; ?>

            <div class="infos-content">
                <?php if ($name): ?>
                    <div class="content-name slide-up" itemprop="name">
                        <?php echo wp_kses_post($name); ?>
                    </div>
                <?php endif; ?>

                <?php if ($function): ?>
                    <div class="content-function slide-up" itemprop="jobTitle">
                        <?php echo wp_kses_post($function); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="testimonial-content slide-up">
            <i class="icon icon--top-quote" aria-hidden="true"></i>
            <blockquote class="content-testimonial cbo-title-3" itemprop="text">
                <?php echo wp_kses_post($content); ?>
            </blockquote>
            <i class="icon icon--bottom-quote" aria-hidden="true"></i>
        </div>

    </div>
</section>
