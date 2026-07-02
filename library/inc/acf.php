<?php
	add_action( 'acf/init', function() {
		require get_template_directory() . '/templates/blocks/articles/block.php';
		require get_template_directory() . '/templates/blocks/accordion/block.php';
		require get_template_directory() . '/templates/blocks/blocs/block.php';
		require get_template_directory() . '/templates/blocks/blocsrich/block.php';
		require get_template_directory() . '/templates/blocks/cardslider/block.php';
		require get_template_directory() . '/templates/blocks/casestudies/block.php';
		require get_template_directory() . '/templates/blocks/gallery/block.php';
		require get_template_directory() . '/templates/blocks/herorich/block.php';
		require get_template_directory() . '/templates/blocks/herosimple/block.php';
		require get_template_directory() . '/templates/blocks/jobslider/block.php';
		require get_template_directory() . '/templates/blocks/keynumbers/block.php';
		require get_template_directory() . '/templates/blocks/partners/block.php';
		require get_template_directory() . '/templates/blocks/team/block.php';
		require get_template_directory() . '/templates/blocks/testimonial/block.php';
		require get_template_directory() . '/templates/blocks/testimonials/block.php';
		require get_template_directory() . '/templates/blocks/text/block.php';
		require get_template_directory() . '/templates/blocks/textpicture/block.php';
		require get_template_directory() . '/templates/blocks/textpictureaccordion/block.php';
		require get_template_directory() . '/templates/blocks/textpictureslide/block.php';
		require get_template_directory() . '/templates/blocks/video/block.php';
		require get_template_directory() . '/templates/blocks/webinaires/block.php';
	} );

	function allow_only_custom_blocks( $allowed_blocks, $editor_context ) {
		return array(
			'acf/articles',
			'acf/accordion',
			'acf/blocs',
			'acf/blocsrich',
			'acf/cardslider',
			'acf/casestudies',
			'acf/gallery',
			'acf/herorich',
			'acf/herosimple',
			'acf/jobslider',
			'acf/keynumbers',
			'acf/partners',
			'acf/team',
			'acf/testimonial',
			'acf/testimonials',
			'acf/text',
			'acf/textpicture',
			'acf/textpictureaccordion',
			'acf/textpictureslide',
			'acf/video',
			'acf/webinaires',
		);
	}
	add_filter( 'allowed_block_types_all', 'allow_only_custom_blocks', 10, 2 );

	/* ************************* */
	/* ADD NEW CATEGORIES INTO ACF BLOCK REGISTER */
	/* ************************* */
	function add_custom_block_categories($categories) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'text',
					'title' => __('Texte'),
					'icon'  => null,
				),
				array(
					'slug'  => 'blocs',
					'title' => __('Liste de blocs'),
					'icon'  => null,
				),
				array(
					'slug'  => 'hero',
					'title' => __('En-tête'),
					'icon'  => null,
				),
				array(
					'slug'  => 'media',
					'title' => __('Médias'),
					'icon'  => null,
				),
				array(
					'slug'  => 'relationship',
					'title' => __('Relationel'),
					'icon'  => null,
				),
			)
		);
	}
	add_filter('block_categories_all', 'add_custom_block_categories');

?>