<?php
	get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cbo-page page--single'); ?>>
	<div class="single-content">
		<?php
			if(have_posts()):
				the_post();
				get_part('articlehero/template');
				the_content();
			endif;
		?>
	</div>

	<?php
		get_part('newsletter/template');

		get_block('articles', [
			'related_to' => get_the_ID(),
			'title'      => pll__('Articles similaires'),
		]);
	?>
</article>

<?php
	get_footer();
?>