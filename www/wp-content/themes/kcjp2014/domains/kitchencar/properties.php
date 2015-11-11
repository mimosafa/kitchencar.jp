<?php

/*

Name: Kitchencar
Plural Name: Kitchencars
Register As: Custom Post Type
Capability Type: kitchencar, kitchencars

*/

namespace kitchencar;

class properties {
	use \module\properties;

	private $properties = [

		'msg_from_admin' => [
			'type' => 'string',
			'model' => 'metadata',
			'label' => '管理者からのメッセージ',
			'readonly' => true,
		],

		'default' => [
			'type'     => 'group',
			'elements' => [ 'serial' ],
			'label'    => '基本情報',
		],

		'serial' => [
			'model' => 'metadata',
			'type'  => 'integer',
			'label' => 'ネオ屋台ID',
			'description' => 'ネオ屋台村の登録通し番号です',
			'readonly' => true,
			'allow_0'  => true,
		],

		'org' => [
			'model' => 'metadata',
			'type'  => 'string',
			'label' => '会社 / 組織',
		],

		'menus' => [
			'type'  => 'post_children',
			'post_type' => [ 'menu_item' ],
			'description' => 'キッチンカー選手権で提供するメニューです。追加する場合は「Add Menu」をクリックしてください',
		],

		'kgc2014' => [
			'type' => 'boolean',
			'model' => 'metadata',
			'label' => 'キッチンカー選手権へのエントリー'
		],

		'oneWord' => [
			'type' => 'string',
			'model' => 'metadata',
			'label' => '一言',
			'description' => '15文字以内であなたのお店のキャッチコピーを入力してください'
		],

	];

}
