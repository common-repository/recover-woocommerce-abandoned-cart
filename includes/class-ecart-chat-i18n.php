<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 * @author     tradebuk <info@tradebuk.com>
 */
class Ecart_Chat_For_Woocommerce_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'recover-woocommerce-abandoned-cart',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
