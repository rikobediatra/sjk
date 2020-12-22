<?php
/**
 * Important function for the customizer module are created here.
 *
 * @package ../customizer-module
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create config id for the customizer.
 */
Travel_Joy_Customizer::add_config(
	TRAVEL_JOY_CUSTOMIZER_THEME_CONFIG_ID,
	array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/**
 * Format the string ready for customizer id.
 *
 * @param string $string Raw or unformated string.
 * @return string Formated string.
 */
function travel_joy_format_string_id_ready( $string ) {
	$string_lower = strtolower( $string );
	return str_replace( array( ' ', '-' ), array( '_', '_' ), $string_lower );
}

/**
 * Returns the panel id.
 *
 * @param string $panel_name Customizer panel name.
 * @return string Panel ID.
 */
function travel_joy_get_customizer_panel_id( $panel_name ) {
	if ( empty( $panel_name ) || ! is_string( $panel_name ) ) {
		return;
	}
	$panel_name = travel_joy_format_string_id_ready( $panel_name );
	return 'travel_joy_panel_' . $panel_name;
}

/**
 * Returns the section ID.
 *
 * @param string $parent_panel Parent panel name or ID.
 * @param string $section_name Name of the customizer section.
 * @return string Section ID.
 */
function travel_joy_get_customizer_section_id( $parent_panel, $section_name ) {
	if ( empty( $parent_panel ) || ! is_string( $parent_panel ) ) {
		return;
	}
	if ( empty( $section_name ) || ! is_string( $section_name ) ) {
		return;
	}

	$section_name = travel_joy_format_string_id_ready( $section_name );
	return travel_joy_get_customizer_panel_id( $parent_panel ) . '_section_' . $section_name;
}

/**
 * Returns the settings ID.
 *
 * @param string $panel_name Customizer panel name.
 * @param string $section_name Section Name.
 * @param string $field_name Field Name.
 * @return string Section ID.
 */
function travel_joy_customizer_fields_settings_id( $panel_name, $section_name, $field_name ) {
	$panel_name   = travel_joy_format_string_id_ready( $panel_name );
	$section_name = travel_joy_format_string_id_ready( $section_name );
	$field_name   = travel_joy_format_string_id_ready( $field_name );

	return 'travel_joy_theme_options[' . $panel_name . '][' . $section_name . '][' . $field_name . ']';
}

/**
 * Returns the customizer default data.
 *
 * @param string $panel   Panel id name.
 * @param string $section Section id name.
 * @param string $field   Field id name.
 * @return string  Default value.
 */
function travel_joy_customizer_defaults( $panel, $section, $field ) {
	$panel   = travel_joy_format_string_id_ready( $panel );
	$section = travel_joy_format_string_id_ready( $section );
	$field   = travel_joy_format_string_id_ready( $field );

	$sort_sections = array(
		'trip_activities',
		'popular_destination',
		'featured_trips_slider',
		'popular_tour_packages',
		'blogs',
		'testimonials',
	);

	if ( ! travel_joy_is_wp_travel_active() ) {

		/**
		 * Include the methods name that you want to disable from
		 * customizer when WP Travel is not activated.
		 */
		$sort_sections = array(
			// 'counter',
			'blogs',
			'testimonials',
			// 'featured_on',
		);
	}

	/**
	 * Array Structure.
	 *
	 *  $defaults = array(
	 *      'PANEL_IDs' => array(
	 *          'SECTION_IDs => array(
	 *              'FIELD_IDs => value,
	 *          ),
	 *      ),
	 *  );
	 *
	 * @return array
	 */
	$defaults = array(
		'colors'        => array(
			'colors' => array(
				'link_color'                        => '#4e4e4e',
				'link_hover_color'                  => '#f08039',
				'post_title_color'                  => '#ffffff',
				'primary_button_bg_color'           => '#ff8121',
				'primary_button_hover_color'        => '#f9985b',
				'primary_button_text_color'         => '#ffffff',
				'primary_button_text_hover_color'   => '#ffffff',
				'secondary_button_bg_color'         => '',          // Transparent color.
				'secondary_button_bg_hover_color'   => '#f08039',
				'secondary_button_text_color'       => '#fff',
				'secondary_button_text_hover_color' => '#fff',
				'footer_section_bg_color'           => '#f8f8f8',
			),
		),
		'theme_options' => array(
			'sort_sections' => array(
				'sort_sections' => $sort_sections,
			),
			'footer'        => array(
				'copyright_text' => sprintf( esc_html__( '&copy; All rights reserved | %1$s by %2$s | Proudly powered by %3$s', 'travel-joy' ), 'Travel Joy', '<a class="footer-credit-text" href="https://wensolutions.com/" rel="designer">WEN Solutions</a>', '<a href="https://wordpress.org/" class="footer-credit-text">WordPress</a>' ), // phpcs:ignore
			),
		),
		'front_page'    => array(
			'banner_slider'         => array(
				'enable_banner_slider'    => false,
				'taxonomies_dropdown'     => 'category',
				'terms_category_dropdown' => 'uncategorized',
				'number_of_trip_slides'   => 5,
				'enable_social_links'     => true,
				'enable_search_filter'    => true,
			),
			'trip_activities'       => array(
				'enable_trip_activities'      => false,
				'main_heading'                => esc_html__( 'Trip Activities', 'travel-joy' ),
				'sub_heading'                 => esc_html__( 'Just select where you want to go, we take care of rest', 'travel-joy' ),
				'display_all_trip_activities' => true,
				'enable_button'               => true,
				'button_label'                => esc_html__( 'View All', 'travel-joy' ),
				'button_custom_link'          => get_home_url() . '/itinerary',
				'number_of_packages'          => 3,
			),
			'popular_destination'   => array(
				'enable_popular_destination'       => false,
				'main_heading'                     => esc_html__( 'Popular Destination', 'travel-joy' ),
				'sub_heading'                      => esc_html__( 'Just select where you want to go, we take care of rest', 'travel-joy' ),
				'display_all_popular_destinations' => true,
				'number_of_destination'            => 6,
				'button_label'                     => esc_html__( 'View All', 'travel-joy' ),
				'button_custom_link'               => get_home_url() . '/itinerary',
			),
			'featured_trips_slider' => array(
				'enable_featured_trips_slider' => false,
				'enable_button'                => true,
				'button_label'                 => esc_html__( 'View Details', 'travel-joy' ),
				'display_trip_details'         => true,
			),
			'popular_tour_packages' => array(
				'enable_popular_tour_packages' => false,
				'main_heading'                 => esc_html__( 'Popular Trip Packages', 'travel-joy' ),
				'sub_heading'                  => esc_html__( 'Just select where you want to go, we take care of rest', 'travel-joy' ),
				'button_label'                 => esc_html__( 'View Details', 'travel-joy' ),
				'display_next_departures'      => true,
			),
			'blogs'                 => array(
				'enable_blogs'            => false,
				'main_heading'            => esc_html__( 'Blogs', 'travel-joy' ),
				'sub_heading'             => esc_html__( 'Just select where you want to go, we take care of rest', 'travel-joy' ),
				'taxonomies_dropdown'     => 'category',
				'terms_category_dropdown' => 'uncategorized',
				'number_of_blogs'         => 6,
				'enable_button'           => true,
				'button_label'            => esc_html__( 'View All', 'travel-joy' ),
				'button_custom_link'      => get_permalink( get_option( 'page_for_posts' ) ),
			),
			'testimonials'          => array(
				'enable_testimonials' => false,
				'main_heading'        => esc_html__( 'Testimonials', 'travel-joy' ),
			),
		),
	);

	return isset( $defaults[ $panel ][ $section ][ $field ] ) && ! empty( $defaults[ $panel ][ $section ][ $field ] ) ? $defaults[ $panel ][ $section ][ $field ] : '';
}

/**
 * Returns the theme mod options.
 *
 * @param string $panel   Panel id name.
 * @param string $section Section id name.
 * @param string $field   Field id name.
 * @return string|array Returns theme option array if panel id or section id or field is passed empty.
 */
function travel_joy_get_theme_options( $panel = '', $section = '', $field = '' ) {
	$panel   = ! empty( $panel ) ? travel_joy_format_string_id_ready( $panel ) : '';
	$section = ! empty( $section ) ? travel_joy_format_string_id_ready( $section ) : '';
	$field   = ! empty( $field ) ? travel_joy_format_string_id_ready( $field ) : '';

	$theme_options = get_theme_mod( 'travel_joy_theme_options' );
	$default       = travel_joy_customizer_defaults( $panel, $section, $field );

	if ( empty( $panel ) || empty( $section ) || empty( $field ) ) {
		return $theme_options;
	} else {
		return isset( $theme_options[ $panel ][ $section ][ $field ] ) ? $theme_options[ $panel ][ $section ][ $field ] : $default;
	}
}

/**
 * Returns the list of taxonomies.
 *
 * @param bool $exclude Pass true if you want to exclude WP Travel related taxonomies.
 * @return array $items Array of taxonomies.
 */
function travel_joy_customizer_get_taxonomies( $exclude = false ) {
	$items      = array();
	$taxonomies = array();

	$is_wp_travel_active = travel_joy_is_wp_travel_active();
	if ( $exclude ) {
		$is_wp_travel_active = false;
	}

	$exclude_tax = array(
		'post_format',
	);

	if ( ! $is_wp_travel_active ) {
		$exclude_tax = array_merge(
			$exclude_tax,
			array(
				'itinerary_types',
				'travel_locations',
			)
		);
	}

	$taxonomies = array(
		''                 => __( 'Select Category', 'travel-joy' ),
		'category'         => __( 'Post Category', 'travel-joy' ),
		'pages'            => __( 'Pages', 'travel-joy' ),
		'travel_locations' => __( 'Trip Locations', 'travel-joy' ),
		'itinerary_types'  => __( 'Trip Types', 'travel-joy' ),
	);

	// Build the array.
	foreach ( $taxonomies as $tax_slug => $tax_label ) {
		if ( ! in_array( $tax_slug, $exclude_tax, true ) ) {
			$items[ $tax_slug ] = $tax_label;
		}
	}

	return $items;
}

/**
 * Returns the array terms according to the selected taxonomy.
 *
 * @param string $panel Panel slug or name.
 * @param string $section Section slug or name.
 * @param string $field Field slug or name.
 */
function travel_joy_customizer_get_taxonomy_terms( $panel = '', $section = '', $field = '' ) {
	$items   = array();
	$panel   = ! empty( $panel ) ? travel_joy_format_string_id_ready( $panel ) : '';
	$section = ! empty( $section ) ? travel_joy_format_string_id_ready( $section ) : '';
	$field   = ! empty( $field ) ? travel_joy_format_string_id_ready( $field ) : '';

	$selected_taxonomy = travel_joy_get_theme_options( $panel, $section, $field );

	$terms = get_terms(
		array(
			'taxonomy'   => $selected_taxonomy,
			'hide_empty' => true,
		)
	);

	if ( is_array( $terms ) && count( $terms ) > 0 ) {
		foreach ( $terms as $term ) {
			$term_name           = ! empty( $term->name ) ? $term->name : '';
			$term_slug           = ! empty( $term->slug ) ? $term->slug : '';
			$items[ $term_slug ] = $term_name;
		}
	}

	return $items;

}

/**
 * Returns the terms array of category taxonomy.
 */
function travel_joy_get_terms_for_category_taxonomy() {
	$items = array();
	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		)
	);

	if ( is_array( $terms ) && count( $terms ) > 0 ) {
		foreach ( $terms as $term ) {
			$term_name           = ! empty( $term->name ) ? $term->name : '';
			$term_slug           = ! empty( $term->slug ) ? $term->slug : '';
			$items[ $term_slug ] = $term_name;
		}
	}

	return $items;
}

