<?php
/**
 * Featured Slider options.
 *
 * @package Travel Ace
 */

$default = travel_ace_get_default_theme_options();

// Featured Slider Section
$wp_customize->add_section( 'section_featured_slider',
	array(
		'title'      => __( 'Featured Slider', 'travel-ace' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);

// Enable Featured Slider Section
$wp_customize->add_setting('theme_options[enable_featured_slider]', 
	array(
	'default' 			=> $default['enable_featured_slider'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'travel_ace_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_featured_slider]', 
	array(		
	'label' 	=> __('Enable Featured Slider Section', 'travel-ace'),
	'section' 	=> 'section_featured_slider',
	'settings'  => 'theme_options[enable_featured_slider]',
	'type' 		=> 'checkbox',	
	)
);

// Number of items
$wp_customize->add_setting('theme_options[number_of_slider_items]', 
	array(
	'default' 			=> $default['number_of_slider_items'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'travel_ace_sanitize_number_range'
	)
);

$wp_customize->add_control('theme_options[number_of_slider_items]', 
	array(
	'label'       => __('Number Of Slides', 'travel-ace'),
	'description' => __('Save & Refresh the customizer to see its effect. Maximum is 3.', 'travel-ace'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[number_of_slider_items]',		
	'type'        => 'number',
	'active_callback' => 'travel_ace_slider_active',
	'input_attrs' => array(
			'min'	=> 1,
			'max'	=> 3,
			'step'	=> 1,
		),
	)
);

// Content Type
$wp_customize->add_setting('theme_options[slider_content_type]', 
	array(
	'default' 			=> $default['slider_content_type'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'travel_ace_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[slider_content_type]', 
	array(
	'label'       => __('Content Type', 'travel-ace'),
	'section'     => 'section_featured_slider',   
	'settings'    => 'theme_options[slider_content_type]',		
	'type'        => 'select',
	'active_callback' => 'travel_ace_slider_active',
	'choices'	  => array(
			'slider_page'	  => __('Page','travel-ace'),
			'slider_post'	  => __('Post','travel-ace'),
		),
	)
);

$number_of_slider_items = travel_ace_get_option( 'number_of_slider_items' );

for( $i=1; $i<=$number_of_slider_items; $i++ ){

	// Page
	$wp_customize->add_setting('theme_options[slider_page_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'travel_ace_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[slider_page_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Page #%1$s', 'travel-ace'), $i),
		'section'     => 'section_featured_slider',   
		'settings'    => 'theme_options[slider_page_'.$i.']',		
		'type'        => 'dropdown-pages',
		'active_callback' => 'travel_ace_slider_page',
		)
	);

	// Posts
	$wp_customize->add_setting('theme_options[slider_post_'.$i.']', 
		array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',	
		'sanitize_callback' => 'travel_ace_dropdown_pages'
		)
	);

	$wp_customize->add_control('theme_options[slider_post_'.$i.']', 
		array(
		'label'       => sprintf( __('Select Post #%1$s', 'travel-ace'), $i),
		'section'     => 'section_featured_slider',   
		'settings'    => 'theme_options[slider_post_'.$i.']',		
		'type'        => 'select',
		'choices'	  => travel_ace_dropdown_posts(),
		'active_callback' => 'travel_ace_slider_post',
		)
	);
}