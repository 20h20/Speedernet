<?php

$uptitle = get_field('team_uptitle');
$uptitlepic  = get_field('team_uptitlepicture');
$title      = get_field('team_title');
$chapo      = get_field('team_chapo');

?>

<section class="cbo-team">
	<div class="team-inner cbo-container container--small">

		<div class="team-content">
			<?php if ($uptitle) : ?>
				<span class="cbo-tag tag--blue content-uptitle slide-up">
					<?php echo esc_html($uptitle); ?>
					<?php if($uptitlepic): ?>
						<span class="tag-picture cbo-picture-contain">
							<img
								src="<?php echo esc_url($uptitlepic['sizes']['small']); ?>"
								srcset="<?php echo esc_url($uptitlepic['sizes']['small']); ?> 320w"
								sizes="(max-width: 768px) 54px, 54px"
								alt=""
								width="<?php echo esc_attr($uptitlepic['sizes']['small-width']); ?>"
								height="<?php echo esc_attr($uptitlepic['sizes']['small-height']); ?>"
								decoding="async"
								loading="lazy"
							>
						</span>
					<?php endif; ?>
				</span>
			<?php endif; ?>

			<?php if ($title): ?>
				<div class="content-title cbo-title-2 slide-up">
					<?php echo wp_kses_post($title); ?>
				</div>
			<?php endif; ?>

			<?php if ( $chapo ) : ?>
				<div class="content-chapo cbo-chapo slide-up">
					<?php echo wp_kses_post( $chapo ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php $pictures = get_field('team_pictureslist') ?: []; ?>

		<?php if (!empty($pictures)) :
			$mid = (int) ceil( count($pictures) / 2 );
			$cols = [
				'list-left'  => array_slice($pictures, 0, $mid),
				'list-right' => array_slice($pictures, $mid),
			];
		?>
			<div class="team-list">

				<?php foreach ($cols as $col => $col_pictures) : ?>
					<div class="<?php echo esc_attr($col); ?>">
						<?php foreach ($col_pictures as $row) :
							$picture = $row['picture'] ?? null;
							if (!$picture) continue;
						?>
							<div class="list-el">
								<div class="el-inner cbo-picture-cover" aria-hidden="true">
									<img
										src="<?php echo esc_url($picture['sizes']['small']); ?>"
										srcset="<?php echo esc_url($picture['sizes']['small']); ?> 320w,
										<?php echo esc_url($picture['sizes']['large']); ?> 768w"
										sizes="(min-width: 1024px) 25vw, (min-width: 640px) 22vw, 50vw"
										alt="<?php echo esc_attr($picture['alt']); ?>"
										width="<?php echo esc_attr($picture['sizes']['small-width']); ?>"
										height="<?php echo esc_attr($picture['sizes']['small-height']); ?>"
										decoding="async"
										loading="lazy"
									>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>

			</div>
		<?php endif; ?>
	</div>
</section>