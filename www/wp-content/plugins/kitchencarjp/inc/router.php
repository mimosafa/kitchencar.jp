<?php
namespace KCJP;
use mimosafa\WP\Repository as Repo;

class Router {

	private $repository;

	private static $admin_q = [
		'post_type' => \FILTER_SANITIZE_ENCODED,
		'taxonomy'  => \FILTER_SANITIZE_ENCODED,
		'post'      => \FILTER_VALIDATE_INT,
	];

	public static function init() {
		static $instance;
		$instance ?: $instance = new self();
	}

	private function __construct() {
		is_admin() ? $this->admin_dispatch() : $this->dispatch();
	}

	private function admin_dispatch() {
		global $pagenow;
		$q = filter_input_array( \INPUT_GET, self::$admin_q );
		if ( in_array( $pagenow, [ 'edit.php', 'post-new.php' ], true ) ) {
			$maybe_namespace = $q['post_type'] ?: 'post';
		}
		else if ( $pagenow === 'post.php' ) {
			$maybe_namespace = $q['post'] ? get_post_type( $q['post'] ) : filter_input( \INPUT_POST, 'post_type' );
		}
		if ( isset( $maybe_namespace ) && $repository = Repo\PostType::getInstance( $maybe_namespace ) ) {
			$this->repository = $repository;
			add_action( 'admin_init', [ $this, 'init_service' ] );
		}
	}

	private function dispatch() {
		//
	}

	public function init_service() {
		//
	}

}
