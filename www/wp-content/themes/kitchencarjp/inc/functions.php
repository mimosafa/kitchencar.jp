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

/**
 * Auto Class Loader
 *
 * @access private
 *
 * @since  0.0.0
 */
function _kcjp_autoloader( $class ) {
	/**
	 * @var string # directory path
	 */
	static $viewDir, $appDir;
	$strings = explode( '\\', $class );
	if ( $strings[0] === 'KCJP' && $n = count( $strings ) - 1 ) {
		if ( $n > 1 && $strings[1] === 'View' ) {
			/**
			 * View Classes
			 *
			 * @since 0.0.0
			 */
			if ( ! isset( $viewDir ) ) { $viewDir = TEMPLATEPATH . '/view'; }
			$path = $viewDir;
			$i = 2;
		}
		else {
			/**
			 * Application Classes
			 *
			 * @since 0.0.0
			 */
			if ( ! isset( $appDir ) ) { $appDir = TEMPLATEPATH . '/app'; }
			$path = $appDir;
			$i = 1;
		}
		for ( $i; $i <= $n; $i++ ) { $path .= '/' . $strings[$i]; }
		$path .= '.php';
		if ( is_readable( $path ) ) { require_once $path; }
	}
}
