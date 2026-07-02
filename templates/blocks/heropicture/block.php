<?php
    if( function_exists('acf_register_block_type') ):
        acf_register_block_type(array(
            'name'          => 'heropicture',
            'title'         => 'Hero avec image',
            'description'   => 'En-tête de page avec un titre, un chapeau et trois images.',
            'category'      => 'hero',
            'keywords'      => array(),
            'post_types'    => array(),
            'mode'          => 'auto',
            'align'         => '',
            'render_template' => 'templates/blocks/heropicture/template.php',
            'icon'          => 'format-image',
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
