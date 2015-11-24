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

}
