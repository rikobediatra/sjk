<?php
/**
 * This file has all the required code for helping the kirki customizer to load and blend in with theme.
 * Please run this file before the kirki framework.
 * And also please do not include any kirki functions and class here.
 *
 * @package ../customizer-module/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travel_joy_customizer_styles' ) ) {

	/**
	 * Generates the styles for the customizer fields itself.
	 *
	 * @return void
	 */
	function travel_joy_customizer_custom_styles() {
		?>
		<style>

		/* For fixing the colors controls button height. */
		/* span.wp-color-result-text {
			line-height: 2.54545455 !important;
		} */

		/* Hiding the section hide button in theme option. */
		#customize-control-travel_joy_theme_options-theme_options-sort_sections-sort_sections i.dashicons.dashicons-visibility.visibility
		{
			display: none;
		}
		</style>
		<?php
	}
	add_action( 'admin_enqueue_scripts', 'travel_joy_customizer_custom_styles' );
}

/**
 * Helps the autoload method to load the kirki files hence saving our time to replace file names of kirki framework.
 * This function uses str_replace function to work.
 *
 * @see https://www.php.net/manual/en/function.str-replace.php
 *
 * @param string $find_text    Class name text to you want to replace.
 * @param string $replace_with Text that class name will be replaced to.
 * @param string $class_name   Name of the class name that we are trying to load.
 * @return string New compatible class name string that autoload can read.
 */
function travel_joy_customizer_kirki_autoloader_helper( $find_text, $replace_with, $class_name ) {
	return str_replace( $find_text, $replace_with, $class_name );
}
