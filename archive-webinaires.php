<?php
	get_header();
	$page_id = get_option('cbo_webinaires_archive_page');
?>

<div class="cbo-page page--archive page--webinaires">
	<?php
		if ($page_id) {
			$page = get_post($page_id);
			if ($page) {
				$blocks = parse_blocks($page->post_content);
				foreach ($blocks as $block) {
					echo render_block($block);
				}
			}
		}
	?>
</div>

<?php
	get_footer();
?>
