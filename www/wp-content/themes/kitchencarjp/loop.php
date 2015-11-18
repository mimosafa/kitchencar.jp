<?php
/**
 * Kitchencar.jp
 *
 * @since 0.0.0
 */

if ( have_posts() ) :
	while ( have_posts() ) : the_post();

?><section id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php

		the_ttl( '<h3>', '</h3>' );
		the_content();
		the_date();

?></section><?php

	endwhile;
endif;
