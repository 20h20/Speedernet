<?php
	get_header();
?>

<div class="cbo-page page--archive">

	<?php
		$hero_title = single_term_title('', false);
		if (is_paged()) {
			$hero_title .= ' <span class="title-page slide-up">' . sprintf( pll__('Page numéro %d'), max(1, get_query_var('paged')) ) . '</span>';
		}
		get_block('herosimple', [
			'title' => $hero_title,
			'chapo' => !is_paged() ? term_description() : '',
		]);
	?>

	<section class="cbo-casestudies">
		<div class="casestudies-inner cbo-container">

			<?php
				$cs_archive_id = (int) get_option('cbo_casestudies_archive_page');
				get_part('filters/template', [
					'taxonomy'   => 'casestudies_cat',
					'post_type'  => 'casestudies',
					'base_url'   => $cs_archive_id ? get_permalink($cs_archive_id) : home_url('/nos-etudes-de-cas'),
					'aria_label' => pll__('Filtrer les études de cas par catégorie'),
					'singular'   => pll__('%d étude de cas'),
					'plural'     => pll__('%d études de cas'),
				]);
			?>

			<div class="casestudies-list">
				<?php
					global $post;
					if (have_posts()) :
					while (have_posts()) : the_post();
					get_part('casestudy/template');
					endwhile;
					echo page_navi();
					endif;
				?>
			</div>
		</div>
	</section>
</div>

<?php
	get_footer();
?>