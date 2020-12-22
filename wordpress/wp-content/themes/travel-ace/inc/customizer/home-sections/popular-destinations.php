<?php
/**
 * Popular Destinations options.
 *
 * @package Travel Ace
 */

$default = travel_ace_get_default_theme_options();

// Featured Popular Destinations Section
$wp_customize->add_section( 'section_popular_destinations',
	array(
		'title'      => __( 'Popular Destinations', 'travel-ace' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);
// Disable Popular Destinations Section
$wp_customize->add_setting('theme_options[enable_popular_destinations_section]', 
	array(
	'default' 			=> $default['enable_popular_destinations_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'travel_ace_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_popular_destinations_section]', 
	array(		
	'label' 	=> __('Enable Popular Destinations Section', 'travel-ace'),
	'section' 	=> 'section_popular_destinations',
	'settings'  => 'theme_options[enable_popular_destinations_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[popular_destinations_section_title]', 
	array(
	'default'           => $default['popular_destinations_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[popular_destinations_section_title]', 
	array(
	'label'       => __('Section Title', 'travel-ace'),
	'section'     => 'section_popular_destinations',   
	'settings'    => 'theme_options[popular_destinations_section_title]',	
	'active_callback' => 'travel_ace_popular_destinations_active',		
	'type'        => 'text'
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_cs_items]', 
	array(
	'default' 			=> $default['number_of_cs_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'travel_ace_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_cs_items]', 
	array(
	'label'       => __('Number Of Items', 'travel-ace'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 5.', 'travel-ace'),
	'section'     => 'section_popular_destinations',   
	'settings'    => 'theme_options[number_of_cs_items]',		
	'type'        => 'number',
	'active_callback' => 'travel_ace_popular_destinations_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 5,
			'step'	=> 1,
		),
	)
);

$wp_customize->add_setting('theme_options[cs_content_type]', 
	array(
	'default' 			=> $default['cs_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'travel_ace_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[cs_content_type]', 
	array(
	'label'       => __('Content Type', 'travel-ace'),
	'section'     => 'section_popular_destinations',   
	'settings'    => 'theme_options[cs_content_type]',		
	'type'        => 'select',
	'active_callback' => 'travel_ace_popular_destinations_active',
	'choices'	  => array(
			'cs_page'	  => __('Page','travel-ace'),
			'cs_post'	  => __('Post','travel-ace'),
		),
	)
);

$number_of_cs_items = travel_ace_get_option( 'number_of_cs_items' );

for( $i=1; $i<=$number_of_cs_items; $i++ ){

	// Page
	$wp_customize->add_setting('theme_options[popular_destinations_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'travel_ace_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[popular_destinations_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'travel-ace'), $i),
		'section'     => 'section_popular_destinations',   
		'settings'    => 'theme_options[popular_destinations_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'travel_ace_popular_destinations_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[popular_destinations_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'travel_ace_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[popular_destinations_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'travel-ace'), $i),
		'section'     => 'section_popular_destinations',   
		'settings'    => 'theme_options[popular_destinations_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => travel_ace_dropdown_posts(),
		'active_callback' => 'travel_ace_popular_destinations_post',
		)
	);
}