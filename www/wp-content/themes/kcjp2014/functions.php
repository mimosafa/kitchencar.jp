<?php

/**
 * Theme styles and scripts
 */
add_action( 'wp_enqueue_scripts', function() {
	$styles = [
		[ 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css', [], '3.3.1' ],
		[ 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', [ 'bootstrap' ], '4.2.0' ],
		[ 'kcjp', get_stylesheet_uri() ],
	];
	$scripts = [
		[ 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', [ 'jquery' ], '3.3.1', true ],
		[ 'kcjp', get_stylesheet_directory_uri() . '/js/script.js', [ 'bootstrap' ], '', true ],
	];
	foreach ( $styles as $arg ) {
		call_user_func_array( 'wp_register_style', $arg );
	}
	foreach ( $scripts as $arg ) {
		call_user_func_array( 'wp_register_script', $arg );
	}

	wp_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'kcjp' );
	wp_enqueue_script( 'kcjp' );
	if ( is_singular( 'kitchencar' ) ) {
		wp_enqueue_script( 'masonry' );
	}
} );

/**
 * Google Analytics tracking code
 */
add_action( 'wp_head', function() {
	if ( is_user_logged_in() ) {
		return;
	}
	if ( $_SERVER['HTTP_HOST'] === 'kitchencar.vccw' ) {
		return;
	}
	if ( $_SERVER['HTTP_HOST'] === 'wordpress.local' ) {
		return;
	}
	?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-26079619-1', 'auto');
  ga('send', 'pageview');

</script>
	<?php
}, 999 );

/**
 * Customizing login styles
 *
 * @see  http://www.nxworld.net/wordpress/wp-custom-login-page.html
 * 
 * @see  https://github.com/WordPress/WordPress/blob/master/wp-login.php#L111
 * @see  https://github.com/WordPress/WordPress/blob/master/wp-login.php#L119
 */
add_action( 'login_enqueue_scripts', function() {
	$logo = esc_url( get_stylesheet_directory_uri() . '/images/kgc2014.png' );
	?>
<style>
  .login h1 a {
    background-image: url(<?= $logo ?>);
    -webkit-background-size: 218px;
    background-size: 218px;
    width: 218px;
  }
  #nav {
  	text-align: center;
  }
  #backtoblog {
    display: none;
  }
</style>
	<?php
} );
add_filter( 'login_headerurl', function() { return home_url(); } );
add_filter( 'login_headertitle', function() { return get_bloginfo( 'name' ); } );

/**
 * Registeration as kitchencar manager
 * 
 * ~/wp-login.php?action=register&kitchencar=**
 */
if ( 'wp-login.php' === $pagenow ) {
	new register_kitchencar_manager();
}

/**
 * 
 */
class register_kitchencar_manager {

	/**
	 * Kitchencar
	 * @var WP_Post
	 */
	private $kitchencar;

	/**
	 * Dummy user ID
	 * @var  int
	 */
	private $dummy_user = 1;

	private $rnonce_action = 'register_kitchencar_manager';

	/**
	 * Construct
	 */
	public function __construct() {

		/**
		 * 
		 */
		if ( array_key_exists( 'kitchencar_id', $_POST ) ) {
			if (
				!array_key_exists( '_nonce_kitchencar_manager', $_POST )
				|| !wp_verify_nonce( $_POST['_nonce_kitchencar_manager'], 'kitchencar-manager' )
			) {
				wp_die( 'Invalid registration!' );
			}
			add_action( 'user_register', [ $this, 'update_author' ] );
			return;
		}

		/**
		 * 
		 */
		if ( !$this -> is_register_action() ) {
			if ( array_key_exists( 'already', $_GET ) && '1' === $_GET['already'] ) {
				add_filter( 'login_message', [ $this, 'message_already_registered' ] );
			}
			return;
		}

		if ( !$this -> kitchencar_param() ) {
			wp_redirect( home_url() );
		}

		if ( $this -> has_been_registered() ) {
			$param = [
				'kitchencar' => $this -> kitchencar -> ID,
				'already' => 1
			];
			$url = add_query_arg( $param, wp_login_url() );
			wp_safe_redirect( $url );
		}

		$this -> init();
	}

