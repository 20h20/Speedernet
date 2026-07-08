<?php

$title  = get_field('cta_title');
$button = get_field('cta_button');
$icon   = get_field('cta_icon');

?>

<section class="cbo-cta">
	<div class="cta-inner cbo-container">

		<div class="cta-content">
			<div class="content-text">
				<?php if ( $title ) : ?>
					<h2 class="cta-title cbo-title-3">
						<?php echo wp_kses_post( preg_replace('/<\/?p[^>]*>/', '', $title) ); ?>
					</h2>
				<?php endif; ?>

				<?php if ( $button ) : ?>
					<?php get_part('button/template', [
						'url'    => $button['url'],
						'label'  => $button['title'],
						'target' => $button['target'] ?: '_self',
						'class'  => 'cbo-button button--blue',
					]); ?>
				<?php endif; ?>
			</div>

			<?php if ( $icon ) : ?>
				<div class="cta-icon cbo-picture-contain" aria-hidden="true">
					<img
						src="<?php echo esc_url( $icon['sizes']['medium'] ?? $icon['url'] ); ?>"
						alt=""
						loading="lazy"
						decoding="async"
						width="<?php echo esc_attr( $icon['sizes']['medium-width']  ?? $icon['width'] ); ?>"
						height="<?php echo esc_attr( $icon['sizes']['medium-height'] ?? $icon['height'] ); ?>"
					>
				</div>
			<?php endif; ?>

			<div class="cta-visual cbo-picture-contain" aria-hidden="true">
				<img
					src="<?php echo esc_url( get_template_directory_uri() . '/library/images/crown.svg' ); ?>"
					alt=""
					loading="lazy"
					decoding="async"
				>
			</div>
		</div>
	</div>
</section>
