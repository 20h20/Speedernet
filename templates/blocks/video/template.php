<?php

$video		= get_field('video_file');

?>

<div class="cbo-video">
	<section class="video-inner">
		<?php if($video): ?>
			<div class="video-file" itemscope itemtype="https://schema.org/VideoObject">
				<meta itemprop="name" content="<?php echo esc_attr($video['title']); ?>">
				<meta itemprop="description" content="<?php echo esc_attr($video['description']); ?>">
				<meta itemprop="uploadDate" content="<?php echo date('Y-m-d', strtotime($video['date'])); ?>">
				<meta itemprop="publisher" content="Speedernet">
				<i class="icon icon--player"></i>
				<video class="cbo-video-element" autoplay muted loop playsinline>
					<source type="video/mp4" src="<?php echo esc_url($video['url']); ?>">
				</video>
			</div>
		<?php endif; ?>
		<p class="video-label" aria-hidden="true">
			<?php echo esc_html(pll__('Notre showreel')); ?>
		</p>
	</section>
</div>