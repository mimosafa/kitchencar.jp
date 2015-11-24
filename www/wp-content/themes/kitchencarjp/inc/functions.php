<?php
/**
 * Functions
 *
 * @since 0.0.0
 */

if ( ! function_exists( 'the_ttl' ) ) {
	/**
	 * Expand The Title
	 *
	 * @access public
	 *
	 * @since  0.0.0
	 */
	function the_ttl( $before = '', $after = '', $echo = true ) {
		if ( ! is_singular() ) {
			$before .= '<a href="' . get_permalink() . '">';
			$after   = '</a>' . $after;
		}
		the_title( $before, $after, $echo );
	}
}
