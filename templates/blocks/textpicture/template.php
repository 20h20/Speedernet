<?php
	$uptitle	= get_field('textpicture_uptitle');	
	$content	= get_field('textpicture_content');
	$picture	= get_field('textpicture_picture');
	$picturepos	= get_field('textpicture_picturepos');
	$color	= get_field('textpicture_color');
	$cover	= get_field('textpicture_cover');
?>

<section class="cbo-textpicture textpicture--<?php echo esc_attr( $color ); ?> textpicture--<?php echo esc_attr( $picturepos ); ?>">
	<div class="textpicture-inner cbo-container container--small">
		<div class="textpicture-wrap">
			<div class="textpicture-picture <?php echo $cover ? 'cbo-picture-cover' : 'cbo-picture-contain'; ?>">
				<img
					src="<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?>"
					srcset="<?php echo esc_url( $picture['sizes']['small']  ?? $picture['url'] ); ?> 320w,
						<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?> 768w,
						<?php echo esc_url( $picture['sizes']['large']  ?? $picture['url'] ); ?> 1024w"
					alt="<?php echo esc_attr( $picture['alt'] ); ?>"
					sizes="(min-width: 1024px) 50vw, (min-width: 768px) 60vw, 100vw"
					loading="lazy"
					decoding="async"
					width="<?php echo esc_attr( $picture['width'] ); ?>"
					height="<?php echo esc_attr( $picture['height'] ); ?>"
				>
				<?php if( !empty($picture['title']) ): ?>
							<p class="el-title" itemprop="name">
								<?php echo esc_html($picture['title']); ?>
							</p>
						<?php endif; ?>
			</div>

			<div class="textpicture-content">
				<?php if ( $uptitle ) : ?>
					<span class="cbo-tag tag--blue content-uptitle slide-up">
						<?php echo esc_html( $uptitle ); ?>
					</span>
				<?php endif; ?>

				<?php if($content): ?>
					<div class="content-text cbo-cms">
						<?php echo wp_kses_post($content); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>