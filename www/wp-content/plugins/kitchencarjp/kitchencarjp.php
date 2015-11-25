<?php
/**
 * Plugin Name: Kitchencar.jp
 * Author: Toshimichi Mimoto
 * Version: 0.0.0
 */

define( 'KCJP_PLUGIN_VERSION', '0.0.0' );

add_action( 'plugins_loaded', 'init_kcjp_plugin' );

function init_kcjp_plugin() {
	if ( class_exists( 'mimosafa\\ClassLoader' ) ) {
		mimosafa\ClassLoader::register( 'KCJP', dirname( __FILE__ ) . '/inc' );
		KCJP\Bootstrap::init();
		KCJP\Router::init();
	}
}
