<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://www.blackandwhitedigital.eu/
 * @since      1.0.0
 *
 * @package    Chatpressai
 * @subpackage Chatpressai/includes
 */

// phpcs:disable PEAR.NamingConventions.ValidClassName.Invalid
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Chatpressai
 * @subpackage Chatpressai/includes
 * @author     Black and White Digital OU <paul@blackandwhitedigital.eu>
 */
class Chatpressai_i18n {

	// phpcs:enable
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'chatpressai',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
