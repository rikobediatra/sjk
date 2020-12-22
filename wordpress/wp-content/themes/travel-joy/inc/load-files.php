<?php
/**
 * All the neccessary loading is done here.
 *
 * @package travel-joy
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$travel_joy_root = get_template_directory();

/**
 * Initialize customizer module.
 */
require_once $travel_joy_root . '/framework/customizer-module/class-init-customizer-module.php';

/**
 * Implement the Custom Header feature.
 */
require_once $travel_joy_root . '/inc/breadcrumb-class.php';

/**
 * Implement the Custom Header feature.
 */
require_once $travel_joy_root . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once $travel_joy_root . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once $travel_joy_root . '/inc/template-functions.php';

/**
 * Class which loads the assets for this theme.
 */
require_once $travel_joy_root . '/inc/class-assets.php';

/**
 * Class which loads the assets for this theme.
 */
require_once $travel_joy_root . '/inc/class-travel-joy-dynamic-styling-settings.php';

/**
 * This file has the required codes for the frontpage section hooks.
 */
require_once $travel_joy_root . '/template-parts/structure-hooks.php';

/**
 * This file handles the single itinerary page and archive-itinerary page of wp travel plugin.
 * It uses the default wp travel hooks.
 */
require_once $travel_joy_root . '/template-parts/wp-travel-hooks.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require_once $travel_joy_root . '/inc/jetpack.php';
}
