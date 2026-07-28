<?php

$title   = get_field('contact_title');
$chapo   = get_field('contact_chapo');
$address = get_field('contact_address');
$form_id = (int) get_field('contact_form_id');

?>

<section class="cbo-contact">
	<div class="contact-inner cbo-container">

		<div class="contact-content">

			<?php if ( $title ) : ?>
				<div class="contact-title cbo-title-2 slide-up">
					<?php echo wp_kses_post( $title ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $chapo ) : ?>
				<div class="contact-chapo cbo-cms slide-up">
					<?php echo wp_kses_post( $chapo ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $address ) : ?>
				<address class="contact-address cbo-cms slide-up">
					<?php echo wp_kses_post( $address ); ?>
				</address>
			<?php endif; ?>

		</div>

		<?php if ( $form_id && function_exists('gravity_form') ) : ?>
			<div class="contact-form cbo-form" aria-label="<?php echo esc_attr( pll__('Formulaire de contact') ); ?>">
				<?php gravity_form( $form_id, false, false, false, null, true ); ?>
			</div>
		<?php endif; ?>

	</div>
</section>