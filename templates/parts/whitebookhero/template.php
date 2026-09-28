<?php

$post_id = get_the_ID();
$form_id = (int) get_field('whitebook_form', $post_id);
$cover   = get_field('whitebook_cover', $post_id);

?>

<div class="cbo-page page--single page--single-whitebook">

	<?php get_template_part( 'templates/blocks/herosimple/template', null, [
		'title' => get_the_title(),
	] ); ?>

	<section class="cbo-single-whitebook" itemscope itemtype="https://schema.org/Book">
		<meta itemprop="name" content="<?php echo esc_attr( get_the_title() ); ?>">
		<meta itemprop="url" content="<?php echo esc_url( get_permalink() ); ?>">
		<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" hidden>
			<meta itemprop="name" content="Speedernet">
			<meta itemprop="url" content="<?php echo esc_url( home_url() ); ?>">
		</div>

		<div class="single-inner cbo-container">

			<div class="single-content">
				<?php if ( $cover ) : ?>
					<figure class="content-cover">
						<?php echo wp_get_attachment_image( is_array( $cover ) ? $cover['ID'] : $cover, 'small', false, [ 'itemprop' => 'image' ] ); ?>
					</figure>
				<?php endif; ?>

				<div class="single-resume cbo-cms" itemprop="description">
					<?php the_content(); ?>
				</div>
			</div>

			<?php if ( $form_id && function_exists('gravity_form') ) : ?>
				<aside class="single-form cbo-form" aria-label="<?php echo esc_attr( pll__('Formulaire de téléchargement') ); ?>">
					<?php gravity_form( $form_id, false, false, false, null, true ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</section>

</div>