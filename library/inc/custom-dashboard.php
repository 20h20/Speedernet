<?php
	// Ordre des widgets dans le dashboard
	add_action('wp_dashboard_setup', 'set_dashboard_widget_order', 100);
	function set_dashboard_widget_order() {
		global $wp_meta_boxes;
		$wp_meta_boxes['dashboard']['normal']['core'] = array(
			'welcome_dashboard'      => array('id' => 'welcome_dashboard',      'title' => 'Bienvenue',                'callback' => 'display_welcome_message',                          'args' => array()),
			'google_sheet_dashboard' => array('id' => 'google_sheet_dashboard', 'title' => 'Suivi de maintenance',    'callback' => 'display_google_sheet_data',                        'args' => array()),
			'custom_git_commits'     => array('id' => 'custom_git_commits',     'title' => 'Modifications récentes',  'callback' => 'render_custom_git_commits_dashboard_widget',        'args' => array()),
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
					<a href="' . $new_post . '" class="wb-btn wb-btn--ghost">Nouvel article</a>
				</div>
			</div>
			<div class="wb-deco" aria-hidden="true">
				<img src="' . $logo_url . '" alt="">
			</div>
		</div>';
	}







	

	/* ───────────────────────────────────────────
	   DONNÉES GOOGLE SHEET (Time tracking)
	─────────────────────────────────────────── */
	// Données Google Sheet (Time tracking)
	function get_google_sheet_json() {
		$url = '#';
		$response = wp_remote_get($url);

		if (is_wp_error($response)) return null;

		$json = wp_remote_retrieve_body($response);
		$json = str_replace(["/*O_o*/", "google.visualization.Query.setResponse("], '', $json);
		$json = substr($json, 0, -2);

		return json_decode($json, true);
	}

	function add_google_sheet_dashboard_widget() {
		$year = date('Y');
		wp_add_dashboard_widget(
			'google_sheet_dashboard',
			"Récapitulatif du temps passé sur le site en $year",
			'display_google_sheet_data'
		);
	}	
	add_action('wp_dashboard_setup', 'add_google_sheet_dashboard_widget');

	function display_google_sheet_data() {
		$data = get_google_sheet_json();
	
		if (!$data || !isset($data['table']['rows'])) {
			echo '<div class="cbo-bo-timesheet-none">Pas de maintenance en cours sur le site.</div>';
			return;
		}
		$totals = [];
		echo '<table><thead><tr>
				<th>Date</th>
				<th>Tâche effectuée</th>
				<th>Temps passé</th>
				<th>Prix</th>
				<th>Facturé</th>
			</tr></thead><tbody>';

		foreach ($data['table']['rows'] as $row) {
			$date   = isset($row['c'][0]['v']) ? esc_html($row['c'][0]['v']) : '-';
			$task   = isset($row['c'][1]['v']) ? esc_html($row['c'][1]['v']) : '-';
			$time   = isset($row['c'][2]['v']) ? esc_html($row['c'][2]['v']) : '-';
			$price  = isset($row['c'][3]['v']) ? esc_html($row['c'][3]['v']) : '-';
			$billed = isset($row['c'][4]['v']) ? esc_html($row['c'][4]['v']) : '-';
	
			if ($date === '-' || stripos($date, 'Total') !== false) {
				$totals[] = ['date' => $date, 'time' => $time, 'price' => $price];
				continue;
			}

			$billed_class = strtolower($billed) === 'oui' ? 'billed--ok' : 'billed--nonok';

			echo "<tr>
				<td>{$date}</td>
				<td>{$task}</td>
				<td>{$time}</td>
				<td>{$price} €</td>
				<td><span class='billed {$billed_class}'>{$billed}</span></td>
			</tr>";
		}

		echo '</tbody>';

		if (!empty($totals)) {
			echo '<tfoot>';
			foreach ($totals as $total) {
				$time_text = ($total['time'] !== '-' && !empty($total['time'])) ? esc_html($total['time']) . ' jour' : '';
				echo "<tr>
					<td>" . esc_html($total['date']) . "</td>
					<td>{$time_text}</td>
					<td>" . esc_html($total['price']) . " €</td>
				</tr>";
			}
			echo '</tfoot>';
		}
		echo '</table>';
	}













	/* ───────────────────────────────────────────
	   WIDGET GIT
	─────────────────────────────────────────── */
	function render_custom_git_commits_dashboard_widget() {
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