<?php
namespace KCJP\View;
/**
 * Kitchencar.jp Page Layout Class
 *
 * @since 0.0.0
 */
class Home {

	/**
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public static function init() {
		static $instance;
		$instance ?: $instance = new self();
	}

	/**
	 * Constructor
	 *
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function __construct() {
		add_action( 'kcjp_lead_contents', [ $this, 'main_visual' ], 0 );
	}

	/**
	 * Rendering Main Visual for Home
	 *
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public function main_visual() {
		$bg_ground  = esc_url( get_template_directory_uri() . '/images/stadium2002_inside.jpg' );
		$bg_stadium = esc_url( get_template_directory_uri() . '/images/stadium2002.png' );
		$bg_title   = esc_url( get_template_directory_uri() . '/images/kcjp2015_logo_ds.png' );
		$bg_info    = esc_url( get_template_directory_uri() . '/images/kcjp_info.png' ); ?>
<style>
	#kcjp-main-visual {
		position: relative;
		height: 325px;
		padding-left: 0;
		padding-right: 0;
		background: url( <?php echo $bg_ground ?> ) center no-repeat;
		-moz-background-size: cover;
		     background-size: cover;
	}
	#kcjp-main-visual::before {
		display: block;
		height: 100%;
		/*background: url( <?php echo $bg_stadium ?> ) bottom right no-repeat;
		-moz-background-size: auto 93%;
		     background-size: auto 93%;*/
	}
	#kcjp-information {
		position: absolute;
		top: 10px;
		width: 599px;
		max-width: 100%;
	}
	@media (min-width: 768px) {
		#kcjp-information { left: 25px; }
	}
	#kcjp-information > h1 {
		height: 210px;
		overflow: hidden;
		white-space: nowrap;
		text-indent: 100%;
		background: url( <?php echo $bg_title ?> ) top left no-repeat;
		-moz-background-size: contain;
		     background-size: contain;
	}
	#kcjp-information > dl {
		margin-top: -55px;
		margin-left: 20px;
		height: 98px;
		width: 460px;
		max-width: 87%;
		overflow: hidden;
		white-space: nowrap;
		text-indent: 100%;
		background: url( <?php echo $bg_info ?> ) top left no-repeat;
		-moz-background-size: contain;
		     background-size: contain;
	}
</style>
<header class="container-fluid" id="kcjp-main-visual">
	<section id="kcjp-information">
		<h1><?php bloginfo( 'name' ); ?></h1>
		<dl>
			<dt>開催日時</dt>
			<dd>2015/12/6 日曜日 10:00 ~ 16:00 <small>雨天決行（荒天中止） 売り切れ次第終了致します。選手権の投票は15:00までです。</small></dd>
			<dt>開催場所</dt>
			<dd>埼玉スタジアム２００２ 北広場</dd>
			<dt>入場料</dt>
			<dd>入場無料</dd>
		</dl>
	</section>
</header><?php
	}

}
