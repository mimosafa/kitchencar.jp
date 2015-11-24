<?php
namespace KCJP\View;
/**
 * @version 0.0.0
 *
 * @uses KCJP_COLUMN_LAYOUT_MIN_SIZE
 * @uses KCJP_SIDEBAR_COLUMN_POSITION
 */
class Gene {

	/**
	 * @var null|Object
	 */
	private static $queried;

	private $container_class = 'container';
	private $row_class       = 'row';

	private $caption_class;
	private $main_class;
	private $aside_class;

	private $break_point;

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
		self::$queried = get_queried_object();
		/**
		 * Define Constants
		 */
		if ( ! defined( 'KCJP_COLUMN_LAYOUT_MIN_SIZE' ) ) {
			/**
			 * @var string small|medium
			 */
			define( 'KCJP_COLUMN_LAYOUT_MIN_SIZE', 'medium' );
		}
		if ( ! defined( 'KCJP_SIDEBAR_COLUMN_POSITION' ) ) {
			/**
			 * @var string left|right
			 */
			define( 'KCJP_SIDEBAR_COLUMN_POSITION', 'right' );
		}
		if ( ! defined( 'KCJP_CONTAINER_FLUID' ) ) {
			define( 'KCJP_CONTAINER_FLUID', false );
		}
		$this->prepare();
		add_action( 'wp_enqueue_scripts', [ $this, 'localize_script' ], 11 );
	}

	/**
	 * @access private
	 */
	private function prepare() {
		switch ( KCJP_COLUMN_LAYOUT_MIN_SIZE ) {
			case 'small' :
				$this->caption_class = 'col-sm-4';
				$this->main_class    = 'col-sm-8';
				$this->aside_class   = 'col-sm-4';
				$this->break_point    = 767;
				break;
			case 'xsmall' :
				$this->caption_class = 'col-xs-4';
				$this->main_class    = 'col-xs-8';
				$this->aside_class   = 'col-xs-4';
				$this->break_point    = 477;
				break;
			default :
				/**
				 * Default: medium
				 */
				$this->caption_class = 'col-md-4';
				$this->main_class    = 'col-md-8';
				$this->aside_class   = 'col-md-4';
				$this->break_point    = 991;
		}
	}

	/**
	 * @access public
	 * @return string
	 */
	public static function context() {
		return (boolean) apply_filters( '_view_gene_context', '', self::$queried );
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public static function use_grid() {
		return (boolean) apply_filters( '_view_gene_use_grid', true, self::$queried );
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public static function show_aside() {
		return (boolean) apply_filters( '_view_gene_show_aside', true, self::$queried );
	}

	/**
	 * @access public
	 * @return boolean
	 */
	public static function has_caption() {
		return (boolean) apply_filters( '_view_gene_has_caption', false, self::$queried );
	}

	/**
	 * @access public
	 */
	public static function e_class( $area ) {
		$class = self::getInstance()->_class( $area );
		if ( isset( $class ) ) {
			$class = sprintf( 'contents-%s %s', $area, esc_attr( $class ) );
			if ( $area === 'container' ) {
				$class .= self::getInstance()->_container_class();
			}
			else if ( in_array( $area, [ 'main', 'aside' ], true ) ) {
				if ( KCJP_SIDEBAR_COLUMN_POSITION === 'left' && ! self::has_caption() ) {
					$class .= self::getInstance()->_pull_push_class( $area );
				}
			}
			echo $class;
		}
	}

	private function _container_class() {
		$size = 'medium';
		if ( in_array( KCJP_COLUMN_LAYOUT_MIN_SIZE, [ 'small', 'xsmall' ], true ) ) {
			$size = KCJP_COLUMN_LAYOUT_MIN_SIZE;
		}
		return ' break-at-' . $size;
	}

	private function _pull_push_class( $area ) {
		$size = 'md';
		if ( KCJP_COLUMN_LAYOUT_MIN_SIZE === 'small' ) {
			$size = 'sm';
		}
		else if ( KCJP_COLUMN_LAYOUT_MIN_SIZE === 'xsmall' ) {
			$size = 'xs';
		}
		if ( $area === 'main' ) {
			return ' col-' . $size .'-push-4';
		} else {
			return ' col-' . $size .'-pull-8';
		}
	}

	/**
	 * @access private
	 *
	 * @param  string cantainer|row|caption|main|aside
	 * @return string # class string
	 */
	private function _class( $area ) {
		$var = (string) $area . '_class';
		if ( property_exists( __CLASS__, $var ) ) {
			if ( ! $this->use_grid() ) {
				add_filter( '_view_gene_' . $var, '__return_empty_string' );
			}
			if ( in_array( $area, [ 'container', 'row' ], true ) && KCJP_CONTAINER_FLUID ) {
				//
			}
			return apply_filters( '_view_gene_' . $var, $this->$var );
		}
		return null;
	}

	/**
	 * Lead Contents
	 *
	 * @access public
	 */
	public static function add_lead_contents( Callable $callback ) {
		add_action( '_view_gene_lead_contents', $callback );
	}

	/**
	 * @access public
	 */
	public static function render_lead_contents() {
		do_action( '_view_gene_lead_contents', self::$queried );
	}

	/**
	 * Contents Caption
	 *
	 * @access public
	 *
	 * @param  callable $callback
	 * @return void
	 */
	public static function add_caption( Callable $callback ) {
		$gene = self::getInstance();
		add_filter( '_view_gene_has_caption', '__return_true' );
		add_action( '_view_gene_contents_caption', $callback );
		if ( KCJP_SIDEBAR_COLUMN_POSITION === 'left' ) {
			$gene->area_pull( 'caption', 'left'  );
			$gene->area_pull( 'main',    'right' );
			$gene->area_pull( 'aside',   'left'  );
		} else {
			$gene->area_pull( 'caption', 'right' );
			$gene->area_pull( 'main',    'left'  );
			$gene->area_pull( 'aside',   'right' );
		}
	}

	/**
	 * @access public
	 */
	public static function render_caption() {
		do_action( '_view_gene_contents_caption', self::$queried );
	}

	/**
	 * @access private
	 *
	 * @param  string caption|main|aside
	 * @return void
	 */
	private function area_pull( $area, $whitch ) {
		if ( in_array( $whitch, [ 'left', 'right' ], true ) && $class = $this->_class( $area ) ) {
			$class .= ' pull-' . $whitch;
			add_filter( '_view_gene_' . $area . '_class', function() use ( $class ) {
				return $class;
			} );
		}
	}

	/**
	 * Localize Script
	 *
	 * @uses KCJP_GRID_BREAKE_POINT
	 */
	public function localize_script() {
		$data = [ 'bp' => $this->break_point ];
		wp_localize_script( 'kitchencarjp', 'KCJP_LAYOUT', $data );
	}

}
