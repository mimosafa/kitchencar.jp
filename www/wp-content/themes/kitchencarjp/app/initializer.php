<?php
namespace KCJP;

abstract class Initializer {

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
	 * @access protected
	 *
	 * @since 0.0.0
	 */
	protected function __construct() {
		/* Do Something */
	}

}
