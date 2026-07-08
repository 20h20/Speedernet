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
	$allowed_tag   = [ 'span' => [ 'class' => [], 'itemprop' => [] ] ];
	$schema_type   = $post_type === 'post' ? 'BlogPosting' : 'Article';
?>

<section class="cbo-heroarticle <?php echo esc_attr( $post_type === 'post' ? 'heroarticle--post' : '' ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>" itemscope itemtype="https://schema.org/<?php echo esc_attr( $schema_type ); ?>">
	<?php if ( $post_type !== 'post' ) : ?>
		<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date('c') ); ?>">
	<?php endif; ?>
	<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date('c') ); ?>">
	<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" hidden>
		<meta itemprop="name" content="Speedernet">
	</div>

	<div class="heroarticle-inner cbo-container">
		<div class="heroarticle-content">
			<?php if ( $client ) : ?>
				<span class="content-client cbo-tag slide-up" itemprop="about" itemscope itemtype="https://schema.org/Organization">
					<meta itemprop="name" content="<?php echo esc_attr( $client ); ?>">
					<?php echo esc_html( $client ); ?>
				</span>
			<?php endif; ?>

			<div class="content-category slide-up">
				<?php echo wp_kses( $categories_list, $allowed_tag ); ?>
			</div>

			<div class="content-title cbo-title-2 slide-up">
				<h1 itemprop="headline" data-word-anim>
					<?php echo esc_html( get_the_title() ); ?>
				</h1>
			</div>

			<?php if ( $post_type === 'post' ) :
				$content      = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
				$word_count   = preg_match_all( '/\p{L}+/u', $content );
				$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
			?>
				<div class="content-meta slide-up">
					<time class="meta-date" datetime="<?php echo esc_attr( get_the_date('c') ); ?>" itemprop="datePublished">
						<?php echo esc_html( get_the_date() ); ?>
					</time>
					<span class="meta-reading" aria-label="<?php echo esc_attr( sprintf( pll__('%d min de lecture'), $reading_time ) ); ?>">
						<i class="icon icon--clock" aria-hidden="true"></i> <?php echo esc_html( sprintf( pll__('%d min de lecture'), $reading_time ) ); ?>
					</span>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="content-picture cbo-picture-cover slide-up" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<?php
					the_post_thumbnail('large', [
						'sizes'         => '(max-width:320px) 145px, (max-width:425px) 220px, 500px',
						'itemprop'      => 'contentUrl',
						'loading'       => 'eager',
						'decoding'      => 'async',
						'fetchpriority' => 'high',
					]);
				?>
			</div>
		<?php else : ?>
			<div class="content-picture cbo-picture-cover slide-up picture--none" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
				<img
					src="<?php echo esc_url( get_template_directory_uri() ); ?>/library/images/logo-speedernet-white.svg"
					alt="Speedernet"
					itemprop="contentUrl"
					loading="eager"
					decoding="async"
					width="150"
					height="150"
					fetchpriority="high"
				>
			</div>
		<?php endif; ?>

		<?php if ( has_excerpt() ) : ?>
			<div class="heroarticle-excerpt cbo-cms cbo-chapo slide-up" itemprop="description">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>