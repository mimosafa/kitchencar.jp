<?php
/**
 * Plugin Name: Kitchencar.jp
 * Author: Toshimichi Mimoto
 * Version: 0.0.0
 */

define( 'KCJP_PLUGIN_VERSION', '0.0.0' );

add_action( 'plugins_loaded', function() {
	if ( class_exists( 'mimosafa\\ClassLoader' ) ) {
		mimosafa\WP\Repository\PostType::init( 'kitchencar', 'post' );
	}
} );
