<?php

$post_id	= get_the_ID();
$client	= get_field('casestudy_client', $post_id);
$categories	= get_the_terms( $post_id, 'casestudies_cat' );
$categories_list = '';
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	foreach ( $categories as $category ) {
		$categories_list .= '<span class="cbo-tag tag--yellow" itemprop="articleSection">' . esc_html( $category->name ) . '</span>';
	}
}

$allowed_tag = [ 'span' => [ 'class' => [], 'itemprop' => [] ] ];

?>

<article <?php post_class('cbo-casestudy'); ?> itemscope itemtype="https://schema.org/TechArticle">
	<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date('c') ); ?>">
	<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date('c') ); ?>">
	<meta itemprop="description" content="<?php echo esc_attr( get_the_excerpt() ); ?>">
	<meta itemprop="name" content="<?php echo esc_attr( get_the_title() ); ?>">

	<a
		class="el-inner slide-up"
		href="<?php the_permalink(); ?>"
		itemprop="url"
		aria-label="<?php echo esc_attr( sprintf( pll__('Lire le cas : %s'), get_the_title() ) ); ?>"
	>
		<div class="inner-content">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="content-picture cbo-picture-cover" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php
					the_post_thumbnail( 'small', [
						'sizes'    => '(max-width:320px) 145px, (max-width:425px) 220px, 500px',
						'itemprop' => 'contentUrl',
						'loading'  => 'lazy',
						'decoding' => 'async',
					] );
					?>
				</div>
			<?php else : ?>
				<div class="content-picture picture--none cbo-picture-cover" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<img
						src="<?php echo esc_url( get_template_directory_uri() ); ?>/library/images/logo-speedernet-white.svg"
						alt="Speedernet"
						itemprop="contentUrl"
						loading="lazy"
						decoding="async"
						width="150"
						height="150"
					>
				</div>
			<?php endif; ?>

			<div class="content-text">
				<div class="content-top">
					<?php if ( $client ) : ?>
						<span class="content-client cbo-tag slide-up" itemprop="about" itemscope itemtype="https://schema.org/Organization">
							<meta itemprop="name" content="<?php echo esc_attr( $client ); ?>">
							<?php echo esc_html( $client ); ?>
						</span>
					<?php endif; ?>

					<span class="content-category slide-up">
						<?php echo wp_kses( $categories_list, $allowed_tag ); ?>
					</span>
				</div>

				<h3 class="content-title cbo-title-4 slide-up" itemprop="headline">
					<?php echo esc_html( get_the_title() ); ?>
				</h3>
			</div>
		</div>

		<div class="inner-link cbo-link slide-up">
			<span class="link-txt" aria-hidden="true">
				<?php pll_e('Lire le cas') ?>
			</span>
			<span class="link-button">
				<i class="icon icon--arrow-next" aria-hidden="true"></i>
			</span>
		</div>
	</a>
</article>