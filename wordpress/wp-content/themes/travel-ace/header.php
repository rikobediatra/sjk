<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Travel Ace
 */
/**
* Hook - travel_ace_action_doctype.
*
* @hooked travel_ace_doctype -  10
*/
do_action( 'travel_ace_action_doctype' );
?>
<head>
<?php
/**
* Hook - travel_ace_action_head.
*
* @hooked travel_ace_head -  10
*/
do_action( 'travel_ace_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php

/**
* Hook - travel_ace_action_before.
*
* @hooked travel_ace_page_start - 10
*/
do_action( 'travel_ace_action_before' );

/**
*
* @hooked travel_ace_header_start - 10
*/
do_action( 'travel_ace_action_before_header' );

/**
*
*@hooked travel_ace_site_branding - 10
*@hooked travel_ace_header_end - 15 
*/
do_action('travel_ace_action_header');

/**
*
* @hooked travel_ace_content_start - 10
*/
do_action( 'travel_ace_action_before_content' );

/**
 * Banner start
 * 
 * @hooked travel_ace_banner_header - 10
*/
do_action( 'travel_ace_banner_header' );  
