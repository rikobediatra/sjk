<?php
/**
 * This file has all the required codes for the creating required fields for the sections.
 *
 * @package ../customizer-module/inc/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Travel_Joy_Customizer_Init_Fields' ) ) {

	/**
	 * Class to load and initialize the fields according to the sections.
	 *
	 * Steps:
	 * 1. Set the panel id, section id and field id in the function travel_joy_customizer_defaults.
	 * 2. Set settings name in this pattern => travel_joy_theme_options[PANEL_NAME][SECTION_NAME][FIELD_NAME]
	 * WARNING: Do not create any other method in this class other then initializing sections.
	 *
	 * Table of contents:
	 * - Theme Options
	 *  * site_layout
	 *  * footer
	 * - Front page
	 *  * banner_slider
	 *  * trip_activities
	 *  * popular_destination
	 *  * featured_trips_slider
	 *  * popular_tour_packages
	 *  * blogs
	 *  * testimonials
	 */
	class Travel_Joy_Customizer_Init_Fields {

		/**
		 * Returns true if wp travel is active.
		 *
		 * @var boolean
		 */
		public $is_wp_travel_active = false;

		/**
		 * Initialize class.
		 */
		public function __construct() {
			$this->is_wp_travel_active = travel_joy_is_wp_travel_active();
			$this->load_methods();
		}

		/**
		 * Automatically loads all the methods of this class.
		 *
		 * @return void
		 */
		public function load_methods() {
			$methods             = get_class_methods( $this );
			$sections_to_disable = array();

			$wp_travel_dependent_sections = travel_joy_wp_travel_dependent_sections();

			if ( ! $this->is_wp_travel_active ) {

				/**
				 * Include the methods name that you want to disable from
				 * customizer when WP Travel is not activated.
				 */
				$sections_to_disable = array_merge( $sections_to_disable, $wp_travel_dependent_sections );
			}

			/**
			 * Exclude construct and load methods.
			 */
			if ( is_array( $methods ) && isset( $methods[0] ) && isset( $methods[1] ) ) {
				unset( $methods[0] );
				unset( $methods[1] );
			}

			if ( is_array( $methods ) && count( $methods ) > 0 ) {
				foreach ( $methods as $section_names ) {
					if ( method_exists( $this, $section_names ) ) {
						if ( ! in_array( $section_names, $sections_to_disable, true ) ) {
							$this->$section_names();
						}
					}
				}
			}
		}

		/**
		 * This method has all the fields for the Homepage Settings sections.
		 *
		 * Structure: Theme Options > Homepage Settings > ***
		 *
		 * @return void
		 */
		public function static_front_page() {
			$panel_name   = __FUNCTION__;
			$section_name = $panel_name;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'        => 'checkbox',
					'settings'    => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable content' ),
					'label'       => esc_html__( 'Enable content', 'travel-joy' ),
					'description' => esc_html__( 'Check to enable content on static front page only.', 'travel-joy' ),
					'section'     => $section_name,
					'priority'    => 10,
				)
			);

		}

		/**
		 * This method has all the fields for the Site Layout sections.
		 *
		 * Structure: Theme Options > Site Layout > ***
		 *
		 * @return void
		 */
		public function site_layout() {
			$panel_name     = 'theme_options';
			$section_name   = __FUNCTION__;
			$layout_options = array(
				'right_sidebar' => __( 'Right sidebar', 'travel-joy' ),
				'full_width'    => __( 'Full width', 'travel-joy' ),
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'select',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Single Post Layout' ),
					'label'    => __( 'Single Post Layout', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Single Post Layout' ),
					'priority' => 10,
					'multiple' => false,
					'choices'  => $layout_options,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'select',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Pages Layout' ),
					'label'    => __( 'Pages Layout', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Pages Layout' ),
					'priority' => 10,
					'multiple' => false,
					'choices'  => $layout_options,
				)
			);
		}

		/**
		 * This method has all the fields for the Footer sections.
		 *
		 * Structure: Theme Options > Footer > ***
		 *
		 * @return void
		 */
		public function footer() {
			$panel_name   = 'theme_options';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'text',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Facebook' ),
					'label'    => __( 'Facebook', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Facebook' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'text',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Twitter' ),
					'label'    => __( 'Twitter', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Twitter' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'text',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Instagram' ),
					'label'    => __( 'Instagram', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Instagram' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'text',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'LinkedIn' ),
					'label'    => __( 'LinkedIn', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'LinkedIn' ),
					'priority' => 10,
				)
			);

		}

		/**
		 * This method has all the fields for the Social Links sections.
		 *
		 * Structure: Front Page > Social Links > ***
		 *
		 * @return void
		 */
		public function banner_slider() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			// Slider.
			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
					'label'    => __( 'Enable Banner Slider Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable Banner Slider' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
					'label'           => __( 'Select Taxonomy', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Taxonomies Dropdown' ),
					'priority'        => 10,
					'multiple'        => false,
					'choices'         => travel_joy_customizer_get_taxonomies(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Terms Category Dropdown' ),
					'label'           => __( 'Select Terms For Slider ', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Terms Category Dropdown' ),
					'priority'        => 10,
					'multiple'        => false,
					'choices'         => travel_joy_get_terms_for_category_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'category',
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'dropdown-pages',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Pages Dropdown' ),
					'label'           => __( 'Select Pages For Slider ', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Pages Dropdown' ),
					'priority'        => 10,
					'multiple'        => 5,
					'description'     => esc_html__( 'You can select maximum of 5 pages', 'travel-joy' ),
					'choices'         => travel_joy_get_terms_for_travel_locations_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'pages',
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Terms Travel Locations Dropdown' ),
					'label'           => __( 'Select Terms For Slider ', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Terms Travel Locations Dropdown' ),
					'priority'        => 10,
					'multiple'        => false,
					'choices'         => travel_joy_get_terms_for_travel_locations_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'travel_locations',
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Terms Itinerary Types Dropdown' ),
					'label'           => __( 'Select Terms For Slider ', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Terms Itinerary Types Dropdown' ),
					'priority'        => 10,
					'multiple'        => false,
					'choices'         => travel_joy_get_terms_for_itinerary_types_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'itinerary_types',
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Facebook' ),
					'label'           => __( 'Facebook', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Facebook' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Social Links' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Twitter' ),
					'label'           => __( 'Twitter', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Twitter' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Social Links' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'LinkedIn' ),
					'label'           => __( 'LinkedIn', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'LinkedIn' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Social Links' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Instagram' ),
					'label'           => __( 'Instagram', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Instagram' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Banner Slider' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable Social Links' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

		}

		/**
		 * This method has all the fields for the Trip Activities sections.
		 *
		 * Structure: Front Page > Trip Activities > ***
		 *
		 * @return void
		 */
		public function trip_activities() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'enable trip activities' ),
					'label'    => __( 'Enable Trip Activities Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'enable trip activities' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'main heading' ),
					'label'           => __( 'Main Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'main heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'enable trip activities' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'textarea',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'sub heading' ),
					'label'           => __( 'Sub Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'sub heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'enable trip activities' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

		}

		/**
		 * This method has all the fields for the Popular Destination sections.
		 *
		 * Structure: Front Page > Popular Destination > ***
		 *
		 * @return void
		 */
		public function popular_destination() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular destination' ),
					'label'    => __( 'Enable Popular Destination Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable popular destination' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'main heading' ),
					'label'           => __( 'Main Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'main heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular destination' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'textarea',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'sub heading' ),
					'label'           => __( 'Sub Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'sub heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular destination' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

		}

		/**
		 * This method has all the fields for the Featured Trips Slider sections.
		 *
		 * Structure: Front Page > Featured Trips Slider > ***
		 *
		 * @return void
		 */
		public function featured_trips_slider() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable featured trips slider' ),
					'label'    => __( 'Enable Featured Trips Slider Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable featured trips slider' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'toggle',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'display trip details' ),
					'label'           => __( 'Display Trip Details?', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable featured trips slider' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable featured trips slider' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

		}

		/**
		 * This method has all the fields for the Popular Tour Packages sections.
		 *
		 * Structure: Front Page > Popular Tour Packages > ***
		 *
		 * @return void
		 */
		public function popular_tour_packages() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular tour packages' ),
					'label'    => __( 'Enable Popular Tour Packages Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable popular tour packages' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'main heading' ),
					'label'           => __( 'Main Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'main heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular tour packages' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'textarea',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'sub heading' ),
					'label'           => __( 'Sub Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'sub heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular tour packages' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Trips Dropdown' ),
					'label'           => __( 'Select Trips', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'priority'        => 10,
					'multiple'        => 3, // Set greater than 1 for multiple select.
					'choices'         => Travel_Joy_Customizer_Helper::get_posts(
						array(
							'post_type'   => 'itineraries',
							'post_status' => 'publish',
						)
					),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular tour packages' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'toggle',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'display next departures' ),
					'label'           => __( 'Display Next Departures?', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'display next departures' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable popular tour packages' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);
		}

		/**
		 * This method has all the fields for the Popular Tour Packages sections.
		 *
		 * Structure: Front Page > Popular Tour Packages > ***
		 *
		 * @return void
		 */
		public function blogs() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable blogs' ),
					'label'    => __( 'Enable Blogs Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable blogs' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Main Heading' ),
					'label'           => __( 'Main Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Main Heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable blogs' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'textarea',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Sub Heading' ),
					'label'           => __( 'Sub Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Sub Heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable blogs' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
					'label'           => __( 'Select Taxonomy', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'priority'        => 10,
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Taxonomies Dropdown' ),
					'multiple'        => false,
					'choices'         => travel_joy_customizer_get_taxonomies( true ),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable blogs' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'dropdown-pages',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Pages Dropdown' ),
					'label'           => __( 'Select Pages For Listing', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Pages Dropdown' ),
					'priority'        => 10,
					'multiple'        => 6,
					'choices'         => travel_joy_get_terms_for_travel_locations_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable blogs' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'pages',
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Terms Category Dropdown' ),
					'label'           => __( 'Select Term For Blogs ', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'priority'        => 10,
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Terms Category Dropdown' ),
					'multiple'        => false,
					'choices'         => travel_joy_get_terms_for_category_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable blogs' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'category',
						),
					),
				)
			);

		}

		/**
		 * This method has all the fields for the Testimonials sections.
		 *
		 * Structure: Front Page > Testimonials > ***
		 *
		 * @return void
		 */
		public function testimonials() {
			$panel_name   = 'front_page';
			$section_name = __FUNCTION__;

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'     => 'toggle',
					'settings' => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable testimonials' ),
					'label'    => __( 'Enable Testimonials Section?', 'travel-joy' ),
					'section'  => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'  => travel_joy_customizer_defaults( $panel_name, $section_name, 'Enable testimonials' ),
					'priority' => 10,
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'text',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Main Heading' ),
					'label'           => __( 'Main Heading', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Main Heading' ),
					'priority'        => 10,
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable testimonials' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
					'label'           => __( 'Taxonomy', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'priority'        => 10,
					'multiple'        => false,
					'choices'         => travel_joy_customizer_get_taxonomies( true ),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable testimonials' ),
							'operator' => '==',
							'value'    => true,
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'select',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Terms Category Dropdown' ),
					'label'           => __( 'Select Term For Testimonials', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'priority'        => 10,
					'multiple'        => false,
					'choices'         => travel_joy_get_terms_for_category_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable testimonials' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'category',
						),
					),
				)
			);

			Travel_Joy_Customizer::add_field(
				TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
				array(
					'type'            => 'dropdown-pages',
					'settings'        => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Pages Dropdown' ),
					'label'           => __( 'Select Pages For Testimonials', 'travel-joy' ),
					'section'         => travel_joy_get_customizer_section_id( $panel_name, $section_name ),
					'default'         => travel_joy_customizer_defaults( $panel_name, $section_name, 'Pages Dropdown' ),
					'priority'        => 10,
					'multiple'        => 6,
					'choices'         => travel_joy_get_terms_for_travel_locations_taxonomy(),
					'active_callback' => array(
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Enable testimonials' ),
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => travel_joy_customizer_fields_settings_id( $panel_name, $section_name, 'Taxonomies Dropdown' ),
							'operator' => '==',
							'value'    => 'pages',
						),
					),
				)
			);

		}

	}

}

if ( ! function_exists( 'travel_joy_customizer_init_fields' ) ) {

	/**
	 * Hook the fields to init hook.
	 * It is necessary as the fields are being triggered before custom post taxonomies.
	 */
	function travel_joy_customizer_init_fields() {
		new Travel_Joy_Customizer_Init_Fields();
	}
	add_action( 'init', 'travel_joy_customizer_init_fields' );
}
