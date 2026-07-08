<?php

get_header();

?>

<section class="cbo-herosimple" itemscope itemtype="https://schema.org/WPHeader">
    <div class="herosimple-inner cbo-container">
        <h1 class="herosimple-title cbo-title-1" data-word-anim itemprop="headline">
			<?php pll_e('Résultats pour'); ?> : <?php echo esc_html(get_search_query(false)); ?>
        </h1>
    </div>

    <div class="cbo-blob blob--blue" aria-hidden="true"></div>
    <div class="cbo-blob blob--yellow blob--left" aria-hidden="true"></div>
</section>

<section class="cbo-searchresults" aria-label="<?php pll_e('Résultats de recherche'); ?>">
	<div class="searchresults-inner cbo-container">

		<?php if (have_posts()) : ?>

			<p class="searchresults-count cbo-label slide-up">
				<?php printf(
					esc_html( $wp_query->found_posts <= 1 ? pll__('%d résultat') : pll__('%d résultats') ),
					$wp_query->found_posts
				); ?>
			</p>

			<div class="searchresults-list">
				<?php while (have_posts()) : the_post(); ?>
					<?php get_part('article/template'); ?>
				<?php endwhile; ?>
			</div>

			<?php get_part('pagination/template'); ?>

		<?php else : ?>

			<div class="searchresults-empty">
				<p>
					<?php printf(
						esc_html(pll__('Aucun résultat pour « %s ». Essayez avec d\'autres mots-clés.')),
						esc_html(get_search_query(false))
					); ?>
				</p>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php

get_footer();

?>
