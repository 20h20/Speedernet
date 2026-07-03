<?php
	$post_id  = get_the_ID();
	$post_type = get_post_type( $post_id );
	$taxonomy  = ($post_type === 'casestudies') ? 'casestudies_cat' : 'category';
	$client    = get_field( 'casestudy_client', $post_id );

	$terms = wp_get_post_terms( $post_id, $taxonomy );
	$categories_list = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$categories_list .= '<span class="cbo-tag tag--yellow" itemprop="articleSection">';
			$categories_list .= esc_html( $term->name );
			$categories_list .= '</span>';
		}
	}
?>

<section class="cbo-heroarticle" aria-label="<?php echo esc_attr( get_the_title() ); ?>" itemscope itemtype="https://schema.org/Article">
	<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date('c') ); ?>">
	<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date('c') ); ?>">

	<div class="heroarticle-inner cbo-container">
		<div class="heroarticle-content">
			<?php if ( $client ) : ?>
				<span class="content-client cbo-tag slide-up" itemprop="about" itemscope itemtype="https://schema.org/Organization">
					<meta itemprop="name" content="<?php echo esc_attr( $client ); ?>">
					<?php echo esc_html( $client ); ?>
				</span>
			<?php endif; ?>

			<div class="content-category slide-up">
				<?php echo $categories_list; ?>
			</div>

			<div class="content-title cbo-title-2 slide-up">
				<h1 itemprop="headline" data-word-anim>
					<?php echo esc_html( get_the_title() ); ?>
				</h1>
			</div>
		</div>

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="content-picture cbo-picture-cover slide-up" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<?php 
					the_post_thumbnail('large', [
						'sizes'   => '(max-width:320px) 145px, (max-width:425px) 220px, 500px',
						'itemprop' => 'url',
						'loading'  => 'eager',
						'decoding' => 'async',
						'fetchpriority' => 'high',
					]);
				?>
			</div>
		<?php } else { ?>
			<div class="content-picture cbo-picture-cover slide-up picture--none" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<img
					src="<?php echo esc_url( get_template_directory_uri() ); ?>/library/images/logo-speedernet-white.svg"
					alt=""
					itemprop="url"
					loading="eager"
					decoding="async"
					width="150"
					height="150"
					fetchpriority="high"
				>
			</div>
		<?php } ?>

		<?php if ( has_excerpt() ) : ?>
			<div class="heroarticle-excerpt cbo-cms cbo-chapo slide-up" itemprop="description">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>