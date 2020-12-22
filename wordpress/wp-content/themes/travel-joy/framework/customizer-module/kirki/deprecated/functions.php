<?php
// phpcs:ignoreFile

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travel_joy_customizer_get_option' ) ) {
	/**
	 * Get the value of a field.
	 * This is a deprecated function that we used when there was no API.
	 * Please use the Travel_Joy_Customizer::get_option() method instead.
	 * Documentation is available for the new method on https://github.com/aristath/kirki/wiki/Getting-the-values
	 *
	 * @return mixed
	 */
	function travel_joy_customizer_get_option( $option = '' ) {
		_deprecated_function( __FUNCTION__, '1.0.0', sprintf( esc_html__( '%1$s or %2$s', 'travel-joy' ), 'get_theme_mod', 'get_option' ) );
		return Travel_Joy_Customizer::get_option( '', $option );
	}
}

if ( ! function_exists( 'travel_joy_customizer_sanitize_hex' ) ) {
	function travel_joy_customizer_sanitize_hex( $color ) {
		_deprecated_function( __FUNCTION__, '1.0.0', 'ariColor::newColor( $color )->toCSS( \'hex\' )' );
		return Travel_Joy_Customizer_Color::sanitize_hex( $color );
	}
}

if ( ! function_exists( 'travel_joy_customizer_get_rgb' ) ) {
	function travel_joy_customizer_get_rgb( $hex, $implode = false ) {
		_deprecated_function( __FUNCTION__, '1.0.0', 'ariColor::newColor( $color )->toCSS( \'rgb\' )' );
		return Travel_Joy_Customizer_Color::get_rgb( $hex, $implode );
	}
}

if ( ! function_exists( 'travel_joy_customizer_get_rgba' ) ) {
	function travel_joy_customizer_get_rgba( $hex = '#fff', $opacity = 100 ) {
		_deprecated_function( __FUNCTION__, '1.0.0', 'ariColor::newColor( $color )->toCSS( \'rgba\' )' );
		return Travel_Joy_Customizer_Color::get_rgba( $hex, $opacity );
	}
}

if ( ! function_exists( 'travel_joy_customizer_get_brightness' ) ) {
	function travel_joy_customizer_get_brightness( $hex ) {
		_deprecated_function( __FUNCTION__, '1.0.0', 'ariColor::newColor( $color )->lightness' );
		return Travel_Joy_Customizer_Color::get_brightness( $hex );
	}
}

if ( ! function_exists( 'Travel_Joy_Customizer' ) ) {
	function Travel_Joy_Customizer() {
		return travel_joy_customizer();
	}
}
