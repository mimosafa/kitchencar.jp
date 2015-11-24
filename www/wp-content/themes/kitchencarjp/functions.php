<?php
/**
 * Kitchencar.jp Theme Functions
 *
 * @package kcjp
 */

define( 'KCJP_COLUMN_LAYOUT_MIN_SIZE',  'xsmall' );
// define( 'KCJP_SIDEBAR_COLUMN_POSITION', 'left'  );

/**
 * Include Theme Functions
 */
require_once get_template_directory() . '/inc/functions.php';
require_once get_template_directory() . '/inc/setup.php';

/**
 * Register Auto Class Loader
 */
spl_autoload_register( '_kcjp_autoloader' );

/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'kcjp_setup' );
add_action( 'widgets_init', 'kcjp_widgets_init' );

/**
 * Styles & JavaScripts
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

if ( ! is_admin() ) {
	add_action( 'template_redirect', 'KCJP\\View\\Gene::getInstance' );
	require_once get_template_directory() . '/inc/googleanalytics.php';
}
