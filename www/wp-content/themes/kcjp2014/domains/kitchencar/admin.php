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
	private $_excerpt   = true;
	private $_author    = false;
	private $_thumbnail = true;

	private $meta_boxes = [
		[
			'property' => 'msg_from_admin',
			'priority' => 'high',
		],[
			'property' => 'oneWord',
		], [
			'property' => 'menus',
		], [
			'property' => 'default',
			'context'  => 'side',
			'priority' => 'low',
		], [
			'property' => 'kgc2014',
			'context'  => 'side',
		],
	];

	private function custom_init() {
		if ( current_user_can( 'edit_others_kitchencars' ) ) {
			$this -> _author = true;
		}
		if ( !current_user_can( 'edit_others_kitchencars' ) ) {
			unset( $this -> meta_boxes[3] );
		}
	}

}

#####################################################################
###                                                               ###
###   Below, additional admin cusomize, for 'kitchencar' domain   ###
###                                                               ###
#####################################################################

/**
 * Show kitchencar's owner registration page url
 */
\add_action( 'add_meta_boxes', 'kitchencar\\registeration_url' );

/**
 * add meta box
 * 
 * @return (void)
 */
function registeration_url() {
	if ( 'kitchencar' !== get_current_screen() -> post_type ) {
		return;
	}
	if ( !current_user_can( 'edit_others_kitchencars' ) ) {
		return;
	}
	$post = get_post();
	if ( 1 !== (int) $post -> post_author ) {
		return;
	}
	if ( !in_array( $post -> post_status, [ 'publish', 'pending' ] ) ) {
		return;
	}

	$args = [
		'registeration_url_for_kitchencar_manager', // id
		'Registration URL', //title
		'kitchencar\\registeration_url_inner', // callback
		'kitchencar', // post_type
		'side', // context
		'low', // priority
	];
	call_user_func_array( 'add_meta_box', $args );
}

/**
 * Registration url meta box inner
 * 
 * @param  WP_Post $post
 * @param  array $metabox
 * @return (void)
 */
function registeration_url_inner( $post, $metabox ) {
	$url = add_query_arg( [ 'kitchencar' => $post -> ID ], wp_registration_url() );
	?>
<code style="word-break:break-all;"><?= esc_url( $url ) ?></code>
	<?php
}

/**
 * Add thumbnail column and managing columns order
 */

\add_filter( 'manage_kitchencar_posts_columns', 'kitchencar\\manage_columns' );
#\add_filter( 'manage_edit-kitchencar_sortable_columns', 'kitchencar\\manage_sortable_columns' );
\add_filter( 'manage_kitchencar_posts_custom_column', 'kitchencar\\column_callbacks', 10, 2 );

/**
 * @param  array $columns
 * @return array
 */
function manage_columns( $columns ) {
	$columns['thumbnail'] = 'Photo';
	$columns['serial']    = 'Serial';
	$columns['kgc2014']    = '2014';
	$order = [
		'cb'        => 0,
		'title'     => 3,
		'author'    => 4,
		'date'      => 5,
		'thumbnail' => 2,
		'serial'    => 1,
		'kgc2014'   => 6
	];
	if ( !current_user_can( 'edit_others_kitchencars' ) ) {
		unset( $order['author'] );
	}
	array_multisort( $order, $columns );
	if ( !current_user_can( 'edit_others_kitchencars' ) ) {
		unset( $columns['serial'] );
		unset( $columns['kgc2014'] );
	}
	return $columns;
}
#function manage_sortable_columns( $columns ) {
#	$columns['kgc2014'] = 'kgc2014';
#	return $columns;
#}

/**
 * Print column contents
 * 
 * @param  string $column_name
 * @param  int $post_id 
 * @return (void)
 */
function column_callbacks( $column_name, $post_id ) {
	if ( 'thumbnail' === $column_name ) {
		\kitchencar\thumbnail_column( $post_id );
	} else if ( 'serial' === $column_name ) {
		\kitchencar\serial_column( $post_id );
	} else if ( 'kgc2014' === $column_name ) {
		\kitchencar\kgc2014_column( $post_id );
	}
}
function thumbnail_column( $post_id ) {
	$thumb = get_the_post_thumbnail( $post_id, [ 84, 84 ], 'thumbnail' );
	echo ( $thumb ) ? $thumb : '－';
}
function serial_column( $post_id ) {
	$serial = get_post_meta( $post_id, 'serial', true );
	echo false !== $serial ? esc_html( $serial ) : '-';
}
function kgc2014_column( $post_id ) {
	echo get_post_meta( $post_id, 'kgc2014', true ) ? 'Entry' : '';
}

\add_action( 'admin_enqueue_scripts', function() {
	?>
<style>
  .column-serial,
  .column-kgc2014 {
    width: 84px;
  }
  .column-thumbnail {
    width: 104px;
  }
  @media screen and (max-width: 782px) {
    .column-thumbnail,
    .column-serial,
    .column-kgc2014 {
      display: none;
    }
  }
</style>
	<?php
} );
