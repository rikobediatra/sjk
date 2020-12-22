<?php
/**
 * All the panels for the customizer are generated from here.
 *
 * @package ../customizer-module/inc/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$priority = 200;

Travel_Joy_Customizer::add_panel(
	travel_joy_get_customizer_panel_id( 'Front Page' ),
	array(
		'title'       => __( 'Front Page', 'travel-joy' ),
		'description' => __( 'This panel has all the settings for the frontpage layout.', 'travel-joy' ),
		'priority'    => $priority,
	)
);

Travel_Joy_Customizer::add_panel(
	travel_joy_get_customizer_panel_id( 'Theme Options' ),
	array(
		'title'       => __( 'Theme Options', 'travel-joy' ),
		'description' => __( 'This panel has all the general settings and options for the theme.', 'travel-joy' ),
		'priority'    => $priority,
	)
);
