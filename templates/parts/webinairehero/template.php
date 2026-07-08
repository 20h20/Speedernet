<?php

$post_id        = get_the_ID();
$date_raw       = get_field('webinair_date', $post_id, false);
$duree          = get_field('webinair_duration', $post_id);
$speakers       = get_field('webinair_speakers', $post_id);
$form_shortcode = get_field('webinair_form', $post_id);
$video_id       = get_field('webinair_video', $post_id);
$video_cover    = get_field('webinair_videocover', $post_id);

$date_formatted  = '';
$heure_formatted = '';
$datetime_iso    = '';
$is_past         = false;

if ( $date_raw ) {
	$timestamp = strtotime( $date_raw );
	if ( $timestamp ) {
		$date_formatted  = ucfirst( date_i18n( 'l d F', $timestamp ) );
		$heure_formatted = date_i18n( 'H\hi', $timestamp );
		$datetime_iso    = date( 'c', $timestamp );
		$is_past         = $timestamp < time();
	}
}

$section_id = 'webinaire-' . $post_id;

?>

<div class="cbo-page page--single page--single-webinaire">

	<?php get_template_part( 'templates/blocks/herosimple/template', null, [
		'title' => get_the_title(),
	] ); ?>

	<section
		class="cbo-single-webinaire"
		aria-labelledby="<?php echo esc_attr( $section_id . '-title' ); ?>"
		itemscope
		itemtype="https://schema.org/Event"
	>
		<meta itemprop="name" content="<?php echo esc_attr( get_the_title() ); ?>">
		<meta itemprop="url" content="<?php echo esc_url( get_permalink() ); ?>">
		<meta itemprop="eventAttendanceMode" content="https://schema.org/OnlineEventAttendanceMode">
		<meta itemprop="eventStatus" content="https://schema.org/<?php echo $is_past ? 'EventScheduled' : 'EventScheduled'; ?>">
		<div itemprop="organizer" itemscope itemtype="https://schema.org/Organization" hidden>
			<meta itemprop="name" content="Speedernet">
			<meta itemprop="url" content="<?php echo esc_url( home_url() ); ?>">
		</div>
		<div itemprop="location" itemscope itemtype="https://schema.org/VirtualLocation" hidden>
			<meta itemprop="url" content="<?php echo esc_url( get_permalink() ); ?>">
		</div>

		<div class="single-inner cbo-container">

			<div class="single-content">

				<h2 id="<?php echo esc_attr( $section_id . '-title' ); ?>" class="sr-only">
					<?php echo esc_html( get_the_title() ); ?>
				</h2>

				<?php if ( $date_formatted || $duree ) : ?>
					<div class="content-meta">
						<i class="icon icon--datepicker" aria-hidden="true"></i>
						<div class="meta-info cbo-label">
							<?php if ( $date_formatted ) : ?>
								<span class="meta-date">
									<strong><?php pll_e('Date :') ?></strong>
									<?php if ( $datetime_iso ) : ?>
										<time itemprop="startDate" datetime="<?php echo esc_attr( $datetime_iso ); ?>">
											<?php echo esc_html( $date_formatted ); ?><?php echo $heure_formatted ? ' / ' . esc_html( $heure_formatted ) : ''; ?>
										</time>
									<?php else : ?>
										<?php echo esc_html( $date_formatted ); ?>
									<?php endif; ?>
								</span>
							<?php endif; ?>
							<?php if ( $duree ) : ?>
								<span class="meta-duree" itemprop="duration">
									<strong><?php pll_e('Durée :') ?></strong> <?php echo esc_html( $duree ); ?>
								</span>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $video_id ) : ?>
					<a class="content-button cbo-button button--yellow" href="#webinaire-video-<?php echo esc_attr( $post_id ); ?>">
						<?php pll_e('Lire le teaser vidéo'); ?>
					</a>
				<?php endif; ?>

				<div class="single-resume cbo-cms" itemprop="description">
					<?php the_content(); ?>
				</div>

				<?php get_part( 'speakers/template', [ 'speakers' => $speakers, 'show_details' => true ] ); ?>

			</div>

			<?php if ( ! empty( $form_shortcode ) ) : ?>
				<aside class="single-form cbo-form" aria-label="<?php echo esc_attr( pll__('Formulaire d\'inscription') ); ?>">
					<?php foreach ( $form_shortcode as $cf7_post ) : ?>
						<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $cf7_post->ID ) . '" title="' . esc_attr( $cf7_post->post_title ) . '"]' ); ?>
					<?php endforeach; ?>
				</aside>
			<?php endif; ?>

		</div>
	</section>

	<?php if ( $video_id ) : ?>
		<?php get_block( 'video', [
			'youtube_id' => $video_id,
			'cover'      => $video_cover,
			'id'         => 'webinaire-video-' . $post_id,
			'aria_label' => pll__('Teaser vidéo du webinaire'),
		] ); ?>
	<?php endif; ?>

</div>
