<section class="cbo-price" aria-label="Tarification">
	<div class="price-inner cbo-container">
		<div class="price-list">
			<?php
				if (have_rows('price_list')):
				while (have_rows('price_list')): the_row();
				$tag     = get_sub_field('tag');
				$content = get_sub_field('content');
				$price   = get_sub_field('price');
			?>
				<div class="list-el" itemscope itemtype="https://schema.org/Offer">
					<div class="el-inner">
						<div class="inner-content">
							<?php if ($tag): ?>
								<span class="inner-label cbo-tag tag--blue" itemprop="name">
									<?php echo esc_html($tag); ?>
								</span>
							<?php endif; ?>

							<?php if ($content): ?>
								<div class="inner-description cbo-cms" itemprop="description">
									<?php echo wp_kses_post($content); ?>
								</div>
							<?php endif; ?>
						</div>

						<?php if ($price): ?>
							<div class="el-price">
								<meta itemprop="priceCurrency" content="EUR">
								<span class="price-amount cbo-title-4" itemprop="price">
									<?php echo wp_kses_post($price); ?>
								</span>
							</div>
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