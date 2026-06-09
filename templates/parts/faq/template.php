<?php

$index = (int) get_query_var('faq_index', 0);
$section_id     = isset($section_id) ? $section_id : 'faq';
$item_id	= $section_id . '-item-' . $index;
$is_first	= ($index === 0);
 
?>

<div class="list-el slide-up <?php echo $is_first ? 'el--open' : ''; ?>" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
	<h3 class="el-wrapper slide-up" itemprop="name">
		<button
			type="button"
			class="el-title cbo-title-4"
			aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
			aria-controls="<?php echo esc_attr($item_id); ?>"
			id="<?php echo esc_attr($item_id); ?>-button"
		>
			<?php the_title(); ?>
			<i class="icon icon--cross"></i>
		</button>
	</h3>

	<div
		id="<?php echo esc_attr($item_id); ?>"
		class="el-content cbo-cms slide-up"
		role="region"
		aria-labelledby="<?php echo esc_attr($item_id); ?>-button"
		itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"
		<?php echo $is_first ? '' : 'hidden'; ?>
	>
		<div itemprop="text">
			<?php the_content(); ?>
		</div>
	</div>
</div>