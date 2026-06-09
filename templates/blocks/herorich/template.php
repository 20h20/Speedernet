<?php

$title  = get_field('herorich_title');
$chapo  = get_field('herorich_chapo');
$button  = get_field('herorich_button');
$button2 = get_field('herorich_button2');

?>

<section class="cbo-herorich">
    <div class="herorich-inner cbo-container">

        <?php if ($title): ?>
            <h1 class="herorich-title cbo-title-1" data-word-anim>
                <?php echo wp_kses_post( preg_replace('/<\/?p[^>]*>/', '', $title) ); ?>
            </h1>
        <?php endif; ?>

        <?php if ($chapo): ?>
            <div class="herorich-chapo cbo-chapo slide-up">
                <?php echo wp_kses_post($chapo); ?>
            </div>
        <?php endif; ?>

        <?php if ($button || $button2): ?>
            <div class="herorich-buttons slide-up">
                <?php if ($button): ?>
                    <a
                        class="cbo-button"
                        href="<?php echo esc_url($button['url']); ?>"
                        target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                        <?php if (($button['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
                    >
                        <?php echo esc_html($button['title']); ?>
                    </a>
                <?php endif; ?>
                <?php if ($button2): ?>
                    <a
                        class="cbo-button button--white"
                        href="<?php echo esc_url($button2['url']); ?>"
                        target="<?php echo esc_attr($button2['target'] ?: '_self'); ?>"
                        <?php if (($button2['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
                    >
                        <?php echo esc_html($button2['title']); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if( have_rows('herorich_list') ): ?>
        <ul class="herorich-list" role="list" aria-hidden="true">
            <?php while ( have_rows('herorich_list') ) : the_row();
                $picture = get_sub_field('picture');
            ?>
                <li class="list-el herorich-animate" role="listitem">
                    <span class="el-inner cbo-picture-cover" aria-hidden="true">
                        <img
                            src="<?php echo esc_url($picture['sizes']['small']); ?>"
                            srcset="
                            <?php echo esc_url($picture['sizes']['small']); ?> 320w,
                            <?php echo esc_url($picture['sizes']['medium']); ?> 768w,
                            <?php echo esc_url($picture['sizes']['large']); ?> 1024w"
                            sizes="(min-width: 1024px) 25vw, (min-width: 640px) 22vw, 50vw"
                            alt="<?php echo esc_attr($picture['alt']); ?>"
                            width="<?php echo esc_attr($picture['sizes']['small-width']); ?>"
                            height="<?php echo esc_attr($picture['sizes']['small-height']); ?>"
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