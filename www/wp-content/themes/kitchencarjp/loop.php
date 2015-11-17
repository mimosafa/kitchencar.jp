<?php
/**
 * Kitchencar.jp
 *
 * @since 0.0.0
 */

if ( have_posts() ) :

	while ( have_posts() ) : the_post();
		echo '<section id="post-' . get_the_ID() . '" ';
		post_class();
		echo '>';
		the_title( '<h3>', '</h3>' );
		the_content();
		the_time();
		echo '</section>';
	endwhile;

endif;
