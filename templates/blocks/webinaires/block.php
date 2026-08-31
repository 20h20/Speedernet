<?php
    if( function_exists('acf_register_block_type') ):

        function cbo_render_webinaires_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
            $has_content = get_field('webinaires_title');

            if ( $is_preview && ! $has_content ) {
                echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/library/images/previews/preview.svg' ) . '" alt="" style="display:block;width:100%;height:auto;">';
                return;
            }

            include get_stylesheet_directory() . '/templates/blocks/webinaires/template.php';
        }

        acf_register_block_type(array(
            'name'            => 'webinaires',
            'api_version'       => 3,
            'acf_block_version' => 3,
            'title'           => 'Liste de webinaires',
            'description'     => 'Liste de webinaires triée par date',
            'category'        => 'relationship',
            'keywords'        => array('webinaire', 'liste', 'vidéo'),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_callback' => 'cbo_render_webinaires_block',
            'enqueue_assets'  => function() {
                if (is_admin()) {
                    wp_enqueue_style('acf-block-style', get_template_directory_uri() . '/library/css/style.min.css');
                }
            },
            'icon'    => 'video-alt2',
            'supports' => array(
                'align'         => false,
                'mode'          => false,
                'multiple'      => true,
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
