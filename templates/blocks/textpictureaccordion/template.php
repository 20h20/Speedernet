<?php

$pictures = get_field('textpictureaccordion_pictures');
$items    = get_field('textpictureaccordion_items');
$illustration    = get_field('textpictureaccordion_illustration');

?>

<section class="cbo-textpictureaccordion">
	<div class="textpictureaccordion-inner cbo-container">

		<?php if ($pictures) : ?>
			<div class="textpictureaccordion-pictures">
				<div class="pictures-grid">
					<?php if($illustration): ?>
						<div class="textpictureaccordion-illustration cbo-picture-contain slide-up">
							<img
								src="<?php echo esc_url($illustration['sizes']['small']); ?>"
								srcset="<?php echo esc_url($illustration['sizes']['small']); ?> 320w"
								sizes="(max-width: 768px) 54px, 54px"
								alt=""
								width="<?php echo esc_attr($illustration['sizes']['small-width']); ?>"
								height="<?php echo esc_attr($illustration['sizes']['small-height']); ?>"
								decoding="async"
								loading="lazy"
							>
						</div>
					<?php endif; ?>

					<?php foreach ($pictures as $index => $pic) :
						$picture = $pic['picture'];
						if (!$picture) continue;
					?>
						<div class="picture-el picture-el--<?php echo $index + 1; ?>">
							<div class="el-picture cbo-picture-cover slide-up">
								<img
									src="<?php echo esc_url($picture['sizes']['medium']); ?>"
									srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w,
										<?php echo esc_url($picture['sizes']['medium']); ?> 768w,
										<?php echo esc_url($picture['sizes']['large']); ?> 1024w"
									alt="<?php echo esc_attr($picture['alt']); ?>"
									sizes="(min-width: 1024px) 35vw, 90vw"
									width="<?php echo esc_attr($picture['sizes']['medium-width']); ?>"
									height="<?php echo esc_attr($picture['sizes']['medium-height']); ?>"
									decoding="async"
									<?php echo $index === 0 ? 'loading="eager"' : 'loading="lazy"'; ?>
								>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($items) : ?>
		<div class="textpictureaccordion-accordion">
			<ul class="accordion-list" role="list">
				<?php foreach ($items as $index => $item) :
					$title   = $item['title'];
					$content = $item['content'];
				?>
					<li class="accordion-item">
						<button
							class="item-header slide-up"
							type="button"
							aria-expanded="false"
							aria-controls="accordion-body-<?php echo $index; ?>"
						>
							<span class="header-title cbo-title-4"><?php echo esc_html($title); ?></span>
							<span class="header-icon" aria-hidden="true"></span>
						</button>
						<div
							class="item-body"
							id="accordion-body-<?php echo $index; ?>"
							role="region"
						>
							<div class="body-content cbo-cms">
								<?php echo wp_kses_post($content); ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>

	</div>
</section>
