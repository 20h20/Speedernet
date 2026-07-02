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

$date_formatted = '';
$heure_formatted = '';
$is_past = false;
if ( $date_raw ) {
	$timestamp = strtotime( $date_raw );
	if ( $timestamp ) {
		$date_formatted  = ucfirst( date_i18n( 'l d F', $timestamp ) );
		$heure_formatted = date_i18n( 'H\hi', $timestamp );
		$is_past         = $timestamp < time();
	}
}

$categories = get_the_terms( $post_id, 'webinaires_cat' );
$category_name = '';
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	$category_name = $categories[0]->name;
}

?>

<article <?php post_class('cbo-webinaire'); ?> id="<?php echo esc_attr($card_id); ?>" aria-labelledby="<?php echo esc_attr($title_id); ?>" itemscope itemtype="https://schema.org/Event">

	<div class="webinaire-inner">
		<div class="webinaire-content">
			<div class="content-head">
				<div class="content-meta">
					<i class="icon icon--datepicker" aria-hidden="true"></i>
					<div class="meta-info cbo-label">
						<span class="meta-date" itemprop="startDate" content="<?php echo esc_attr($date_raw); ?>">
							<strong><?php pll_e('Date :') ?></strong> <?php echo esc_html($date_formatted); ?><?php echo $heure_formatted ? ' / ' . esc_html($heure_formatted) : ''; ?>
						</span>
						<span class="meta-duree">
							<strong><?php pll_e('Durée :') ?></strong> <?php echo esc_html($duree); ?>
						</span>
					</div>
				</div>

				<?php if ( $category_name ) : ?>
					<span class="content-category cbo-tag tag--yellow">
						<?php pll_e('Thématique :') ?> <?php echo esc_html($category_name); ?>
					</span>
				<?php endif; ?>

				<h3 id="<?php echo esc_attr($title_id); ?>" class="content-title cbo-title-4" itemprop="name">
					<?php the_title(); ?>
				</h3>
			</div>

			<?php if ( $is_past ) : ?>
				<a
					class="content-cta cbo-button button--yellow"
					href="<?php echo esc_url( get_permalink() ); ?>"
					aria-label="<?php echo esc_attr( sprintf( pll__( 'Voir le replay : %s' ), get_the_title() ) ); ?>"
				>
					<?php pll_e('Voir le replay'); ?> <i class="icon icon--player" aria-hidden="true"></i>
				</a>
			<?php elseif ( $link ) : ?>
				<a
					class="content-cta cbo-button button--yellow"
					href="<?php echo esc_url( $link ); ?>"
					target="_blank"
					aria-label="<?php echo esc_attr( sprintf( pll__( 'S\'inscrire au webinaire : %s' ), get_the_title() ) ); ?>"
					rel="noopener noreferrer"
				>
					<?php pll_e('S\'inscrire au webinaire') ?><i class="icon icon--external-link" aria-hidden="true"></i>
				</a>
			<?php endif; ?>

		</div>

		<?php get_part( 'speakers/template', [ 'speakers' => $speakers ] ); ?>

		<?php if ( $resume ) : ?>
			<div class="toggle-wrap">
				<button
					class="webinaire-toggle cbo-button"
					type="button"
					aria-expanded="false"
					aria-controls="<?php echo esc_attr($toggle_id); ?>"
					aria-label="<?php echo esc_attr( sprintf( pll__( '+ d\'infos sur : %s' ), get_the_title() ) ); ?>"
				>
					<span class="toggle-open"><?php pll_e('+ d\'infos') ?></span>
					<span class="toggle-close"><?php pll_e('Fermer') ?></span>
				</button>
			</div>
		<?php endif; ?>

		<?php if ( has_excerpt() ) : ?>
			<div id="<?php echo esc_attr($toggle_id); ?>" class="webinaire-excerpt cbo-cms" hidden>
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</div>

</article>