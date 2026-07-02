<?php

get_header();
while ( have_posts() ) : the_post();
	get_template_part( 'templates/blocks/webinaires-single/template' );
endwhile;
get_footer();

?>