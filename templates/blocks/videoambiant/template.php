<?php

$video     = get_field('videoambiant_file');
$video_url = $video ? esc_url($video['url']) : '';

?>

<div class="cbo-video">
	<section class="video-inner">
		<?php if ($video): ?>
			<div class="video-file" itemscope itemtype="https://schema.org/VideoObject">
				<meta itemprop="name"        content="<?php echo esc_attr($video['title']); ?>">
				<meta itemprop="description" content="<?php echo esc_attr($video['description']); ?>">
				<meta itemprop="uploadDate"  content="<?php echo date('Y-m-d', strtotime($video['date'])); ?>">
				<meta itemprop="publisher"   content="Speedernet">

				<video class="cbo-video-element" autoplay muted loop playsinline>
					<source type="video/mp4" src="<?php echo $video_url; ?>">
				</video>

				<button class="video-play" aria-label="<?php esc_attr_e('Voir le showreel', 'bonestheme'); ?>">
					<span class="play-icon" aria-hidden="true">
						<i class="icon icon--player"></i>
					</span>
				</button>
			</div>
		<?php endif; ?>

	</section>

	<?php if ($video): ?>
		<div class="video-modal" role="dialog" aria-modal="true" aria-label="Showreel" hidden>
			<div class="modal-backdrop"></div>
			<div class="modal-inner">
				<button class="modal-close" aria-label="Fermer">&times;</button>
				<video class="modal-video" controls playsinline preload="none">
					<source type="video/mp4" src="<?php echo $video_url; ?>">
				</video>
			</div>
		</div>
	<?php endif; ?>
</div>
