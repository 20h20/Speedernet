<?php
	function cbo_faq() { 
		register_post_type( 'faq',
		array( 'labels' => array(
			'name' => __( 'FAQ', 'bonestheme' ),
			'singular_name' => __( 'Question Fréquente', 'bonestheme' ),
			'all_items' => __( 'Toutes les questions fréquentes', 'bonestheme' ), 
			'add_new' => __( 'Ajouter', 'bonestheme' ), 
			'add_new_item' => __( 'Ajouter une question fréquente', 'bonestheme' ),
			'edit' => __( 'Modifier', 'bonestheme' ),
			'edit_item' => __( 'Modifier une question fréquente', 'bonestheme' ),
			'new_item' => __( 'Nouvelle question fréquente', 'bonestheme' ),
			'view_item' => __( 'Voir la question fréquente', 'bonestheme' ),
			'search_items' => __( 'Rechercher', 'bonestheme' ),
			'not_found' =>  __( 'Aucune question fréquente trouvée.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Aucune question fréquente dans la corbeille', 'bonestheme' ),
			'parent_item_colon' => ''
		),
		'description' => __( 'Ceci est une question fréquente d\'exemple', 'bonestheme' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 3, 
		'menu_icon' => 'dashicons-welcome-learn-more',
		'rewrite'	=> array( 'slug' => 'faq', 'with_front'   => true ), // slug du single
		'has_archive' => 'nos-faqs', // slug de la page d'archive
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_rest' => false,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'), 
	)); }
	add_action( 'init', 'cbo_faq');

	register_taxonomy( 'faq_cat', 
		array('faq'),
		array('hierarchical' => true,
			'labels' => array(
				'name' => __( 'Catégories des questions fréquentes', 'bonestheme' ),
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
			'rewrite' => array( 'slug' => 'nos-faqs' ),
		)
	);
?>