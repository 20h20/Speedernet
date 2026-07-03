<?php
    if( function_exists('acf_register_block_type') ):
        acf_register_block_type(array(
            'name'            => 'price',
            'title'           => 'Tarification',
            'description'     => 'Bloc de tarification avec deux offres (standard et featured).',
            'category'        => 'text',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_template' => 'templates/blocks/price/template.php',
            'icon'            => 'tag',
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
