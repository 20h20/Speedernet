<?php

$uptitle	= get_field('text_uptitle');
$content	= get_field('text_content');

?>

<section class="cbo-text">
	<div class="text-inner cbo-container container--small">
		<?php if($uptitle): ?>
			<span class="cbo-tag tag--blue text-uptitle slide-up">
				<?php echo esc_html($uptitle); ?>
			</span>
		<?php endif; ?>

		<div class="text-content cbo-cms">
			<?php echo wp_kses_post($content); ?>
		</div>
	</div>
</section>