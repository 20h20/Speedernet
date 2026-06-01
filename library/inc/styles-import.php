<?php

	/* ****************** */
	/* Initialisation du tableau global des blocs utilisés */
	/* Ce tableau sert à collecter les noms des blocs ACF présents sur la page,
	afin de ne charger que les CSS nécessaires (chargement conditionnel). */
	if (!isset($GLOBALS['cbo_used_blocks'])) {
		$GLOBALS['cbo_used_blocks'] = array();
	}

	/* ****************** */
	/* Enregistrer un bloc utilisé */
	/* Ajoute un nom de bloc dans le tableau global, en évitant les doublons.
	Appelée à chaque fois qu'un bloc ACF est détecté dans le contenu de la page. */
	function cbo_register_block_usage($block_name) {
		if (!in_array($block_name, $GLOBALS['cbo_used_blocks'])) {
			$GLOBALS['cbo_used_blocks'][] = $block_name;
		}
	}

	/* ****************** */
	/* Chargement des parts */
	/* Charge dynamiquement le CSS associé à une "part"
	uniquement si son fichier .min.css existe et n'a pas déjà été enqueué.*/
	function get_part($name){
		$slug = basename(dirname($name));
		$handle = 'part-' . $slug;
		$css_file = get_stylesheet_directory() . '/library/css/parts/' . $slug . '.min.css';
		$css_url  = get_stylesheet_directory_uri() . '/library/css/parts/' . $slug . '.min.css';

		if (file_exists($css_file) && !wp_style_is($handle, 'enqueued')) {
			wp_enqueue_style(
				$handle,
				$css_url,
				array(),
				filemtime($css_file)
			);
		}
		get_template_part('templates/parts/' . $name);
	}


	/* ****************** */
	/* Chargement des styles Frontend */
	/* Exécutée sur le front uniquement (guard is_admin()).
	Charge le style global avec versioning automatique via filemtime.*/
	function cbo_scripts_and_styles() {
		if (!is_admin()) {
			$css_blocks_path = get_stylesheet_directory() . '/library/css/blocks/';
			$css_blocks_url  = get_stylesheet_directory_uri() . '/library/css/blocks/';

			/* Charger les styles globaux */
			$global_css_file = get_stylesheet_directory() . '/library/css/style.min.css';

			$global_css_version = file_exists($global_css_file)
				? filemtime($global_css_file)
				: wp_get_theme()->get('Version');

			wp_enqueue_style(
				'global-styles',
				get_stylesheet_directory_uri() . '/library/css/style.min.css',
				array(),
				$global_css_version
			);

			/* Chargement du script principal */
			$js_file = get_stylesheet_directory() . '/library/js/scripts.js';
			wp_enqueue_script(
				'cbo-scripts',
				get_stylesheet_directory_uri() . '/library/js/scripts.js',
				array('jquery'),
				file_exists($js_file) ? filemtime($js_file) : wp_get_theme()->get('Version'),
				true
			);

			/* Détection automatique des blocs ACF dans le contenu */
			if (is_singular() || is_tax()) {
				global $post;
				if (!empty($post->post_content)) {
					preg_match_all('/wp:acf\/([a-z0-9-]+)/', $post->post_content, $matches);
					if (!empty($matches[1])) {
						foreach ($matches[1] as $block_name) {
							cbo_register_block_usage($block_name);
						}
					}
				}
			}

			/* Détection des blocs ACF sur la page des articles (is_home) */
			/* is_home() n'est pas is_singular(), donc la détection ci-dessus ne s'exécute pas.
			   On récupère manuellement le contenu de la page définie comme "Page des articles". */
			if (is_home()) {
				$page_for_posts_id = get_option('page_for_posts');
				if ($page_for_posts_id) {
					$home_page = get_post($page_for_posts_id);
					if ($home_page && !empty($home_page->post_content)) {
						preg_match_all('/wp:acf\/([a-z0-9-]+)/', $home_page->post_content, $home_matches);
						if (!empty($home_matches[1])) {
							foreach ($home_matches[1] as $block_name) {
								cbo_register_block_usage($block_name);
							}
						}
					}
				}
			}

			/* Détection des blocs ACF sur la page d'archive Casestudies */
			if (is_post_type_archive('casestudies') || is_tax('casestudies_cat')) {
				$casestudies_page_id = get_option('cbo_casestudies_archive_page');
				if ($casestudies_page_id) {
					$cs_page = get_post($casestudies_page_id);
					if ($cs_page && !empty($cs_page->post_content)) {
						preg_match_all('/wp:acf\/([a-z0-9-]+)/', $cs_page->post_content, $cs_matches);
						if (!empty($cs_matches[1])) {
							foreach ($cs_matches[1] as $block_name) {
								cbo_register_block_usage($block_name);
							}
						}
					}
				}
			}

			/* Détection des blocs ACF sur la page d'archive Testimonials */
			if (is_post_type_archive('testimonial') || is_tax('testimonials_cat')) {
				$testimonials_page_id = get_option('cbo_testimonials_archive_page');
				if ($testimonials_page_id) {
					$cs_page = get_post($testimonials_page_id);
					if ($cs_page && !empty($cs_page->post_content)) {
						preg_match_all('/wp:acf\/([a-z0-9-]+)/', $cs_page->post_content, $cs_matches);
						if (!empty($cs_matches[1])) {
							foreach ($cs_matches[1] as $block_name) {
								cbo_register_block_usage($block_name);
							}
						}
					}
				}
			}

			/* Charger les styles des blocs */
			if (!empty($GLOBALS['cbo_used_blocks'])) {
				foreach ($GLOBALS['cbo_used_blocks'] as $block_name) {
					$block_css_file = $css_blocks_path . $block_name . '.min.css';
					if (file_exists($block_css_file)) {
						wp_enqueue_style(
							'block-' . $block_name,
							$css_blocks_url . $block_name . '.min.css',
							array(),
							filemtime($block_css_file)
						);
					}
				}
			}
		}
	}


	/* ****************** */
	/* Chargement des styles dans l'éditeur Gutenberg */
	/* Appelé directement ici car ce fichier est déjà inclus dans after_setup_theme.
	   Encapsuler dans une fonction re-hookée sur after_setup_theme ne fonctionnerait pas
	   (le hook est déjà en cours d'exécution). */
	add_theme_support( 'editor-styles' );
	add_editor_style( 'library/css/style.min.css' );
	add_editor_style( 'library/css/gutenberg.min.css' );


	/* ****************** */
	/* Chargement des styles des blocs et parts dans l'éditeur Gutenberg */
	/* style.min.css est volontairement absent ici : add_editor_style() le gère déjà */
	function cbo_enqueue_block_editor_assets() {
		// Blocs
		$css_blocks_path = get_stylesheet_directory() . '/library/css/blocks/';
		$css_blocks_url  = get_stylesheet_directory_uri() . '/library/css/blocks/';
		$block_css_files = glob( $css_blocks_path . '*.min.css' );

		if ( ! empty( $block_css_files ) ) {
			foreach ( $block_css_files as $file ) {
				$block_name = basename( $file, '.min.css' );
				wp_enqueue_style(
					'editor-block-' . $block_name,
					$css_blocks_url . $block_name . '.min.css',
					array(),
					filemtime( $file )
				);
			}
		}

		// Parts
		$css_parts_path = get_stylesheet_directory() . '/library/css/parts/';
		$css_parts_url  = get_stylesheet_directory_uri() . '/library/css/parts/';
		$parts_css_files = glob( $css_parts_path . '*.min.css' );

		if ( ! empty( $parts_css_files ) ) {
			foreach ( $parts_css_files as $file ) {
				$part_name = basename( $file, '.min.css' );
				wp_enqueue_style(
					'editor-part-' . $part_name,
					$css_parts_url . $part_name . '.min.css',
					array(),
					filemtime( $file )
				);
			}
		}
	}
	add_action( 'enqueue_block_editor_assets', 'cbo_enqueue_block_editor_assets' );


	/* ****************** */
	/* Import des styles pour le dashboard */
	function cbo_admin_styles() {
		$admin_css_file = get_stylesheet_directory() . '/library/css/admin.min.css';

		if (file_exists($admin_css_file)) {
			wp_enqueue_style(
				'cbo-admin-styles',
				get_stylesheet_directory_uri() . '/library/css/admin.min.css',
				array(),
				filemtime($admin_css_file)
			);
		}
	}
	add_action('admin_enqueue_scripts', 'cbo_admin_styles');

?>