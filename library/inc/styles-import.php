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
	/* Charge dynamiquement le CSS/JS d'une "part". Si appelée après wp_head()
	(rendu du template), les styles sont flushés automatiquement via wp_footer(). */
	function get_part($name, $args = []){
		$slug = basename(dirname($name));
		$handle = 'part-' . $slug;

		$css_file = get_stylesheet_directory() . '/library/css/parts/' . $slug . '.min.css';
		$css_url  = get_stylesheet_directory_uri() . '/library/css/parts/' . $slug . '.min.css';
		if (file_exists($css_file) && !wp_style_is($handle, 'enqueued')) {
			wp_enqueue_style($handle, $css_url, array(), filemtime($css_file));
		}

		$js_file = get_stylesheet_directory() . '/templates/parts/' . $slug . '/script.js';
		$js_url  = get_stylesheet_directory_uri() . '/templates/parts/' . $slug . '/script.js';
		if (file_exists($js_file) && !wp_script_is($handle, 'enqueued')) {
			wp_enqueue_script($handle, $js_url, array('jquery'), filemtime($js_file), true);
		}

		get_template_part('templates/parts/' . $name, null, $args);
	}

	/* ****************** */
	/* Chargement des blocs depuis les templates PHP */
	/* Équivalent de get_part() pour les blocs ACF : charge le CSS du bloc
	et inclut son template avec des $args. Gère automatiquement le timing. */
	function get_block($name, $args = []) {
		$handle = 'block-' . $name;

		$css_file = get_stylesheet_directory() . '/library/css/blocks/' . $name . '.min.css';
		$css_url  = get_stylesheet_directory_uri() . '/library/css/blocks/' . $name . '.min.css';
		if (file_exists($css_file) && !wp_style_is($handle, 'enqueued')) {
			wp_enqueue_style($handle, $css_url, array(), filemtime($css_file));
		}

		$js_file = get_stylesheet_directory() . '/templates/blocks/' . $name . '/script.js';
		$js_url  = get_stylesheet_directory_uri() . '/templates/blocks/' . $name . '/script.js';
		if (file_exists($js_file) && !wp_script_is($handle, 'enqueued')) {
			wp_enqueue_script($handle, $js_url, array('jquery'), filemtime($js_file), true);
		}

		get_template_part('templates/blocks/' . $name . '/template', null, $args);
	}

	/* ****************** */
	/* Flush des styles en footer */
	/* wp_enqueue_style() appelé après wp_head() (ex: depuis get_part() ou get_block()
	dans le corps du template) n'est pas rendu dans <head>. Ce hook imprime
	automatiquement tous les styles encore en attente juste avant </body>. */
	add_action('wp_footer', 'wp_print_styles', 5);


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

			/* Chargement des libs JS (séparées — concaténées par Autoptimize en prod) */
			$libs_path = get_stylesheet_directory() . '/src/js/libs/';
			$libs_url  = get_stylesheet_directory_uri() . '/src/js/libs/';
			$lib_order = ['footer', 'forms', 'languages', 'nav', 'parallaxe', 'slick', 'scrollanim', 'search', 'wavy'];

			foreach ($lib_order as $lib) {
				$lib_file = $libs_path . $lib . '.js';
				if (file_exists($lib_file)) {
					wp_enqueue_script(
						'cbo-' . $lib,
						$libs_url . $lib . '.js',
						array('jquery'),
						filemtime($lib_file),
						true
					);
				}
			}

			/* ---- Configuration des CPTs ----
			 * archive_option  : clé wp_option stockant l'ID de la page d'archive
			 * taxonomies      : slugs de taxonomies liées à ce CPT
			 * singular_blocks : blocs hardcodés dans le template single (non détectables via le contenu ACF)
			 */
			$cbo_cpt_config = [
				'casestudies' => [
					'archive_option'  => 'cbo_casestudies_archive_page',
					'taxonomies'      => ['casestudies_cat'],
					'singular_blocks' => ['casestudies'],
					'archive_blocks'  => ['herosimple'],
				],
				'faq' => [
					'archive_option'  => 'cbo_faqs_archive_page',
					'taxonomies'      => ['faq_cat'],
					'singular_blocks' => ['faqs'],
					'archive_blocks'  => ['faqs'],
				],
				'testimonial' => [
					'archive_option'  => 'cbo_testimonials_archive_page',
					'taxonomies'      => ['testimonials_cat'],
					'singular_blocks' => [],
					'archive_blocks'  => ['herosimple', 'testimonials'],
				],
				'webinaires' => [
					'archive_option'  => 'cbo_webinaires_archive_page',
					'taxonomies'      => ['webinaires_cat'],
					'singular_blocks' => ['webinaires-single', 'herosimple'],
				],
				'glossaire' => [
					'archive_option'  => 'cbo_glossaire_archive_page',
					'taxonomies'      => ['glossaire_lettre'],
					'singular_blocks' => ['glossaire', 'heropicture', 'text'],
					'archive_blocks'  => ['glossaire'],
				],
			];

			/* Détection automatique des blocs ACF dans le contenu (singular & tax) */
			if (is_singular() || is_tax()) {
				global $post;
				if (!empty($post->post_content)) {
					preg_match_all('/wp:acf\/([a-z0-9-]+)/', $post->post_content, $matches);
					foreach ($matches[1] ?? [] as $block_name) {
						cbo_register_block_usage($block_name);
					}
				}
			}

			/* is_home() n'est pas is_singular() : on parse manuellement la "Page des articles" */
			if (is_home()) {
				$home_page = get_post(get_option('page_for_posts'));
				if ($home_page && !empty($home_page->post_content)) {
					preg_match_all('/wp:acf\/([a-z0-9-]+)/', $home_page->post_content, $home_matches);
					foreach ($home_matches[1] ?? [] as $block_name) {
						cbo_register_block_usage($block_name);
					}
				}
			}

			/* Détection par CPT : archives, taxonomies, et blocs hardcodés dans les singles */
			foreach ($cbo_cpt_config as $post_type => $config) {
				$is_archive = is_post_type_archive($post_type) || !empty(array_filter($config['taxonomies'], 'is_tax'));

				if ($is_archive) {
					// Blocs hardcodés pour l'archive
					if (!empty($config['archive_blocks'])) {
						foreach ($config['archive_blocks'] as $block_name) {
							cbo_register_block_usage($block_name);
						}
					}

					// Blocs détectés dans le contenu de la page d'archive désignée
					if (!empty($config['archive_option'])) {
						$archive_page = get_post(get_option($config['archive_option']));
						if ($archive_page && !empty($archive_page->post_content)) {
							preg_match_all('/wp:acf\/([a-z0-9-]+)/', $archive_page->post_content, $cpt_matches);
							foreach ($cpt_matches[1] ?? [] as $block_name) {
								cbo_register_block_usage($block_name);
							}
						}
					}
				}

				if (is_singular($post_type)) {
					foreach ($config['singular_blocks'] as $block_name) {
						cbo_register_block_usage($block_name);
					}
				}
			}

			/* Pages avec blocs hardcodés (templates sans ACF block dans le contenu) */
			if ( is_page('nos-replays') ) {
				cbo_register_block_usage('webinaires');
			}

			if ( is_search() ) {
				cbo_register_block_usage('herosimple');
				$css_parts_path = get_stylesheet_directory() . '/library/css/parts/';
				$css_parts_url  = get_stylesheet_directory_uri() . '/library/css/parts/';
				foreach (['article', 'pagination'] as $part_name) {
					$part_css_file = $css_parts_path . $part_name . '.min.css';
					if (file_exists($part_css_file) && !wp_style_is('part-' . $part_name, 'enqueued')) {
						wp_enqueue_style('part-' . $part_name, $css_parts_url . $part_name . '.min.css', array(), filemtime($part_css_file));
					}
				}
			}

			/* Charger les styles et scripts des blocs */
			$js_blocks_path = get_stylesheet_directory() . '/templates/blocks/';
			$js_blocks_url  = get_stylesheet_directory_uri() . '/templates/blocks/';

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

					$block_js_file = $js_blocks_path . $block_name . '/script.js';
					if (file_exists($block_js_file) && !wp_script_is('block-' . $block_name, 'enqueued')) {
						wp_enqueue_script(
							'block-' . $block_name,
							$js_blocks_url . $block_name . '/script.js',
							array('jquery'),
							filemtime($block_js_file),
							true
						);
					}
				}
			}

			/* Parts requises par certains blocs */
			$css_parts_path = get_stylesheet_directory() . '/library/css/parts/';
			$css_parts_url  = get_stylesheet_directory_uri() . '/library/css/parts/';
			$js_parts_path  = get_stylesheet_directory() . '/templates/parts/';
			$js_parts_url   = get_stylesheet_directory_uri() . '/templates/parts/';
			$block_part_deps = [
				'faqs'         => ['faq'],
				'testimonials' => ['testimonial', 'filters'],
				'casestudies'  => ['casestudy', 'filters'],
			];
			foreach ($block_part_deps as $block_name => $part_names) {
				if (in_array($block_name, $GLOBALS['cbo_used_blocks'])) {
					foreach ((array) $part_names as $part_name) {
						$part_css_file = $css_parts_path . $part_name . '.min.css';
						if (file_exists($part_css_file) && !wp_style_is('part-' . $part_name, 'enqueued')) {
							wp_enqueue_style('part-' . $part_name, $css_parts_url . $part_name . '.min.css', array(), filemtime($part_css_file));
						}
						$part_js_file = $js_parts_path . $part_name . '/script.js';
						if (file_exists($part_js_file) && !wp_script_is('part-' . $part_name, 'enqueued')) {
							wp_enqueue_script('part-' . $part_name, $js_parts_url . $part_name . '/script.js', array('jquery'), filemtime($part_js_file), true);
						}
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

	// Ajoute la classe "cbo-cms" au <body> de chaque iframe TinyMCE (WYSIWYG ACF)
	// et force le chargement de style.min.css via content_css (couvre les éditeurs ACF
	// Gutenberg initialisés en JS, où add_editor_style() seul ne suffit pas).
	function cbo_editor_body_class( $mce_init ) {
		$mce_init['body_class'] = trim( ( $mce_init['body_class'] ?? '' ) . ' cbo-cms' );

		$style_url = get_stylesheet_directory_uri() . '/library/css/style.min.css';
		if ( empty( $mce_init['content_css'] ) ) {
			$mce_init['content_css'] = $style_url;
		} elseif ( strpos( $mce_init['content_css'], 'style.min.css' ) === false ) {
			$mce_init['content_css'] .= ',' . $style_url;
		}

		return $mce_init;
	}
	add_filter( 'tiny_mce_before_init', 'cbo_editor_body_class' );

	// Vecteur secondaire : mce_css couvre les instances créées via mceAddEditor JS
	add_filter( 'mce_css', function( $stylesheets ) {
		$style_url = get_stylesheet_directory_uri() . '/library/css/style.min.css';
		if ( strpos( $stylesheets, 'style.min.css' ) === false ) {
			$stylesheets .= ( $stylesheets ? ',' : '' ) . $style_url;
		}
		return $stylesheets;
	} );


	/* ****************** */
	/* Chargement des styles des blocs et parts dans l'éditeur Gutenberg */
	function cbo_enqueue_block_editor_assets() {
		// Annule les marges/max-width WP core ajoutées via :where(.wp-block) (WP 6.x+)
		wp_register_style( 'cbo-editor-overrides', false );
		wp_enqueue_style( 'cbo-editor-overrides' );
		wp_add_inline_style( 'cbo-editor-overrides', '.wp-block { max-width: none; margin-top: 0; margin-bottom: 0; }' );

		// Blocs — un seul fichier concaténé
		$gutenberg_file = get_stylesheet_directory() . '/library/css/gutenberg.min.css';
		if ( file_exists( $gutenberg_file ) ) {
			wp_enqueue_style(
				'editor-blocks-gutenberg',
				get_stylesheet_directory_uri() . '/library/css/gutenberg.min.css',
				array(),
				filemtime( $gutenberg_file )
			);
		}

		// Parts
		$css_parts_path  = get_stylesheet_directory() . '/library/css/parts/';
		$css_parts_url   = get_stylesheet_directory_uri() . '/library/css/parts/';
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
	/* Un seul hero par page */
	/* Empêche d'insérer un second type de hero si un hero est déjà présent sur la page. */
	add_action( 'enqueue_block_editor_assets', function() {
		wp_add_inline_script( 'wp-blocks', '
(function() {
	var HERO_BLOCKS = ["acf/herosimple", "acf/heropicture", "acf/herorich"];
	var removing = false;

	wp.data.subscribe(function() {
		if (removing) return;

		var blocks = wp.data.select("core/block-editor").getBlocks();
		if (!blocks) return;

		var heroes = blocks.filter(function(b) {
			return HERO_BLOCKS.indexOf(b.name) !== -1;
		});

		if (heroes.length <= 1) return;

		removing = true;
		wp.data.dispatch("core/block-editor").removeBlock(heroes[heroes.length - 1].clientId);
		wp.data.dispatch("core/notices").createNotice(
			"error",
			"Un seul bloc hero est autorisé par page.",
			{ isDismissible: true, id: "cbo-hero-unique" }
		);
		setTimeout(function() { removing = false; }, 300);
	});
})();
		' );
	} );


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