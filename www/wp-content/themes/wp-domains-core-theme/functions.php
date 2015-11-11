<?php

/**
 * Include version check file
 */
require_once dirname( __FILE__ ) . '/inc/version.php';

// Exec
if ( !requirement_wp_domains_core_theme() ) {
	return;
}

/**
 * include classloader class
 */
require_once __DIR__ . '/lib/ClassLoader.php';

/**
 * Register classloader
 */
ClassLoader::register( 'admin', __DIR__ . '/class' );
ClassLoader::register( 'module', __DIR__ . '/class' );
ClassLoader::register( 'property', __DIR__ . '/class' );
ClassLoader::register( 'service', __DIR__ . '/class' );
ClassLoader::register( 'wordpress', __DIR__ . '/class' );

/**
 * include utility file
 */
require_once __DIR__ . '/inc/utility.php';

/**
 * Initializing domains directory, if activated
 */
if ( get_option( 'wp_dct_domains_dir_activation' ) ) {
	new service\domain\init();
}

/**
 * Bootstrap theme
 * - validate options
 * - add theme setting page
 */
require_once __DIR__ . '/inc/theme-setup.php';

/**
 *
 */
new service\router();
