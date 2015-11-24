<?php
namespace KCJP;
/**
 * Kitchencar.jp Router Class
 *
 * @since 0.0.0
 */
class Router {

	private $namespace;

	private static $services = [ 'view' ];

	public static function init() {
		static $instance;
		$instance ?: $instance = new self();
	}

	private function __construct() {
		is_admin() ? $this->admin_dispatch() : $this->dispatch();
		add_action( 'after_setup_theme', [ $this, 'init_service' ] );
	}

	private function admin_dispatch() {
		//
	}

	private function dispatch() {
		if ( is_home() ) {
			$this->namespace = 'home';
		}
	}

	private function init_service() {
		if ( $this->namespace ) {
			foreach ( $this->services as $service ) {
				$cl = 'KCJP\\' . $this->namespace . '\\' $service;
				if ( class_exists( $cl ) ) {
					$cl::init();
				}
			}
		}
	}

}
