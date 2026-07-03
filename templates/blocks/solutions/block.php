<?php
    if( function_exists('acf_register_block_type') ):
        acf_register_block_type(array(
            'name'            => 'solutions',
            'title'           => 'Solutions',
            'description'     => 'Grille de solutions avec picto, numéro, titre et description.',
            'category'        => 'text',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_template' => 'templates/blocks/solutions/template.php',
            'icon'            => 'lightbulb',
            'supports'        => array(
                'align'         => false,
                'mode'          => false,
                'multiple'      => true,
                'jsx'           => false,
                'align_content' => false,
                'anchor'        => true,
            ),
            'example'         => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => ['preview_image' => true],
                ]
            ]
        ));
    endif;
?>