	private function is_register_action() {
		return array_key_exists( 'action', $_REQUEST ) && 'register' === $_REQUEST['action'];
	}

	/**
	 * @see https://github.com/WordPress/WordPress/blob/master/wp-login.php#L163
	 */
	public function message_already_registered( $message ) {
		if ( $this -> kitchencar_param() ) {
			$message .= esc_html( get_the_title( $this -> kitchencar ) ) . ' は';
		}
		$message .= 'すでに管理ユーザーが登録されています。心当りがない場合は<a href="mailto:mimoto+kcjp@w-tokyodo.com">サイト管理者</a>までご連絡ください。';
		return '<p class="message">' . $message . '</p>';
	}

	/**
	 * Check 'kitchencar' exists query paramater
	 * 
	 * @return bool
	 */
	private function kitchencar_param() {
		if ( !array_key_exists( 'kitchencar', $_REQUEST ) ) {
			return false;
		}
		if ( !$post_id = absint( $_REQUEST['kitchencar'] ) ) {
			return false;
		}
		if ( !$post = get_post( $post_id ) ) {
			return false;
		}
		if ( 'kitchencar' !== $post -> post_type ) {
			return false;
		}
		if ( !in_array( $post -> post_status, [ 'publish', 'pending' ] ) ) {
			return false;
		}
		$this -> kitchencar = $post;
		return true;
	}

	private function has_been_registered() {
		$author = (int) $this -> kitchencar -> post_author;
		return $author && $this -> dummy_user !== $author;
	}

	private function init() {
		add_action( 'register_form', [ $this, 'form' ] );
		add_filter( 'gettext', [ $this, 'text' ], 10, 3 );
	}

	public function form() {
		echo '<input type="hidden" name="kitchencar_id" value="' . $this -> kitchencar -> ID . '" />' . "\n";
		wp_nonce_field( 'kitchencar-manager', '_nonce_kitchencar_manager' );
	}

	public function text( $translated_text, $text, $domain ) {
		if ( 'Register For This Site' === $text ) {
			$translated_text  = get_the_title( $this -> kitchencar ) . ' の管理者として登録する<br>';
			$translated_text .= '<small>※ユーザー名は<b>半角英数字</b>でお願いします。またユーザー名は後で変更ができません</small>';
		}
		return $translated_text;
	}

	public function update_author( $user_id ) {
		if ( !$kitchencar_id = absint( $_POST['kitchencar_id'] ) ) {
			return;
		}
		$kitchencar = get_post( $kitchencar_id );
		if ( 'kitchencar' !== $kitchencar -> post_type || !in_array( $kitchencar -> post_status, [ 'publish', 'pending' ] ) ) {
			return;
		}
		$current_author_data = get_userdata( $kitchencar -> post_author );
		if ( 'kitchencar_manager' === $current_author_data -> roles[0] ) {
			return;
		}

		$post_id = wp_update_post( [ 'ID' => $kitchencar_id, 'post_author' => $user_id ] );
		if ( $post_id && $child_posts = get_children( [ 'post_parent' => $post_id ] ) ) {
			foreach ( $child_posts as $child ) {
				$child_id = wp_update_post( [ 'ID' => $child -> ID, 'post_author' => $user_id ] );
				if ( $child_id && $child_child_posts = get_children( [ 'post_parent' => $child_id ] ) ) {
					foreach ( $child_child_posts as $child_child ) {
						wp_update_post( [ 'ID' => $child_child -> ID, 'post_author' => $user_id ] );
					}
				}
			}
		}
	}

}

