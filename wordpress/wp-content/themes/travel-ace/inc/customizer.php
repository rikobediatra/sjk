<?php
/**
 * Travel Ace Theme Customizer
 *
 * @package Travel Ace
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function travel_ace_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Register custom section types.
	$wp_customize->register_section_type( 'travel_ace_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new travel_ace_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Travel Ace Pro', 'travel-ace' ),
				'pro_text' => esc_html__( 'Buy Pro', 'travel-ace' ),
				'pro_url'  => 'http://www.creativthemes.com/downloads/travel-ace-pro/',
				'priority'  => 10,
			)
		)
	);

	// Load customize sanitize.
	include get_template_directory() . '/inc/customizer/sanitize.php';

	// Load customize sanitize.
	include get_template_directory() . '/inc/customizer/active-callback.php';

	// Load topbar sections option.
	include get_template_directory() . '/inc/customizer/topbar.php';

	// Load header sections option.
	include get_template_directory() . '/inc/customizer/theme-section.php';

	// Load home page sections option.
	include get_template_directory() . '/inc/customizer/home-section.php';
	
}
add_action( 'customize_register', 'travel_ace_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function travel_ace_customize_preview_js() {
	wp_enqueue_script( 'travel_ace_customizer', get_template_directory_uri() . '/inc/customizer/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'travel_ace_customize_preview_js' );
/**
 *
 */
function travel_ace_customize_backend_scripts() {

	wp_enqueue_style( 'travel-ace-admin-customizer-style', get_template_directory_uri() . '/inc/customizer/css/customizer-style.css' );
	wp_enqueue_script( 'travel-ace-admin-customizer', get_template_directory_uri() . '/inc/customizer/js/customizer-script.js', array( 'jquery', 'customize-controls' ), '20151215', true );
}
add_action( 'customize_controls_enqueue_scripts', 'travel_ace_customize_backend_scripts', 10 );
