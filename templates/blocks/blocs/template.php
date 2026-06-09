<section class="cbo-blocs">
	<div class="blocs-inner cbo-container">

		<div class="blocs-list">
			<?php
				if( have_rows('blocs_list') ):
				while( have_rows('blocs_list') ): the_row();
				$icon = get_sub_field('icon');
				$title = get_sub_field('title');
				$content = get_sub_field('content');
				$color = get_sub_field('color');
			?>
				<div class="list-el">
					<div class="el-inner">
						<?php if($icon): ?>
							<span class="inner-icon slide-up cbo-picture-contain icon--<?php echo esc_attr($color); ?>">
								<img
									src="<?php echo esc_url($icon['sizes']['xsmall']); ?>"
									srcset="<?php echo esc_url($icon['sizes']['xsmall']); ?> 320w"
									alt=""
									sizes="(min-width: 1024px) 50vw, (min-width: 768px) 60vw, 100vw"
									width="60" height="60"
									loading="lazy"
									decoding="async"
								>
							</span>
						<?php endif; ?>

						<?php if($title): ?>
							<div class="inner-title cbo-title-4 slide-up">
								<?php echo esc_html($title); ?>
							</div>
						<?php endif; ?>

						<?php if($content): ?>
							<div class="inner-content slide-up">
								<?php echo wp_kses_post($content); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php
				endwhile;
				endif;
			?>
		</div>
	</div>
</section>