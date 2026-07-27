<?php
	function bones_ahoy() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		require_once( 'library/inc/custom-cleanup.php' );
		require_once( 'library/inc/custom-admin.php' );
		require_once( 'library/inc/custom-dashboard.php' );
		require_once( 'library/inc/styles-import.php' );
		require_once( 'library/inc/custom-post/cpt-castestudies.php' );
		require_once( 'library/inc/custom-post/cpt-faq.php' );
		require_once( 'library/inc/custom-post/cpt-testimonial.php' );
		require_once( 'library/inc/custom-post/cpt-webinaires.php' );
		require_once( 'library/inc/custom-post/cpt-glossaire.php' );
		require_once( 'library/inc/acf.php' );
		require_once( 'library/inc/strings.php' );
	}
	add_action( 'after_setup_theme', 'bones_ahoy' );

	/* ************************* */
	// Gravity Forms - désactiver les styles par défaut
	/* ************************* */
	add_filter( 'gform_disable_css', '__return_true' );


	/* ************************* */
	// Pic size
	/* ************************* */
	add_action('after_setup_theme', function() {
		add_image_size('xsmall', 320, 320, false);
		add_image_size('small', 768, 768, false);
		add_image_size('medium', 1200, 1200, false);
		add_image_size('xlarge', 1920, 1920, false);
	});

	/* ************************* */
	// Register menu
	/* ************************* */
	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'main-nav' => 'Menu principal',  
			'footer-nav' => 'Menu footer',
			'footer-annexe' => 'Menu annexe'
		)
	);

	/* ************************* */
	/* AJOUT OPTIONS AU DASHBOARD */
	/* ************************* */
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page();
	}	

	/* ************************* */
	/* ACF - Custom toolbars */
	/* ************************* */
	function custom_acf_wysiwyg_toolbar($toolbars) {

		// Toolbar simple
		$toolbars['Custom'] = [];
		$toolbars['Custom'][1] = ['bold', 'formatselect'];
		$toolbars['HeroRich'] = [];
		$toolbars['HeroRich'][1] = ['bold'];

		return $toolbars;
	}
	add_filter('acf/fields/wysiwyg/toolbars', 'custom_acf_wysiwyg_toolbar');

	/* ************************* */
	/* TinyMCE - Ajout styles personnalisés */
	/* ************************* */
	function my_mce_before_init_insert_formats($init_array) {
		// Retirer style.min.css du content_css de TinyMCE (body { padding-top: 250px } casse l'éditeur)
		if (!empty($init_array['content_css'])) {
			$css_files = array_map('trim', explode(',', $init_array['content_css']));
			$css_files = array_filter($css_files, fn($f) => strpos($f, 'style.min.css') === false);
			$init_array['content_css'] = implode(',', $css_files);
		}

		$style_formats = [
			[
				'title'   => 'Bouton gris',
				'classes' => 'cbo-button',
				'block' => 'a',
				'wrapper' => true,
				'attributes' => array(
					'href' => '#'
				)
			],
			[
				'title'   => 'Bouton bleu',
				'classes' => 'cbo-button button--blue',
				'block' => 'a',
				'wrapper' => true,
				'attributes' => array(
					'href' => '#'
				)
			],
			[
				'title'   => 'Chapô',
				'classes' => 'cbo-chapo',
				'block' => 'span'
			],
		];
		$init_array['style_formats'] = wp_json_encode($style_formats);
		$init_array['block_formats'] = 'Paragraphe=p;Titre 2=h2;Titre 3=h3;Titre 4=h4;Titre 5=h5;Titre 6=h6';
		return $init_array;
	}
	add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');


	/* ************************* */
	/* Ajoute un réglage pour choisir la page archive FAQ */
	/* ************************* */
	function cbo_register_faqs_archive_page_setting() {
		add_settings_section(
			'cbo_faqs_section',
			__('Page Questions fréquentes', 'cbo'),
			'__return_false',
			'reading'
		);
		add_settings_field(
			'cbo_faqs_archive_page',
			__('Page archive FAQ', 'cbo'),
			'cbo_faqs_archive_page_dropdown',
			'reading',
			'cbo_faqs_section'
		);
		register_setting('reading', 'cbo_faqs_archive_page');
	}
	add_action('admin_init', 'cbo_register_faqs_archive_page_setting');

	function cbo_faqs_archive_page_dropdown() {
		$value = get_option('cbo_faqs_archive_page');
		wp_dropdown_pages([
			'name'              => 'cbo_faqs_archive_page',
			'show_option_none'  => __('— Aucune —', 'cbo'),
			'option_none_value' => '',
			'selected'          => $value,
		]);
	}

	/* ************************* */
	/* Ajoute un réglage pour choisir la page archive Casestudies */
	/* ************************* */
	function cbo_register_casestudies_archive_page_setting() {
		add_settings_section(
			'cbo_casestudies_section',
			__('Page de listing des études de cas', 'cbo'),
			'__return_false',
			'reading'
		);

		add_settings_field(
			'cbo_casestudies_archive_page',
			__('Page archive Casestudies', 'cbo'),
			'cbo_casestudies_archive_page_dropdown',
			'reading',
			'cbo_casestudies_section'
		);

		register_setting('reading', 'cbo_casestudies_archive_page');
	}
	add_action('admin_init', 'cbo_register_casestudies_archive_page_setting');

	function cbo_casestudies_archive_page_dropdown() {
		$value = get_option('cbo_casestudies_archive_page');
		wp_dropdown_pages([
			'name'	=> 'cbo_casestudies_archive_page',
			'show_option_none'  => __('— Aucun —', 'cbo'),
			'option_none_value' => '',
			'selected'	=> $value,
		]);
	}


	/* ************************* */
	/* Ajoute un réglage pour choisir la page archive Témoignages */
	/* ************************* */
	function cbo_register_testimonials_archive_page_setting() {
		add_settings_section(
			'cbo_testimonials_section',
			__('Page de listing des témoignages', 'cbo'),
			'__return_false',
			'reading'
		);

		add_settings_field(
			'cbo_testimonials_archive_page',
			__('Page de listing des témoignages', 'cbo'),
			'cbo_testimonials_archive_page_dropdown',
			'reading',
			'cbo_testimonials_section'
		);

		register_setting('reading', 'cbo_testimonials_archive_page');
	}
	add_action('admin_init', 'cbo_register_testimonials_archive_page_setting');

	function cbo_testimonials_archive_page_dropdown() {
		$value = get_option('cbo_testimonials_archive_page');
		wp_dropdown_pages([
			'name'	=> 'cbo_testimonials_archive_page',
			'show_option_none'  => __('— Aucun —', 'cbo'),
			'option_none_value' => '',
			'selected'	=> $value,
		]);
	}


	/* ************************* */
	/* Ajoute un réglage pour choisir la page archive Webinaires */
	/* ************************* */
	function cbo_register_webinaires_archive_page_setting() {
		add_settings_section(
			'cbo_webinaires_section',
			__('Page de listing des webinaires', 'cbo'),
			'__return_false',
			'reading'
		);

		add_settings_field(
			'cbo_webinaires_archive_page',
			__('Page de listing des webinaires', 'cbo'),
			'cbo_webinaires_archive_page_dropdown',
			'reading',
			'cbo_webinaires_section'
		);

		register_setting('reading', 'cbo_webinaires_archive_page');
	}
	add_action('admin_init', 'cbo_register_webinaires_archive_page_setting');

	function cbo_webinaires_archive_page_dropdown() {
		$value = get_option('cbo_webinaires_archive_page');
		wp_dropdown_pages([
			'name'	=> 'cbo_webinaires_archive_page',
			'show_option_none'  => __('— Aucun —', 'cbo'),
			'option_none_value' => '',
			'selected'	=> $value,
		]);
	}


	/* ************************* */
	/* Ajoute un réglage pour choisir la page archive Glossaire */
	/* ************************* */
	function cbo_register_glossaire_archive_page_setting() {
		add_settings_section(
			'cbo_glossaire_section',
			__('Page du glossaire', 'cbo'),
			'__return_false',
			'reading'
		);
		add_settings_field(
			'cbo_glossaire_archive_page',
			__('Page archive Glossaire', 'cbo'),
			'cbo_glossaire_archive_page_dropdown',
			'reading',
			'cbo_glossaire_section'
		);
		register_setting('reading', 'cbo_glossaire_archive_page');
	}
	add_action('admin_init', 'cbo_register_glossaire_archive_page_setting');

	function cbo_glossaire_archive_page_dropdown() {
		$value = get_option('cbo_glossaire_archive_page');
		wp_dropdown_pages([
			'name'              => 'cbo_glossaire_archive_page',
			'show_option_none'  => __('— Aucune —', 'cbo'),
			'option_none_value' => '',
			'selected'          => $value,
		]);
	}


	/* ************************* */
	/* Security headers HTTP */
	/* ************************* */
	add_action('send_headers', function() {
		if (is_admin()) return;
		header('X-Content-Type-Options: nosniff');
		header('X-Frame-Options: SAMEORIGIN');
		header('Referrer-Policy: strict-origin-when-cross-origin');
		header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
	});


	/* ************************* */
	/* Désactivation jQuery Migrate */
	/* ************************* */
	add_action('wp_default_scripts', function($scripts) {
		if (!is_admin() && isset($scripts->registered['jquery'])) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				['jquery-migrate']
			);
		}
	});


	/* ************************* */
	/* TinyMCE - Activer styleselect */
	/* ************************* */
	function my_mce_buttons($buttons) {
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}
	add_filter('mce_buttons', 'my_mce_buttons');


	/* ************************* */
	// Removing autoP from CF7
	/* ************************* */
	add_filter('wpcf7_autop_or_not', '__return_false');


	/* ************************* */
	/* CUSTOM LOGIN */
	/* ************************* */
	function childtheme_custom_login() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/library/css/style.min.css" />';
	}
	add_action('login_head', 'childtheme_custom_login');


	/* ************************* */
	/* CRÉATION PAGINATION */
	/* ************************* */
	function page_navi($before = '', $after = '') {
		global $wpdb, $wp_query;
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if ( $numposts <= $posts_per_page ) { return; }
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 7;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		echo $before.'<ul class="cbo-pagination">'."";

		$prevposts = get_previous_posts_link('<i class="icon icon--arrow-next"></i>');
		if($prevposts) { echo '<li class="cbo-paginate-prev">' . $prevposts  . '</li>'; }
		else { echo '<li class="disabled"><a href="#"><i class="icon icon--arrow-next"></i></a></li>'; }

		for($i = $start_page; $i  <= $end_page; $i++) {
			if($i == $paged) {
				echo '<li class="active"><a href="#">'.$i.'</a></li>';
			} else {
				echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
			}
		}

		$nextposts = get_next_posts_link('<i class="icon icon--arrow-next"></i>');
		if($nextposts) { echo '<li class="cbo-paginate-next">' . $nextposts  . '</li>'; }
		else { echo '<li class="disabled"><a href="#"><i class="icon icon--arrow-next"></i></a></li>'; }
		
		echo '</ul>'.$after."";
	}


	/* ************************* */
	/* Rogne chaque élément du breadcrumb Yoast SEO à 10 mots max */
	/* ************************* */
	function ju_trim_yoast_breadcrumb_links( $links ) {
		$max_words = 5;

		foreach ( $links as $key => $link ) {
			if ( ! empty( $link['text'] ) ) {
				$words = explode( ' ', trim( $link['text'] ) );

				if ( count( $words ) > $max_words ) {
					$links[ $key ]['text'] = implode( ' ', array_slice( $words, 0, $max_words ) ) . '…';
				}
			}
		}

		return $links;
	}
	add_filter( 'wpseo_breadcrumb_links', 'ju_trim_yoast_breadcrumb_links' );


	/* ************************* */
	/* Affiche les images dans le flux rss */
	/* ************************* */
	function add_imagelink_to_rss() {
		global $post;

		if ( has_post_thumbnail( $post->ID ) ) {
			$thumb_id = get_post_thumbnail_id( $post->ID );
			$thumb_url = wp_get_attachment_url( $thumb_id );

			if ( $thumb_url ) {
				echo "<enclosure url='" . esc_url( $thumb_url ) . "' type='image/jpeg' />\n";
				echo "<imagelink>" . esc_url( $thumb_url ) . "</imagelink>\n";
			}
		}

	}
	add_action( 'rss2_item', 'add_imagelink_to_rss' );
?>