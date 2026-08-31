<?php
    if( function_exists('acf_register_block_type') ):

        function cbo_render_glossaire_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
            $has_content = get_field('glossaire_content');

            if ( $is_preview && ! $has_content ) {
                echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/library/images/previews/glossaire.jpg' ) . '" alt="" style="display:block;width:100%;height:auto;">';
                return;
            }

            include get_stylesheet_directory() . '/templates/blocks/glossaire/template.php';
        }

        acf_register_block_type(array(
            'name'            => 'glossaire',
            'api_version'       => 3,
            'acf_block_version' => 3,
            'auto_inline_editing' => false,
            'title'           => 'Glossaire',
            'description'     => 'Affichage d\'un glossaire',
            'category'        => 'text',
            'keywords'        => array('glossaire', 'lexique', 'définitions'),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_callback' => 'cbo_render_glossaire_block',
            'enqueue_assets'  => function() {
                if (is_admin()) {
                    wp_enqueue_style('acf-block-style', get_template_directory_uri() . '/library/css/style.min.css');
                }
            },
            'icon'    => 'book',
            'supports' => array(
                'align'         => false,
                'mode'          => false,
                'multiple'      => false,
                'jsx'           => false,
                'align_content' => false,
                'anchor'        => true,
            ),
            'example' => [
                'attributes' => [
                    'mode' => 'preview',
                ]
            ]
        ));
    endif;
?>
