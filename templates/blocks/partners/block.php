<?php
    if( function_exists('acf_register_block_type') ):

        function cbo_render_partners_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
            $has_content = get_field('partners_uptitle');

            if ( $is_preview && ! $has_content ) {
                echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/library/images/previews/partners.jpg' ) . '" alt="" style="display:block;width:100%;height:auto;">';
                return;
            }

            include get_stylesheet_directory() . '/templates/blocks/partners/template.php';
        }

        acf_register_block_type(array(
            'name'            => 'partners',
            'title'           => 'Liste de partenaires',
            'description'     => '',
            'category'        => 'media',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_callback' => 'cbo_render_partners_block',
            'enqueue_assets'  => function() {
                if (is_admin()) {
                    wp_enqueue_style('acf-block-style', get_template_directory_uri() . '/library/css/style.min.css');
                }
            },
            'icon'    => 'format-chat',
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
