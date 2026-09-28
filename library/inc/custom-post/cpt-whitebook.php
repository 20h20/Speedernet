<?php
	function cbo_whitebook() {
		register_post_type( 'whitebook',
		array( 'labels' => array(
			'name' => __( 'Livres blancs', 'bonestheme' ),
			'singular_name' => __( 'Livre blanc', 'bonestheme' ),
			'all_items' => __( 'Tous les livres blancs', 'bonestheme' ),
			'add_new' => __( 'Ajouter', 'bonestheme' ),
			'add_new_item' => __( 'Ajouter un livre blanc', 'bonestheme' ),
			'edit' => __( 'Modifier', 'bonestheme' ),
			'edit_item' => __( 'Modifier un livre blanc', 'bonestheme' ),
			'new_item' => __( 'Nouveau livre blanc', 'bonestheme' ),
			'view_item' => __( 'Voir le livre blanc', 'bonestheme' ),
			'search_items' => __( 'Rechercher', 'bonestheme' ),
			'not_found' =>  __( 'Aucun livre blanc trouvé.', 'bonestheme' ),
			'not_found_in_trash' => __( 'Aucun livre blanc dans la corbeille', 'bonestheme' ),
			'parent_item_colon' => ''
		),
		'description' => __( 'Livres blancs Speedernet', 'bonestheme' ),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'query_var' => true,
		'menu_position' => 4,
		'menu_icon' => 'dashicons-pdf',
		'rewrite'	=> array( 'slug' => 'livre-blanc', 'with_front' => true ),
		'has_archive' => 'nos-livres-blancs',
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_rest' => false,
		'supports' => array( 'title', 'editor'),
	));
}
add_action( 'init', 'cbo_whitebook');

?>