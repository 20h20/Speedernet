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
		'show_in_rest' => false,
		'supports' => array( 'title', 'editor'),
	));
}
add_action( 'init', 'cbo_webinaires');

?>
