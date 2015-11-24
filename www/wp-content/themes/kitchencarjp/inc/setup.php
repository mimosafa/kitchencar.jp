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
		'id'   => 'sidebar-1',
		'name' => 'Sidebar #1',
		'description'   => 'Widgets in this area will be shown on the right-hand side.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1>',
		'after_title'   => '</h1>'
	] );

}

add_action( 'pre_get_posts', '_kcjp_2015' );
function _kcjp_2015( $query ) {
	if ( $query->is_main_query() && ! is_admin() ) {
		$query->set( 'cat', 32 );
	}
}
