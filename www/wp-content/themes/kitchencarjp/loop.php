<?php
/**
 * Kitchencar.jp
 *
 * @since 0.0.0
 */

/**
 * H tag Number
 *
 * @var stiring 2|3
 */
$n = is_singular() ? '2' : '3';

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

		the_ttl( "<h{$n}>", "</h{$n}>" );
		the_content();
		the_date();

	?>
</section>

<?php endwhile; endif;
