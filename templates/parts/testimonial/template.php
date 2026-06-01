<?php

global $post;
$categories = get_the_terms( get_the_ID(), 'testimonials_cat' );
$name = get_field('testimonial_name', $post->ID);
$function = get_field('testimonial_function', $post->ID);

?>

<article <?php post_class('list-el'); ?> itemscope itemtype="https://schema.org/Review">
	<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date('c') ); ?>">
	<meta itemprop="reviewBody" content="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt() ) ); ?>">
	<div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Organization" hidden>
		<meta itemprop="name" content="Speedernet">
	</div>

	<a class="el-inner slide-up" href="<?php the_permalink(); ?>" itemprop="url" aria-label="<?php echo esc_attr( pll__('Voir l\'interview') . ' : ' . get_the_title() ); ?>">
		<div class="inner-content">
			<?php if ( has_post_thumbnail() ) { ?>
				<div class="content-picture cbo-picture-cover" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php
						the_post_thumbnail('small', [
							'sizes'   => '(max-width:320px) 145px, (max-width:425px) 220px, 500px',
							'itemprop' => 'contentUrl',
							'loading'  => 'lazy',
							'decoding' => 'async',
						]);
					?>
				</div>
			<?php } else { ?>
				<div class="content-picture picture--none cbo-picture-cover" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<img
						src="<?php echo esc_url( get_template_directory_uri() ); ?>/library/images/logo-speedernet-white.svg"
						alt=""
						itemprop="contentUrl"
						loading="lazy"
						decoding="async"
						width="150"
						height="150"
					>
				</div>
			<?php } ?>

			<div class="content-text">
				<div class="content-category cbo-tag slide-up">
					<?php echo $categories && ! is_wp_error( $categories ) ? esc_html( implode( ', ', wp_list_pluck( $categories, 'name' ) ) ) : ''; ?>
				</div>
	
				<h3 class="content-name slide-up" itemprop="author" itemscope itemtype="https://schema.org/Person">
					<span itemprop="name"><?php echo esc_html($name); ?></span>
				</h3>

				<div class="content-function cbo-tag tag--yellow slide-up">
					<?php echo esc_html($function); ?>
				</div>

				<div class="content-title cbo-title-4 slide-up" itemprop="name">
					<?php echo esc_html( get_the_title() ); ?>
				</div>
			</div>
		</div>

		<div class="inner-link cbo-link slide-up">
			<span class="link-txt" aria-hidden="true">
				<?php pll_e('Voir l\'interview') ?>
			</span>
			<span class="link-button button--player">
				<i class="icon icon--player" aria-hidden="true"></i>
			</span>
		</div>
	</a>
</article>