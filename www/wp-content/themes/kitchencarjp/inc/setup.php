<?php
/**
 * Theme Setup
 *
 * @since 0.0.0
 */
function kcjp_setup() {

	/**
	 * Theme Supports
	 *
	 * @since 0.0.0
	 */
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

}

/**
 * Register Widget Area
 *
 * @since 0.0.0
 */
function kcjp_widgets_init() {

	register_sidebar( [
		'id' => 'sidebar-1',
		'name' => 'RightSideBar',
		'description' => 'Widgets in this area will be shown on the right-hand side.',
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	] );

}
