<?php

$items = get_field('textpictureslide_list');

?>

<section class="cbo-textpictureslide" style="--slide-count: <?php echo count($items) ?: 1; ?>">
	<div class="textpictureslide-inner cbo-container">

		<div class="textpictureslide-images" aria-hidden="true">
			<div class="images-list">
				<?php
					if($items): foreach($items as $index => $item):
					$picture       = $item['picture'];
					$illustration  = $item['illustration'] ?? null;
				?>
					<div class="image-el<?php echo $index === 0 ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>">
						<?php if($picture): ?>
							<div class="el-picture cbo-picture-cover">
								<img decoding="async"
									src="<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?>"
									srcset="<?php echo esc_url( $picture['sizes']['small']  ?? $picture['url'] ); ?> 320w,
										<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?> 768w,
										<?php echo esc_url( $picture['sizes']['large']  ?? $picture['url'] ); ?> 1024w"
									alt=""
									sizes="45vw"
									width="<?php echo esc_attr( $picture['width'] ); ?>"
									height="<?php echo esc_attr( $picture['height'] ); ?>"
									<?php echo $index === 0 ? 'loading="eager"' : 'loading="lazy"'; ?>
								>
							</div>
						<?php endif; ?>
						<?php if($illustration): ?>
							<div class="el-illustration" aria-hidden="true">
								<img src="<?php echo esc_url($illustration['url']); ?>" alt="" loading="lazy" decoding="async">
							</div>
						<?php endif; ?>
					</div>
				<?php
					endforeach;
					endif;
				?>
			</div>
		</div>

		<div class="textpictureslide-list">
			<?php
				if($items): foreach($items as $index => $item):
				$picture      = $item['picture'];
				$illustration = $item['illustration'] ?? null;
				$content      = $item['content'];
			?>
				<div class="list-el" data-index="<?php echo esc_attr( $index ); ?>">
					<?php if($picture): ?>
						<div class="el-picture-wrap">
							<div class="el-picture cbo-picture-cover">
								<img decoding="async"
									src="<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?>"
									srcset="<?php echo esc_url( $picture['sizes']['small']  ?? $picture['url'] ); ?> 320w,
										<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?> 768w"
									alt="<?php echo esc_attr( $picture['alt'] ); ?>"
									sizes="100vw"
									width="<?php echo esc_attr( $picture['width'] ); ?>"
									height="<?php echo esc_attr( $picture['height'] ); ?>"
									loading="lazy"
								>
							</div>
							<?php if($illustration): ?>
								<div class="el-illustration slide-up" aria-hidden="true">
									<img src="<?php echo esc_url($illustration['url']); ?>" alt="" loading="lazy" decoding="async">
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if($content): ?>
						<div class="el-content cbo-cms">
							<?php echo wp_kses_post($content); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php
				endforeach;
				endif;
			?>
		</div>
	</div>

	<div class="cbo-blob textpictureslide-blob" aria-hidden="true"></div>

</section>