<?php if ( get_the_posts_pagination() ) : ?>
	<nav class="cbo-pagination" aria-label="<?php pll_e('Pagination'); ?>">
		<?php the_posts_pagination( [
			'prev_text' => '<i class="icon icon--arrow-prev" aria-hidden="true"></i>' . pll__('Précédent'),
			'next_text' => pll__('Suivant') . '<i class="icon icon--arrow-next" aria-hidden="true"></i>',
			'screen_reader_text' => ' ',
		] ); ?>
	</nav>
<?php endif; ?>
