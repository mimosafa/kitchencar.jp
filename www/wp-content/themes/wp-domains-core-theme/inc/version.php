<?php

/**
 * Required PHP version
 */
define( 'PHP_VER_WP_DOMAINS_CORE_THEME_REQUIRE', '5.4.0' );

/**
 * Required WordPress version
 */
define( 'WP_VER_WP_DOMAINS_CORE_THEME_REQUIRE',  '4.0'   );

/**
 * Check PHP & WordPress version
 * @return bool
 */
function requirement_wp_domains_core_theme() {
	$e = new WP_Error();
	$phpVer = PHP_VERSION;
	$wpVer  = $GLOBALS['wp_version'];
	if ( version_compare( $phpVer,PHP_VER_WP_DOMAINS_CORE_THEME_REQUIRE,  '<' ) ) {
		$e -> add(
			'error',
			'PHP version ' . $phpVer . ' does not meet the requirements to use this theme. ' . PHP_VER_WP_DOMAINS_CORE_THEME_REQUIRE . ' or higher will be required.'
		);
	}
	if ( version_compare( $wpVer, WP_VER_WP_DOMAINS_CORE_THEME_REQUIRE, '<' ) ) {
		$e -> add(
			'error',
			'WordPress version ' . $wpVer . ' does not meet the requirements to use this theme. ' . WP_VER_WP_DOMAINS_CORE_THEME_REQUIRE . ' or higher will be required.'
		);
	}
	if ( $e -> get_error_code() ) {
		global $_error_messages;
		$_error_messages = $e -> get_error_messages();
		add_action( 'admin_notices', 'error_requirement_wp_domains_core_theme' );
		return false;
	}
	return true;
}

/**
 * Print error message
 * @return (void)
 */
function error_requirement_wp_domains_core_theme() {
	global $_error_messages;
	foreach ( $_error_messages as $msg ) {
		echo '<div class="message error">' . "\n";
		echo __( '<p>' . $msg . '</p>' ) . "\n";
		echo '</div>' . "\n";
	}
}
