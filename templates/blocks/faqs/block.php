<?php
    if( function_exists('acf_register_block_type') ):

        function cbo_render_faqs_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
            $has_content = get_field('block_faqs_sidebartitle');

            if ( $is_preview && ! $has_content ) {
                echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/library/images/previews/faqs.jpg' ) . '" alt="" style="display:block;width:100%;height:auto;">';
                return;
            }

            include get_stylesheet_directory() . '/templates/blocks/faqs/template.php';
        }

        acf_register_block_type(array(
            'name'            => 'faqs',
            'api_version'       => 3,
            'acf_block_version' => 3,
            'auto_inline_editing' => false,
            'title'           => 'Questions fréquentes',
            'description'     => 'Liste des questions fréquentes par catégorie avec sidebar de navigation.',
            'category'        => 'text',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_callback' => 'cbo_render_faqs_block',
            'enqueue_assets'  => function() {
                if (is_admin()) {
                    wp_enqueue_style('acf-block-style', get_template_directory_uri() . '/library/css/style.min.css');
                }
            },
            'icon'    => 'editor-help',
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
