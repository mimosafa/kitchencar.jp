<?php

/**
 * @see  http://qiita.com/halhide/items/8c85d4ea8f8584721aeb
 * @see  https://github.com/WordPress/WordPress/blob/master/wp-admin/includes/class-wp-list-table.php#L352
 */
add_filter( 'views_edit-menu_item', function( $views ) {
	global $pagenow, $current_user;
	if ( 'kitchencar_manager' === $current_user -> roles[0] ) {
		return [];
	}
	return $views;
} );



/**
 * Change texts in admin => Kitchencar
 */
add_action( 'load-post.php', 'js_menu_item_meta_box_texts' );
add_action( 'load-post-new.php', 'js_menu_item_meta_box_texts' );
function js_menu_item_meta_box_texts() {
	if ( 'menu_item' === get_current_screen() -> post_type ) {
		add_action( 'admin_footer', function() {
			?>
<script>
var ttl = jQuery('#wpbody-content').children('div.wrap').children('h2');
console.log(ttl);
ttl.text('商品情報の編集').children('a').remove();
/**
 * Excerpt
 */
var excerpt = jQuery('#postexcerpt'),
    excerptInside = excerpt.children('div.inside');
excerpt.children('h3').children('span').text('商品PR文');
excerptInside.children('label').text('商品PR文');
excerptInside.children('p').remove();
/**
 * Image Div
 */
jQuery('#postimagediv').children('h3').children('span').text('商品写真');
jQuery('#set-post-thumbnail').attr('title','商品写真を登録');
jQuery('#remove-post-thumbnail').text('商品写真を削除');
</script>
			<?php
		} );
	}
}
