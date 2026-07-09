<?php
	function cbo_glossaire() {
		register_post_type('glossaire',
			array(
				'labels' => array(
					'name'               => __('Glossaire', 'bonestheme'),
					'singular_name'      => __('Terme', 'bonestheme'),
					'all_items'          => __('Tous les termes', 'bonestheme'),
					'add_new'            => __('Ajouter', 'bonestheme'),
					'add_new_item'       => __('Ajouter un terme', 'bonestheme'),
					'edit_item'          => __('Modifier le terme', 'bonestheme'),
					'new_item'           => __('Nouveau terme', 'bonestheme'),
					'view_item'          => __('Voir le terme', 'bonestheme'),
					'search_items'       => __('Rechercher', 'bonestheme'),
					'not_found'          => __('Aucun terme trouvé.', 'bonestheme'),
					'not_found_in_trash' => __('Aucun terme dans la corbeille', 'bonestheme'),
				),
				'public'              => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'show_ui'             => true,
				'show_in_rest'        => false,
				'query_var'           => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-book-alt',
				'rewrite'             => array('slug' => 'glossaire', 'with_front' => false),
				'has_archive'         => 'glossaire',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array('title', 'editor', 'excerpt'),
			)
		);
	}
	add_action('init', 'cbo_glossaire');

	register_taxonomy('glossaire_domaine',
		array('glossaire'),
		array(
			'hierarchical'      => false,
			'labels'            => array(
				'name'          => __('Domaines', 'bonestheme'),
				'singular_name' => __('Domaine', 'bonestheme'),
				'search_items'  => __('Rechercher', 'bonestheme'),
				'all_items'     => __('Tous les domaines', 'bonestheme'),
				'edit_item'     => __('Modifier', 'bonestheme'),
				'update_item'   => __('Mettre à jour', 'bonestheme'),
				'add_new_item'  => __('Ajouter un domaine', 'bonestheme'),
				'new_item_name' => __('Nouveau domaine', 'bonestheme'),
			),
			'show_admin_column' => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'glossaire/domaine'),
		)
	);

	register_taxonomy('glossaire_lettre',
		array('glossaire'),
		array(
			'hierarchical'      => false,
			'labels'            => array(
				'name'          => __('Lettres', 'bonestheme'),
				'singular_name' => __('Lettre', 'bonestheme'),
				'search_items'  => __('Rechercher', 'bonestheme'),
				'all_items'     => __('Toutes les lettres', 'bonestheme'),
				'edit_item'     => __('Modifier', 'bonestheme'),
				'update_item'   => __('Mettre à jour', 'bonestheme'),
				'add_new_item'  => __('Ajouter une lettre', 'bonestheme'),
				'new_item_name' => __('Nouvelle lettre', 'bonestheme'),
			),
			'show_admin_column' => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'glossaire/lettre'),
		)
	);
?>