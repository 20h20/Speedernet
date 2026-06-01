<?php

$uptitle       = get_field('cardslider_uptitle');
$section_title = get_field('cardslider_title');
$items         = get_field('cardslider_list');

?>

<section class="cbo-cardslider cbo-overflow-container<?php echo is_admin() ? ' is-admin' : ''; ?>">
	<div class="cardslider-inner cbo-container">

	 	<?php if($uptitle): ?>
			<span class="cbo-tag tag--blue cardslider-uptitle slide-up">
				<?php echo esc_html($uptitle); ?>
			</span>
		<?php endif; ?>

		<?php if($section_title): ?>
			<div class="cardslider-title cbo-title-2 slide-up">
				<?php echo wp_kses_post($section_title); ?>
			</div>
		<?php endif; ?>

		<?php if($items): ?>
			<nav class="cardslider-tabs" role="tablist" aria-label="<?php pll_e('Navigation par onglets') ?>">
				<?php foreach($items as $index => $item): ?>
					<button
						class="cbo-tag slide-up tag--grey tab-el<?php echo $index === 0 ? ' active' : ''; ?>"
						type="button"
						role="tab"
						aria-label="<?php echo esc_attr(wp_strip_all_tags($item['title'])); ?>"
						aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
						aria-controls="card-panel-<?php echo $index; ?>"
					>
						<i class="icon icon--arrow-next" aria-hidden="true"></i>
						<?php echo wp_kses_post($item['title']); ?>
					</button>
				<?php endforeach; ?>
			</nav>

			<div class="list-container">
				<ul class="cardslider-list" role="list" itemscope itemtype="https://schema.org/ItemList">
					<?php foreach($items as $index => $item):
						$title   = $item['title'];
						$content = $item['content'];
						$picture = $item['picture'];
					?>
						<li
							class="list-el"
							role="tabpanel"
							id="card-panel-<?php echo $index; ?>"
							itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
							<?php echo $index !== 0 ? 'aria-hidden="true"' : ''; ?>
						>
							<div class="el-inner">
								<div class="inner-content cbo-cms slide-up">
									<?php echo wp_kses_post($content); ?>
								</div>

								<?php if($picture): ?>
									<div class="inner-picture cbo-picture-cover slide-up">
										<img
											src="<?php echo esc_url($picture['sizes']['small']); ?>"
											srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w,
											<?php echo esc_url($picture['sizes']['large']); ?> 768w"
											sizes="(min-width: 1024px) 50vw, 100vw"
											alt="<?php echo esc_attr($picture['alt']); ?>"
											width="<?php echo esc_attr($picture['sizes']['small-width']); ?>"
											height="<?php echo esc_attr($picture['sizes']['small-height']); ?>"
											decoding="async"
											loading="lazy"
										>
									</div>
								<?php endif; ?>

								<span class="inner-title slide-up">
									<?php echo wp_kses_post($title); ?>
								</span>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="cardslider-nav">
					<button class="nav-btn nav-btn--prev" type="button" aria-label="<?php pll_e('Précédent') ?>"></button>
					<button class="nav-btn nav-btn--next" type="button" aria-label="<?php pll_e('Suivant') ?>"></button>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<div class="cardslider-bigtxt slide-up" aria-hidden="true">
		xp
	</div>
</section>