<?php

$uptitle	= get_field('jobslider_uptitle');
$title	= get_field('jobslider_title');
$content	= get_field('jobslider_content');

?>

<section class="cbo-jobslider cbo-overflow-container">
	<div class="jobslider-inner cbo-container">

		<div class="jobslider-content">
			<?php if($uptitle): ?>
				<span class="cbo-tag tag--blue content-uptitle slide-up">
					<?php echo esc_html($uptitle); ?>
				</span>
			<?php endif; ?>

			<?php if($title): ?>
				<div class="content-title cbo-title-2 slide-up">
					<?php echo wp_kses_post($title); ?>
				</div>
			<?php endif; ?>

			<?php if($content): ?>
				<div class="content-text cbo-cms slide-up">
					<?php echo wp_kses_post($content); ?>
				</div>
			<?php endif; ?>
		</div>

		<ul class="jobslider-list" role="list" itemscope itemtype="https://schema.org/ItemList">
			<?php
				if( have_rows('jobslider_list') ):
				while ( have_rows('jobslider_list') ) : the_row();
				$picture	= get_sub_field('picture');
				$jobtitle	= get_sub_field('title');
				$link	= get_sub_field('link');
				if($picture && $link):
			?>
				<li
					class="list-el"
					itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
				>
					<a
						class="el-inner"
						href="<?php echo esc_url($link['url']); ?>"
						target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
						<?php if (($link['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
						aria-label="<?php echo esc_attr($link['title']); ?>"
					>
						<div class="inner-picture cbo-picture-cover slide-up">
							<img
								src="<?php echo esc_url($picture['sizes']['small']); ?>"
								srcset="
								<?php echo esc_url($picture['sizes']['small']); ?> 320w,
								<?php echo esc_url($picture['sizes']['large']); ?> 768w"
								sizes="(min-width: 1024px) calc(100vw - 490px), (min-width: 768px) calc(100vw - 80px), 100vw"
								alt="<?php echo esc_attr($picture['alt']); ?>"
								width="<?php echo esc_attr($picture['sizes']['small-width']); ?>"
								height="<?php echo esc_attr($picture['sizes']['small-height']); ?>"
								decoding="async"
								loading="lazy"
							>
						</div>

						<div class="inner-content cbo-title-4 slide-up">
							<?php echo wp_kses_post($jobtitle); ?>
						</div>
					</a>
				</li>
			<?php
				endif; 
				endwhile;
				endif;
			?>
		</ul>
	</div>
</section>