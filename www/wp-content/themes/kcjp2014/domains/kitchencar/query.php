<?php

namespace kitchencar;

class query {
	use \module\query;

	private $filter_others = true;

	private $query_args = [
		// 順序＆順序ベースパラメータ
		'order'   => 'ASC',
		'orderby' => 'meta_value_num',

		// カスタムフィールドパラメータ
		'meta_key'   => 'serial',
	];

}
