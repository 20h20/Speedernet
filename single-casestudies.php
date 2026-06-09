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

	<section class="cbo-casestudies">
		<div class="casestudies-inner cbo-container">

			<div class="casestudies-head">
                <span class="cbo-tag tag--blue content-uptitle">
                    <?php pll_e('Études de cas similaires') ?>
                </span>

                <div class="casestudies-title cbo-title-2">
                    <?php pll_e('Les réussites de nos clients') ?>
                </div>
            </div>

			<div class="casestudies-list">
				<?php
					$post_id = get_the_ID();
					if ( $post_id ) {
						$terms = wp_get_post_terms($post_id, 'casestudies_cat');
						if ( ! empty($terms) && ! is_wp_error($terms) ) {
							$current_term_slug = $terms[0]->slug;
							$args = array(
								'post_type'      => 'casestudies',
								'posts_per_page' => 3,
								'post__not_in'   => array($post_id),
								'tax_query'      => array(
									array(
										'taxonomy' => 'casestudies_cat',
										'field'    => 'slug',
										'terms'    => $current_term_slug,
									),
								),
							);

							$query = new WP_Query($args);

							if ($query->have_posts()) :
								while ($query->have_posts()) : $query->the_post();
									get_part('casestudy/template');
								endwhile;
								wp_reset_postdata();
							else :
								echo '<strong style="text-align:center;width:100%">' . __('Aucune étude de cas', 'cbo') . '</strong>';
							endif;
						} else {
							echo '<strong style="text-align:center;width:100%">' . __('Aucune catégorie associée à cette étude de cas', 'cbo') . '</strong>';
						}
					}
				?>
			</div>
		</div>

		<div class="casestudies-textslide">
            <div class="textslide-track" aria-hidden="true">
                <span class="textslide-item"><?php pll_e('Études de cas') ?></span>
                <span class="textslide-item"><?php pll_e('Études de cas') ?></span>
                <span class="textslide-item"><?php pll_e('Études de cas') ?></span>
            </div>
        </div>
	</section>
</article>

<?php
	get_footer();
?>