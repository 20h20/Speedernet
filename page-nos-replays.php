<?php
	get_header();
	while ( have_posts() ) : the_post();
?>

<div class="cbo-page page--archive page--replays">

	<?php the_content(); ?>

	<section class="cbo-webinaires cbo-webinaires--past">
		<div class="webinaires-inner cbo-container">
			<div class="webinaires-list">
				<?php
					$query = new WP_Query([
						'post_type'      => 'webinaires',
						'posts_per_page' => -1,
						'post_status'    => 'publish',
						'no_found_rows'  => true,
						'meta_query'     => [[
							'key'     => 'webinair_date',
							'value'   => date('Y-m-d H:i:s'),
							'compare' => '<',
							'type'    => 'DATETIME',
						]],
						'orderby'        => 'meta_value',
						'meta_key'       => 'webinair_date',
						'order'          => 'DESC',
					]);

					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) : $query->the_post();
							get_part('webinaire/template');
						endwhile;
						wp_reset_postdata();
					else :
						echo '<p class="webinaires-empty">' . pll__('Aucun replay disponible pour le moment.') . '</p>';
					endif;
				?>
			</div>
		</div>
	</section>

</div>

<?php
	endwhile;
	get_footer();
?>
