<?php

$categories = get_the_category();
$categories_list = '';
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	foreach ( $categories as $category ) {
		$categories_list .= '<span class="cbo-tag" itemprop="articleSection">' . esc_html( $category->name ) . '</span>';
	}
}

?>

<article <?php post_class('cbo-article'); ?> itemscope itemtype="https://schema.org/BlogPosting">
	<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date('c') ); ?>">
	<meta itemprop="description" content="<?php echo esc_attr( get_the_excerpt() ); ?>">

	<a class="el-inner slide-up" href="<?php the_permalink(); ?>" itemprop="url" aria-label="<?php pll_e('Lire l\'article') ?> : <?php echo esc_attr( get_the_title() ); ?>">
		<div class="inner-content">
			<?php if ( has_post_thumbnail() ) { ?>
				<div class="content-picture cbo-picture-cover" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php 
						the_post_thumbnail('small', [
							'sizes'   => '(max-width:320px) 145px, (max-width:425px) 220px, 500px',
							'itemprop' => 'url',
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
						itemprop="url"
						loading="lazy"
						decoding="async"
						width="150"
						height="150"
					>
				</div>
			<?php } ?>

			<div class="content-text">
				<div class="content-top">
					<time class="content-date cbo-tag slide-up" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date('c') ); ?>">
						<?php echo esc_html( get_the_date('j F Y') ); ?>
					</time>

					<div class="content-category slide-up">
						<?php echo $categories_list; ?>
					</div>
				</div>
				
				<h3 class="content-title cbo-title-4 slide-up" itemprop="headline">
					<?php echo esc_html( get_the_title() ); ?>
				</h3>
			</div>
		</div>

		<div class="inner-link cbo-link slide-up">
			<span class="link-txt" aria-hidden="true">
				<?php pll_e('Lire l\'article') ?>
			</span>
			<span class="link-button">
				<i class="icon icon--arrow-next" aria-hidden="true"></i>
			</span>
		</div>
	</a>
</article>