<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Travel Ace
 */

/**
 *
 * @hooked travel_ace_footer_start
 */
do_action( 'travel_ace_action_before_footer' );

/**
 * Hooked - travel_ace_footer_top_section -10
 * Hooked - travel_ace_footer_section -20
 */
do_action( 'travel_ace_action_footer' );

/**
 * Hooked - travel_ace_footer_end. 
 */
do_action( 'travel_ace_action_after_footer' );

wp_footer(); ?>

</body>  
</html>