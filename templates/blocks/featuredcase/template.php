<?php

$uptitle = get_field('featuredcase_uptitle');
$title   = get_field('featuredcase_title');
$chapo   = get_field('featuredcase_chapo');
$case    = get_field('featuredcase_case');

if ( ! $case ) return;

?>

<section class="cbo-featuredcase cbo-overflow-container">
	<div class="featuredcase-inner cbo-container container--small">

		<?php if ($uptitle): ?>
			<span class="cbo-tag tag--blue featuredcase-uptitle slide-up">
				<?php echo esc_html($uptitle); ?>
			</span>
		<?php endif; ?>

		<?php if ($title): ?>
			<div class="featuredcase-title cbo-title-2 slide-up">
				<?php echo wp_kses_post($title); ?>
			</div>
		<?php endif; ?>

		<?php if ($chapo): ?>
			<div class="featuredcase-chapo cbo-chapo slide-up">
				<?php echo wp_kses_post($chapo); ?>
			</div>
		<?php endif; ?>

		<div class="featuredcase-card slide-up">
			<?php
				global $post;
				$post = $case;
				setup_postdata( $post );
				get_part('casestudy/template');
				wp_reset_postdata();
			?>
		</div>
	</div>
</section>
