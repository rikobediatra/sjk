<?php
/**
 * This file has all the required codes for initializing the customizer module.
 */

if ( ! class_exists( 'Travel_Joy_Init_Customizer_Module' ) ) {

	/**
	 * Class to init the customizer module.
	 */
	class Travel_Joy_Init_Customizer_Module {

		/**
		 * Customizer Module root dir path.
		 *
		 * @var string
		 */

		/**
		 * Init class Travel_Joy_Init_Customizer_Module.
		 */
		public function __construct() {
			add_filter( 'kirki_telemetry', '__return_false' ); // Removes the telemetry including the admin notice.
			add_filter( 'kirki_config', array( $this, 'kirki_customizer_configs' ) );
			$this->define_constants();
			$this->includes();
		}

		/**
		 * Define all the customizer module constants here.
		 *
		 * @return void
		 */
		public function define_constants() {
			define( 'TRAVEL_JOY_CUSTOMIZER_MODULE_ROOT_DIR', dirname( __FILE__ ) );
			define( 'TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID', 'travel-joy-theme-config-id' );
		}

		/**
		 * Kirki initial configuration. For example disabling loader.
		 *
		 * @param array $config Kirki configurations.
		 * @return array $config Enhanced kirki configurations.
		 */
		public function kirki_customizer_configs( $config ) {
			return wp_parse_args(
				array(
					'disable_loader' => true,
				),
				$config
			);
		}

		/**
		 * Include all the customizer module file.
		 *
		 * @return void
		 */
		public function includes() {
			$customizer_module_root = TRAVEL_JOY_CUSTOMIZER_MODULE_ROOT_DIR;
			require_once $customizer_module_root . '/customizer-helpers.php';
			require_once $customizer_module_root . '/kirki/kirki.php';
			require_once $customizer_module_root . '/functions.php';

			// Customizer essentials.
			require_once $customizer_module_root . '/inc/panels.php';
			require_once $customizer_module_root . '/inc/class-sections.php';
			require_once $customizer_module_root . '/inc/class-fields.php';
		}
	}
}

new Travel_Joy_Init_Customizer_Module();
