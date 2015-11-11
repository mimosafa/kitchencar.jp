<?php

/**
 * noindex, nofollow
 */
add_action( 'wp_head', function() {
	echo '<meta name="robots" content="noindex,follow"/>';
}, 1 );

/**
 * kitchencars
 */
$kitchencars = new WP_Query( [
	'posts_per_page' => 200,
	'post_type' => 'kitchencar',
	'post_status' => 'publish',
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
	'meta_key' => 'serial',
	'meta_query' => [
		[
			'key' => 'kgc2014',
			'value' => 1,
			'compare' => '=',
		]
	],
] );

/**
 * for entry 'No.'
 */
$n = 0;

/**
 * print template start
 */
get_header(); ?>
<div class="container-fluid">
  <h1>Entry List</h1>
  <?php if ( $kitchencars -> have_posts() ) : ?>
  <table class="table">
    <thead>
      <tr>
        <th>No.</th>
        <th>店名</th>
        <th>ひとこと</th>
        <th>提供商品</th>
      </tr>
    </thead>
    <tbody>
    <?php while ( $kitchencars -> have_posts() ) : $kitchencars -> the_post();

/**
 * increment entry 'No.'
 */
$n++;

/**
 * Setup kitchencar's data
 */
$name = sprintf( '<a href="%s">%s</a>', get_permalink(), get_the_title() );
if ( current_user_can( 'edit_others_kitchencars' ) ) {
	$serial = esc_html( get_post_meta( get_the_id(), 'serial', true ) );
	$name = '<small>' . $serial . '</small> ' . $name . ' <small><a href="' . get_edit_post_link() . '"><i class="fa fa-pencil"></i></a></small>'; 
}

$oneWord = esc_html( $post -> oneWord );

/**
 * kitchencar's menus
 */
$menus = get_posts( [
	'post_parent' => get_the_id(),
	'post_status' => 'publish',
	'post_type' => 'menu_item',
	'posts_per_page' => -1,
] );

/**
 * print kitchencar row
 */
    ?>
      <tr>
        <td><?= $n ?></td>
        <td><?= $name ?></td>
        <td><?= $oneWord ?></td>
        <td>
          <?php if ( $menus ) : ?>
          <dl>
          	<?php foreach ( $menus as $post ) :

/**
 * setup menu's data
 */
setup_postdata( $post );
$menuName = get_the_title();
if ( !has_post_thumbnail() ) {
	$menuName .= ' <span class="label label-warning">画像がありません</span>';
}
if ( get_post_meta( get_the_id(), 'choice', true ) ) {
	$menuName = '<span class="label label-primary">イチオシ</span> ' . $menuName;
}
$menuContent = $post -> post_excerpt ? esc_html( $post -> post_excerpt ) : '<span class="text-danger">商品説明がありません</span>';

/**
 * print menu description list
 */
          ?>
            <dt><?= $menuName ?></dt>
            <dd><?= $menuContent ?></dd>
	      <?php endforeach; wp_reset_postdata(); ?>
	      </dl>
	    <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; wp_reset_query(); ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>
<?php get_footer(); ?>