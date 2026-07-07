<?php
	get_header();
?>

<div class="cbo-page page--archive">

	<section class="cbo-herosimple">
		<div class="herosimple-inner cbo-container">

			<h1 class="herosimple-title cbo-title-1" data-word-anim>
				<?php single_cat_title(); ?>
				<?php if (is_paged()): ?>
					<span class="title-page slide-up">Page numéro <?php echo max(1, get_query_var('paged')); ?></span>
				<?php endif; ?>
			</h1>


			<?php if ( ! is_paged() ) : ?>
				<div class="herosimple-chapo cbo-chapo slide-up">
					<?php echo category_description(); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

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