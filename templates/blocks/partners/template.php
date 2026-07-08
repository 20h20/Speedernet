<?php

$uptitle    = get_field('partners_uptitle');
$uptitlepic = get_field('partners_uptitlepicture');
$title      = get_field('partners_title');

$section_label = $title ? wp_strip_all_tags( $title ) : pll__('Nos partenaires');

?>
<section class="cbo-partners cbo-overflow-container" aria-label="<?php echo esc_attr( $section_label ); ?>">
	<div class="partners-inner cbo-container">

		<?php if ( $uptitle ) : ?>
			<div class="cbo-tag partners-uptitle slide-up">
				<?php echo esc_html( $uptitle ); ?>

				<?php if ( $uptitlepic ) : ?>
					<span class="tag-picture cbo-picture-contain">
						<img
							src="<?php echo esc_url( $uptitlepic['sizes']['small'] ?? $uptitlepic['url'] ); ?>"
							alt=""
							width="<?php echo esc_attr( $uptitlepic['sizes']['small-width'] ?? $uptitlepic['width'] ); ?>"
							height="<?php echo esc_attr( $uptitlepic['sizes']['small-height'] ?? $uptitlepic['height'] ); ?>"
							decoding="async"
							loading="lazy"
						>
					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $title ) : ?>
			<div class="partners-title cbo-title-2 slide-up">
				<?php echo wp_kses_post( $title ); ?>
			</div>
		<?php endif; ?>

		<ul class="partners-list" role="list" aria-label="<?php echo esc_attr( pll__('Liste des partenaires') ); ?>">
			<?php
			if ( have_rows('partners_list') ) :
				while ( have_rows('partners_list') ) : the_row();
					$logo = get_sub_field('logo');
					$name = get_sub_field('partner_name');
			?>
				<li class="list-el" itemscope itemtype="https://schema.org/Organization">
					<div class="el-inner cbo-picture-contain slide-up" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
						<img
							itemprop="contentUrl"
							src="<?php echo esc_url( $logo['sizes']['small'] ?? $logo['url'] ); ?>"
							srcset="<?php echo esc_url( $logo['sizes']['small'] ?? $logo['url'] ); ?> 320w,
									<?php echo esc_url( $logo['sizes']['medium'] ?? $logo['url'] ); ?> 768w"
							alt="<?php echo esc_attr( $logo['alt'] ?: $name ?: '' ); ?>"
							sizes="(min-width: 1024px) 15vw, (min-width: 640px) 25vw, 50vw"
							width="<?php echo esc_attr( $logo['sizes']['small-width'] ?? $logo['width'] ); ?>"
							height="<?php echo esc_attr( $logo['sizes']['small-height'] ?? $logo['height'] ); ?>"
							loading="lazy"
							decoding="async"
						>
					</div>
				</li>
			<?php
				endwhile;
				endif;
			?>
		</ul>
	</div>
</section>
