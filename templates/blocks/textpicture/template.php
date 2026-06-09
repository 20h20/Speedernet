<?php
	$content	= get_field('textpicture_content');
	$picture	= get_field('textpicture_picture');
	$picturepos	= get_field('textpicture_picturepos');
	$color	= get_field('textpicture_color');
?>

<section class="cbo-textpicture textpicture--<?php echo $color; ?> textpicture--<?php echo $picturepos; ?>">
	<div class="textpicture-inner cbo-container container--small">
		<div class="textpicture-wrap">
			<div class="textpicture-picture cbo-picture-cover">
				<img 
					src="<?php echo esc_url($picture['sizes']['medium']); ?>"
					srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w, 
						<?php echo esc_url($picture['sizes']['medium']); ?> 768w, 
						<?php echo esc_url($picture['sizes']['large']); ?> 1024w"
					alt="<?php echo esc_attr($picture['alt']); ?>"
					sizes="(min-width: 1024px) 50vw, (min-width: 768px) 60vw, 100vw"
					loading="lazy"
					decoding="async"
					width="1000" 
					height="1000"
				>
			</div>

			<div class="textpicture-content">
				<?php if($content): ?>
					<div class="content-text cbo-cms">
						<?php echo wp_kses_post($content); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>