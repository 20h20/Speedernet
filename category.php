<?php
	get_header();
?>

<div class="cbo-page page--archive">

	<?php
		$hero_title = single_cat_title('', false);
		if (is_paged()) {
			$hero_title .= ' <span class="title-page slide-up">' . sprintf( pll__('Page numéro %d'), max(1, get_query_var('paged')) ) . '</span>';
		}
		get_block('herosimple', [
			'title' => $hero_title,
			'chapo' => !is_paged() ? category_description() : '',
		]);
	?>

	<?php
		// Balisage "cbo-articles" repris à la main (comme casestudies_cat pour "cbo-casestudies"),
		// donc son CSS (chargé normalement via get_block('articles', ...)) doit être enqueue à part.
		$articles_css_file = get_stylesheet_directory() . '/library/css/blocks/articles.min.css';
		if (file_exists($articles_css_file)) {
			wp_enqueue_style(
				'block-articles',
				get_stylesheet_directory_uri() . '/library/css/blocks/articles.min.css',
				array(),
				filemtime($articles_css_file)
			);
		}
	?>

	<section class="cbo-articles">
		<div class="articles-inner cbo-container">

			<?php
				$blog_page_id = (int) get_option('page_for_posts');
				get_part('filters/template', [
					'taxonomy'   => 'category',
					'post_type'  => 'post',
					'base_url'   => $blog_page_id ? get_permalink($blog_page_id) : home_url('/'),
					'aria_label' => pll__('Filtrer les articles par catégorie'),
					'singular'   => pll__('%d article'),
					'plural'     => pll__('%d articles'),
					'flat'       => true,
				]);
			?>

			<div class="articles-list">
				<?php
					if (have_posts()) :
						while (have_posts()) : the_post();
							get_part('article/template');
						endwhile;
						get_part('pagination/template');
					else :
						echo '<strong style="text-align:center;width:100%">' . esc_html__('Aucun article trouvé.', 'cbo') . '</strong>';
					endif;
				?>
			</div>
		</div>
	</section>
</div>

<?php
	get_footer();
?>
