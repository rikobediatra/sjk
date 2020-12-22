<?php
// phpcs:ignoreFile

if ( ! class_exists( 'Travel_Joy_Customizer_Active_Callback' ) ) {
	// Removed in https://github.com/aristath/kirki/pull/1682/files
	class Travel_Joy_Customizer_Active_Callback {
		public static function evaluate() {
			_deprecated_function( __METHOD__, '3.0.17', null );
			return true;
		}
		private static function evaluate_requirement() {
			_deprecated_function( __METHOD__, '3.0.17', null );
			return true;
		}
		public static function compare( $value1, $value2, $operator ) {
			_deprecated_function( __METHOD__, '3.0.17', 'Travel_Joy_Customizer_Helper::compare_values' );
			return Travel_Joy_Customizer_Helper::compare_values( $value1, $value2, $operator );
		}
	}
}

/**
 * Deprecated in v3.0.36
 *
 * keeping it here in case a theme or plugin was using one of its public methods.
 * This is just to avoid fatal errors, it does not do anything.
 */
if ( ! class_exists( 'Travel_Joy_Customizer_CSS_To_File' ) ) {
	class Travel_Joy_Customizer_CSS_To_File {
		public function __construct() {}
		public function get_url() {}
		public function get_timestamp() {}
		public function write_file() {}
	}
}
