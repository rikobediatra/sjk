<?php
/**
 * Home Page Options.
 *
 * @package Travel Ace
 */

$default = travel_ace_get_default_theme_options();

// Latest Blog Section
$wp_customize->add_section( 'section_home_blog',
	array(
		'title'      => __( 'Recent Articles', 'travel-ace' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'home_page_panel',
		)
);
// Enable Blog Section
$wp_customize->add_setting('theme_options[enable_blog_section]', 
	array(
	'default' 			=> $default['enable_blog_section'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'travel_ace_sanitize_checkbox'
	)
);

$wp_customize->add_control('theme_options[enable_blog_section]', 
	array(		
	'label' 	=> __('Enable Recent Articles Section', 'travel-ace'),
	'section' 	=> 'section_home_blog',
	'settings'  => 'theme_options[enable_blog_section]',
	'type' 		=> 'checkbox',	
	)
);

// Section Title
$wp_customize->add_setting('theme_options[blog_section_title]', 
	array(
	'default'           => $default['blog_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[blog_section_title]', 
	array(
	'label'       => __('Section Title', 'travel-ace'),
	'section'     => 'section_home_blog',   
	'settings'    => 'theme_options[blog_section_title]',	
	'active_callback' => 'travel_ace_blog_active',		
	'type'        => 'text'
	)
);

// Setting  Blog Category.
$wp_customize->add_setting( 'theme_options[blog_category]',
	array(
	'default'           => $default['blog_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new travel_ace_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[blog_category]',
		array(
		'label'    => __( 'Select Category', 'travel-ace' ),
		'section'  => 'section_home_blog',
		'settings' => 'theme_options[blog_category]',	
		'active_callback' => 'travel_ace_blog_active',		
		'priority' => 100,
		)
	)
);

// Blog Number.
$wp_customize->add_setting( 'theme_options[blog_number]',
	array(
		'default'           => $default['blog_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'travel_ace_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[blog_number]',
	array(
		'label'       => __( 'Number of Posts', 'travel-ace' ),
		'description' => __('Maximum number of post to show is 6.', 'travel-ace'),
		'section'     => 'section_home_blog',
		'active_callback' => 'travel_ace_blog_active',		
		'type'        => 'number',
		'priority'    => 100,
		'input_attrs' => array( 'min' => 1, 'max' => 6, 'step' => 1, 'style' => 'width: 115px;' ),
		
	)
);