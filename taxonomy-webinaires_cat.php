<?php
	get_header();
?>

<div class="cbo-page page--archive">

	<section class="cbo-herosimple">
		<div class="herosimple-inner cbo-container">

			<h1 class="herosimple-title cbo-title-1" data-word-anim>
				<?php single_term_title(); ?>
				<?php if ( is_paged() ) : ?>
					<span class="title-page slide-up">Page numéro <?php echo max( 1, get_query_var('paged') ); ?></span>
				<?php endif; ?>
			</h1>

			<?php if ( ! is_paged() ) : ?>
				<div class="herosimple-chapo cbo-chapo slide-up">
					<?php echo term_description(); ?>
				</div>
			<?php endif; ?>

		</div>
	</section>

	<section class="cbo-webinaires">
		<div class="webinaires-inner cbo-container">
			<div class="webinaires-list">
				<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_part('webinaire/template');
						endwhile;
						echo page_navi();
					else :
						echo '<p class="webinaires-empty">' . esc_html__('Aucun webinaire disponible.', 'bonestheme') . '</p>';
					endif;
				?>
			</div>
		</div>
	</section>

</div>

<?php
	get_footer();
?>
