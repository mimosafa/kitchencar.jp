<?php

/**
 * Add user role 'Kitchencar Manager'
 */
add_action( 'init', function() {
	global $wp_roles;
	add_role( 'kitchencar_manager', 'Kitchencar Manager', [ 'read' => true ] );
}, 10 );

/**
 * Filter other's media files
 * @see  http://qiita.com/halhide/items/8c85d4ea8f8584721aeb
 */
add_action( 'pre_get_posts', function( $query ) {
	if ( !is_admin() ) {
		return;
	}
	global $pagenow, $current_user;
	if ( 'kitchencar_manager' === $current_user -> roles[0] ) {
		if ( 'admin-ajax.php' === $pagenow || 'upload.php' === $pagenow ) {
			$query -> set( 'author', $current_user -> ID );
		}
	}
} );

/**
 * @see  http://qiita.com/halhide/items/8c85d4ea8f8584721aeb
 * @see  https://github.com/WordPress/WordPress/blob/master/wp-admin/includes/class-wp-list-table.php#L352
 */
add_filter( 'views_edit-kitchencar', function( $views ) {
	global $pagenow, $current_user;
	if ( 'kitchencar_manager' === $current_user -> roles[0] ) {
		return [];
	}
	return $views;
} );



/**
 * Change texts in admin => Kitchencar
 */
add_action( 'load-post.php', 'js_kitchencar_meta_box_texts' );
add_action( 'load-post-new.php', 'js_kitchencar_meta_box_texts' );
function js_kitchencar_meta_box_texts() {
	if ( 'kitchencar' === get_current_screen() -> post_type ) {
		add_action( 'admin_footer', function() {
			?>
<script>
var ttl = jQuery('#wpbody-content').children('div.wrap').children('h2');
console.log(ttl);
ttl.text('キッチンカー情報の編集').children('a').remove();
/**
 * Excerpt
 */
var excerpt = jQuery('#postexcerpt'),
    excerptInside = excerpt.children('div.inside');
excerpt.children('h3').children('span').text('お店紹介文');
excerptInside.children('label').text('お店紹介文');
excerptInside.children('p').text('お店の紹介文ですが… 今回は使用しないかもしれないのでメニューの方に商品の説明を入れてください');
/**
 * Image Div
 */
jQuery('#postimagediv').children('h3').children('span').text('キッチンカー写真');
jQuery('#set-post-thumbnail').attr('title','キッチンカー写真を登録');
jQuery('#remove-post-thumbnail').text('キッチンカー写真を削除');
</script>
			<?php
		} );
	}
}
