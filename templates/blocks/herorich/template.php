<?php

$title   = get_field('herorich_title');
$chapo   = get_field('herorich_chapo');
$button  = get_field('herorich_button');
$button2 = get_field('herorich_button2');

?>

<section class="cbo-herorich" >
	<div class="herorich-inner cbo-container">

		<?php if ( $title ) : ?>
			<h1 class="herorich-title cbo-title-1" data-word-anim>
				<?php echo wp_kses_post( preg_replace('/<\/?p[^>]*>/', '', $title) ); ?>
			</h1>
		<?php endif; ?>

		<?php if ( $chapo ) : ?>
			<div class="herorich-chapo cbo-chapo slide-up">
				<?php echo wp_kses_post( $chapo ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $button || $button2 ) : ?>
			<div class="herorich-buttons slide-up">
				<?php if ( $button ) :
					$btn_blank = ( $button['target'] ?? '' ) === '_blank';
				?>
					<a
						class="cbo-button"
						href="<?php echo esc_url( $button['url'] ); ?>"
						target="<?php echo esc_attr( $button['target'] ?: '_self' ); ?>"
						<?php if ( $btn_blank ) : ?>
							rel="noopener noreferrer"
							aria-label="<?php echo esc_attr( $button['title'] . ' ' . pll__('(nouvelle fenêtre)') ); ?>"
						<?php endif; ?>
					>
						<?php echo esc_html( $button['title'] ?: $button['url'] ); ?>
					</a>
				<?php endif; ?>

				<?php if ( $button2 ) :
					$btn2_blank = ( $button2['target'] ?? '' ) === '_blank';
				?>
					<a
						class="cbo-button button--white"
						href="<?php echo esc_url( $button2['url'] ); ?>"
						target="<?php echo esc_attr( $button2['target'] ?: '_self' ); ?>"
						<?php if ( $btn2_blank ) : ?>
							rel="noopener noreferrer"
							aria-label="<?php echo esc_attr( $button2['title'] . ' ' . pll__('(nouvelle fenêtre)') ); ?>"
						<?php endif; ?>
					>
						<?php echo esc_html( $button2['title'] ?: $button2['url'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( have_rows('herorich_list') ) : ?>
		<ul class="herorich-list" role="list" aria-hidden="true">
			<?php
			$i = 0;
			while ( have_rows('herorich_list') ) : the_row();
				$picture  = get_sub_field('picture');
				$is_first = $i === 0;
				$i++;
			?>
				<li class="list-el herorich-animate">
					<span class="el-inner cbo-picture-cover">
						<img
							src="<?php echo esc_url( $picture['sizes']['small'] ?? $picture['url'] ); ?>"
							srcset="
								<?php echo esc_url( $picture['sizes']['small']  ?? $picture['url'] ); ?> 320w,
								<?php echo esc_url( $picture['sizes']['medium'] ?? $picture['url'] ); ?> 768w,
								<?php echo esc_url( $picture['sizes']['large']  ?? $picture['url'] ); ?> 1024w"
							sizes="(min-width: 1024px) 25vw, (min-width: 640px) 22vw, 50vw"
							alt="<?php echo esc_attr( $picture['alt'] ); ?>"
							width="<?php echo esc_attr( $picture['sizes']['small-width']  ?? $picture['width'] ); ?>"
							height="<?php echo esc_attr( $picture['sizes']['small-height'] ?? $picture['height'] ); ?>"
							decoding="async"
							loading="eager"
							<?php if ( $is_first ) : ?>fetchpriority="high"<?php endif; ?>
						>
					</span>
				</li>
			<?php endwhile; ?>
		</ul>
	<?php endif; ?>
</section>