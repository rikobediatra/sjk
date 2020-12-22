<?php
/**
 * Call to action options.
 *
 * @package Travel Ace
 */

$default = travel_ace_get_default_theme_options();

// Call to action section
$wp_customize->add_section( 'section_cta',
	array(
		'title'      => __( 'Call To Action', 'travel-ace' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);
// Disable Cta Section
$wp_customize->add_setting('theme_options[enable_cta_section]', 
	array(
	'default' 			=> $default['enable_cta_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'travel_ace_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_cta_section]', 
	array(		
	'label' 	=> __('Enable Call To Action Section', 'travel-ace'),
	'section' 	=> 'section_cta',
	'settings'  => 'theme_options[enable_cta_section]',
	'type' 		=> 'checkbox',	
	)
);

// Cta Background Image
$wp_customize->add_setting('theme_options[background_cta_section]', 
	array(
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'travel_ace_sanitize_image'
	)
);

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
	'theme_options[background_cta_section]', 
	array(
	'label'       => __('Background Image', 'travel-ace'),
	'section'     => 'section_cta',   
	'settings'    => 'theme_options[background_cta_section]',		
	'active_callback' => 'travel_ace_cta_active',
	'type'        => 'image',
	)
	)
);

// Cta Title
$wp_customize->add_setting('theme_options[cta_title]', 
	array(
	'default' 			=> $default['cta_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[cta_title]', 
	array(
	'label'       => __('Title', 'travel-ace'),
	'section'     => 'section_cta',   
	'settings'    => 'theme_options[cta_title]',
	'active_callback' => 'travel_ace_cta_active',		
	'type'        => 'text'
	)
);

// Cta Button Text
$wp_customize->add_setting('theme_options[cta_button_label]', 
	array(
	'default' 			=> $default['cta_button_label'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[cta_button_label]', 
	array(
	'label'       => __('Button Label', 'travel-ace'),
	'section'     => 'section_cta',   
	'settings'    => 'theme_options[cta_button_label]',	
	'active_callback' => 'travel_ace_cta_active',	
	'type'        => 'text'
	)
);
// Cta Button Url
$wp_customize->add_setting('theme_options[cta_button_url]', 
	array(
	'default' 			=> $default['cta_button_url'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[cta_button_url]', 
	array(
	'label'       => __('Button Url', 'travel-ace'),
	'section'     => 'section_cta',   
	'settings'    => 'theme_options[cta_button_url]',	
	'active_callback' => 'travel_ace_cta_active',	
	'type'        => 'url'
	)
);