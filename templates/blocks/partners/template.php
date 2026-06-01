<?php

$uptitle	= get_field('partners_uptitle');
$uptitlepic  = get_field('partners_uptitlepicture');
$title	= get_field('partners_title');
	
?>
<section class="cbo-partners cbo-overflow-container">
	<div class="partners-inner cbo-container">

		<?php if($uptitle): ?>
			<div class="cbo-tag partners-uptitle slide-up">
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
			</div>
		<?php endif; ?>

		<?php if($title): ?>
			<div class="partners-title cbo-title-2 slide-up">
				<?php echo wp_kses_post($title); ?>
			</div>
		<?php endif; ?>
	
		<ul class="partners-list" role="list">
			<?php
				if( have_rows('partners_list') ):
				while( have_rows('partners_list') ): the_row();
				$logo = get_sub_field('logo');
				$name = get_sub_field('partner_name');
				if( $logo ):
			?>
				<li class="list-el" itemscope itemtype="https://schema.org/Organization">
					<div class="el-inner cbo-picture-contain slide-up" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<img
							itemprop="url"
							src="<?php echo esc_url($logo['sizes']['small']); ?>"
							srcset="<?php echo esc_url($logo['sizes']['small']); ?> 320w, 
									<?php echo esc_url($logo['sizes']['medium']); ?> 768w"
							alt="<?php echo esc_attr( $logo['alt'] ?: $name ?: '' ); ?>"
							sizes="(min-width: 1024px) 15vw, (min-width: 640px) 25vw, 50vw"
							width="<?php echo esc_attr($logo['sizes']['small-width']); ?>"
							height="<?php echo esc_attr($logo['sizes']['small-height']); ?>"
							loading="lazy"
							decoding="async"
						>
						<?php if($name): ?>
							<meta itemprop="name" content="<?php echo esc_attr($name); ?>">
						<?php endif; ?>
					</div>
				</li>
			<?php
				endif;
				endwhile;
				endif;
			?>
		</ul>
	</div>
</section>