<?php
/**
 * Default theme options.
 *
 * @package Travel Ace
 */

if ( ! function_exists( 'travel_ace_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function travel_ace_get_default_theme_options() {

	$defaults = array();

	// Top Bar
	$defaults['show_header_contact_info'] 		= false;
    $defaults['show_header_social_links'] 		= false;
    $defaults['header_social_links']			= array();

    // Homepage Options
	$defaults['enable_frontpage_content'] 		= false;

	// Featured Slider Section
	$defaults['enable_featured_slider']			= false;
	$defaults['number_of_slider_items']			= 3;
	$defaults['slider_content_type']			= 'slider_page';

	// Our Services Section
	$defaults['enable_our_services_section']	= false;
	$defaults['number_of_items']				= 3;
	$defaults['services_content_type']			= 'services_page';

	// Popular Destinations Section	
	$defaults['enable_popular_destinations_section']	= false;
	$defaults['popular_destinations_section_title']		= esc_html__( 'Special Offer', 'travel-ace' );
	$defaults['number_of_cs_items']				= 5;
	$defaults['cs_content_type']				= 'cs_page';

	//Call To Action Section	
	$defaults['enable_cta_section']	   			= false;
	$defaults['cta_title']	   	 				= esc_html__( 'Explore A Different Way to Travel', 'travel-ace' );
	$defaults['cta_button_label']	   	 		= esc_html__( 'Learn More', 'travel-ace' );
	$defaults['cta_button_url']	   	 			= '#';

	// Blog Section
	$defaults['enable_blog_section']			= false;
	$defaults['blog_section_title']				= esc_html__( 'Our Blog', 'travel-ace' );
	$defaults['blog_category']	   				= 0; 
	$defaults['blog_number']					= 3;	

	//General Section
	$defaults['readmore_text']					= esc_html__('Read More','travel-ace');
	$defaults['your_latest_posts_title']		= esc_html__('Blog','travel-ace');
	$defaults['excerpt_length']					= 15;
	$defaults['layout_options_blog']			= 'no-sidebar';
	$defaults['layout_options_archive']			= 'no-sidebar';
	$defaults['layout_options_page']			= 'right-sidebar';	
	$defaults['layout_options_single']			= 'right-sidebar';	

	//Footer section 		
	$defaults['copyright_text']					= esc_html__( 'Copyright &copy; All rights reserved.', 'travel-ace' );

	// Pass through filter.
	$defaults = apply_filters( 'travel_ace_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'travel_ace_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function travel_ace_get_option( $key ) {

		$default_options = travel_ace_get_default_theme_options();
		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;