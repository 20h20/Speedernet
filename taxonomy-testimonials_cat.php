<?php
	get_header();
?>

<div class="cbo-page page--archive">

	<?php
		$hero_title = single_term_title('', false);
		if (is_paged()) {
			$hero_title .= ' <span class="title-page slide-up">Page numéro ' . max(1, get_query_var('paged')) . '</span>';
		}
		get_block('herosimple', [
			'title' => $hero_title,
			'chapo' => !is_paged() ? term_description() : '',
		]);
	?>

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