/**
 * Customizing about wp-admin
 *
 * @see  http://www.nxworld.net/wordpress/wp-admin-customize-hack.html
 */
add_action( 'wp_before_admin_bar_render', 'hide_before_admin_bar_render' );
function hide_before_admin_bar_render() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	global $wp_admin_bar;
	$wp_admin_bar -> remove_menu( 'wp-logo' );
}
add_filter( 'admin_footer_text', 'remove_footer_admin' );
function remove_footer_admin ( $text ) {
	if ( current_user_can( 'edit_theme_options' ) ) {
		return $text;
	}
	echo 'このサイトは株式会社ワークストア・トウキョウドゥが運営しています。ご不明な点がある場合は<a href="mailto:mimoto+kcjp@w-tokyodo.com">こちら</a>まで（メーラーが立ち上がります）';
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );        // 現在の状況
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );  // 最近のコメント
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );   // 被リンク
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );          // プラグイン
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );        // クイック投稿
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );      // 最近の下書き
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );            // WordPressブログ
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );          // WordPressフォーラム
}
add_filter( 'update_footer', 'remove_update_footer', 11 );
function remove_update_footer( $string ) {
	if ( current_user_can( 'edit_theme_options' ) ) {
		return $string;
	}
	return '';
}
add_action( 'load-profile.php', function() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
	remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
} );



add_action( 'admin_head', function() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
<style>
#menu-posts-kitchencar .wp-submenu,
#wp-admin-bar-new-content-default #wp-admin-bar-new-kitchencar {
  display: none;
}
</style>
	<?php
} );

/**
 * Profile page customize
 */
add_action( 'load-profile.php', function() {

	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	/**
	 * hide lists
	 */
	add_action( 'admin_head', function() {
		?>
<style>
  .show-admin-bar {
  	display: none;
  }
</style>
		<?php
	} );
	add_action( 'admin_footer', function() {
		?>
<script>
  jQuery('#your-profile').find('h3').filter(':first').hide();
  jQuery('#profile-page > h2').hide();
</script>
		<?php
	} );

	/**
	 * 
	 */
	add_action( 'admin_notices', function() {
		?>
<div class="message updated">
<p><strong>ようこそ「キッチンカー選手権エントリーキッチンカー特設管理サイト」ヘ</strong></p>
<p>この管理サイトでは貴方のキッチンカーの写真更新、一言メッセージの更新、販売商品の情報更新、追加、削除、写真の更新、などを行っていただくことができます。</p>
<p></p>
<p>そんなにむつかしいサイトではありません。まずは「Kitchencar」「Menu」「メディア」の各メニューを覗いてみてください。メッセージの更新、写真の更新などはご自由に。なにかご質問がある場合は<a href="mailto:mimoto+kcjp@w-tokyodo.com">管理者までお寄せください</a>。</p>
<p>（まだ準備中ですが）みなさまが更新された情報がそんなに間を置かずWEBサイトに掲載される便利さを体感いただけたら幸いです。</p>
<p>ユーザー名、パスワードはお忘れなく、ブックマークもよろしくお願い致します。
</div>
		<?php
	} );

} );

/**
 * Admin: user list (sortable)
 *
 * @see  http://hack.aipo.com/archives/3468/
 */
add_filter( 'manage_users_columns', 'my_manage_users_columns' );
add_filter( 'manage_users_sortable_columns', 'my_manage_users_columns_sortable' );
add_filter( 'manage_users_custom_column', 'my_manage_users_custom_column', 10, 3 );
function my_manage_users_columns( $columns ) {
	$columns['registered'] = '登録日時';
	unset( $columns['posts'] );
	return $columns;
}
function my_manage_users_columns_sortable( $columns ) {
	$columns['registered'] = 'registered';
	return $columns;
}
function my_manage_users_custom_column( $dummy, $column, $user_id ) {
  if ( 'registered' == $column ) {
    return esc_html( get_userdata( $user_id ) -> user_registered );
  }
}

