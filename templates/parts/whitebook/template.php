<?php

$post_id  = get_the_ID();
$card_id  = 'whitebook-' . $post_id;
$title_id = $card_id . '-title';

$cover    = get_field('whitebook_cover', $post_id);
$resume   = wp_trim_words( wp_strip_all_tags( get_the_content() ), 30 );

?>

<article
	<?php post_class('cbo-whitebook slide-up'); ?>
	id="<?php echo esc_attr($card_id); ?>"
	aria-labelledby="<?php echo esc_attr($title_id); ?>"
	itemscope
	itemtype="https://schema.org/Book"
>
	<meta itemprop="url" content="<?php echo esc_url( get_permalink() ); ?>">

	<?php if ( $cover ) : ?>
		<figure class="whitebook-cover">
			<?php echo wp_get_attachment_image( is_array( $cover ) ? $cover['ID'] : $cover, 'small', false, [ 'itemprop' => 'image' ] ); ?>
		</figure>
	<?php endif; ?>

	<div class="whitebook-content">
		<h2 id="<?php echo esc_attr($title_id); ?>" class="content-title cbo-title-4" itemprop="name">
			<?php echo esc_html( get_the_title() ); ?>
		</h2>

		<?php if ( $resume ) : ?>
			<p class="content-resume" itemprop="description"><?php echo esc_html( $resume ); ?></p>
		<?php endif; ?>

		<a
			class="content-cta cbo-button button--yellow"
			href="<?php echo esc_url( get_permalink() ); ?>"
			aria-label="<?php echo esc_attr( sprintf( pll__('Télécharger le livre blanc : %s'), get_the_title() ) ); ?>"
		>
			<?php pll_e('Télécharger'); ?> <i class="icon icon--arrow-next" aria-hidden="true"></i>
		</a>
	</div>

</article>