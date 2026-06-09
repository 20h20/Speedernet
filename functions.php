<?php
	function bones_ahoy() {
		require_once( 'library/inc/custom-cleanup.php' );
		require_once( 'library/inc/custom-admin.php' );
		require_once( 'library/inc/custom-dashboard.php' );
		require_once( 'library/inc/styles-import.php' );
		require_once( 'library/inc/custom-post/cpt-castestudies.php' );
		require_once( 'library/inc/custom-post/cpt-faq.php' );
		require_once( 'library/inc/custom-post/cpt-testimonial.php' );
		require_once( 'library/inc/acf.php' );
	}
	add_action( 'after_setup_theme', 'bones_ahoy' );


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
		$toolbars['Custom'][1] = ['bold', 'formatselect', 'styleselect'];
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
		];
		$init_array['style_formats'] = wp_json_encode($style_formats);
		$init_array['block_formats'] = 'Paragraphe=p;Titre 2=h2;Titre 3=h3;Titre 4=h4;Titre 5=h5;Titre 6=h6';
		return $init_array;
	}
	add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');


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
	/* TRANSLATE KEYS */
	/* ************************* */
	add_action('init', function() {
		pll_register_string( 'header', "Navigation principale");
		pll_register_string( 'header', "Ouvrir la navigation principale");

		pll_register_string( 'footer', "Revenir à l\'accueil");
		pll_register_string( 'footer', "Navigation du pied de page");
		pll_register_string( 'footer', "Nous appeler au ");
		pll_register_string( 'footer', "Nos réseaux sociaux");
		pll_register_string( 'footer', "Notre page LinkedIn (nouvelle fenêtre)");
		pll_register_string( 'footer', "Notre chaîne YouTube (nouvelle fenêtre)");
		pll_register_string( 'footer', "Notre page Instagram (nouvelle fenêtre)");
		pll_register_string( 'footer', "Notre page Twitter (nouvelle fenêtre)");
		pll_register_string( 'footer', "Notre page Facebook (nouvelle fenêtre)");
		pll_register_string( 'footer', "Navigation annexe");
		pll_register_string( 'footer', "Tous droits réservés");
		
		pll_register_string( 'article', "Lire l\'article");

		pll_register_string( 'casestudy', "Lire le cas");
		pll_register_string( 'casestudy', "Études de cas similaires");
		pll_register_string( 'casestudy', "Les réussites de nos clients");
		pll_register_string( 'casestudy', "Aucune étude de cas");
		pll_register_string( 'casestudy', "Aucune catégorie associée à cette étude de cas");
		pll_register_string( 'casestudy', "Études de cas");

		pll_register_string( 'testimonial', "Voir l\'interview");

		pll_register_string( 'global', "Navigation par onglets");

		pll_register_string( '404', "Erreur 404");
		pll_register_string( '404', "La page que vous rechechez n\'existe pas.<br />Vous pouvez toujours revenir sur vos pas.");
		pll_register_string( '404', "Revenir à l\'accueil");
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


?>