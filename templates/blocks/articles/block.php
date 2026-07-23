<?php
    if( function_exists('acf_register_block_type') ):

        function cbo_render_articles_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
            $has_content = get_field('articles_uptitle');

            if ( $is_preview && ! $has_content ) {
                echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/library/images/previews/articles.jpg' ) . '" alt="" style="display:block;width:100%;height:auto;">';
                return;
            }

            include get_stylesheet_directory() . '/templates/blocks/articles/template.php';
        }

        acf_register_block_type(array(
            'name'            => 'articles',
            'title'           => 'Liste d\'articles',
            'description'     => 'Liste d\'articles',
            'category'        => 'relationship',
            'keywords'        => array(),
            'post_types'      => array(),
            'mode'            => 'auto',
            'align'           => '',
            'render_callback' => 'cbo_render_articles_block',
            'enqueue_assets'  => function() {
                if (is_admin()) {
                    wp_enqueue_style('acf-block-style', get_template_directory_uri() . '/library/css/style.min.css');
                }
            },
            'icon'    => 'admin-page',
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
