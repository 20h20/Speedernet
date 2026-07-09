<?php

$content = get_field('glossaire_content');
$letters = get_terms(array(
	'taxonomy'   => 'glossaire_lettre',
	'hide_empty' => true,
	'orderby'    => 'name',
	'order'      => 'ASC',
));

if (is_wp_error($letters) || empty($letters)) {
	if (isset($block) && is_admin()) {
		echo '<p style="padding:20px;color:#999;">Aucun terme dans le glossaire pour le moment.</p>';
	}
	return;
}

$anchor = isset($block['anchor']) && $block['anchor'] ? ' id="' . esc_attr($block['anchor']) . '"' : '';

?>

<section class="cbo-glossaire">
	<?php echo $anchor; ?>

	<div class="glossaire-inner cbo-container container--small">

		<nav class="glossaire-nav slide-up" aria-label="<?php pll_e('Navigation alphabétique') ?>">
			<?php foreach ($letters as $letter): ?>
				<a
					href="#lettre-<?php echo esc_attr($letter->slug); ?>"
					class="glossaire-button"
					aria-label="Lettre <?php echo esc_attr($letter->name); ?>"
				>
					<?php echo esc_html($letter->name); ?>
				</a>
			<?php endforeach; ?>
		</nav>

		<?php if ($content): ?>
			<div class="glossaire-title slide-up">
				<?php echo wp_kses_post($content); ?>
			</div>
		<?php endif; ?>

		<div class="glossaire-section">
			<?php foreach ($letters as $letter):
				$posts = get_posts(array(
					'post_type'      => 'glossaire',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'orderby'        => 'title',
					'order'          => 'ASC',
					'tax_query'      => array(array(
						'taxonomy' => 'glossaire_lettre',
						'field'    => 'term_id',
						'terms'    => $letter->term_id,
					)),
				));
				if (!$posts) continue;
			?>
				<div class="glossaire-group" id="lettre-<?php echo esc_attr($letter->slug); ?>">
					<div class="group-letter slide-up" aria-hidden="true">
						<?php echo esc_html($letter->name); ?>
					</div>

					<ul class="glossaire-list" role="list">
						<?php foreach ($posts as $term_post):
							$domains = wp_get_post_terms($term_post->ID, 'glossaire_domaine');
							$tag     = (!empty($domains) && !is_wp_error($domains)) ? $domains[0] : null;
						?>
							<li class="glossaire-item slide-up">
								<a href="<?php echo esc_url(get_permalink($term_post)); ?>" class="item-inner">
									<div class="link-header">
										<span class="link-term cbo-label">
											<?php echo esc_html($term_post->post_title); ?>
										</span>

										<?php if ($tag): ?>
											<span class="link-tag cbo-tag tag--blue"><?php echo esc_html($tag->name); ?></span>
										<?php endif; ?>
									</div>
									<span class="link-cta">
										<?php pll_e('Lire la définition') ?>
									</span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>