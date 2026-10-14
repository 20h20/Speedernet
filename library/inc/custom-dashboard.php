<?php
defined( 'ABSPATH' ) || exit;
	// Ordre des widgets dans le dashboard
	add_action('wp_dashboard_setup', 'set_dashboard_widget_order', 100);
	function set_dashboard_widget_order() {
		global $wp_meta_boxes;
		$wp_meta_boxes['dashboard']['normal']['core'] = array(
			'welcome_dashboard'      => array('id' => 'welcome_dashboard',      'title' => 'Bienvenue',                'callback' => 'display_welcome_message',                          'args' => array()),
		);
		if (current_user_can('manage_options')) {
			$wp_meta_boxes['dashboard']['normal']['core']['custom_git_commits']     = array('id' => 'custom_git_commits',     'title' => 'Modifications récentes', 'callback' => 'render_custom_git_commits_dashboard_widget', 'args' => array());
		}
	}

	// Ordre imposé : Bienvenue, puis Suivi du projet (MU-plugin project-hub-widget, ajouté après ce fichier) et Modifications récentes.
	// Ignore l'ordre éventuellement enregistré par l'utilisateur, puisque le layout est verrouillé. Largeurs : _dashboard.scss.
	add_filter('get_user_option_meta-box-order_dashboard', 'set_dashboard_columns_order');
	function set_dashboard_columns_order() {
		return array(
			'normal'  => 'welcome_dashboard,project_hub_widget,custom_git_commits',
			'side'    => '',
			'column3' => '',
			'column4' => '',
		);
	}


	// Verrouillage du layout du dashboard
	add_action('admin_head-index.php', 'lock_dashboard_layout');
	function lock_dashboard_layout() {
		if (current_user_can('edit_dashboard')) {
			echo '<style>
				#dashboard-widgets .postbox-container { min-height: 0 !important; }
				.postbox .handlediv, .postbox h2.hndle { cursor: default !important; }
				.postbox .hndle { pointer-events: none; }
				.postbox .handle-actions, #screen-options-link, #screen-options-wrap { display: none !important; }
			</style>';
		}
	}


	/* ───────────────────────────────────────────
	   WELCOME WIDGET
	─────────────────────────────────────────── */
	function display_welcome_message() {
		$current_user = wp_get_current_user();
		$first_name   = $current_user->user_firstname ?: esc_html($current_user->display_name);

		$jours  = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
		$mois   = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
		$date   = $jours[date('w')] . ' ' . date('j') . ' ' . $mois[(int)date('n') - 1] . ' ' . date('Y');

		$logo_url = esc_url(get_stylesheet_directory_uri() . '/library/images/logo-speedernet-bo.png');
		$site_url = esc_url(home_url('/'));
		$new_post = esc_url(admin_url('post-new.php'));

		echo '
		<div class="wb-banner">
			<div class="wb-content">
				<span class="wb-date">' . esc_html($date) . '</span>
				<strong class="wb-hello">Bonjour ' . esc_html($first_name) . ',<br>content de vous revoir.</strong>
				<div class="wb-actions">
					<a href="' . $site_url . '" target="_blank" rel="noopener noreferrer" class="wb-btn wb-btn--light">Voir le site <span aria-hidden="true">↗</span></a>
					<a href="https://espace-client.julien-brochard.fr/wp-admin/" class="wb-btn wb-btn--ghost" target="_blank" rel="noopener noreferrer">Gestion du site</a>
				</div>
			</div>
			<div class="wb-deco" aria-hidden="true">
				<img src="' . $logo_url . '" alt="">
			</div>
		</div>';
	}


	/* ───────────────────────────────────────────
	   WIDGET GIT
	─────────────────────────────────────────── */
	function render_custom_git_commits_dashboard_widget() {
		if (!current_user_can('manage_options')) return;
		$api_url = 'https://api.github.com/repos/20h20/Speedernet/commits?sha=develop&per_page=5';

		if (!defined('GITHUB_TOKEN')) {
			echo '<p>Token GitHub non défini.</p>';
			return;
		}
		$response = wp_remote_get($api_url, [
			'headers' => [
				'User-Agent'    => 'WordPress-GitHub-Dashboard',
				'Authorization' => 'token ' . GITHUB_TOKEN,
				'Accept'        => 'application/vnd.github+json',
				'X-GitHub-Api-Version' => '2022-11-28',
			],
		]);
		if (is_wp_error($response)) {
			echo '<p>Erreur lors de la récupération des commits.</p>';
			return;
		}
		$code = wp_remote_retrieve_response_code($response);
		if ($code !== 200) {
			$error_body = json_decode(wp_remote_retrieve_body($response), true);
			$error_msg = isset($error_body['message']) ? $error_body['message'] : 'Inconnue';
			echo '<p>Erreur HTTP ' . esc_html($code) . ' : ' . esc_html($error_msg) . '</p>';
			return;
		}
		$body = wp_remote_retrieve_body($response);
		$commits = json_decode($body, true);

		if (!is_array($commits)) {
			echo '<p>Erreur dans les données du commit.</p>';
			return;
		}
		echo '<ul class="git-list">';
		foreach (array_slice($commits, 0, 5) as $commit) {
			if (!isset($commit['sha'], $commit['commit']['message'], $commit['commit']['author']['date'])) {
				continue;
			}
			$sha = substr($commit['sha'], 0, 7);
			$message = $commit['commit']['message'];
			$date = date('d/m/Y H:i', strtotime($commit['commit']['author']['date']));
			$url = $commit['html_url'];
			echo '<li class="list-el">';
			echo '<em class="el-date">Le ' . esc_html($date) . '</em>';
			echo '<span class="el-infos"><code>' . esc_html($sha) . '</code> <strong class="el-title">' . esc_html($message) . '</strong></span><br>';
			echo '</li>';
		}
		echo '</ul>';
	}
?>