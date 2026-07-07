<?php
	get_header();
?>

<div class="cbo-page page--archive">

	<section class="cbo-herosimple">
		<div class="herosimple-inner cbo-container">

			<h1 class="herosimple-title cbo-title-1" data-word-anim>
				<?php single_term_title(); ?>
				<?php if (is_paged()): ?>
					<span class="title-page slide-up">Page numéro <?php echo max(1, get_query_var('paged')); ?></span>
				<?php endif; ?>
			</h1>

			<?php if (!is_paged()) : ?>
				<div class="herosimple-chapo cbo-chapo slide-up">
					<?php echo term_description(); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="cbo-testimonials">
		<div class="testimonials-inner cbo-container">

			<?php
				$testimonials_page_id = (int) get_option('cbo_testimonials_archive_page');
				get_part('filters/template', [
					'taxonomy'   => 'testimonials_cat',
					'post_type'  => 'testimonial',
					'base_url'   => $testimonials_page_id ? get_permalink($testimonials_page_id) : home_url('/'),
					'aria_label' => pll__('Filtrer les témoignages par catégorie'),
					'singular'   => pll__('%d témoignage'),
					'plural'     => pll__('%d témoignages'),
					'flat'       => true,
				]);
			?>

			<div class="testimonials-list">
				<?php
					if (have_posts()) :
						while (have_posts()) : the_post();
							get_part('testimonial/template');
						endwhile;

						if (function_exists('page_navi')) {
							page_navi();
						} else {
							the_posts_pagination();
						}
					else :
						echo '<p>' . esc_html__('Aucun témoignage trouvé.', 'textdomain') . '</p>';
					endif;
				?>
			</div>
		</div>
	</section>
</div>

<?php
	get_footer();
?>