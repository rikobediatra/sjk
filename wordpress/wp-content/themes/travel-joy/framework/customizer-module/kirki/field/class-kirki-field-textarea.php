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
class Travel_Joy_Customizer_Field_Textarea extends Travel_Joy_Customizer_Field_Kirki_Generic {

	/**
	 * Sets the $choices
	 *
	 * @access protected
	 */
	protected function set_choices() {
		$this->choices = array(
			'element' => 'textarea',
			'rows'    => 5,
		);
	}
}
