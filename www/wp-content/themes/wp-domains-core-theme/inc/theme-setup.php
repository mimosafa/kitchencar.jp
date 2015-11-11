<?php

namespace WP_Domains_Core_Theme;

/**
 * Theme set up
 */
theme_setup();

/**
 * Theme set up function
 * @return (void)
 */
function theme_setup() {
	new Options();
	if ( is_admin() ) {
		new SettingPage();
	}

	/**
	 * theme supports
	 */
	add_theme_support( 'post-thumbnails' );
}

/**
 * @todo  installed hierarchy level in admin
 */
class Options {

	private $disp_error_frontend = false;
	private $disp_error_hook;
	private static $error = null;

	public function __construct() {
		$this -> initial_settings();
		if ( is_admin() || $this -> disp_error_frontend ) {
			self::$error = new \WP_Error();
			$this -> permalink_structure();
			$this -> domains_dir_activation();
			if ( self::$error -> get_error_code() ) {
				$this -> disp_error_hook = is_admin() ? 'admin_notices' : 'wp_footer';
				add_action( $this -> disp_error_hook, [ $this, 'notice' ] );
			}
		}
	}

	private function initial_settings() {
		$this -> installed_hierarchy_level();
		$this -> display_settings_error_in_frontend();
	}

	private function installed_hierarchy_level() {
		$option_key = 'wp_dct_wordpress_installed_hierarchy_lebel_on_server';
		if ( false === get_option( $option_key ) ) {
			$path = str_replace( $_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME'] );
			$array = explode( '/', trim( $path, '/' ) );
			for ( $i = 0; $i < count( $array ); $i++ ) {
				if ( 'index.php' === $array[$i] || 'wp-admin' === $array[$i] ) {
					break;
				}
			}
			update_option( $option_key, $i );
		}
	}

	private function display_settings_error_in_frontend() {
		$option_key = 'wp_dct_display_settings_error_in_frontend';
		if ( get_option( $option_key ) ) {
			$this -> disp_error_frontend = true;
		}
	}

	private function permalink_structure() {
		$option_key = 'permalink_structure';
		if ( !get_option( $option_key ) ) {
			self::$error -> add(
				$option_key,
				'パーマリンクの設定をデフォルト以外にしてください。',
				[ 'このテーマの機能を利用するためにはパーマリンク構造をデフォルト以外にする必要があります。' ]
			);
		}
	}

	private function domains_dir_activation() {
		$option_key = 'wp_dct_domains_dir_activation';
		if ( !get_option( $option_key ) ) {
			self::$error -> add(
				$option_key,
				'Domains Directory 機能が無効になっています。',
				[ 'このテーマの機能を利用するためにはDomains Directory 機能を有効にする必要があります。' ]
			);
		}
	}

	public function notice() {
		$id = esc_attr( 'notice-in-' . $this -> disp_error_hook );
		$codes = self::$error -> get_error_codes();
		?>
<div id="<?= $id ?>">
		<?php
		foreach ( $codes as $code ) {
			$msg  = self::$error -> get_error_message( $code );
			$data = self::$error -> get_error_data( $code );
			?>
  <div class="message error">
    <p>
      <b><?php esc_html_e( $msg ); ?></b><?php esc_html_e( $data[0] ); ?>
    </p>
  </div>
			<?php
		}
		?>
</div>
		<?php
	}

}

/**
 * Theme settings page
 * 
 * @todo  option key: wp_dct_display_settings_error_in_frontend
 * @todo  option key: wp_dct_domains
 * @todo  option key: wp_dct_excepted_domains
 * @todo  option key: wp_dct_post_type_default_supports
 */
class SettingPage {

	/**
	 * capability of read theme settings page
	 * 
	 * @var string
	 */
	private $capability = 'edit_theme_options';

	/**
	 * @var integer
	 */
	private $position = 62;

	/**
	 * page structure
	 * 
	 * @var array
	 */
	private $pages = [
		'wp-dct-settinds' => [
			'page_title' => 'WP Domains Core Theme Settings',
			'menu_title' => 'Theme Settings',
			'sections' => [
				'theme-core' => [
					'title' => 'Theme Core Settings',
					'fields' => [
						'domains-activation' => [
							'title' => 'Domains Directory',
							'callback' => 'checkbox',
							'label' => 'Active',
							'option_name' => 'wp_dct_domains_dir_activation',
						],
					],
				],
				'theme-debug' => [
					'title' => 'Debug Settings',
					'description' => 'Some debuging option for developers.',
					'fields' => [
						'display-settings-error' => [
							'title' => 'Display Error in Frontend',
							'description' => 'If checked, errors will be displayed in frontend. (Hooked @<code>wp_footer</code>)',
							'callback' => 'checkbox',
							'label' => 'Display',
							'option_name' => 'wp_dct_display_settings_error_in_frontend',
						]
					],
				],
			],
		],
	];

