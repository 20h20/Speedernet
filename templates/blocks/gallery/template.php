<?php

$title  = get_field('gallery_title');

?>

<section class="cbo-gallery cbo-overflow-container" itemscope itemtype="https://schema.org/ImageGallery">
	<div class="gallery-inner cbo-container">

		<?php if ($title): ?>
            <div class="gallery-title cbo-title-2 slide-up">
                <?php echo wp_kses_post($title); ?>
            </div>
        <?php endif; ?>

		<div class="gallery-list slide-up">
			<?php
				if( have_rows('gallery_list') ):
				while( have_rows('gallery_list') ): the_row();
				$picture = get_sub_field('picture');
			?>
				<div class="list-el" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<div class="el-inner"
						data-full="<?php echo esc_url( $picture['url'] ); ?>"
						data-alt="<?php echo esc_attr( $picture['alt'] ?? '' ); ?>"
						role="button"
						tabindex="0"
						aria-label="<?php echo esc_attr( ! empty( $picture['title'] ) ? $picture['title'] : ( $picture['alt'] ?? '' ) ); ?>"
					>
						<div class="inner-picture cbo-picture-cover">
							<img
								src="<?php echo esc_url($picture['sizes']['large']); ?>"
								srcset="<?php echo esc_url($picture['sizes']['medium']); ?> 320w,
									<?php echo esc_url($picture['sizes']['medium']); ?> 768w,
									<?php echo esc_url($picture['sizes']['large']); ?> 1024w"
								alt="<?php echo esc_attr($picture['alt'] ?? ''); ?>"
								sizes="(min-width: 1024px) 50vw, (min-width: 768px) 60vw, 100vw"
								width="<?php echo (int)$picture['width']; ?>"
								height="<?php echo (int)$picture['height']; ?>"
								loading="lazy"
								decoding="async"
								itemprop="contentUrl"
							>
						</div>
						<div class="inner-zoom" aria-hidden="true"></div>
						<meta itemprop="url" content="<?php echo esc_url($picture['url']); ?>">
						<?php if( !empty($picture['title']) ): ?>
							<p class="el-title" itemprop="name">
								<?php echo esc_html($picture['title']); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			<?php
				endwhile;
				endif;
			?>
		</div>
	</div>
</section>