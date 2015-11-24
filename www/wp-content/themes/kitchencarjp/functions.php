<?php
/**
 * Kitchencar.jp Theme Functions
 *
 * @package kcjp
 */

define( 'KCJP_THEME_VERSION', '0.0.0' );
// define( 'KCJP_COLUMN_LAYOUT_MIN_SIZE',  'xsmall' );
// define( 'KCJP_SIDEBAR_COLUMN_POSITION', 'left'  );

/**
 * Include Theme Functions
 */
require_once get_template_directory() . '/inc/functions.php';
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/view/gene.php';

/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'kcjp_setup' );

if ( ! is_admin() ) {
	require_once get_template_directory() . '/inc/googleanalytics.php';
}
