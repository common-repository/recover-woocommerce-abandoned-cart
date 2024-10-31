<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 * @author     tradebuk <info@tradebuk.com>
 */
class Ecart_Chat_For_Woocommerce_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option('abcart_shop_id');
		delete_option('abcart_shop_token');
		delete_option('abcart_allow_consent');
	}

}
