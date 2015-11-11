<?php

namespace menu;

/**
 *
 */
class admin {
	use \module\admin;

	/**
	 *
	 */
	private $_title     = true;
	#private $_editor    = true;
	private $_excerpt   = true;
	private $_author    = false;
	private $_thumbnail = true;

	private $meta_boxes = [
		[
			'property' => 'price',
		], [
			'property' => 'choice',
			'context' => 'side',
		]
	];

	private function custom_init() {
		if ( current_user_can( 'edit_others_menus' ) ) {
			$this -> _author = true;
		}
	}

}

#####################################################################
###                                                               ###
###   Below, additional admin cusomize, for 'kitchencar' domain   ###
###                                                               ###
#####################################################################

/**
 * Add thumbnail column and managing columns order
 */

\add_filter( 'manage_menu_item_posts_columns', 'menu\\manage_columns' );
\add_filter( 'manage_menu_item_posts_custom_column', 'menu\\column_callbacks', 10, 2 );

/**
 * @param  array $columns
 * @return array
 */
function manage_columns( $columns ) {
	$columns['thumbnail'] = 'Photo';
	$columns['kitchencar'] = 'Kitchencar';
	$order = [
		'cb'         => 0,
		'title'      => 2,
		'author'     => 4,
		'date'       => 5,
		'thumbnail'  => 1,
		'kitchencar' => 3,
	];
	if ( !current_user_can( 'edit_others_kitchencars' ) ) {
		unset( $order['author'] );
	}
	array_multisort( $order, $columns );
	if ( !current_user_can( 'edit_others_kitchencars' ) ) {
		unset( $columns['serial'] );
	}
	return $columns;
}

/**
 * Print column contents
 * 
 * @param  string $column_name
 * @param  int $post_id 
 * @return (void)
 */
function column_callbacks( $column_name, $post_id ) {
	if ( 'thumbnail' === $column_name ) {
		\menu\thumbnail_column( $post_id );
	} else if ( 'kitchencar' === $column_name ) {
		\menu\kitchencar_column( $post_id );
	}
}
function thumbnail_column( $post_id ) {
	$thumb = get_the_post_thumbnail( $post_id, [ 84, 84 ], 'thumbnail' );
	echo ( $thumb ) ? $thumb : '－';
}
function kitchencar_column( $post_id ) {
	$post = get_post( $post_id );
	$kitchencar_id = $post -> post_parent;
	if ( $kitchencar_id ) {
		printf( '<a href="%s">%s</a>', get_edit_post_link( $kitchencar_id ), esc_html( get_the_title( $kitchencar_id ) ) );
	} else {
		echo '-';
	}
}

\add_action( 'admin_enqueue_scripts', function() {
	?>
<style>
  .column-thumbnail {
    width: 104px;
  }
  @media screen and (max-width: 782px) {
    .column-thumbnail,
    .column-kitchencar {
      display: none;
    }
  }
</style>
	<?php
} );

/**
 * Select parent post as 'Kitchencar'
 */
\add_action( 'add_meta_boxes', 'menu\\add_select_kitchencar_meta_box' );
\add_filter( 'wp_insert_post_parent', 'menu\\insert_post_parent', 10, 2 );
function add_select_kitchencar_meta_box() {
	global $pagenow;
	if ( 'post-new.php' === $pagenow && array_key_exists( 'post_parent', $_GET ) ) {
		return;
	}
	add_meta_box(
		'select-kitchencar',
		'この商品を提供するキッチンカー',
		'menu\\select_kitchencar_meta_box',
		'menu_item'
	);
}
function select_kitchencar_meta_box( $post ) {
	$parent  = absint( $post -> post_parent );
	$user_id = absint( $post -> post_author );
	$_q_args = [
		'posts_per_page' => 200,
		'order' => 'ASC',
		'orderby' => 'meta_value_num',
		'meta_key' => 'serial',
		'post_type' => 'kitchencar',
		'post_status' => [ 'publish', 'pending' ],
		'author' => $user_id,
	];
	if ( current_user_can( 'edit_others_kitchencars' ) ) {
		unset( $_q_args['author'] );
	}
	$kitchencars = get_posts( $_q_args );
	?>
<p class="description">キッチンカーを選択してください。</p>
<select name="select-kitchencar">
  <?php foreach ( $kitchencars as $kitchencar ) { $_id = (int) $kitchencar -> ID; ?>
  <option value="<?= $_id ?>" <?php if ( $parent === $_id ) { echo 'selected="selected"'; } ?>><?= esc_html( get_the_title( $_id ) ) ?></option>
  <?php } ?>
</select>
<?php if ( $parent ) { ?>
<a href="<?= get_edit_post_link( $parent ) ?>">Edit <?= esc_html( get_the_title( $parent ) ) ?></i></a>
<?php } ?>
	<?php
	wp_nonce_field( 'save_kitchencar', '_nonce_save_kitchencar' );
}
function insert_post_parent( $parent, $post_id ) {
	if ( !array_key_exists( 'select-kitchencar', $_POST ) || !$_POST['select-kitchencar'] ) {
		return $parent;
	}
	check_admin_referer( 'save_kitchencar', '_nonce_save_kitchencar' );
	$newParent = absint( $_POST['select-kitchencar'] );
	return $parent != $newParent ? $newParent : $parent;
}








