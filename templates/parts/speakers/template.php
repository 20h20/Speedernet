<?php
$speakers = $args['speakers'] ?? [];
if ( empty( $speakers ) ) return;
?>

<div class="webinaire-speakers">
	<p class="speakers-title"><?php pll_e('Speakers :') ?></p>
	<ul class="speakers-list" role="list">
		<?php foreach ( $speakers as $speaker ) :
			$picture = $speaker['picture'];
			$name    = $speaker['name'];
			$role    = $speaker['function'];
		?>
			<li class="speaker-el">
				<?php if ( $picture ) : ?>
					<div class="speaker-picture">
						<div class="picture-inner cbo-picture-cover">
							<img
								src="<?php echo esc_url( $picture['sizes']['xsmall'] ?? $picture['url'] ); ?>"
								alt="<?php echo esc_attr( $name ); ?>"
								width="60" height="60" loading="lazy" decoding="async"
							>
						</div>
					</div>
				<?php endif; ?>
				<div class="speaker-info cbo-label">
					<?php if ( $name ) : ?>
						<strong class="speaker-name" itemprop="performer" itemscope itemtype="https://schema.org/Person">
							<span itemprop="name"><?php echo esc_html( $name ); ?></span>
						</strong>
					<?php endif; ?>
					<?php if ( $role ) : ?>
						<span class="speaker-role"><?php echo esc_html( $role ); ?></span>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>