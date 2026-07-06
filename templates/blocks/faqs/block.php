<?php
    if( function_exists('acf_register_block_type') ):
        acf_register_block_type(array(
            'name'            => 'faqs',
            'title'           => 'Questions fréquentes',
            'description'     => 'Liste des questions fréquentes par catégorie avec sidebar de navigation.',
            'category'        => 'text',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_template' => 'templates/blocks/faqs/template.php',
            'icon'            => 'editor-help',
            'supports'        => array(
                'align'         => false,
                'mode'          => false,
                'multiple'      => false,
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
