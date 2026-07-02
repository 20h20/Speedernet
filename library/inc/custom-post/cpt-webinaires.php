<?php
	function cbo_webinaires() {
		register_post_type( 'webinaires',
		array( 'labels' => array(
			'name' => __( 'Webinaires', 'bonestheme' ),
			'singular_name' => __( 'Webinaire', 'bonestheme' ),
			'all_items' => __( 'Tous les webinaires', 'bonestheme' ),
			'add_new' => __( 'Ajouter', 'bonestheme' ),
			'add_new_item' => __( 'Ajouter un webinaire', 'bonestheme' ),
			'edit' => __( 'Modifier', 'bonestheme' ),
			'edit_item' => __( 'Modifier un webinaire', 'bonestheme' ),
			'new_item' => __( 'Nouveau webinaire', 'bonestheme' ),
			'view_item' => __( 'Voir le webinaire', 'bonestheme' ),
			'search_items' => __( 'Rechercher', 'bonestheme' ),
			'not_found' =>  __( 'Aucun webinaire trouvé.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Aucun webinaire dans la corbeille', 'bonestheme' ),
			'parent_item_colon' => ''
		),
		'description' => __( 'Webinaires Speedernet', 'bonestheme' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 4,
		'menu_icon' => 'dashicons-video-alt2',
		'rewrite'	=> array( 'slug' => 'webinaire', 'with_front' => true ),
		'has_archive' => 'nos-webinaires',
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_rest' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'),
	));

	register_taxonomy( 'webinaires_cat',
		array('webinaires'),
		array('hierarchical' => true,
			'labels' => array(
				'name' => __( 'Catégories des webinaires', 'bonestheme' ),
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
			'show_in_rest' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'horizons-learning' ),
		)
	);
}
	add_action( 'init', 'cbo_webinaires');



?>
