<?php
	get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cbo-page page--single'); ?>>
	<div class="single-content">
		<?php
			if(have_posts()):
				the_post();
				get_part('webinairehero/template');
			endif;
		?>
	</div>
</article>

<?php
	get_footer();
?>