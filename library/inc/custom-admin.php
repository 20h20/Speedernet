<?php

	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	add_action('get_header', 'remove_admin_login_header');

	// Hooks
	add_filter( 'upload_mimes', 'cbo_mime_types' );
	add_filter( 'wp_check_filetype_and_ext', 'cbo_file_types', 10, 4 );


	// Autoriser l'import des fichiers SVG et WEBP
	function cbo_mime_types( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		$mimes['webp'] = 'image/webp';
		return $mimes;
	}

	// Contrôle de l'import d'un WEBP
	function cbo_file_types( $types, $file, $filename, $mimes ) {
		if ( false !== strpos( $filename, '.webp' ) ) {
			$types['ext'] = 'webp';
			$types['type'] = 'image/webp';
		}
		return $types;
	}

	// Nettoyage du menu du back office - Items principaux
	add_action( 'admin_init', function () {
		remove_menu_page( 'edit-comments.php' );
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


	// Suppression des widgets du Dashboard
	function remove_dashboard_meta() {
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
		remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
		remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
		remove_meta_box('wordfence_activity_report_widget', 'dashboard', 'normal'); //Removes the 'Wordfence plugin' widget 
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
	}
	add_action('admin_init', 'remove_dashboard_meta'); 
	

	// Redirection de la page des commentaires
	function wpc_redirect_comments_page() {
		global $pagenow;
		
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url('index.php'));
			exit;
		}
	}
	add_action('admin_init', 'wpc_redirect_comments_page');
	
?>