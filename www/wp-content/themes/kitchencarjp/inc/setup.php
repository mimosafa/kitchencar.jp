<?php
/**
 * Theme Setup
 *
 * @since 0.0.0
 */

/**
 * Register Auto Class Loaders
 *
 * @since 0.0.0
 */
spl_autoload_register( 'kcjp_view_autoloader' );
spl_autoload_register( 'kcjp_app_autoloader' );

/**
 * Auto Loader for View Classes
 *
 * @since 0.0.0
 */
function kcjp_view_autoloader( $class ) {
	static $dir;
	if ( ! isset( $dir ) ) { $dir = TEMPLATEPATH . '/view'; }
	$strings = explode( '\\', $class );
	$n = count( $strings ) - 1;
	if ( $n > 1 ) {
		if ( $strings[0] === 'KCJP' && $strings[1] === 'View' ) {
			$path = $dir;
			for ( $i = 2; $i <= $n; $i++ ) { $path .= '/' . $strings[$i]; }
			$path .= '.php';
			if ( is_readable( $path ) ) { require_once $path; }
		}
	}
}

/**
 * Auto Loader for Application Classes
 *
 * @since 0.0.0
 */
function kcjp_app_autoloader( $class ) {
	static $dir;
	if ( ! isset( $dir ) ) { $dir = TEMPLATEPATH . '/app'; }
	$strings = explode( '\\', $class );
	if ( $n = count( $strings ) - 1 ) {
		if ( $strings[0] === 'KCJP' ) {
			$path = $dir;
			for ( $i = 1; $i <= $n; $i++ ) { $path .= '/' . $strings[$i]; }
			$path .= '.php';
			if ( is_readable( $path ) ) { require_once $path; }
		}
	}
}

/**
 * Theme Supports
 *
 * @since 0.0.0
 */
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

/**
 * Styles & JavaScripts
 *
 * @since 0.0.0
 */
KCJP\Scripts::init();

if ( class_exists( 'mimosafa\\ClassLoader' ) ) {
	/**
	 * Kitchencar.jp Repositories
	 *
	 * @since 0.0.0
	 */
	KCJP\Domains::init();
}

KCJP\View::init();

register_sidebar( [
	'id' => 'sidebar-1',
	'name' => 'RightSideBar',
	'description' => 'Widgets in this area will be shown on the right-hand side.',
	'before_title' => '<h1>',
	'after_title' => '</h1>'
] );
