<?php

$post_id   = get_the_ID();
$card_id   = 'webinaire-' . $post_id;
$title_id  = $card_id . '-title';
$toggle_id = $card_id . '-secondary';

$date_raw  = get_field('webinair_date', $post_id, false);
$duree     = get_field('webinair_duration', $post_id);
$link      = get_field('webinair_link', $post_id);
$speakers  = get_field('webinair_speakers', $post_id);
$resume    = get_field('webinair_resume', $post_id);

$date_formatted  = '';
$heure_formatted = '';
$datetime_iso    = '';
$is_past         = false;

if ( $date_raw ) {
	$timestamp = strtotime( $date_raw );
	if ( $timestamp ) {
		$date_formatted  = ucfirst( date_i18n( 'l d F', $timestamp ) );
		$heure_formatted = date_i18n( 'H\hi', $timestamp );
		$datetime_iso    = date( 'c', $timestamp ); // ISO 8601 pour Schema.org
		$is_past         = $timestamp < time();
	}
}

$categories    = get_the_terms( $post_id, 'webinaires_cat' );
$category_name = '';
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	$category_name = $categories[0]->name;
}

$has_more_content = (bool) get_the_content();

?>

<article
	<?php post_class('cbo-webinaire'); ?>
	id="<?php echo esc_attr($card_id); ?>"
	aria-labelledby="<?php echo esc_attr($title_id); ?>"
	itemscope
	itemtype="https://schema.org/Event"
>
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

	<div class="webinaire-inner">
		<div class="webinaire-content">
			<div class="content-head">
				<div class="content-meta">
					<i class="icon icon--datepicker" aria-hidden="true"></i>
					<div class="meta-info cbo-label">
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
						<?php if ( $duree ) : ?>
							<span class="meta-duree" itemprop="duration">
								<strong><?php pll_e('Durée :') ?></strong> <?php echo esc_html( $duree ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $category_name ) : ?>
					<span class="content-category cbo-tag tag--yellow">
						<?php pll_e('Thématique :') ?> <?php echo esc_html( $category_name ); ?>
					</span>
				<?php endif; ?>

				<h2 id="<?php echo esc_attr($title_id); ?>" class="content-title cbo-title-4" itemprop="name">
					<?php echo esc_html( get_the_title() ); ?>
				</h2>
			</div>

			<?php if ( $is_past ) : ?>
				<a
					class="content-cta cbo-button button--yellow"
					href="<?php echo esc_url( get_permalink() ); ?>"
					aria-label="<?php echo esc_attr( sprintf( pll__('Voir le replay : %s'), get_the_title() ) ); ?>"
				>
					<?php pll_e('Voir le replay'); ?> <i class="icon icon--player" aria-hidden="true"></i>
				</a>
			<?php elseif ( $link ) : ?>
				<a
					class="content-cta cbo-button button--yellow"
					href="<?php echo esc_url( $link ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php echo esc_attr( sprintf( pll__("S'inscrire au webinaire : %s (nouvelle fenêtre)"), get_the_title() ) ); ?>"
				>
					<?php pll_e("S'inscrire au webinaire") ?><i class="icon icon--external-link" aria-hidden="true"></i>
				</a>
			<?php endif; ?>

		</div>

		<?php get_part( 'speakers/template', [ 'speakers' => $speakers ] ); ?>

		<?php if ( $has_more_content ) : ?>
			<div class="toggle-wrap">
				<button
					class="webinaire-toggle cbo-button"
					type="button"
					aria-expanded="false"
					aria-controls="<?php echo esc_attr($toggle_id); ?>"
					aria-label="<?php echo esc_attr( sprintf( pll__("+ d'infos sur : %s"), get_the_title() ) ); ?>"
				>
					<span class="toggle-open"><?php pll_e("+ d'infos") ?></span>
					<span class="toggle-close"><?php pll_e('Fermer') ?></span>
				</button>
			</div>

			<div
				id="<?php echo esc_attr($toggle_id); ?>"
				class="webinaire-excerpt cbo-cms"
				itemprop="description"
				hidden
			>
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
	</div>

</article>
