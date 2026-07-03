<?php
    if( function_exists('acf_register_block_type') ):
        acf_register_block_type(array(
            'name'          => 'cta',
            'title'         => 'Appel à l\'action',
            'description'   => 'Bloc CTA avec titre, bouton et picto.',
            'category'      => 'text',
            'keywords'      => array(),
            'post_types'    => array(),
            'mode'          => 'auto',
            'align'         => '',
            'render_template' => 'templates/blocks/cta/template.php',
            'icon'          => 'megaphone',
            'supports'      => array(
                'align'         => false,
                'mode'          => false,
                'multiple'      => true,
                'jsx'           => false,
                'align_content' => false,
                'anchor'        => true,
            ),
            'example'       => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => ['preview_image' => true],
                ]
            ]
        ));
    endif;
?>
