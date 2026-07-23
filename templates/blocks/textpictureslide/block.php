<?php
    if( function_exists('acf_register_block_type') ):

        function cbo_render_textpictureslide_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
            $has_content = get_field('textpictureslide_list');

            if ( $is_preview && ! $has_content ) {
                echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/library/images/previews/textpictureslide.jpg' ) . '" alt="" style="display:block;width:100%;height:auto;">';
                return;
            }

            include get_stylesheet_directory() . '/templates/blocks/textpictureslide/template.php';
        }

        acf_register_block_type(array(
            'name'            => 'textpictureslide',
            'title'           => 'Texte et Image fixe',
            'description'     => '',
            'category'        => 'text',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_callback' => 'cbo_render_textpictureslide_block',
            'enqueue_assets'  => function() {
                if (is_admin()) {
                    wp_enqueue_style('acf-block-style', get_template_directory_uri() . '/library/css/style.min.css');
                }
            },
            'icon'    => 'align-pull-left',
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
