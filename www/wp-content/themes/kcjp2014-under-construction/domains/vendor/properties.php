<?php

/*

Name: Vendor
Plural Name: Vendors
Register As: Custom Post Type

*/

namespace vendor;

class properties {
	use \module\properties;

	private $properties = [

		'serial' => [
			'model' => 'metadata',
			'type'  => 'int',
		],

		'org' => [
			'model' => 'metadata',
			'type'  => 'string',
		],

	];
}
