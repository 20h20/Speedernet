<?php
    if (is_home()) {
        $articles_page = get_post(get_option('page_for_posts'));
        if ($articles_page) {
            $blocks = parse_blocks($articles_page->post_content);
            foreach ($blocks as $block) {
                echo render_block($block);
            }
        }
    }
?>