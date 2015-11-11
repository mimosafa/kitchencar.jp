<?php

add_action( 'after_setup_theme', function() {

	/**
	 * Enqueue Styles & Scripts
	 */
	function vendor_scripts_styles() {
		if ( !is_admin() ) {
			wp_enqueue_style( 'bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css', array(), '3.0.2', 'screen' );
			wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array( 'bootstrap' ), '4.0.3', 'screen' );
			wp_deregister_script( 'jquery' );
			wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.10.2' );
			wp_enqueue_script( 'bootstrap', '//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js', array( 'jquery' ), '3.0.2', true );
			wp_enqueue_script(
				'mmsf_newel',
				get_stylesheet_directory_uri() . '/js/jquery.newel.js',
				array( 'jquery' ),
				date( 'YmdHis', filemtime( get_stylesheet_directory() . '/js/jquery.newel.js' ) ),
				true
			);
			if ( is_home() ) {
				wp_enqueue_script( 'slabtext', get_stylesheet_directory_uri() . '/js/jquery.slabtext.min.js', array( 'jquery' ), '2.3', true );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'vendor_scripts_styles' );

	function my_scripts_styles() {
		if ( !is_admin() ) {
			wp_enqueue_style(
				'theme-style',
				get_stylesheet_uri(),
				array( 'bootstrap' ),
				date( 'YmdHis', filemtime( get_stylesheet_directory() . '/style.css' ) )
			);
			wp_enqueue_script(
				'theme-script',
				get_stylesheet_directory_uri() . '/js/script.js',
				array( 'jquery' ),
				date( 'YmdHis', filemtime( get_stylesheet_directory() . '/js/script.js' ) ),
				true
			);
		}
	}
	add_action( 'wp_enqueue_scripts', 'my_scripts_styles' );

	function my_head() {
		$style = '';
		if ( is_admin_bar_showing() ) {
			$style .= "body{padding-top:54px !important;}\n";
			$style .= ".navbar-fixed-top{top:28px !important;}\n";
		} else {
			$style .= "body{padding-top:54px !important;}\n";
		}
		if ( is_home() ) {
			//$style .= '#headerImage{background:url(' . get_stylesheet_directory_uri() . '/images/bg-stadium.png) center right no-repeat;}';
		}
		if ( $style ) {
			$style = "<style>\n" . $style . "</style>\n";
			echo $style;
		}
	}
	add_action( 'wp_head', 'my_head' );

	function my_queries( $query ) {
		if ( !is_admin() && $query->is_main_query() ) {
			/*
			$query->set( 'cat', '-1' );
			*/
			if ( is_home() ) {
				$query->set( 'posts_per_page', 1 );
			}
		}
	}
	add_action( 'pre_get_posts', 'my_queries' );

} );

/**
 *
 *
 * 
 */
add_action( 'init', function() {

	add_role( 'kitchencar_manager', 'Kitchencar Manager', array( 'read' => true ) );

} );


add_action( 'load-post.php', 'js_kcjp_meta_box_texts' );
add_action( 'load-post-new.php', 'js_kcjp_meta_box_texts' );

function js_kcjp_meta_box_texts() {
	add_filter( 'gettext', 'kcjp_translate_text', 10, 3 );
	add_action( 'admin_footer', function() {
		?>
<script>
jQuery('#postexcerpt').children('div.inside').children('p').remove();
</script>
		<?php
	} );
}

function kcjp_translate_text( $translate_text, $text, $domain ) {
	return str_replace( '抜粋', 'お店紹介文', $translate_text );
}




