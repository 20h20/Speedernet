<?php
	get_header();

	if (have_posts()): the_post();

		$domains = wp_get_post_terms(get_the_ID(), 'glossaire_domaine');
		$domain  = (!empty($domains) && !is_wp_error($domains)) ? $domains[0] : null;

		get_block('heropicture', [
			'title' => get_the_title(),
		]);

		get_block('text', [
			'color'     => 'blue',
			'container' => 'cbo-container container--small',
			'uptitle'   => $domain ? $domain->name : '',
			'content'   => apply_filters('the_content', get_the_content()),
		]);

	endif;

	get_footer();
?>
