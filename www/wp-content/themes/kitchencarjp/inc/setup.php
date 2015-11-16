<?php
/**
 * Theme Setup
 *
 * @since 0.0.0
 */

/**
 * Register Auto Class Loader
 *
 * @since 0.0.0
 */
spl_autoload_register(
	function ( $class ) {
		static $app;
		if ( ! isset( $app ) ) {
			$app = TEMPLATEPATH . '/app';
		}
		$strings = explode( '\\', $class );
		if ( $n = count( $strings ) - 1 ) {
			if ( $strings[0] === 'KCJP' ) {
				$path = $app;
				for ( $i = 1; $i <= $n; $i++ ) {
					$path .= '/' . $strings[$i];
				}
				$path .= '.php';
				if ( is_readable( $path ) ) {
					require_once $path;
				}
			}
		}
	}
);

/**
 * Theme Supports
 *
 * @since 0.0.0
 */
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

KCJP\Scripts::init();