/**
 * Returns the terms array of travel_locations taxonomy.
 */
function travel_joy_get_terms_for_travel_locations_taxonomy() {
	$items = array();
	$terms = get_terms(
		array(
			'taxonomy'   => 'travel_locations',
			'hide_empty' => false,
		)
	);

	if ( is_array( $terms ) && count( $terms ) > 0 ) {
		foreach ( $terms as $term ) {
			$term_name           = ! empty( $term->name ) ? $term->name : '';
			$term_slug           = ! empty( $term->slug ) ? $term->slug : '';
			$items[ $term_slug ] = $term_name;
		}
	}

	return $items;
}


/**
 * Returns the terms array of trip_activity taxonomy.
 */
function travel_joy_get_terms_for_trip_activity_taxonomy() {
	$items = array();
	$terms = get_terms(
		array(
			'taxonomy'   => 'activity',
			'hide_empty' => false,
		)
	);

	if ( is_array( $terms ) && count( $terms ) > 0 ) {
		foreach ( $terms as $term ) {
			$term_name           = ! empty( $term->name ) ? $term->name : '';
			$term_slug           = ! empty( $term->slug ) ? $term->slug : '';
			$items[ $term_slug ] = $term_name;
		}
	}

	return $items;
}


/**
 * Returns the terms array of itinerary_types taxonomy.
 */
function travel_joy_get_terms_for_itinerary_types_taxonomy() {
	$items = array();
	$terms = get_terms(
		array(
			'taxonomy'   => 'itinerary_types',
			'hide_empty' => false,
		)
	);

	if ( is_array( $terms ) && count( $terms ) > 0 ) {
		foreach ( $terms as $term ) {
			$term_name           = ! empty( $term->name ) ? $term->name : '';
			$term_slug           = ! empty( $term->slug ) ? $term->slug : '';
			$items[ $term_slug ] = $term_name;
		}
	}

	return $items;
}
