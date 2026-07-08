<?php

$url    = $args['url']    ?? '';
$label  = $args['label']  ?? '';
$target = $args['target'] ?? '_self';
$class  = $args['class']  ?? 'cbo-button';

if ( ! $url || ! $label ) return;

$is_blank = $target === '_blank';

?>
<a
	class="<?php echo esc_attr( $class ); ?>"
	href="<?php echo esc_url( $url ); ?>"
	target="<?php echo esc_attr( $target ); ?>"
	<?php if ( $is_blank ) : ?>
		rel="noopener noreferrer"
		aria-label="<?php echo esc_attr( $label . ' ' . pll__('(nouvelle fenêtre)') ); ?>"
	<?php endif; ?>
>
	<?php echo esc_html( $label ); ?>
</a>