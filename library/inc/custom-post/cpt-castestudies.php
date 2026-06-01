<?php
	function cbo_casestudies() { 
		register_post_type( 'casestudies',
		array( 'labels' => array(
			'name' => __( 'Études de cas', 'bonestheme' ),
			'singular_name' => __( 'Étude de cas', 'bonestheme' ),
			'all_items' => __( 'Toutes les études de cas', 'bonestheme' ), 
			'add_new' => __( 'Ajouter', 'bonestheme' ), 
			'add_new_item' => __( 'Ajouter une étude de cas', 'bonestheme' ),
			'edit' => __( 'Modifier', 'bonestheme' ),
			'edit_item' => __( 'Modifier une étude de cas', 'bonestheme' ),
			'new_item' => __( 'Nouvelle étude de cas', 'bonestheme' ),
			'view_item' => __( 'Voir l\'étude de cas', 'bonestheme' ),
			'search_items' => __( 'Rechercher', 'bonestheme' ),
			'not_found' =>  __( 'Aucune étude de cas trouvée.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Aucune étude de cas dans la corbeille', 'bonestheme' ),
			'parent_item_colon' => ''
		),
		'description' => __( 'Ceci est une étude de cas d\'exemple', 'bonestheme' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 3, 
		'menu_icon' => 'dashicons-groups',
		'rewrite'	=> array( 'slug' => 'etude-de-cas', 'with_front'   => true ), // slug du single
		'has_archive' => 'nos-etudes-de-cas', // slug de la page d'archive
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_rest' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'), 
	)); }
	add_action( 'init', 'cbo_casestudies');

	register_taxonomy( 'casestudies_cat', 
		array('casestudies'),
		array('hierarchical' => true,
			'labels' => array(
				'name' => __( 'Catégories des études de cas', 'bonestheme' ),
				'singular_name' => __( 'Catégorie', 'bonestheme' ),
				'search_items' =>  __( 'Rechercher', 'bonestheme' ),
				'all_items' => __( 'Toutes les catégories', 'bonestheme' ),
				'parent_item' => __( 'Catégories parentes', 'bonestheme' ),
				'parent_item_colon' => __( 'Catégorie parente', 'bonestheme' ),
				'edit_item' => __( 'Modifier la catégorie', 'bonestheme' ),
				'update_item' => __( 'Mettre à jour', 'bonestheme' ),
				'add_new_item' => __( 'Ajouter', 'bonestheme' ),
				'new_item_name' => __( 'Nouveau nom', 'bonestheme' )
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'nos-etudes-de-cas' ),
		)
	);
?>