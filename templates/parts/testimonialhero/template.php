<?php

$name     = get_field('testimonial_name');
$function = get_field('testimonial_function');
$logo     = get_field('testimonial_logo');
$cats     = get_the_terms(get_the_ID(), 'testimonials_cat');

?>

<section class="cbo-testimonialhero" itemscope itemtype="https://schema.org/Review">
	<meta itemprop="reviewBody" content="<?php echo esc_attr(wp_strip_all_tags(get_the_excerpt())); ?>">
	<div itemprop="itemReviewed" itemscope itemtype="https://schema.org/Organization" hidden>
		<meta itemprop="name" content="Speedernet">
	</div>

	<div class="testimonialhero-inner cbo-container">

		<?php if ($cats && !is_wp_error($cats)) : ?>
			<div class="hero-categories slide-up">
				<?php foreach ($cats as $cat) : ?>
					<span class="cbo-tag tag--blue">
						<?php echo esc_html($cat->name); ?>
					</span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h1 class="hero-title cbo-title-1" data-word-anim itemprop="name">
			<?php the_title(); ?>
		</h1>

		<div class="testimonialhero-author slide-up">
			<?php if (has_post_thumbnail()) : ?>
				<div class="author-picture cbo-picture-cover slide-up" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
					<?php the_post_thumbnail('medium', [
						'itemprop' => 'contentUrl',
						'loading'  => 'eager',
						'decoding' => 'async',
					]); ?>
				</div>
			<?php endif; ?>

			<div class="author-info slide-up" itemprop="author" itemscope itemtype="https://schema.org/Person">
				<?php if ($name) : ?>
					<p class="author-name cbo-title-4" slide-up itemprop="name">
						<?php echo esc_html($name); ?>
					</p>
				<?php endif; ?>
				<?php if ($function) : ?>
					<p class="author-function cbo-tag tag--yellow slide-up" itemprop="jobTitle">
						<?php echo esc_html($function); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>