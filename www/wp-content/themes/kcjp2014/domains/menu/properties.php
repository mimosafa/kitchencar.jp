<?php

/*

Name: Menu
Plural Name: Menus
Register As: Custom Post Type
Post Type Name: menu_item
Permalink Format: ID
Capability Type: menu, menus

*/

namespace menu;

class properties {
	use \module\properties;

	private $properties = [

		'price' => [
			'type' => 'integer',
			'model' => 'metadata',
			'label' => '価格',
			'description' => '参考情報です。（入力は任意）',
		],

		'choice' => [
			'type' => 'boolean',
			'model' => 'metadata',
			'label' => 'イチオシ商品',
			'unique' => true,
		],

	];

}
