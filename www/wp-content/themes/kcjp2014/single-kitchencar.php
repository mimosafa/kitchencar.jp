<?php

/**
 * noindex, nofollow
 */
add_action( 'wp_head', function() {
	echo '<meta name="robots" content="noindex,follow"/>';
}, 1 );

/**
 * Author
 */
$author_id = ( 1 !== absint( $post -> post_author ) ) ? absint( $post -> post_author ) : false;

/**
 * media size
 */
$size = wp_is_mobile() ? 'medium' : 'large';

/**
 * Get header.php
 */
get_header(); ?>
  <div id="contents" class="container">
    <div class="row">
      <div class="col-sm-4">
        <p>
          <a href="<?= home_url() ?>" title="Kitchencar.jp">
            <img src="<?= get_stylesheet_directory_uri() ?>/images/ttl.png" alt="<?= bloginfo( 'name' ) ?>">
          </a>
        </p>
        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } ?>
      </div>
      <div class="col-sm-8 pull-right">
        <?php

/**
 * Kitchencar single main contents
 */

/**
 * one word
 */
$oneWord = $post -> oneWord ? $post -> oneWord : '';

/**
 * menu items
 */
$menusArgs = [
	'post_type' => 'menu_item',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'post_parent' => get_the_id()
];
$menus = get_posts( $menusArgs );


        ?>
        <h1 class="single-ttl-kitchencar">
          <?php if ( $oneWord ) { ?>
          <small><i class="fa fa-quote-left"></i> <?= esc_html( $oneWord ) ?> <i class="fa fa-quote-right"></i></small>
          <br>
          <?php } ?>
          <i class="fa fa-truck"></i> <?php the_title(); ?>
        </h1>
        <?php if ( $menus ) : foreach ( $menus as $post ) : setup_postdata( $post );

/**
 * menu data
 */
$menuName = get_the_title();
$menuContent = esc_html( $post -> post_excerpt );
if ( has_post_thumbnail() ) {
	$menuThumb = sprintf( '<a class="media-left modal-image" href="%s" title="%s">%s</a>',
		wp_get_attachment_image_src( $post -> _thumbnail_id, $size )[0],
		$menuName,
		get_the_post_thumbnail( get_the_id(), [ 84, 84 ] )
	);
} else {
	$menuThumb = '';
}
if ( get_post_meta( get_the_id(), 'choice', true ) ) {
	$menuName .= ' <small><span class="label label-primary">イチオシ</span></small>';
}

        ?>
        <div class="media">
          <?= $menuThumb ?>
          <div class="media-body">
            <h4 class="media-heading"><i class="fa fa-cutlery"></i> <?= $menuName ?></h4>
            <?= $menuContent ?>
          </div>
        </div>
        <hr>
        <?php endforeach; wp_reset_postdata(); endif; ?>
        <div class="text-right">
          <small><i class="fa fa-exclamation"></i> 掲載されているメニューは予定です。変更となる場合がありますのであらかじめご了承ください。</small>
        </div>
        <?php

if ( $author_id ) :

	$medias = get_posts( [
		'author' => $author_id,
		'post_type' => 'attachment',
		'order' => 'ASC',
		'post_status' => 'piblish',
		'posts_per_page' => 20
	] );
	$medias = array_filter( $medias, function( $post ) {
		return preg_match( '/^image\//', $post -> post_mime_type );
	} );

	if ( $medias ) :
		?>
        <h2>ギャラリー</h2>
        <div id="kitchencar-gallery">
        <?php
        foreach ( $medias as $media ) {
        	$img = wp_get_attachment_image_src( $media -> ID, $size );
        	?>
          <div class="masonry-item">
            <img src="<?= $img[0] ?>" />
          </div>
        	<?php
        }
        ?>
        </div>
        <?php
	endif;
endif;
        ?>
      </div>
    </div>
  </div><!-- /#contents -->
<?php get_footer(); ?>
