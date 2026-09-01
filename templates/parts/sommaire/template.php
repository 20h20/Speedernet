<?php

$post_id = get_the_ID();
$items   = get_field('casestudy_summary', $post_id);

if (!$items) return;

?>

<nav class="cbo-summary" aria-label="<?php echo esc_attr(pll__('Sommaire')); ?>">
	<button type="button" class="summary-toggle" aria-expanded="false" aria-controls="summary-list">
		<span class="summary-label cbo-title-4">
			<?php pll_e('Sommaire'); ?>
		</span>
		<i class="icon icon--chevron" aria-hidden="true"></i>
	</button>

	<ul class="summary-list" id="summary-list">
		<?php foreach ($items as $item):
			$label  = $item['label']  ?? '';
			$anchor = $item['anchor'] ?? '';
			if (!$label || !$anchor) continue;
		?>
			<li class="list-el">
				<a href="#<?php echo esc_attr($anchor); ?>" class="el-link" data-anchor="<?php echo esc_attr($anchor); ?>">
					<?php echo esc_html($label); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
