<?php

/**
 * Class loader
 *
 * @see http://sotarok.hatenablog.com/entry/20101208/1291739722
 * @see https://gist.github.com/sotarok/732010
 */
class ClassLoader {

	/**
	 * Defined flags
	 *
	 * 1. FILENAME_STRTOLOWER
	 *    - Class name string to lower case for file name
	 *    - ex: 'ModelClass' -> 'modelclass.php'
	 * 2. UNDERBAR_AS_DIR_SEP
	 *    - '_' in class name replace to '/' for directory separator
	 *    - ex: 'Model_Class' -> 'Model/Class.php'
	 *
	 * (Bitwise operation use as $flag
	 *  -> http://qiita.com/mpyw/items/ce626976ec4dc07dfec2#1-2)
	 */
	const FILENAME_STRTOLOWER = 1;
	const UNDERBAR_AS_DIR_SEP = 2;

	/**
	 * Supplied flag
	 *
	 * @var int
	 */
	private $flag = 0;

	/**
	 * Stocker of registered autoloader
	 *
	 * @var array
	 */
	private static $_loaders = [];

	/**
	 * @var string
	 */
	private $_namespace;

	/**
	 * @var string
	 */
	private $_includePath;

	/**
	 * @var string
	 */
	private $_namespace_separator = '\\';

	/**
	 * @access private
	 *
	 * @param  string|null $ns
	 * @param  string|null $path
	 * @param  int $flag
	 * @return (void)
	 */
	private function __construct( $ns, $path, $flag ) {
		$this -> _namespace = $ns;
		$this -> _includePath = realpath( $path );

		/**
		 *
		 */
		if ( $flag && is_int( $flag ) ) {
			$this -> flag = $flag;
		}
	}

	/**
	 * @access private
	 */
	private function _register() {
		spl_autoload_register( [ $this, 'loadClass' ] );
	}

	/**
	 * @access private
	 */
	private function _unregister() {
		spl_autoload_unregister( [ $this, 'loadClass' ] );
	}

	/**
	 * @access protected
	 *
	 * @param  string $className
	 */
	public function loadClass( $className ) {
		$sep = $this -> _namespace_separator;
		if (
			null === $this -> _namespace
			|| $this -> _namespace . $sep === substr( $className, 0, strlen( $this -> _namespace . $sep ) )
		) {
			$fileName = '';
			$namespace = '';
			if ( false !== ( $lastNsPos = strripos( $className, $sep ) ) ) {
				$namespace = substr( $className, 0, $lastNsPos );
				$className = substr( $className, $lastNsPos + 1 );

				/**
				 * Analys flag 'FILENAME_STRTOLOWER'
				 */
				if ( self::FILENAME_STRTOLOWER & $this -> flag ) {
					$className = strtolower( $className );
				}

				$fileName = str_replace( $sep, '/', $namespace ) . '/';
			}

			/**
			 * Analys flag 'UNDERBAR_AS_DIR_SEP'
			 */
			$replace = self::UNDERBAR_AS_DIR_SEP & $this -> flag ? '/' : '-';

			$fileName .= str_replace( '_', $replace, $className ) . '.php';
			$filePath = $this -> _includePath . '/' . $fileName;
			if ( file_exists( $filePath ) ) {
				require $filePath;
			}
		}
	}

	/**
	 * @access public
	 */
	public static function register( $ns = null, $path = null, $flag = 0 ) {
		$cl = new self( $ns, $path, $flag );
		$cl -> _register();
		$key = $ns . $path . $flag;
		self::$_loaders[ $key ] = $cl;
	}

	/**
	 * @access public
	 */
	public static function unregister( $ns = null, $path = null, $flag = 0 ) {
		$key = $ns . $path . $flag;
		if ( isset( $key ) ) {
			self::$_loaders[ $key ] -> _unregister();
		}
	}

}
