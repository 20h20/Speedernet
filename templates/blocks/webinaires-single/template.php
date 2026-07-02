<?php

$post_id        = get_the_ID();
$date_raw       = get_field('webinair_date', $post_id, false);
$duree          = get_field('webinair_duration', $post_id);
$speakers       = get_field('webinair_speakers', $post_id);
$resume         = get_field('webinair_resume', $post_id);
$form_shortcode = get_field('webinair_form', $post_id);

$date_formatted  = '';
$heure_formatted = '';

if ( $date_raw ) {
	$timestamp = strtotime( $date_raw );
	if ( $timestamp ) {
		$date_formatted  = ucfirst( date_i18n( 'l d F', $timestamp ) );
		$heure_formatted = date_i18n( 'H\hi', $timestamp );
		$is_past         = $timestamp < time();
	}
}

?>

<div class="cbo-page page--single page--single-webinaire">

	<?php get_template_part( 'templates/blocks/herosimple/template', null, [
		'title' => get_the_title(),
	] ); ?>

	<section class="cbo-single-webinaire" itemscope itemtype="https://schema.org/Event">
		<div class="single-inner cbo-container">

			<div class="single-content">

				<?php if ( $date_formatted || $duree ) : ?>
					<div class="content-meta">
						<i class="icon icon--datepicker" aria-hidden="true"></i>
						<div class="meta-info cbo-label">
							<?php if ( $date_formatted ) : ?>
								<span class="meta-date" itemprop="startDate" content="<?php echo esc_attr( $date_raw ); ?>">
									<strong><?php pll_e('Date :') ?></strong> <?php echo esc_html( $date_formatted ); ?><?php echo $heure_formatted ? ' / ' . esc_html( $heure_formatted ) : ''; ?>
								</span>
							<?php endif; ?>
							<?php if ( $duree ) : ?>
								<span class="meta-duree">
									<strong><?php pll_e('Durée :') ?></strong> <?php echo esc_html( $duree ); ?>
								</span>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $resume ) : ?>
					<div class="single-resume cbo-cms" itemprop="description">
						<?php echo wp_kses_post( $resume ); ?>
					</div>
				<?php endif; ?>

				<?php get_part( 'speakers/template', [ 'speakers' => $speakers ] ); ?>

			</div>

			<?php if ( ! empty( $form_shortcode ) ) : ?>
				<aside class="single-form cbo-form" aria-label="<?php pll_e('Formulaire d\'inscription'); ?>">
					<?php foreach ( $form_shortcode as $cf7_post ) : ?>
						<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $cf7_post->ID ) . '" title="' . esc_attr( $cf7_post->post_title ) . '"]' ); ?>
					<?php endforeach; ?>
				</aside>
			<?php endif; ?>

		</div>
	</section>
</div>