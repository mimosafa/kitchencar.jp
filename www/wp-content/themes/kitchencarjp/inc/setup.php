<?php
/**
 * Theme Setup
 *
 * @since 0.0.0
 */

/**
 * Theme Supports
 *
 * @since 0.0.0
 */
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

/**
 * Register Auto Class Loader
 *
 * @since 0.0.0
 */
spl_autoload_register( '_kcjp_autoloader' );

/**
 *
 */
add_action( 'template_redirect', 'KCJP\\View\\Allocation::getInstance' );

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
