<?php
/**
 * Plugin Name:   Kirki Customizer Framework
 * Plugin URI:    https://kirki.org
 * Description:   The Ultimate WordPress Customizer Framework
 * Author:        Ari Stathopoulos (@aristath)
 * Author URI:    https://aristath.github.io
 * Version:       3.0.45
 * Text Domain:   kirki
 * Requires WP:   4.9
 * Requires PHP:  5.3
 * GitHub Plugin URI: aristath/kirki
 * GitHub Plugin URI: https://github.com/aristath/kirki
 *
 * @package   Kirki
 * @category  Core
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if Kirki already exists.
if ( class_exists( 'Travel_Joy_Customizer' ) ) {
	return;
}

// Include the autoloader.
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'class-kirki-autoload.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
new Travel_Joy_Customizer_Autoload();

if ( ! defined( 'TRAVEL_JOY_CUSTOMIZER_PLUGIN_FILE' ) ) {
	define( 'TRAVEL_JOY_CUSTOMIZER_PLUGIN_FILE', __FILE__ );
}

// Define the TRAVEL_JOY_CUSTOMIZER_VERSION constant.
if ( ! defined( 'TRAVEL_JOY_CUSTOMIZER_VERSION' ) ) {
	define( 'TRAVEL_JOY_CUSTOMIZER_VERSION', '3.0.45' );
}

// Make sure the path is properly set.
Travel_Joy_Customizer::$path = wp_normalize_path( dirname( __FILE__ ) ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
Travel_Joy_Customizer_Init::set_url();

new Travel_Joy_Customizer_Controls();

if ( ! function_exists( 'Travel_Joy_Customizer' ) ) {
	/**
	 * Returns an instance of the Kirki object.
	 */
	function travel_joy_customizer() {
		$kirki = Travel_Joy_Customizer_Toolkit::get_instance();
		return $kirki;
	}
}

// Start Kirki.
global $kirki;
$kirki = travel_joy_customizer();

// Instantiate the modules.
$kirki->modules = new Travel_Joy_Customizer_Modules();

Travel_Joy_Customizer::$url = plugins_url( '', __FILE__ );

// Instantiate classes.
new Travel_Joy_Customizer();
new Travel_Joy_Customizer_L10n();

// Include deprecated functions & methods.
require_once wp_normalize_path( dirname( __FILE__ ) . '/deprecated/deprecated.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

// Include the ariColor library.
require_once wp_normalize_path( dirname( __FILE__ ) . '/lib/class-aricolor.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

// Add an empty config for global fields.
Travel_Joy_Customizer::add_config( '' );

$custom_config_path = dirname( __FILE__ ) . '/custom-config.php';
$custom_config_path = wp_normalize_path( $custom_config_path );
if ( file_exists( $custom_config_path ) ) {
	require_once $custom_config_path; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
}

// Add upgrade notifications.
require_once wp_normalize_path( dirname( __FILE__ ) . '/upgrade-notifications.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude

/**
 * To enable tests, add this line to your wp-config.php file (or anywhere alse):
 * define( 'TRAVEL_JOY_CUSTOMIZER_TEST', true );
 *
 * Please note that the example.php file is not included in the wordpress.org distribution
 * and will only be included in dev versions of the plugin in the github repository.
 */
if ( defined( 'TRAVEL_JOY_CUSTOMIZER_TEST' ) && true === TRAVEL_JOY_CUSTOMIZER_TEST && file_exists( dirname( __FILE__ ) . '/example.php' ) ) {
	include_once dirname( __FILE__ ) . '/example.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude
}
