<?php
namespace KCJP;
use mimosafa\WP\Repository as Repo;

class Bootstrap {

	public static function init() {
		static $instance;
		$instance ?: $instance = new self();
	}

	private function __construct() {
		$this->init_repositories();
		$this->test();
	}

	private function init_repositories() {
		$kitchencar = Repo\PostType::init( 'kitchencar' );
		$menu_item  = Repo\PostType::init( 'menu_item' );
		$kitchencar->public = true;
		$kitchencar->label  = 'キッチンカー';
		$menu_item->public  = true;
		$menu_item->label   = '商品';

		Repo\Repository\Registry::set( 'prefix', 'kcjp-' );

		$year = Repo\Taxonomy::init( 'year', [ 'public' => true ] );
		$year->attach( $kitchencar );
		$year->attach( 'post' );
		$year->show_admin_column = true;
		$year->hierarchical = true;

		$activity = Repo\PostType::init( 'activity' );
		$activity->show_ui = true;
	}

	private function test() {
		/*
		add_action( 'wp_footer', function() {
			$a = 0;
			var_dump( ! $a );
			var_dump( ! $a == 0 );
			var_dump( $a != 0 );
		} );
		*/
	}

}
