<?php

$taxonomy   = $args['taxonomy']   ?? 'category';
$post_type  = $args['post_type']  ?? 'post';
$base_url   = $args['base_url']   ?? home_url('/');
$aria_label = $args['aria_label'] ?? pll__('Filtrer par catégorie');
$singular   = $args['singular']   ?? pll__('%d résultat');
$plural     = $args['plural']     ?? pll__('%d résultats');
$flat       = $args['flat']       ?? false;

$is_term_page = is_tax($taxonomy) || ($taxonomy === 'category' && is_category());
$post_count   = $is_term_page
	? (int) get_queried_object()->count
	: (int) wp_count_posts($post_type)->publish;

?>

<nav class="cbo-filters slide-up" aria-label="<?php echo esc_attr($aria_label); ?>">
	<div class="filters-inner">
		<div class="inner-filters slide-up">
			<span class="filters-label">
				<?php pll_e('Filtrer par :'); ?>
			</span>

			<ul class="filters-list" role="list">
				<?php
					$current_term    = get_queried_object();
					$current_term_id = isset($current_term->term_id) ? $current_term->term_id : 0;

					if ($flat) :
						$all_terms = get_terms([
							'taxonomy'   => $taxonomy,
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => true,
						]);

						if (!empty($all_terms) && !is_wp_error($all_terms)) :
				?>
					<li class="list-el">
						<select
							name="<?php echo esc_attr($taxonomy); ?>"
							class="el-inner"
							aria-label="<?php echo esc_attr($aria_label); ?>"
							onchange="window.location.href=this.value"
						>
							<option value="<?php echo esc_url($base_url); ?>" <?php if (!$is_term_page) echo 'selected'; ?>>
								<?php pll_e('Toutes les catégories'); ?>
							</option>
							<?php foreach ($all_terms as $term) : ?>
								<option
									value="<?php echo esc_url(get_term_link($term)); ?>"
									<?php if ($current_term_id === $term->term_id) echo 'selected'; ?>
								>
									<?php echo esc_html($term->name); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</li>
				<?php
						endif;
					else :
						$current_term_parent = isset($current_term->parent) ? $current_term->parent : 0;

						$parent_terms = get_terms([
							'taxonomy'   => $taxonomy,
							'parent'     => 0,
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => false,
						]);

						foreach ($parent_terms as $parent) :
							$children = get_terms([
								'taxonomy'   => $taxonomy,
								'parent'     => $parent->term_id,
								'orderby'    => 'name',
								'order'      => 'ASC',
								'hide_empty' => true,
							]);

							if (empty($children)) continue;

							$is_selected = $is_term_page && $current_term_parent === $parent->term_id;
				?>
					<li class="list-el">
						<select
							name="<?php echo esc_attr($parent->slug); ?>"
							class="el-inner"
							aria-label="<?php echo esc_attr(sprintf(pll__('Filtrer par %s'), strtolower($parent->name))); ?>"
							onchange="window.location.href=this.value"
						>
							<option value="<?php echo esc_url($base_url); ?>" <?php if (!$is_selected) echo 'selected'; ?>>
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
				<?php
						endforeach;
					endif;
				?>
			</ul>
		</div>

		<span class="filters-count">
			<?php
				$label = $post_count === 1 ? $singular : $plural;
				echo esc_html(sprintf($label, $post_count));
			?>
		</span>
	</div>
</nav>