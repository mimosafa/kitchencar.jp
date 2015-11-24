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

	add_action( 'wp_enqueue_scripts', 'kcjp_scripts' );
	add_action( 'widgets_init', 'kcjp_widgets_init' );
}

function kcjp_scripts() {
	/**
	 * Twitter Bootstrap
	 */
	wp_register_style(
		'twitter-bootstrap',
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css',
		[],
		'3.3.5'
	);
	wp_register_script(
		'twitter-bootstrap',
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
		[ 'jquery' ],
		'3.3.5',
		true
	);

	/**
	 * Font Awesome
	 */
	wp_register_style(
		'font-awesome',
		'//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
		[ 'twitter-bootstrap' ],
		'4.4.0'
	);

	/**
	 * Kitchencar.jp Theme
	 */
	wp_register_style(
		'kitchencarjp',
		trailingslashit( get_template_directory_uri() ) . 'style.css',
		[ 'font-awesome' ],
		KCJP_THEME_VERSION
	);
	wp_register_script(
		'kitchencarjp',
		trailingslashit( get_template_directory_uri() ) . 'js/script.js',
		[ 'twitter-bootstrap' ],
		KCJP_THEME_VERSION,
		true
	);

	wp_enqueue_style( 'kitchencarjp' );
	wp_enqueue_script( 'kitchencarjp' );
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
