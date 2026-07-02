<?php

$url    = $args['url']    ?? '';
$label  = $args['label']  ?? '';
$target = $args['target'] ?? '_self';
$class  = $args['class']  ?? 'cbo-button';

if ( ! $url || ! $label ) return;

?>
<a
	class="<?php echo esc_attr($class); ?>"
	href="<?php echo esc_url($url); ?>"
	target="<?php echo esc_attr($target); ?>"
	<?php if ( $target === '_blank' ) : ?>rel="noopener noreferrer"<?php endif; ?>
>
	<?php echo esc_html($label); ?>
</a>
