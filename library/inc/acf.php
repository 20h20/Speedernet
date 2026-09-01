<?php
	add_action( 'acf/init', function() {
		require get_template_directory() . '/templates/blocks/articles/block.php';
		require get_template_directory() . '/templates/blocks/accordion/block.php';
		require get_template_directory() . '/templates/blocks/cta/block.php';
		require get_template_directory() . '/templates/blocks/glossaire/block.php';
		require get_template_directory() . '/templates/blocks/price/block.php';
		require get_template_directory() . '/templates/blocks/solutions/block.php';
		require get_template_directory() . '/templates/blocks/blocs/block.php';
		require get_template_directory() . '/templates/blocks/blocsrich/block.php';
		require get_template_directory() . '/templates/blocks/cardslider/block.php';
		require get_template_directory() . '/templates/blocks/casestudies/block.php';
		require get_template_directory() . '/templates/blocks/faqs/block.php';
		require get_template_directory() . '/templates/blocks/gallery/block.php';
		require get_template_directory() . '/templates/blocks/herorich/block.php';
		require get_template_directory() . '/templates/blocks/heropicture/block.php';
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
		require get_template_directory() . '/templates/blocks/videoambiant/block.php';
		require get_template_directory() . '/templates/blocks/video/block.php';
		require get_template_directory() . '/templates/blocks/webinaires/block.php';
		require get_template_directory() . '/templates/blocks/contact/block.php';
	} );

	function allow_only_custom_blocks( $allowed_blocks, $editor_context ) {
		return array(
			'acf/articles',
			'acf/accordion',
			'acf/cta',
			'acf/glossaire',
			'acf/price',
			'acf/solutions',
			'acf/blocs',
			'acf/blocsrich',
			'acf/cardslider',
			'acf/casestudies',
			'acf/faqs',
			'acf/gallery',
			'acf/herorich',
			'acf/herosimple',
			'acf/heropicture',
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
			'acf/videoambiant',
			'acf/video',
			'acf/webinaires',
			'acf/contact',
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

	/* ****************** */
	/* Ancre HTML des blocs ACF */
	/* Tous les blocs déclarent 'supports.anchor' => true, mais comme ils utilisent un
	   render_callback (HTML brut, pas de save() géré par WP), WordPress n'ajoute jamais
	   automatiquement l'id="..." correspondant sur la balise de sortie — seuls 2 des 29
	   blocs le font eux-mêmes "à la main" dans leur template.php (glossaire, faqs).
	   Ce filtre injecte l'ancre sur la première balise du HTML rendu, pour tous les
	   autres, sans avoir à modifier chaque template individuellement. */
	function cbo_inject_block_anchor( $block_content, $block ) {
		if ( empty( $block['attrs']['anchor'] ) || strpos( (string) $block['blockName'], 'acf/' ) !== 0 ) {
			return $block_content;
		}

		$anchor = $block['attrs']['anchor'];

		// Déjà présent (ex : glossaire, faqs qui gèrent leur ancre eux-mêmes) : on ne double pas.
		if ( strpos( $block_content, 'id="' . esc_attr( $anchor ) . '"' ) !== false ) {
			return $block_content;
		}

		return preg_replace( '/^(\s*<[a-zA-Z0-9]+)/', '$1 id="' . esc_attr( $anchor ) . '"', $block_content, 1 );
	}
	add_filter( 'render_block', 'cbo_inject_block_anchor', 10, 2 );

?>