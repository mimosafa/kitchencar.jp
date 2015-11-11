<?php

/**
 * kitchencar posts
 * 
 * @var WP_Query
 */
$posts = new WP_Query( [
	'post_type'      => 'kitchencar',
	'posts_per_page' => 100,
	/*
	'order' => 'rand',
	*/
	'order'          => 'ASC',
	'orderby'        => 'meta_value_num',
	'meta_key'       => 'serial',
] );

/**
 * Loop
 */
if ( $posts -> have_posts() ) :
	while ( $posts -> have_posts() ) : $posts -> the_post();
		/**
		 * kgc2014 filter
		 */
		if ( !$post -> kgc2014 ) continue;
		
		/**
		 * Kitchencar section background image
		 */
		$kitchencarSectionStyle = ( $kitchencarThumb = wp_get_attachment_image_src( $post -> _thumbnail_id, 'medium' ) )
			? 'background-image: url(' . $kitchencarThumb[0] . ');'
			: ''
		;

		/**
		 * menu
		 */
		$menus = get_children( [
			'post_parent' => $post -> ID,
			'post_type' => 'menu_item',
			'post_status' => 'publish',
			'orderby' => 'rand',
			'numberposts' => 10
		] );
		$foodDivStyle = '';
		if ( $menus ) {
			foreach ( $menus as $menu ) {
				if ( $foodThumbID = $menu -> _thumbnail_id ) {
					$foodThumb = wp_get_attachment_image_src( $foodThumbID, 'medium' );
					$foodDivStyle = 'background-image: url(' . $foodThumb[0] . ');';
				}
			}
		}
		?>
<section class="kitchencar-section" id="kitchencar-<?= get_the_ID() ?>" style="<?= esc_attr( $kitchencarSectionStyle ) ?>">
  <div class="kitchencar-food-div" style="<?= esc_attr( $foodDivStyle ) ?>">
    <h3 class="kitchencar-name"><i class="fa fa-truck"></i> <?= get_the_title() ?></h3>
    <a class="kitchencar-anchor" href="<?= get_permalink() ?>"><i class="fa fa-arrow-right"></i></a>
  </div>
</section>
		<?php
	endwhile;
	?>
</div>
	<?php
endif;
wp_reset_query();
