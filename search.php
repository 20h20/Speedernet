<?php
	get_header();

	cbo_enqueue_block_assets( 'acf/block-herosimple' );
?>

<section class="cbo-herosimple">
	<div class="herosimple-inner cbo-container container--nomargin container--padding">
			<?php get_template_part('templates/parts/breadcrumb/template'); ?>

			<div class="herosimple-title cbo-title-1 slide-up" itemprop="headline">
				<h1>
					<?php pl_e('search-title'); ?><em><?php printf( __( '%s'), get_search_query() ); ?></em>
				</h1>
			</div>
		</div>
	</section>

	<section class="cbo-searchresults">
		<div class="searchresults-inner cbo-container">
			<div class="searchresults-count cbo-label slide-up">
				<?php printf( _n( '%d résultat', '%d résultats', $wp_query->found_posts, 'merveillespacifique' ), $wp_query->found_posts ); ?>
			</div>

			<?php if ( have_posts() ) : ?>
				<div class="searchresults-list">
					<?php while ( have_posts() ) : the_post(); ?>
						<div class="list-el">
							<?php if ( get_post_type() === 'product' ) : ?>
								<?php wc_get_template_part( 'content', 'product' ); ?>
							<?php else : ?>
								<?php get_template_part( 'templates/parts/article/template' ); ?>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php cbo_template_part('pagination'); ?>
			<?php else : ?>
				<div class="searchresults-empty">
					<p><?php pl_e('search-no-results'); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php
	get_footer();
?>