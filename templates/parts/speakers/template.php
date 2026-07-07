<?php

$speakers     = $args['speakers']     ?? [];
$show_details = $args['show_details'] ?? false;
if ( empty( $speakers ) ) return;

?>

<div class="webinaire-speakers" itemscope itemtype="https://schema.org/Event">
	<p class="speakers-title">
		<?php pll_e('Speakers :') ?>
	</p>

	<ul class="speakers-list" role="list">
		<?php foreach ( $speakers as $speaker ) :
			$picture	= $speaker['picture']     ?? null;
			$name	= $speaker['name']        ?? '';
			$role	= $speaker['function']    ?? '';
			$linkedin	= $speaker['linkedin']    ?? '';
			$description	= $speaker['description'] ?? '';
		?>
			<li class="speaker-el slide-up" itemprop="performer" itemscope itemtype="https://schema.org/Person">
				<div class="speaker-content">
					<?php if ( $picture ) : ?>
						<div class="speaker-picture slide-up">
							<div class="picture-inner cbo-picture-cover">
								<img
									src="<?php echo esc_url( $picture['sizes']['xsmall'] ?? $picture['url'] ); ?>"
									alt="<?php echo esc_attr( $name ); ?>"
									width="60" height="60"
									loading="lazy"
									decoding="async"
									itemprop="image"
								>
							</div>
						</div>
					<?php endif; ?>

					<div class="speaker-info cbo-label slide-up">
						<?php if ( $name ) : ?>
							<span class="speaker-name" itemprop="name">
								<?php echo esc_html( $name ); ?>
							</span>
						<?php endif; ?>
						<?php if ( $role ) : ?>
							<span class="speaker-role" itemprop="jobTitle">
								<?php echo esc_html( $role ); ?>
							</span>
						<?php endif; ?>
						<?php if ( $show_details && $description ) : ?>
							<p class="speaker-description" itemprop="description">
								<?php echo esc_html( $description ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $show_details && $linkedin ) : ?>
					<a
						class="speaker-linkedin slide-up"
						href="<?php echo esc_url( $linkedin ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						aria-label="<?php echo esc_attr( sprintf( pll__('Voir le profil LinkedIn de %s (nouvelle fenêtre)'), $name ) ); ?>"
						itemprop="sameAs"
					>
						<i class="icon icon--linkedin" aria-hidden="true"></i>
					</a>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
