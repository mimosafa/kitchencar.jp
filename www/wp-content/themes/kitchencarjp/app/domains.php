<?php
namespace KCJP;

/**
 * @uses mimosafa\WP\Repository
 */
use mimosafa\WP as mWP;

/**
 *
 */
class Domains {

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
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function __construct() {
		$this->create_repositories();
	}

	private function create_repositories() {
		$kitchencar = mWP\Repository\PostType::init( 'kitchencar', 'post' );
		$menu_item  = mWP\Repository\PostType::init( 'menu_item', 'post' );
		$kcjp = mWP\Repository\PostType::init( 'kcjp', 'post' );
	}

}
