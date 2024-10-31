<?php

/**
 * Fired during plugin activation
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 * @author     tradebuk <info@tradebuk.com>
 */
class Ecart_Chat_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {


         /**
         * Create the database tables and the options required for the plugin - Initially only API.
         * @hook register_activation_hook
         * @globals mixed $wpdb
         * @since 1.0
         */

        /*
            global $wpdb;
            $wcap_collate = '';
            if ( $wpdb->has_cap( 'collation' ) ) {
                $wcap_collate = $wpdb->get_charset_collate();
            }


            $abcart_wc_history_table_name = $wpdb->prefix . "abcart_wc_history";

            $history_query = "CREATE TABLE IF NOT EXISTS $abcart_wc_history_table_name (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `user_id` int(11) NOT NULL,
                             `abcart_wc_info` text COLLATE utf8_unicode_ci NOT NULL,
                             `abcart_wc_time` int(11) NOT NULL,
                             `cart_ignored` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
                             `recovered_cart` int(11) NOT NULL,
                             `user_type` text,
                             `session_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
                             PRIMARY KEY (`id`)
                             ) $wcap_collate";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $history_query );

            do_action( 'abcart_wc_activate' );
         *
         */


            // Register SAAS API call

            $shop_id = get_option('abcart_shop_id');

            if (FALSE == $shop_id) {

                $url = ABCART_API_ENDPOINT_BASE_V1 . '/shops';

                $base_country = '';
                if(class_exists('WC_Countries')){

                    $WC_Countries = new WC_Countries();
                    $base_country = $WC_Countries->get_base_country();

                }

                $current_user = wp_get_current_user();
                $user_name = ( $current_user->exists() ) ? $current_user->user_login : '';
                $user_email = ( $current_user->exists() ) ? $current_user->user_email : '';

                $data = array(
                    "shop" => array(
                        "domain" => get_site_url(),
                        "name" => get_bloginfo('name'),
                        "currency" => get_woocommerce_currency(),
                        "currency_symbol" => utf8_encode(get_woocommerce_currency_symbol()),
                        "country" => $base_country,
                        "locale" => get_locale(),
                        "admin_email" => get_option('admin_email'),
                        "timezone_string" =>  get_option('timezone_string'),
                        "gmt_offset" => get_option('gmt_offset')
                    )
                );

                $data['shop']['user'] = array(
                    'name' => $user_name,
                    'email' => $user_email
                );

                $register_store_args = apply_filters('register_saas_args', array(
                    'method' => 'POST',
                    'headers' => array(
                        "Content-Type" => "application/json",
                        "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                    ),
                    'body' => json_encode($data)
                    )
                );


                $request = wp_remote_post($url, $register_store_args);


                if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                    deactivate_plugins( plugin_basename( __FILE__ ) );
                    wp_die( 'This plugin is not able to activate now. Please try again after sometime.' );
                    return false;
                }
                $response = wp_remote_retrieve_body($request);
                $response_data = json_decode($response);

                $shop_id = $response_data->data->shop_id;
                update_option('abcart_shop_id', $shop_id);
            }

            header('Location: ' . $_SERVER['HTTP_REFERER']);

    }


}
