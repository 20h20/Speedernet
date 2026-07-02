<?php

$post_count = is_tax('casestudies_cat') ? get_queried_object()->count : wp_count_posts('casestudies')->publish;

?>

<nav class="cbo-filterscasestudies slide-up" aria-label="<?php pll_e('Filtrer les études de cas par catégorie)') ?>">
	<div class="filterscasestudies-inner">
		<div class="inner-filters slide-up">
			<span class="filterscasestudies-label">
				<?php _e('Filtrer par :',); ?>
			</span>

			<ul class="filterscasestudies-list" role="list" aria-labelledby="filterscasestudies-label">
				<?php
					$all_categories_url  = home_url('/nos-etudes-de-cas');
					$current_term        = get_queried_object();
					$current_term_id     = isset($current_term->term_id) ? $current_term->term_id : 0;
					$current_term_parent = isset($current_term->parent) ? $current_term->parent : 0;

					$parent_terms = get_terms([
						'taxonomy'   => 'casestudies_cat',
						'parent'     => 0,
						'orderby'    => 'name',
						'order'      => 'ASC',
						'hide_empty' => false,
					]);

					foreach ($parent_terms as $parent) :
						$children = get_terms([
							'taxonomy'   => 'casestudies_cat',
							'parent'     => $parent->term_id,
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => true,
						]);

						if (empty($children)) continue;

						$is_selected = is_tax('casestudies_cat') && $current_term_parent === $parent->term_id;
				?>
					<li class="list-el">
						<select
							name="<?php echo esc_attr($parent->slug); ?>"
							class="el-inner"
							aria-label="<?php echo esc_attr(sprintf(__('Filtrer par %s', 'cbo'), strtolower($parent->name))); ?>"
							onchange="window.location.href=this.value"
						>
							<option value="<?php echo esc_url($all_categories_url); ?>" <?php if (!$is_selected) echo 'selected'; ?>>
								<?php echo esc_html($parent->name); ?>
							</option>
							<?php foreach ($children as $child) : ?>
								<option
									value="<?php echo esc_url(get_term_link($child)); ?>"
									<?php if ($current_term_id === $child->term_id) echo 'selected'; ?>
								>
									<?php echo esc_html($child->name); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<span class="filterscasestudies-count">
			<?php echo esc_html(sprintf(_n('%d étude de cas', '%d études de cas', $post_count, 'cbo'), $post_count)); ?>
		</span>
	</div>
</nav>
