<?php

$items = get_field('textpictureslide_list');

?>

<section class="cbo-textpictureslide">
	<div class="textpictureslide-inner cbo-container container--small">

		<div class="textpictureslide-images">
			<div class="images-list">
				<?php
					if($items): foreach($items as $index => $item):
					$picture       = $item['picture'];
					$illustration  = $item['illustration'] ?? null;
				?>
					<div class="image-el<?php echo $index === 0 ? ' is-active' : ''; ?>" data-index="<?php echo $index; ?>">
						<?php if($picture): ?>
							<div class="el-picture cbo-picture-cover">
								<img decoding="async"
									src="<?php echo esc_url($picture['sizes']['medium']); ?>"
									srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w,
										<?php echo esc_url($picture['sizes']['medium']); ?> 768w,
										<?php echo esc_url($picture['sizes']['large']); ?> 1024w"
									alt="<?php echo esc_attr($picture['alt']); ?>"
									sizes="45vw"
									width="1000" height="1000"
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
				<div class="list-el" data-index="<?php echo $index; ?>">
					<?php if($picture): ?>
						<div class="el-picture-wrap">
							<div class="el-picture cbo-picture-cover">
								<img decoding="async"
									src="<?php echo esc_url($picture['sizes']['medium']); ?>"
									srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w,
										<?php echo esc_url($picture['sizes']['medium']); ?> 768w"
									alt="<?php echo esc_attr($picture['alt']); ?>"
									sizes="100vw"
									width="1000" height="1000"
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