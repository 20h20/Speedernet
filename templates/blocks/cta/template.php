<?php

$title  = get_field('cta_title');
$button = get_field('cta_button');
$icon  = get_field('cta_icon');

?>

<section class="cbo-cta">
    <div class="cta-inner cbo-container">

        <div class="cta-content">
			<div class="content-text">
				<?php if ($title): ?>
					<h2 class="cta-title cbo-title-3">
						<?php echo wp_kses_post(preg_replace('/<\/?p[^>]*>/', '', $title)); ?>
					</h2>
				<?php endif; ?>

				<?php if ($button): ?>
					<a
						class="cbo-button button--blue"
						href="<?php echo esc_url($button['url']); ?>"
						target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
						<?php if (($button['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
					>
						<?php echo esc_html($button['title']); ?>
					</a>
				<?php endif; ?>
        	</div>

			<?php if ($icon): ?>
				<div class="cta-icon cbo-picture-contain">
					<img
						src="<?php echo esc_url($icon['sizes']['medium']); ?>"
						alt=""
						loading="lazy"
						width="<?php echo esc_attr($icon['sizes']['medium-width']); ?>"
						height="<?php echo esc_attr($icon['sizes']['medium-height']); ?>"
					>
				</div>
			<?php endif; ?>


			  <div class="cta-visual cbo-picture-contain" aria-hidden="true">
            <img
                src="<?php echo esc_url(get_template_directory_uri() . '/library/images/crown.svg'); ?>"
                alt=""
                loading="lazy"
            >
            
        </div>
		</div>

      

    </div>
</section>
