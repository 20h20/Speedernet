<?php
	if( function_exists('acf_register_block_type') ):
		acf_register_block_type(array(
			'name'            => 'glossaire',
			'title'           => 'Glossaire',
			'description'     => 'Liste alphabétique de tous les termes du glossaire.',
			'category'        => 'text',
			'keywords'        => array('glossaire', 'lexique', 'définitions'),
			'post_types'      => array(),
			'mode'            => 'auto',
			'align'           => '',
			'render_template' => 'templates/blocks/glossaire/template.php',
			'icon'            => 'book-alt',
			'supports'        => array(
				'align'         => false,
				'mode'          => false,
				'multiple'      => false,
				'jsx'           => false,
				'align_content' => false,
				'anchor'        => true,
			),
		));
	endif;
?>
