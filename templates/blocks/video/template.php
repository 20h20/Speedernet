<?php

$title      = $args['title']      ?? get_field('video_title');
$youtube_id = $args['youtube_id'] ?? get_field('video_youtube_id');
$cover      = $args['cover']      ?? get_field('video_cover');
$format     = $args['format']     ?? (get_field('video_format') ?: 'horizontal');
$section_id = $args['id']         ?? '';

if (!$youtube_id && !is_admin()) return;

?>

<section
	class="cbo-video cbo-video--<?php echo esc_attr($format); ?>"
	<?php if ($section_id) : ?>id="<?php echo esc_attr($section_id); ?>"<?php endif; ?>
	<?php if (!empty($args['aria_label'])) : ?>aria-label="<?php echo esc_attr($args['aria_label']); ?>"<?php endif; ?>
>
	<div class="video-inner cbo-container">

		<?php if ($title) : ?>
			<div class="video-title cbo-title-2 slide-up">
				<?php echo wp_kses_post($title); ?>
			</div>
		<?php endif; ?>

		<div
			class="video-player slide-up"
			data-youtube-id="<?php echo esc_attr($youtube_id); ?>"
			itemscope
			itemtype="https://schema.org/VideoObject"
		>
			<meta itemprop="name" content="<?php echo esc_attr($title ?: 'Vidéo'); ?>">
			<meta itemprop="embedUrl" content="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>">
			<?php if ($cover) : ?>
				<meta itemprop="thumbnailUrl" content="<?php echo esc_url($cover['url']); ?>">
			<?php endif; ?>

			<?php if ($cover) : ?>
				<div class="player-cover cbo-picture-cover">
					<img
						src="<?php echo esc_url($cover['sizes']['large'] ?? $cover['url']); ?>"
						alt="<?php echo esc_attr($cover['alt'] ?: $title); ?>"
						width="<?php echo esc_attr($cover['sizes']['large-width'] ?? $cover['width']); ?>"
						height="<?php echo esc_attr($cover['sizes']['large-height'] ?? $cover['height']); ?>"
						loading="lazy"
						decoding="async"
					>
				</div>
			<?php endif; ?>

			<button
				class="player-button"
				type="button"
				aria-label="<?php echo esc_attr(pll__('Lire la vidéo')); ?>"
			>
				<i class="icon icon--player" aria-hidden="true"></i>
			</button>

			<div class="player-embed"></div>
		</div>

	</div>
</section>
