<?php
namespace KCJP;
/**
 * Kitchencar.jp Router Class
 *
 * @since 0.0.0
 */
class Router {

	public static function init() {
		static $instance;
		$instance ?: $instance = new self();
	}

	private function __construct() {
		is_admin() ? $this->admin_dispatch() : $this->dispatch();
	}

	private function admin_dispatch() {
		//
	}

	private function dispatch() {
		//
	}

}
