<?php
defined( 'ABSPATH' ) || exit;

	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	add_action('get_header', 'remove_admin_login_header');

	// Hooks
	add_filter( 'upload_mimes', 'cbo_mime_types' );


	// Autoriser l'import des fichiers SVG et WEBP
	// SVG réservé aux administrateurs : un SVG peut embarquer du JavaScript (XSS)
	function cbo_mime_types( $mimes ){
		if ( current_user_can( 'manage_options' ) ) {
			$mimes['svg'] = 'image/svg+xml';
		}
		$mimes['webp'] = 'image/webp';
		return $mimes;
	}

	// Nettoyage du menu du back office - Items principaux
	add_action( 'admin_init', function () {
		remove_menu_page( 'tools.php' );
	});


	// Nettoyage de l'adminbar du back office - Items principaux
	function wps_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_node('comments');
	}
	add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );


	// Suppresion des sous-items Personnaliser et Compositions
	function wpc_force_remove_appearance_menus() {
		global $submenu;
		
		// Vérifie que le menu "Apparence" existe
		if (isset($submenu['themes.php'])) {
			foreach ($submenu['themes.php'] as $key => $menu_item) {
				// Supprimer "Personnaliser"
				if (strpos($menu_item[2], 'customize.php') !== false) {
					unset($submenu['themes.php'][$key]);
				}
				// Supprimer "Éditeur de site"
				if (strpos($menu_item[2], 'site-editor.php') !== false) {
					unset($submenu['themes.php'][$key]);
				}
			}
		}
	}
	add_action('admin_menu', 'wpc_force_remove_appearance_menus', 999);


	/* Logo sur la page de connexion */
	add_action('login_enqueue_scripts', function() {
		$logo_url = esc_url(get_stylesheet_directory_uri() . '/library/images/logo-speedernet-bo.png');
		echo '<style>
			#login h1 a, .login h1 a {
				background-image: url(' . $logo_url . ');
				background-size: contain;
				background-repeat: no-repeat;
				background-position: center;
				width: 84px;
				height: 84px;
			}
		</style>';
	});
	add_filter('login_headerurl',  fn() => home_url());
	add_filter('login_headertext', fn() => get_bloginfo('name'));


	/* Pied de page administration */
	function remove_footer_admin () {
		echo 'Proudly handcrafted by <a href="https://julien-brochard.fr/" target="_blank"><i class="icon icon--logo-jb"></i> Julien B</a>';
	}
	add_filter('admin_footer_text', 'remove_footer_admin');


	/* ************************* */
	// Désactivation complète des commentaires, pings et trackbacks
	// (les robots postent directement sur wp-comments-post.php, XML-RPC ou l'API REST)
	/* ************************* */
	// Fermeture des commentaires et pings sur tous les contenus
	add_filter('comments_open', '__return_false', 20);
	add_filter('pings_open', '__return_false', 20);

	// Masque les commentaires existants en front
	add_filter('comments_array', '__return_empty_array', 10);

	// Retire le support des commentaires et trackbacks de tous les types de contenu
	add_action('init', function() {
		foreach (get_post_types() as $post_type) {
			if (post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}, 100);

	// Bloque l'accès direct au script d'envoi de commentaire
	add_action('pre_comment_on_post', function() {
		wp_die('Les commentaires sont désactivés.', '', ['response' => 403]);
	});

	// XML-RPC : désactivation complète (évite le brute-force via system.multicall)
	add_filter('xmlrpc_enabled', '__return_false');
	add_filter('xmlrpc_methods', '__return_empty_array');
	add_filter('wp_headers', function($headers) {
		unset($headers['X-Pingback']);
		return $headers;
	});

	// API REST : suppression des routes de commentaires
	add_filter('rest_endpoints', function($endpoints) {
		unset($endpoints['/wp/v2/comments'], $endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
		return $endpoints;
	});


	/* ************************* */
	// Anti-énumération des identifiants de connexion
	/* ************************* */
	// API REST : routes utilisateurs réservées aux connectés (Gutenberg en a besoin)
	add_filter('rest_endpoints', function($endpoints) {
		if (!is_user_logged_in()) {
			unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
		}
		return $endpoints;
	});

	// ?author=1 et archives auteur (/author/identifiant/) redirigés vers l'accueil
	// Priorité 1 : avant redirect_canonical qui révèlerait l'identifiant dans l'URL
	add_action('template_redirect', function() {
		if (is_author() || isset($_GET['author'])) {
			wp_safe_redirect(home_url('/'), 301);
			exit;
		}
	}, 1);


?>