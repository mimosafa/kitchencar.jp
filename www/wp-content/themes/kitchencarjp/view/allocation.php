<?php
namespace KCJP\View;
/**
 * @version 0.0.0
 */
class Allocation {

	const VERSION = '0.0.0';

	/**
	 * @var null|Object
	 */
	private $queried;

	private $framework = 'twitter-bootstrap';

	private $container_class = 'container';
	private $caption_class   = 'col-md-4';
	private $main_class      = 'col-md-8';
	private $aside_class     = 'col-md-4';

	/**
	 * @access public
	 */
	public static function getInstance() {
		static $instance;
		return $instance ?: $instance = new self();
	}

	/**
	 * Constructor
	 *
	 * @access private
	 */
	private function __construct() {
		$this->queried = get_queried_object();
		add_action( 'wp_enqueue_scripts', [ $this, 'init_assets' ] );
	}

	/**
	 * @access public
	 * @return string
	 */
	public function context() {
		return (boolean) apply_filters( '_view_allocation_context', '', $this->queried );
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public function use_grid() {
		return (boolean) apply_filters( '_view_allocation_use_grid', true, $this->queried );
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public function show_aside() {
		return (boolean) apply_filters( '_view_allocation_show_aside', true, $this->queried );
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public function has_caption() {
		return (boolean) apply_filters( '_view_allocation_has_caption', false, $this->queried );
	}

	/**
	 * @access public
	 */
	public function e_class( $area ) {
		$class = $this->_class( $area );
		if ( isset( $class ) ) {
			printf( 'contents-%s %s', $area, esc_attr( $class ) );
		}
	}

	/**
	 * Lead Contents
	 *
	 * @access public
	 */
	public function add_lead_contents( Callable $callback ) {
		add_action( '_view_allocation_lead_contents', $callback );
	}

	/**
	 * @access public
	 */
	public function render_lead_contents() {
		do_action( '_view_allocation_lead_contents', $this->queried );
	}

	/**
	 * Contents Caption
	 *
	 * @access public
	 */
	public function add_caption( Callable $callback ) {
		add_filter( '_view_allocation_has_caption', '__return_true' );
		add_action( '_view_allocation_contents_caption', $callback );
		if ( $this->sidebar_left() ) {
			$this->area_pull( 'caption', 'left'  );
			$this->area_pull( 'main',    'right' );
			$this->area_pull( 'aside',   'left'  );
		} else {
			$this->area_pull( 'caption', 'right' );
			$this->area_pull( 'main',    'left'  );
			$this->area_pull( 'aside',   'right' );
		}
	}

	/**
	 * @access public
	 */
	public function render_caption() {
		do_action( '_view_allocation_contents_caption', $this->queried );
	}

	/**
	 * @access private
	 */
	private function _class( $area ) {
		$var = (string) $area . '_class';
		if ( property_exists( __CLASS__, $var ) ) {
			if ( ! $this->use_grid() ) {
				add_filter( '_view_allocation_' . $var, '__return_empty_string' );
			}
			return apply_filters( '_view_allocation_' . $var, $this->$var );
		}
		return null;
	}

	/**
	 * @access private
	 */
	private function area_pull( $area, $whitch ) {
		if ( in_array( $whitch, [ 'left', 'right' ], true ) && $class = $this->_class( $area ) ) {
			$class .= ' pull-' . $whitch;
			add_filter( '_view_allocation_' . $area . '_class', function() use ( $class ) {
				return $class;
			} );
		}
	}

	/**
	 * @access private
	 * @return boolean
	 */
	private function sidebar_left() {
		return (boolean) apply_filters( '_view_allocation_sidebar_left', false, $this->queried );
	}

	/**
	 * @access public
	 */
	public function init_assets() {
		$uri = get_template_directory_uri() . '/view/asset/';
		wp_enqueue_style(  'view-allocation', $uri . 'allocation.css', [ $this->framework ], self::VERSION );
		wp_enqueue_script( 'view-allocation', $uri . 'allocation.js',  [ $this->framework ], self::VERSION, true );
	}

}
