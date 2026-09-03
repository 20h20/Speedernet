<?php

$title   = get_field('newsletter_title', 'option');
$text    = get_field('newsletter_text', 'option');
$form_id = (int) get_field('newsletter_form_id', 'option');

if (!$title && !$form_id) return;

?>

<section class="cbo-newsletter">
	<div class="newsletter-inner cbo-container">

		<div class="newsletter-content">
			<?php if ($title): ?>
				<div class="content-title cbo-title-2 slide-up">
					<?php echo wp_kses_post($title); ?>
				</div>
			<?php endif; ?>

			<?php if ($text): ?>
				<div class="content-text cbo-cms slide-up">
					<?php echo wp_kses_post($text); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($form_id && function_exists('gravity_form')): ?>
			<div class="newsletter-form cbo-form" aria-label="<?php echo esc_attr(pll__('Inscription à la newsletter')); ?>">
				<?php gravity_form($form_id, false, false, false, null, true); ?>
			</div>
		<?php endif; ?>
	</div>
</section>