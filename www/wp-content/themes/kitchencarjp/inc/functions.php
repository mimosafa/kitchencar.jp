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
	static $views, $apps;
	$views ?: $views = get_template_directory() . '/view';
	$apps  ?: $apps  = get_template_directory() . '/app';
	$arr = explode( '\\', $class );
	if ( $arr[0] === 'KCJP' && $n = count( $arr ) - 1 ) {
		// View Classes
		if ( $n > 1 && $arr[1] === 'View' ) {
			$path = $views;
			$i = 2;
		}
		// Application Classes
		else {
			$path = $apps;
			$i = 1;
		}
		for ( $i; $i <= $n; $i++ ) { $path .= '/' . $arr[$i]; }
		$path .= '.php';
		if ( is_readable( $path ) ) { require_once $path; }
	}
}