	/**
	 * arrays for function's arguments
	 * 
	 * @var array
	 */
	private $sections = [];
	private $fields = [];
	private $settings = [];

	/**
	 * 
	 */
	public function __construct() {
		$this -> init();
	}

	/**
	 * 
	 */
	private function init() {
		add_action( 'admin_menu', [ $this, 'add_pages' ] );
		add_action( 'admin_init', [ $this, 'add_settings' ] );
	}

	/**
	 * 
	 */
	public function add_pages() {

		/**
		 * pages
		 */
		foreach ( $this -> pages as $menu_slug => $page_args ) {
			$page_title = esc_html( $page_args['page_title'] );
			$menu_title = esc_html( $page_args['menu_title'] );
			add_menu_page(
				$page_title, $menu_title, $this -> capability, $menu_slug, [ $this, 'page_body' ], '', $this -> position
			);

			/**
			 * option group
			 */
			$optionGroup = 'group_' . $menu_slug;

			/**
			 * sections
			 */
			$sections = $page_args['sections'];
			foreach ( $sections as $section_id => $section_args ) {
				$section_title = esc_html( $section_args['title'] );
				$callback = array_key_exists( 'callback', $section_args ) && is_callable( $section_args['callback'] )
					? $section_args['callback'] : ''
				;
				$this -> sections[] = [ $section_id, $section_title, $callback, $menu_slug ];

				/**
				 * fields
				 */
				$fields = $section_args['fields'];
				foreach ( $fields as $field_id => $field_args ) {
					$field_title = esc_html( $field_args['title'] );
					$callback = [ $this, $field_args['callback'] ];
					$args = compact( 'menu_slug', 'section_id', 'field_id' ) + $field_args;
					$this -> fields[] = [ $field_id, $field_title, $callback, $menu_slug, $section_id, $args ];
					$this -> settings[] = [ $optionGroup, $field_args['option_name'], '' ];
				}
			}
		}

	}

	/**
	 * Drowing page html
	 * 
	 * @return (void)
	 */
	public function page_body() {
		$menu_slug = $_GET['page'];
		$h2 = esc_html( $this -> pages[$menu_slug]['page_title'] );
		$optionGroup = 'group_' . $menu_slug;
		?>
<div class="wrap">
  <h2><?= $h2; ?></h2>
  <form method="post" action="options.php">
    <?php settings_fields( $optionGroup ); ?>
    <?php do_settings_sections( $menu_slug ); ?>
    <?php submit_button(); ?>
  </form>
</div>
		<?php
	}

	/**
	 * 
	 */
	public function add_settings() {
		foreach ( $this -> sections as $section_arg ) {
			call_user_func_array( 'add_settings_section', $section_arg );
		}
		foreach ( $this -> fields as $field_arg ) {
			call_user_func_array( 'add_settings_field', $field_arg );
		}
		foreach ( $this -> settings as $setting_arg ) {
			call_user_func_array( 'register_setting', $setting_arg );
		}
	}

	public function checkbox( $array ) {
		$args = $this -> pages[$array['menu_slug']];
		if ( array_key_exists( 'section_id', $array ) ) {
			$args = $args['sections'][$array['section_id']];
		}
		$args = $args['fields'][$array['field_id']];
		$option_name = esc_attr( $args['option_name'] );
		$checked = get_option( $args['option_name'] ) ? 'checked="checked" ' : '';
		$label = array_key_exists( 'label', $array ) ? __( esc_html( $array['label'] ) ) : '';
		$description = array_key_exists( 'description', $array ) ? $array['description'] : '';
		?>
<fieldset>
  <label for="<?= $option_name ?>">
    <input type="checkbox" name="<?= $option_name ?>" id="<?= $option_name ?>" value="1" <?= $checked ?>/>
    <?= $label ?>
  </label>
  <?php if ( $description ) { ?>
  <p class="description"><?= $description ?></p>
  <?php } ?>
</fieldset>
		<?php
	}

}
