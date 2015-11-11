<?php

namespace kitchencar;

/**
 *
 */
class admin {
	use \module\admin;

	/**
	 *
	 */
	private $_title     = 'readonly';
	private $_slug      = 'readonly';
	#private $_editor    = true;
	private $_excerpt   = true;
	private $_author    = false;
	private $_thumbnail = true;

	private function custom_init() {
		if ( current_user_can( 'edit_others_kitchencars' ) ) {
			$this -> _author = true;
		}
	}

}
