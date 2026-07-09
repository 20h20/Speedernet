<?php

$color     = $args['color']     ?? get_field('text_color');
$uptitle   = $args['uptitle']   ?? get_field('text_uptitle');
$content   = $args['content']   ?? get_field('text_content');
$container = $args['container'] ?? ($color === 'blue' ? 'cbo-container' : 'cbo-container container--small');

?>

<section class="cbo-text text--<?php echo esc_attr($color); ?>">
	<div class="text-inner <?php echo esc_attr($container); ?>">
		<div class="text-wrap">
			<?php if($uptitle): ?>
				<span class="cbo-tag tag--blue text-uptitle slide-up">
					<?php echo esc_html($uptitle); ?>
				</span>
			<?php endif; ?>

			<div class="text-content cbo-cms">
				<?php echo wp_kses_post($content); ?>
			</div>
		</div>
	</div>
</section>