<?php
namespace KCJP;
/**
 * Management Styles & JavaScripts Class
 *
 * @since 0.0.0
 */
class Scripts {

	/**
	 * This Theme
	 *
	 * @since 0.0.0
	 */
	const THEME = 'kitchencarjp';
	const THEME_VERSION = '0.0.0';

	/**
	 * @var string
	 *
	 * @since 0.0.0
	 */
	private $theme;

	/**
	 * Depends
	 *
	 * @var array
	 */
	private $css_depends = [];
	private $js_depends  = [];

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
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function __construct() {
		$this->theme = get_stylesheet();
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * @access public
	 *
	 * @since 0.0.0
	 */
	public function enqueue() {
		$this->register();
		wp_enqueue_style( $this->theme );
		wp_enqueue_script( $this->theme );
	}

	/**
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function register() {
		$this->twitter_bootstrap( '3.3.5' );
		$this->font_awesome( '4.4.0' );
		$this->register_themes();
	}

	/**
	 * @access private
	 */
	private function twitter_bootstrap( $ver ) {
		$handle = 'twitter-bootstrap';
		$css = '//maxcdn.bootstrapcdn.com/bootstrap/%s/css/bootstrap.min.css';
		$js  = '//maxcdn.bootstrapcdn.com/bootstrap/%s/js/bootstrap.min.js';
		wp_register_style( $handle, sprintf( $css, $ver ), [], $ver );
		wp_register_script( $handle, sprintf( $js, $ver ), [ 'jquery' ], $ver );
		$this->css_depends[] = $handle;
		$this->js_depends[]  = $handle;
	}

	/**
	 * @access private
	 */
	private function font_awesome( $ver ) {
		$handle = 'font-awesome';
		$css = '//maxcdn.bootstrapcdn.com/font-awesome/%s/css/font-awesome.min.css';
		wp_register_style( $handle, sprintf( $css, $ver ), [ 'twitter-bootstrap' ], $ver );
		$this->css_depends[] = $handle;
	}

	/**
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function register_themes() {
		/**
		 * Styles
		 */
		if ( $this->theme !== self::THEME ) {
			// Child Theme Style
			wp_register_style(
				$this->theme,
				get_stylesheet_uri(),
				[ self::THEME ],
				wp_get_theme()->get( 'Version' )
			);
		}
		// This Theme Style
		wp_register_style(
			self::THEME,
			$this->stylesheet_uri(),
			$this->css_depends,
			self::THEME_VERSION
		);

		/**
		 * Scripts
		 */
		wp_register_script(
			self::THEME,
			trailingslashit( get_template_directory_uri() ) . 'js/script.js',
			$this->js_depends,
			self::THEME_VERSION,
			true
		);
	}

	/**
	 * @access private
	 *
	 * @since 0.0.0
	 */
	private function stylesheet_uri() {
		return trailingslashit( get_template_directory_uri() ) . 'style.css';
	}

}
