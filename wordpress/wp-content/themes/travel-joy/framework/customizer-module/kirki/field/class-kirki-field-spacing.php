<?php
/**
 * Override field methods
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       2.2.7
 */

/**
 * Field overrides.
 */
class Travel_Joy_Customizer_Field_Spacing extends Travel_Joy_Customizer_Field_Dimensions {

	/**
	 * Set the choices.
	 * Adds a pseudo-element "controls" that helps with the JS API.
	 *
	 * @access protected
	 */
	protected function set_choices() {
		$default_args = array(
			'controls' => array(
				'top'    => ( isset( $this->default['top'] ) ),
				'bottom' => ( isset( $this->default['top'] ) ),
				'left'   => ( isset( $this->default['top'] ) ),
				'right'  => ( isset( $this->default['top'] ) ),
			),
			'labels'   => array(
				'top'    => esc_html__( 'Top', 'travel-joy' ),
				'bottom' => esc_html__( 'Bottom', 'travel-joy' ),
				'left'   => esc_html__( 'Left', 'travel-joy' ),
				'right'  => esc_html__( 'Right', 'travel-joy' ),
			),
		);

		$this->choices = wp_parse_args( $this->choices, $default_args );
	}
}
