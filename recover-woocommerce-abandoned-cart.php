<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ecart.chat
 * @since             1.0.0
 * @package           Ecart_Chat_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Ecart Chat For WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/recover-woocommerce-abandoned-cart
 * Description:       Plugin provides detailed insights about abandoned carts in your store.
 * Version:           2.0.8
 * Author:            ecart.chat
 * Author URI:        https://ecart.chat
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       recover-woocommerce-abandoned-cart
 * Domain Path:       /languages
 * WC requires at least: 2.7.0
 * WC tested up to: 3.6.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ABANDONED_CART_FOR_WOOCOMMERCE_VERSION', '2.0.2' );
define( 'ABCART_API_ENDPOINT_BASE_V1', 'https://api.tradebuk.com/api/v1/wc' );
define( 'ABCART_PLUGIN_BASE_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ecart-chat-activator.php
 */
function activate_abandoned_cart_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ecart-chat-activator.php';
	Ecart_Chat_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ecart-chat-deactivator.php
 */
function deactivate_abandoned_cart_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ecart-chat-deactivator.php';
	Ecart_Chat_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_abandoned_cart_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_abandoned_cart_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ecart-chat.php';
require plugin_dir_path(__FILE__) . 'includes/class-ecart-chat-feedback.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_abandoned_cart_for_woocommerce() {

	$plugin = new Ecart_Chat_For_Woocommerce();
	$plugin->run();

}
run_abandoned_cart_for_woocommerce();
