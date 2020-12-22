<?php
/**
 * This file has all the required code for creating the sections for the panels.
 *
 * @package ../customizer-module/inc/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Travel_Joy_Customizer_Init_Sections' ) ) {

	/**
	 * Class to load and initialize the sections according to the panel.
	 *
	 * WARNING: Do not create any other method in this class other then initializing sections.
	 */
	class Travel_Joy_Customizer_Init_Sections {

		/**
		 * Initialize class.
		 */
		public function __construct() {
			$this->load_methods();
		}

		/**
		 * Automatically loads all the methods of this class.
		 *
		 * @return void
		 */
		public function load_methods() {
			$methods = get_class_methods( $this );

			/**
			 * Exclude construct and this method.
			 */
			if ( is_array( $methods ) && isset( $methods[0] ) && isset( $methods[1] ) ) {
				unset( $methods[0] );
				unset( $methods[1] );
			}

			if ( is_array( $methods ) && count( $methods ) > 0 ) {
				foreach ( $methods as $panel_names ) {
					if ( method_exists( $this, $panel_names ) ) {
						$this->$panel_names();
					}
				}
			}
		}

		/**
		 * This method has all the section for the Theme Options panel.
		 *
		 * @return void
		 */
		public function theme_options() {

			$panel_name = __FUNCTION__;

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Site Layout' ),
				array(
					'title'       => __( 'Site Layout', 'travel-joy' ),
					'description' => __( 'Set the over all site layout.', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Footer' ),
				array(
					'title'    => __( 'Footer', 'travel-joy' ),
					'panel'    => travel_joy_get_customizer_panel_id( $panel_name ),
					'priority' => 160,
				)
			);

		}

		/**
		 * This method has all the section for the Front Page panel.
		 *
		 * @return void
		 */
		public function front_page() {

			$panel_name = __FUNCTION__;

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Banner Slider' ),
				array(
					'title'       => __( 'Banner Slider', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'Customize the main banner slider options including the social links.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Trip Activities' ),
				array(
					'title'       => __( 'Trip Activities', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'Display the trip activities packages of WP Travel. You can create trip activities from Dashboard > Trips > Activites.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Popular Destination' ),
				array(
					'title'       => __( 'Popular Destinations', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'Display your destination packages. You can create the packages from Dashboard > Trips > Destinations.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Featured Trips Slider' ),
				array(
					'title'       => __( 'Featured Trips Slider', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'All the trips that you set as featured will be displayed in slider here.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Popular Tour Packages' ),
				array(
					'title'       => __( 'Popular Trip Packages', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'Select your trips packages from here to set it as popular trip packages.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Blogs' ),
				array(
					'title'       => __( 'Blogs', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'Display or configure your latest blog posts listing.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

			Travel_Joy_Customizer::add_section(
				travel_joy_get_customizer_section_id( $panel_name, 'Testimonials' ),
				array(
					'title'       => __( 'Testimonials', 'travel-joy' ),
					'panel'       => travel_joy_get_customizer_panel_id( $panel_name ),
					'description' => __( 'Display or create the testimonials from here.', 'travel-joy' ),
					'priority'    => 160,
				)
			);

		}
	}
}
new Travel_Joy_Customizer_Init_Sections();
