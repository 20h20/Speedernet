<?php

$bigtxt	= get_field('keynumbers_bigtxt');
$uptitle	= get_field('keynumbers_uptitle');
$uptitlepic  = get_field('keynumbers_uptitlepicture');
$title	= get_field('keynumbers_title');
$outroleft	= get_field('keynumbers_outroleft');
$outroright	= get_field('keynumbers_outroright');

?>

<section class="cbo-keynumbers cbo-overflow-container">
	<div class="keynumbers-inner cbo-container">
	 	<?php if($uptitle): ?>
			<span class="cbo-tag tag--blue keynumbers-uptitle slide-up">
				<?php echo esc_html($uptitle); ?>

				<?php if($uptitlepic): ?>
					<span class="tag-picture cbo-picture-contain">
						<img
							src="<?php echo esc_url($uptitlepic['sizes']['small']); ?>"
							srcset="<?php echo esc_url($uptitlepic['sizes']['small']); ?> 320w"
							sizes="(max-width: 768px) 54px, 54px"
							alt=""
							width="<?php echo esc_attr($uptitlepic['sizes']['small-width']); ?>"
							height="<?php echo esc_attr($uptitlepic['sizes']['small-height']); ?>"
							decoding="async"
							loading="lazy"
						>
					</span>
				<?php endif; ?>
			</span>
		<?php endif; ?>

		<?php if($title): ?>
			<div class="keynumbers-title cbo-title-2 slide-up">
				<?php echo wp_kses_post($title); ?>
			</div>
		<?php endif; ?>

		<ul class="keynumbers-list" role="list">
			<?php
				if( have_rows('keynumbers_list') ):
				while ( have_rows('keynumbers_list') ) : the_row();
				$color	= get_sub_field('color');
				$number	= get_sub_field('number');
				$content	= get_sub_field('content');
			?>
				<li class="list-el" itemscope itemtype="https://schema.org/QuantitativeValue">
					<div class="el-inner inner--<?php echo esc_attr($color); ?> slide-up">
						<?php if($number): ?>
							<div class="content-number slide-up" itemprop="value">
								<?php echo esc_html($number); ?>
							</div>
						<?php endif; ?>

						<?php if($content): ?>
							<div class="content-text cbo-cms slide-up" itemprop="description">
								<?php echo wp_kses_post($content); ?>
							</div>
						<?php endif; ?>
					</div>
				</li>
			<?php
				endwhile;
				endif;
			?>
		</ul>
		
		<?php if ($outroleft || $outroright) : ?>
			<div class="keynumbers-outro">
				<?php if($outroleft): ?>
					<div class="outro-col cbo-cms slide-up">
						<?php echo wp_kses_post($outroleft); ?>
					</div>
				<?php endif; ?>

				<?php if($outroright): ?>
					<div class="outro-col cbo-cms slide-up">
						<?php echo wp_kses_post($outroright); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if($bigtxt): ?>
		<div class="keynumbers-wrapper slide-up">
			<div class="keynumbers-bigtxt" aria-hidden="true">
				<?php echo wp_kses_post($bigtxt); ?>
			</div>
		</div>
	<?php endif; ?>
		
</section>