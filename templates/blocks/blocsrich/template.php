<?php

$uptitle  = get_field('blocsrich_uptitle');
$title  = get_field('blocsrich_title');

?>

<section class="cbo-blocsrich">
	<div class="blocsrich-inner cbo-container">

        <?php if($uptitle): ?>
            <span class="cbo-tag tag--blue blocsrich-uptitle slide-up">
                <?php echo esc_html($uptitle); ?>
            </span>
        <?php endif; ?>

        <?php if ($title): ?>
            <div class="blocsrich-title cbo-title-2 slide-up">
                <?php echo wp_kses_post($title); ?>
            </div>
        <?php endif; ?>

		<div class="blocsrich-list" itemscope itemtype="https://schema.org/ItemList">
			<?php
				if( have_rows('blocs_list') ):
				while( have_rows('blocs_list') ): the_row();
				$icon = get_sub_field('icon');
				$title = get_sub_field('title');
				$content = get_sub_field('content');
				$link = get_sub_field('link');
				$link_url    = is_array($link) ? $link['url']    : $link;
			?>
				<div class="list-el" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<?php if($link): ?>
						<a class="el-inner slide-up" href="<?php echo esc_url($link_url); ?>">
					<?php else: ?>
						<span class="el-inner slide-up">
					<?php endif; ?>

						<span class="inner-top">
							<?php if($icon): ?>
								<span class="inner-icon cbo-picture-contain slide-up">
									<img
										src="<?php echo esc_url($icon['sizes']['xsmall']); ?>"
										alt=""
										sizes="60px"
										width="60" height="60"
										loading="lazy"
										decoding="async"
									>
								</span>
							<?php endif; ?>

							<?php if($title): ?>
								<h3 class="inner-title cbo-title-4 slide-up" itemprop="name">
									<?php echo esc_html($title); ?>
								</h3>
							<?php endif; ?>

							<?php if($content): ?>
								<span class="inner-content slide-up">
									<?php echo wp_kses_post($content); ?>
								</span>
							<?php endif; ?>
						</span>

						<?php if($link): ?>
							<span class="inner-link cbo-link slide-up">
								<span class="link-button">
									<i class="icon icon--arrow-next" aria-hidden="true"></i>
								</span>
							</span>
						<?php endif; ?>

					<?php if($link): ?>
						</a>
					<?php else: ?>
						</span>
					<?php endif; ?>
				</div>
			<?php
				endwhile;
				endif;
			?>
		</div>
	</div>
</section>