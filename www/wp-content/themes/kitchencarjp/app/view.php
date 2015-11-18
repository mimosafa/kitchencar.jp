<?php
namespace KCJP;
/**
 * Kitchencar.jp View Controller
 *
 * @since 0.0.0
 */
class View {

	/**
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public static function init() {
		static $instance;
		$instance ?: $instance = new self();
	}

	/**
	 * Constructor
	 *
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function __construct() {
		add_action( 'template_redirect', [ $this, 'init_template' ] );
	}

	/**
	 * Dispatcher
	 *
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public function init_template() {
		if ( is_home() ) {
			View\Home::init();
		}
	}

	/**
	 * Bootstrap Fluid Layout
	 *
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public static function fluid_layout() {
		add_filter( 'kcjp_contents_class', function() { return 'container-fluid'; } );
	}

	/**
	 * Single Column Layout
	 *
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public static function single_column_layout() {
		add_filter( 'kcjp_use_glid_system', '__return_false' );
		add_filter( 'kcjp_contents_main_class', '__return_empty_string' );
	}

	/**
	 * Rendering Contents Information Area
	 *
	 * @access public
	 *
	 * @since 0.0.0
	 *
	 * @param  Callable $callback
	 */
	public static function render_contents_information( Callable $callback ) {
		add_filter( 'kcjp_has_contents_information', '__return_true' );
		add_filter( 'kcjp_contents_main_class', function( $class ) {
			$class .= ' pull-left';
			return $class;
		} );
		add_filter( 'kcjp_contents_aside_class', function( $class ) {
			$class .= ' pull-right';
			return $class;
		} );
		add_action( 'kcjp_contents_information', $callback );
	}

}
