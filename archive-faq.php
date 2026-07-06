
<?php
	get_header();
	$page_id = get_option('cbo_faqs_archive_page');
?>

<div class="cbo-page">
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
