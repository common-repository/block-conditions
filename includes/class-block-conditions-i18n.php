<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://chintesh.github.io/
 * @since      1.0.0
 *
 * @package    Block_Conditions
 * @subpackage Block_Conditions/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Block_Conditions
 * @subpackage Block_Conditions/includes
 * @author     Chintesh Prajapati <prajapatichintesh95@gmail.com>
 */
class Block_Conditions_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'block-conditions',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
