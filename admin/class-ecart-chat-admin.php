<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/admin
 * @author     tradebuk <info@tradebuk.com>
 */
class Ecart_Chat_For_Woocommerce_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ecart_Chat_For_Woocommerce_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ecart_Chat_For_Woocommerce_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $screen = get_current_screen();
        if ('toplevel_page_abcart-report' == $screen->id || 'woocommerce_page_ecart-popup' == $screen->id) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ecart-chat-admin.css', array(), $this->version, 'all');

            wp_register_style($this->plugin_name . 'bootstrapcss', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'bootstrapcss');

            wp_register_style($this->plugin_name . 'materialdesignicons', 'https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.5.95/css/materialdesignicons.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'materialdesignicons');
        }

        if ('woocommerce_page_ecart-popup' == $screen->id) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ecart-chat-admin.css', array(), $this->version, 'all');
            wp_register_style($this->plugin_name . 'ecartuikit', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/css/uikit.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'ecartuikit');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ecart_Chat_For_Woocommerce_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ecart_Chat_For_Woocommerce_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //Change the hook of this include to admin_footer if need to make an ajax dismiss notice - currently dissmiss will just close the consent banner temporary

        $screen = get_current_screen();
        if ('toplevel_page_abcart-report' == $screen->id || 'woocommerce_page_ecart-popup' == $screen->id) {

            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ecart-chat-admin.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . 'chart', plugin_dir_url(__FILE__) . 'js/chart.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . 'util', plugin_dir_url(__FILE__) . 'js/utils.js', array('jquery'), $this->version, false);

            wp_register_script($this->plugin_name . 'highchartsjs', 'https://code.highcharts.com/highcharts.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . 'highchartsjs');
            wp_register_script($this->plugin_name . 'highchartsexportjs', 'https://code.highcharts.com/modules/exporting.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . 'highchartsexportjs');
            wp_register_script($this->plugin_name . 'bootstrapjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script($this->plugin_name . 'bootstrapjs');
        }

        if ('woocommerce_page_ecart-popup' == $screen->id) {
           //wp_register_script($this->plugin_name . 'uikitecart', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit.min.js', array('jquery'), $this->version, false);
           wp_enqueue_script($this->plugin_name . 'uikitecart');
           wp_enqueue_script($this->plugin_name . 'popuputil', plugin_dir_url(__FILE__) . 'js/letsconnect.js', array('jquery'), $this->version, false);
        }
    }

    public function rest_api_url_prefix() {
        return 'ecartchat';
    }

    /**
     * Register product retrieve public API.
     * $id == Product ID
     * @since    1.0.0
     */
    public function add_api_product_route() {
        register_rest_route('/v1', '/products/(?P<id>\d+)', array(
            'methods' => 'POST',
            'callback' => array($this, 'abcart_retrieve_product_details'),
        ));

        register_rest_route('/v1', '/status', array(
            'methods' => 'POST',
            'callback' => array($this, 'abcart_status_check'),
        ));
    }

    public function abcart_status_check(WP_REST_Request $request) {

        $saas_shop_id = $request->get_header('Shop-Id');
        $saas_plugin_token = $request->get_header('Plugin-Token');

        $shop_token = get_option('abcart_shop_token');
        $shop_id = get_option('abcart_shop_id');

        if ($saas_shop_id == $shop_id && $saas_plugin_token == $shop_token) {

            $shop = array(
                "domain" => get_site_url(),
                "name" => get_bloginfo('name'),
                "currency" => get_woocommerce_currency(),
                "currency_symbol" => utf8_encode(get_woocommerce_currency_symbol()),
                "language" => get_locale(),
                "timezone" => get_option('timezone_string'),
                "gmt_offset" => get_option('gmt_offset')
            );

            wp_send_json(array('data' => $shop, 'status' => 'success'));
        } else {
            $return = array(
                'message' => 'Invalid Token Details',
                'status' => 'error'
            );
            wp_send_json($return);
        }
    }

    /**
     * Retrieve the product details based on specified ID.
     *
     * Function will return the product details in JSON format.
     * @since 1.0.0
     *
     * @param WP_REST_Request $request (int|bool $id) | Product ID | Required.
     * @return JSON Product details - empty [] other wise
     */
    public function abcart_retrieve_product_details(WP_REST_Request $request) {
        /*
        // You can get the combined, merged set of parameters:
        $parameters = $request->get_params();

        // The individual sets of parameters are also available, if needed:
        $parameters = $request->get_url_params();
        $parameters = $request->get_query_params();
        $parameters = $request->get_body_params();
        $parameters = $request->get_json_params();
        $parameters = $request->get_default_params();

        // Uploads aren't merged in, but can be accessed separately:
        $parameters = $request->get_file_params();
        */

        $saas_shop_id = $request->get_header('Shop-Id');
        $saas_plugin_token = $request->get_header('Plugin-Token');

        $shop_token = get_option('abcart_shop_token');
        $shop_id = get_option('abcart_shop_id');

        if ($saas_shop_id == $shop_id && $saas_plugin_token == $shop_token) {
            $param = $request->get_param('id');

            $produt_data = array();
            if ($param) {

                $product_details = wc_get_product($param);
                if ($product_details) {
                    // echo '<re>';print_r($product_details);exit;
                    $produt_data['name'] = $product_details->get_name();
                    $produt_data['sku'] = $product_details->get_sku();
                    $produt_data['regular_price'] = $product_details->get_regular_price();
                    $produt_data['sale_price'] = $product_details->get_sale_price();
                    $produt_data['total_sales'] = $product_details->get_total_sales();
                    $produt_data['stock_status'] = $product_details->get_stock_status();
                    $produt_data['stock_quantity'] = $product_details->get_stock_quantity();
                    $produt_data['manage_stock'] = $product_details->get_manage_stock();

                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $param ), 'single-post-thumbnail' );
                    $produt_data['image'] = $image[0];

                    wp_send_json(array('data' => $produt_data, 'status' => 'success'));
                    exit;
                } else {
                    $return = array(
                        'message' => 'No Products with this ID',
                        'status' => 'error'
                    );

                    wp_send_json($return);
                }
            }

            $return = array(
                'message' => 'Invalid params',
                'status' => 'error'
            );
        } else {
            $return = array(
                'message' => 'Invalid Token Details',
                'status' => 'error'
            );
            wp_send_json($return);
        }
    }

    /**
     * Capture the cart and send the information to API.
     * @hook woocommerce_cart_updated
     * @globals mixed $wpdb
     * @globals mixed $woocommerce
     * @since 1.0
     */
    public function abcart_prepare_cart_details($cart_updated = null) {


        global $wpdb, $woocommerce;

        $abcart_allow_consent = get_option('abcart_allow_consent', 'no');

        $shop_id = get_option('abcart_shop_id');

        if ('yes' !== $abcart_allow_consent || false == $shop_id) {
            return;
        }

        $cart = $woocommerce->cart->get_cart();


        if (( isset($_COOKIE['wc_cart_present']) && !($_COOKIE['wc_cart_present'])) && empty($cart)) {
            return;
        }

        if (empty($cart)) {
            @setcookie('wc_cart_present', 0, 0, '/', get_site_url());
        } else {
            @setcookie('wc_cart_present', 1, 0, '/', get_site_url());
        }


        $status = 'update_cart';
        $payload = $this->prepare_cart_payload($cart, $status);

        $this->send_cart_updated_details($payload);
    }

    public function abcart_prepare_cart_details_order_placed() {

        global $wpdb, $woocommerce;

        $abcart_allow_consent = get_option('abcart_allow_consent', 'no');

        $shop_id = get_option('abcart_shop_id');

        if ('yes' !== $abcart_allow_consent || false == $shop_id) {
            return;
        }

        # Return if there is no cart object
        if(!is_object($woocommerce->cart)){
            return;
        }

        $cart = $woocommerce->cart->get_cart();

        $status = 'place_cart';
        $payload = $this->prepare_cart_payload($cart, $status);

        $this->send_cart_updated_details($payload);
    }

    public function prepare_cart_payload($cart, $status) {

        global $wpdb, $woocommerce;
        $current_time = current_time('timestamp');

        $payload = array();

        $current_user = wp_get_current_user();
        $user_name = ( $current_user->exists() ) ? $current_user->user_login : '';
        $user_email = ( $current_user->exists() ) ? $current_user->user_email : '';
        $wc_user_id = ( $current_user->exists() ) ? $current_user->ID : '';

        $shop_id = get_option('abcart_shop_id');

        $payload['cart']['customer']['name'] = $user_name;
        $payload['cart']['customer']['email'] = $user_email;
        $payload['cart']['customer']['wc_user_id'] = $wc_user_id;
        $payload['cart']['customer']['ip_address'] = $this->get_ip_address();

        $cart_hash_key = apply_filters('woocommerce_cart_hash_key', 'wc_cart_hash_' . md5(get_current_blog_id() . '_' . get_site_url(get_current_blog_id(), '/') . get_template()));

        $cart_hash_key = $woocommerce->session->get_customer_id();  // get for guset session.
        // $cart_hash_key = isset($_COOKIE['wp_woocommerce_session_' . COOKIEHASH]) ? $_COOKIE['wp_woocommerce_session_' . COOKIEHASH] : $cart_hash_key;

        $payload['cart']['customer']['wc_guest_id'] = empty($wc_user_id) ? $cart_hash_key : '';

        $payload['cart']['cart_status'] = $status;


        $payload['cart']['wc_cart']['timestamp'] = $current_time;
        $payload['cart']['wc_cart']['discount_total'] = $woocommerce->cart->get_cart_discount_total();
        $payload['cart']['wc_cart']['shipping_total'] = $woocommerce->cart->shipping_total;
        $payload['cart']['wc_cart']['total_tax'] = $woocommerce->cart->tax_total;
        $payload['cart']['wc_cart']['sub_total'] = $woocommerce->cart->subtotal;
        $payload['cart']['wc_cart']['total'] = $woocommerce->cart->total;

        $carts = array();
        $currency = get_woocommerce_currency();
        foreach ($cart as $cart_key => $cart_obj) {

            $crt = [];

            $crt['unique_id'] = $cart_obj['key'];
            $crt['timestamp'] = 'timestamp';
            $crt['sub_total'] = $cart_obj['line_subtotal'];
            $crt['total'] = $cart_obj['line_total'];
            $crt['product_id'] = $cart_obj['product_id'];
            $crt['variant_id'] = $cart_obj['variation_id'];
            $crt['quantity'] = $cart_obj['quantity'];
            $crt['name'] = $cart_obj['data']->get_name();
            $crt['price'] = $cart_obj['data']->get_price();
            $crt['image'] = get_the_post_thumbnail_url($cart_obj['product_id']);
            $crt['currency'] = $currency;
            array_push($carts, $crt);
        }
        $payload['cart']['wc_cart']['wc_cart_items'] = $carts;
        $payload['cart']['wc_cart']['currency'] = $currency;

        $payload['cart']['wc_cart']['digest'] = md5(json_encode($carts, JSON_UNESCAPED_SLASHES));

        return $payload;
    }

    // Taken from SO https://stackoverflow.com/a/2031935/1117368

    public function get_ip_address() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // Just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    public function send_cart_updated_details($cart_details) {

        // Uncomment below line to block API calls for cart update
        //return;

        $url = ABCART_API_ENDPOINT_BASE_V1 . '/carts/update-cart';

        $shop_token = get_option('abcart_shop_token');
        $shop_id = get_option('abcart_shop_id');

        $cart_update_saas_args = apply_filters('cart_update_saas_args', array(
            'method' => 'POST',
            'headers' => array(
                "Content-Type" => "application/json",
                "Shop-ID" => $shop_id,
                "Plugin-Token" => $shop_token,
                "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
            ),
            'body' => json_encode($cart_details)
                )
        );

        $request = wp_remote_post($url, $cart_update_saas_args);

        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
            return false;
        }
        $response = wp_remote_retrieve_body($request);
        $response_data = json_decode($response);

        // process response data here if need to do anything
    }

    public function abcart_data_usage_consent() {

        $admin_url = get_admin_url();
        echo '<input type="hidden" id="admin_url" value="' . $admin_url . '"/>';
        self::abcart_consent_actions();
        if ('unknown' === get_option('abcart_allow_consent', 'unknown')) :
            ?>
            <div class="abcart-message abcart-consent notice notice-info is-dismissible" style="position: relative;">

                <p class="submit" style="font-size: medium;">
                    <?php _e('Recover WooCommerce Abandon Cart collects your shopping cart update activities and non-sensitive indicative data that helps to recover your abandoned carts.', 'recover-woocommerce-abandoned-cart'); ?></p>
                <a class="button-primary button button-large" href="<?php echo esc_url(wp_nonce_url(add_query_arg('abcart_consent_optin', 'true'), 'abcart_consent_optin', 'abcart_consent_nonce')); ?>"><?php esc_html_e('Got It', ''); ?></a>
                <!--<a class="button-secondary button button-large skip"  href="<?php //echo esc_url(wp_nonce_url(add_query_arg('abcart_consent_optout', 'true'), 'abcart_consent_optout', 'abcart_consent_nonce'));    ?>"><?php //esc_html_e('No thanks', '');    ?></a>-->
            </p>
            </div>
            <?php
        endif;
    }

    public function dashboard_info_notice() {
        ?>
            <div class="ec-dashboard-notice notice notice-info is-dismissible" style="position: relative;">
                <p>Please click here to access your <a href="https://app.ecart.chat" target="_blank">ecartchat dashboard</a></p>
            </div>
       <?php
    }

    private static function abcart_consent_actions() {

        if (isset($_GET['abcart_consent_optin']) && isset($_GET['abcart_consent_nonce']) && wp_verify_nonce($_GET['abcart_consent_nonce'], 'abcart_consent_optin')) {

            // Register SAAS API Token call

            $shop_id = get_option('abcart_shop_id');

            if (FALSE !== $shop_id) {

                $shop_token = get_option('abcart_shop_token');

                if (!$shop_token) {
                    $url = ABCART_API_ENDPOINT_BASE_V1 . '/shops/update-token';

                    $t_oken = md5(get_current_blog_id() . '_' . get_site_url(get_current_blog_id(), '/') . get_template() + current_time('timestamp'));

                    $register_store_args = apply_filters('register_saas_token_args', array(
                        'method' => 'POST',
                        'headers' => array(
                            "Content-Type" => "application/json",
                            "Shop-Id" => $shop_id,
                            "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                        ),
                        'body' => json_encode(
                                array(
                                    "shop" => array(
                                        "token" => $t_oken
                                    )
                        ))
                            )
                    );



                    $request = wp_remote_post($url, $register_store_args);

                    if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                        return false;
                    }
                    $response = wp_remote_retrieve_body($request);
                    $response_data = json_decode($response);
                }
                update_option('abcart_shop_token', $t_oken);

                update_option('abcart_allow_consent', 'yes');
            }


            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } elseif (isset($_GET['abcart_consent_optout']) && isset($_GET['abcart_consent_nonce']) && wp_verify_nonce($_GET['abcart_consent_nonce'], 'abcart_consent_optout')) {
            update_option('abcart_allow_consent', 'no');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public static function abcart_admin_notices() {
        update_option('abcart_allow_consent', 'dismissed');
        die();
    }

    public function register_abandon_cart_report_page() {
        add_menu_page('Ecart Chat', 'Ecart Chat', 'manage_options', 'abcart-report', array($this, 'render_abcart_default_page'),'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSIxMDVweCIgaGVpZ2h0PSIxMDVweCIgdmlld0JveD0iMCAwIDEwNSAxMDUiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEwNSAxMDUiIHhtbDpzcGFjZT0icHJlc2VydmUiPiAgPGltYWdlIGlkPSJpbWFnZTAiIHdpZHRoPSIxMDUiIGhlaWdodD0iMTA1IiB4PSIwIiB5PSIwIiBocmVmPSJkYXRhOmltYWdlL3BuZztiYXNlNjQsaVZCT1J3MEtHZ29BQUFBTlNVaEVVZ0FBQUdrQUFBQnBDQVlBQUFBNWdnMDZBQUFBQkdkQlRVRUFBTEdQQy94aEJRQUFBQ0JqU0ZKTiBBQUI2SmdBQWdJUUFBUG9BQUFDQTZBQUFkVEFBQU9wZ0FBQTZtQUFBRjNDY3VsRThBQUFBQm1KTFIwUUEvd0QvQVArZ3ZhZVRBQUFBIEIzUkpUVVVINHdzR0JpTXQ4VVQ2NXdBQUZFcEpSRUZVZU5ydG5XbVlGY1c1eC85VnZaeHR6dXo3c0krQUFpUElJaUFvRWVKQ2pJSUwgZUtOUmlWc2l1WWw2amRFYjQxVmpqUEZHRXJ3SVh1TUNHczJOQmx5QWdNU0lFRlpCR0pDZFlSaTJZZll6eTltN3UrcTlId2JRQ2N3RyA1OHc1d1BrOXovbHl1cnVXOTk5VjlmWmIxZFZBZ2dRSkVpUklFQit3V0JmZ3RDQUNBZmdSd0c2ckRiTDhuYXQ1ZXYxK3JnV3J1RUltIGhBUXNSNjVzU09zbEt3cEgwL3I4ZERuTkJHVTR6ODdxeG5XcFo0Y0paVHB3MC93MzdCbUhONlhyM3NvOE5WamZqWVY5ZWR3SzVVS1kgT2R3S3VVZ0lCNGhzaklUR0FFNkFKSENUT0RlNG9nU0phejVTOUdwU2JaVlNkNVpMVzlLUmNISkJ0Yi9uOExyNnFROEVrNE1taGp2MSBXRmUzVmVKS3BQV0hhckcyZXdhKy9jYXpMa2Y1VnoxVlgzV1JFbW9jd2czL1FNVUtGVEpoWkROaHVobEpuWkZrQUhXb0FuUzhxb3dUIE1XNFFWN3hTMFd1bGFpc2oxYjVWNnE1aU15bDd1NWszOE9DcTZmL3Q3N2QzTjhiMXZ5alc1amhCekVXcVhQMFJjc1pNd3FGbmIzR1QgNTFBUkQvdXVWRXovRmR3S0QrVEN5T2JTMGhnSXgwMGR1U0lUQUFZQ0F6SEZsSXBXUTRxKzAxS2RxK0ZJWHNreXVtOVZILzZ3M2xyNCBlM1M3L1pHWTJpaG1JdFU4TmdiaDdMNmFmdURMdmhSc3ZKYk04SGVaTkMvaDBrcjlXcFN1THg2QmdianFKVVhiRHE0dGdkMjl4Q29ZIHROTjk1S3ZRKzNQMjRGN1c5V1hxMGh4WEVHSElkeGxxcnA3dWRwU3VIYTM2cW03bFp2QnFKa1UrQS9FdXIzMDdFRURnYXExVTdTdE4gVithZncza0RQKy81eEhzTlgxU1VZMHhlUVplVm8wdEVXa09FM0lrNi9GZmVsZXc4dXZVcXU2L3FiaTNjZERrbnl4M3ovcmFEU0tZRyBMYzJ4UHV4SWY5T1gxWC9Kb0E4LzhMdzJheW51SHpjeDZubEgzVWFsdjV3SUplOUNseXhkZjYzV1dINi9GbTRhcTVMbGpIck5vb1JnIFN0aFU3R3ROZStvcnJQdmdwVlJaNHF1ZXRSa2pvOWdOUmkzbHFyZWVCdTg3aWxzTG54OU9kUWQveGtPTjE2blNQR3ZGK1ZjRWVFQnEgem1WSXlaM0pSMzkvTGFzcXNiSWZmRFVxZVVWY3BGMUVTTDNaRGZQeTIzTFUvZXQvcURSVjNNK3RZTUhaMHExMUZzRzFHdUhNZUZQbSBGNzNzV1BUaGtZWlhWNkp3MkxpSTVxRkVNckY5ZjUySlFGSWh0eDNaZElWNllNTXMxVnQ1cHlLTmxITlZJQURnSkYzY0NGd0dYKzFsIDRRdUx5ajE2VHRsRGx4ZlM3RTgyUkN5UGlObHY5OU5UWURoU25TbUh2cmpiNXF2OFQ4VUs1Si9MNHB3S29kaHFRdmIwM3pmbERYbEYgcmR2ZmVOSExteUtTN2huYmNSMFI4aDhjQmtyT3llR1Z1NSswaGVydlZzaHl4TnBnc1VLQ200YnVuaC9PN1BzRUhTb3VDNHlaam90LyArdndacFhsR3p5WTdseTFBOSs4eWtPN29xeDhwZnMwUnJIM2dmQllJQURpa1pqTWF2K2VzM3ZHMkxidlhpS0tmUG8vaVJmUE9NTTNUIFpPVkhjM0hoRXpmRDdEZHltSzIyOUMzTjlGMGZqdytrc1lBQjBLemdXTFd4ZkY3WmY0d2VQK1Q2YWRneis5SFRUdSswSEljTlMvNFAgL1g1MkI0Nk1IejNTNmRuL21tNzVoNTl2NDA5SFVNaks0cUdtS3p5amV1eDc1cG1QU3hZbFZlSVBuM1orbk9xMGJSdi91UUNIcHQ4TSA5eldYamRScTkvM1JaZ1V1anJVeDRoMkxhUWRGY3Y2UG0rYnMrRnZLTzc5Ri92Y2Y3OVQxblJLcFpQTkdKRDA3Q3ZLaUs0Y3FSN2UvIG9acStJYkUyd05tQ3BkZ1B5TnorOXdYZVd2T1BqUGZuSTIzY0xSMit0bE1pVlR3eUNpdzVxNUFkMmpLUGgrckhKcnE0emlFMDEzWXIgby9lZHZHSlBzZkt1QjlrZERDVjEyTTU3bjd3QjB1NU9UeTViL2FvVzlOekNUc3p2Sk9nb0JNRFNrajd6NXhYZHBUVFdsUGVlczZWRCAxM1hJR3l2NS9ROFJHajVWZFI3YzhMQWFyTDh4SWREcHdRQ29wbitDWHIzbnY0SjlScnIyUFRXNVE5ZTE2OTF0ZnYwWHlIaDNKdFR3IC9zazJYOFZ6Q29RVGpPR2MvSFdSVUZ3WWc3aXZycWJreFZVYm5pc0lZdWFpTmUxZTB5YTF6d3lGMEZQNmFnMzczMWV0NEpCemRSd2kgQUJBRWFRaklzSUEwSkNDajEyTllYRDlrcGZmOE42bzVzQzc0cmdmOTJyaEoyclM1NTNjVElmVjB1MWE3NFNWRit1OW5qSEJPOTNRTSBPRDV6THcwSkViQWcvQ2JJa2xISnp0S2NTeWgvNFBjUjl0WG56ZGpZNm5tdGprbU5pMStGN2RCUzZEVmZYcWNJLzIwTTU3aEFRSXUxIEx0ekdvYVhwMEhNY1VKTjFnRWUrRDFITTRGV28ybmNIWm14RTNYdXR4L2RhemJudXQrTWhWVWVPdlg3YkFnNXpUS3p0RjJ0RXdJSlogSHdhWmtXMVZRckh0RFdmMm4wVCtodDA5WDkxNXluTk8yWkwyL1dNdTBuKzlITng3NkRZR2ExU3NEUlFQS0U0VmVxWURYSS9vRkJ5NCBNUHB4YjlWOTlTL3Q0QWZlZnZhVTU1eXlKUjE5NFNvSXhkSFQzYkJ0c1VhaFFiRTJVRHdoRFFtak5nZ3lJdGVpTE1WUjdpdTRaSkxxIHJkclVhNGtkMlA5RmkrTW50YVFkWDN5TXZOYy9oU053K0JhVndnTmliWlI0ZytzY2Vyb2RUSW5jR0tXSVVJSGVlT1N1ZzdPMktIdGUgdU9PazR5ZmxWUGZhSGJDWUxkZHhlTVVpeGZJTmo0TkZybkdKMVdUQTlJUWpsQnJCMU4ySHc0Vmp2OE9EM3UwOW5sdlc0bWlMbGpUaiBreEtrYlBzVGJIVTdyK1lpT0RnaFVPc29TUnE0WFkxUWFneUtHZWl1MTVaT1RuNXVHZllWcjJ4eHRJVklkemJOUmQxVk01eEsySE16IEk2bkYyaER4REZNWVZMY1dzZnVZa3dEMzEwMEsvKytEMlNscjMydHhyTVd0NERqNFR3amROWkNiZ2RHeE5rTGNRd0MzSzJDYUFqSkUgQkJKazRHSGZBT3ZRVjVkYVZmc1dmL1BJaVpaVWQvUVE5R1dyd1FNMUV5Q3RyRmpiNEd5QUtReUtJM0l1T1JPbWt6VlZYNVAvK2lIbSAzL2oxdU1RQmdJaGdXemNINFo4OG5jUU03M2dnT21HUWN4RnVVeUxXNVRGSXNHRGptTnJYSDgwS2JWNEtvdVlRaUFJQU8zYnN3T1RVIFVsQ2c3a0xtUGZvSUk1a1U2OHFmTlJBZ0ExYUVRbVlNSUhKWlhQdFVIdGx4OEplZjdNSVhYM3pSM0pMbXo1OFBlV0FONEs4ZERKSG8gNmpvRFUxaEU0M3BNbXNsb3FoNUd5NHB4L1E5K0N1QllkMWR4cUF6dW1TRklJekNDUVVZMjduRWV3Q0k1RjBVU0NQdUdXTHRJR2NJciBBUndUU2QrMUVKVkxaeVV4S3pUbzNBOTF4emNNQkdZRSt0SGJ2MG9XMjVhRGlLRHUyclVMZlAwTDBKaWF4WVRSTTlhRlBCdWhDRThPIE1tSG1vM3AvcGhEaCtzV0xGNE12V0xBQVZMc1A4RlhuZ3F6MFJKU2hjNUFnZ0NJcEVnT2tsY3E4TmJtaXNnUStudzk4MEtCQjRFMFYga0VMa01LSno1aVd2cm9Jc0dmbVdSTklocE16aGpaVm9hR2dBbnpObkRod0l3TENzZFBxWENFU0M5cEdHalBnd3praXFQTmlZNW1ncSB4NHdaTTZDdVhMa1Nlbzh3N0xiY1pFNVdZc0Y5WnlDQ0RGbFJTRmN5Q2phbDBBRmczNzU5NE9QSGowZXdHZ2hKeFU2VUdJODZnelNvIHVTVkZBWU1VbTZnRyt2WHJCOTY3ZDI4WUFVQkNTVHdmZFJJUk1LTzA3SXNCVE9PbUJ4ZytmRGk0WVJqZ0tpTHZSNTdqU0ZOQytLUFEgMVoyQWlDbUFFQUs4cEtRRWVoS2dNV0V5bHRDcG93aHY5TmJqSFZ2NEo3Uk1vTGk0R0h6MTZ0WFFNd0diaW1EaUdhbGp5SkNBOEpsUiB6SUhCcHJLUWxnK1VscFpDblRScEVnS1pHeEIwNURhcWdScWhrSlVZbTlxQUJNRnNDRWQxZENDdVNNdVYxWWcrYWZpV2JTajR0R25UIFlPbkpzQ21zaGdGR3JJMFExeEJnTmhpUW9Vak14TGFKcGFsS25aYzdNWDM2ZFBETm16ZkR6Qm9BdzVaZUlibnFqYlVkNGhtenlZRHcgUmY4K0pzWURVUFVxWlBiRXBrMmJ3Sjk2Nmlud2pONVFrck9yd2RUcVJCVDgxQWlmQ2F2UjZBTHpFSWlySHBhY1ZhWGs5c0ZOTjkwRSB6aGdEN3owV3NtaEtQYW0yc2xnYkl4NFJRUUd6UGh6VlYyRmFvTnFPVVBmQmRXcnZvYzNQU1FBUTduOHRjZ2VOQ2tHMWIwdDRlQzJSIFlRSFRFMnFPZG5jQkJBYlNITHZGbEllOGN1QUVBTWNtL2Q2WTlTTDhqK2NDdXZ0TFlrckNlVGlHTkNVTVQrVGZwR2dMWWdxUnc3MVogSDgvbzdZM05IUnNIZ0hYcjFzSHFkVGxrY3Y0MmNPMW9ZbHc2NW1wN3dxQncxRDI1bHZrcW1vY2xaeGRqK0dYNCtSMlRBUndUYWZIaSB4YUQrMXdMRDdqNE0zYlVsMWdhS05TUUpSbDBZTWhqTnNNK3BNaWFRN3R5cjlodGRZaC84N1JOL241aWFjSHpyYnVqUFRnZ3plOXBuIHpmdWZuNStRYkc1Qk1oRE5pRUlyZVRNT2NxU3Urdk50VDlZN2gzL254UDhuUkxJekJqSCtCcGp1N2l0SXNaV2ZqMTNlY1lHaUcvSnAgSGFuYXZFanYvdWt0MHdmQ2NlSFg3KzYxbU9ScnZPQTYxSXg0YUsvUVUxYWZkMTZlSkZqMVJzd0VBZ2pDbnJ4RjlMOWlFeC9aY2t1YiBGaUw5ZmVoZEtIam5hc04wRlh3Z21ScUtsYjI2M0R5eU9SNW5lV1BuMkVxbWtrekoveGpmZTZ3K05QN3VGc2RhaUhSdmpoMU53MzZFIFVQNmxLNFNhdE9sODZQSklFcXo2TUt5bVdMVWdBQ0JZZWxLcGxYZlJJdkhjVlBUcDNuSmwzVWxyR2xKdWZBYk9tVS9WQ0QzMVhZTFMgeGU1TkY1dEdFa3lQQWNzYlM0RUFDUVdtSzJ2QmxvZitXQklhZDg5SngwOFN5ZUcwSVhEckZQaFQrbjlrTW50eFRFc2ZSVWdRekxwdyBsd1JNMjhQU0hBZEM2YjNlR2ZUSUZWUTRhc0pKeDArNU9pZzRkQnE2Zno2dnd0RFNYcFBnc2IzTm9nQlpCS011Qk9HUGZkVWtPRXhIIHhwOTJQdjNoRGo3dVRxanF5YXZxV25YaGFsNitEYVE1MHh6bEs5N2p3bmZWdWVMdFNWUENyQXRIWnluV2FXQnBycTlDM1laTlppRnYgV2M4WFY1M3luRmJYMlNYLytGMDQ5ODZ2aHoxdEJqRzFQdGFWaVFReUxHRFVoT0pHSU1tVUVKSXlaOUs4SldXcEUrNXE5YnhXUmJJeCBCblBvdlRCR1A3N2MxRFBlNnRnM3YrSVhFYkJnMUlRaTlIN3JtVU1BVEh2cXg5UjM3RjhkUDU2S2xJbjN0bnB1dTVhditzTjFJR2Q2IEwzdjUrdmMxNFJzUjY4cWRqalVzbndtcklkeGwwdzBkd1ZCZGU4UGRMNWxLbnZLdGZlWnNhL1BjZHBjVmg4WTlDdGZhUHgyUXJ1eVggSkhqc1hhRk9jUHdoMWZURWwwQ0NhVDRycmNmelRiLytaS3Q3Mm92dG50L3VBbjBscHk5Q0JZVlFkRmNEd002YU41N0prakRyamJqdyA0TDZKQkpPV0svT1BmTXp0ZjhucU93cFpsMTdUN2pYdEx0OEtoVUlZejdmQWNPZU4xSUsxTjNQSXVGL1VMME9pMllQcjZxbUdkaUFBIGxqM3RZL1FZOWhnN1dOeFU4SXYzT25SZHV3Ym5uTU8rdlJvMjAxdkFJZUo3VFI0Qmx0ZUVVUk9FN09MSnVnNFVEYVl0WlozSXUrZ3ggV2I2dEp2LzU1UjIrdGwyUkpsOS9IVnlmQUVKWTJiR3VhSnRHRUFUREUrN1M5UWlkd2JJbGI1UGRCajhrdHY1OXIyUDZXNTE2R2JwZCBrWVowYzJGWEhhbUtGZXdXcjF0Tnk1Q0FVUjJFOEhiRmtxdk9ZK3JKTzYyOFFkUGxyNVpzMEo1ZGljeUxPN2ZQWTd1T2czcHdQVkwzIHJISnhhWGFMZFdYL0ZaSUU0VFZoTlJseDJYb0FJS3k1dC90emlxYjNmbTdaNmkzci80RVJRenIvS2JrMld4SVJRVlR0QnZPVXBrT2EgdWZGMG0wcER3S3dOTmUrTEdvY0NFUUJEVDE1dlp2ZS9wKzl2bDYxYXRlYnZHREhxMjZlVlZwc2lUWmt5QmF4bUw3UkFkVDRuS3lNdSA0bmVTWURXWk1LcERFSUg0OHQ1T0ZCRmNHczdNUmFMSDBHbnF6aFViam43MkFjYVB1ZnEwMDJ1enUydG9hQUN2M2dGa0R5aGswbkxIIHZQSmhDYXN4REJHTTFGNCtrVWN3MVc4bFpiOGhMeGo5RzFINlpWWFdJb0xyREhkTWFiTWx6ZjdsZzlCbjE0TWIzb0VzaHM5SEpBaG0gbzlIc0hFUnNzNlVJbHhHQXBUb09XQm05SDJZanBqek9qSEJWcjFkMm5MRkFRRHNpOWFwWkJmbk9VM1p1Qm9waTB0SFI4Y0JvRUZaOSBHQ1RpTStBaG1HS0dIZWwvTXd1S2JuWFAzUHk2a3Q4cjJPMFhmNGxZK20xMmQrTElKakFnbHd1amYxZFhYQm9TVnBQUjNITGk5SFZlIEFtQnFyaklqcGR2THNzL0llV0wzR2s4S2dKeUo5MFUwbjdhN3NQcjlRS2grQUlQSTc3S0tXODFCVWFNcTBMeThLZzRGSWdDUzY0MGkgS2Z0TnEvc2xrNnQvOWVVZndqMHU5dlI5WlN1U28vRDFtRlpiVXYzNmhWQitjZ09zNjIyalFkSWU5WW9MZ3ZDYnNMeG1seTZRNzFRWiBBVWl1ZVlYdVhzNVM4MSt4RGJsMmhWSzVQM3hwbEw5SjNmcTNLbDY1RlJMYzdUaTZkaUdUeHJlaVZXMFNCQkVRRUY0VE1rNG01RTRxIEl6aUVZcXUzbk9tZnk2VHN1V1orMGVlTzBuWCt1cGVMVWRRRjMxMXF0U1d4eWgxZ3Vxcy9wQldWenlDUVlxdVFhdExHWUUyZ04ydHMgNk04c29UZHZVUkFIejJLZzV2ZUVtQ3FFN2pvZ1hCbkxyTlR1ZnczMG43REJzZTF2Z2Z5SDU4REJHREM3YThwNlNwRzJMSjZIdE5uVCA0QmxWTkFHZ3pFalduaFQ5S0RrelA2TE1mbTk3aC8xZ3E3Rm1hWlorOUt0eHJPSG9kVHpZTUpxYndRSkdsdFljSit4S3dZNExvd2hTIGJkWFNucktSVW5LWEdya0RQbXNjZFd0Wlp2a2VhOEF0RHpTZitrTFgza2luek8zd3E5TmdNUzBqL2NqeWoxVVJPT1BQOGhDWWxOeFcgQnQyOWdHWDArWE5vOUgwN25KVTdMZGZFUnpHVkNHLzk1azVVajcxSlZ6ZCsySXRWNzcrVStXcXZZQ0h2Y0dhRmVqRnBwakNTeDNZNSBqWlJ3ZEx4Y0lIQWlydnBJdFIwbVc5SVdTc3I0Sjh2b3NSYURyOW1YKzUxN2dvdUpjSDBYZlVxdU5VN0tmVjBGb2VocGhrQ2Z5NmM2IHZHVnZjUktuNVRRUUFBRTFJTGg5cTlSVEZvajBDeGJheC81N3FhemNLZE91dWIvVjZ5by9udy9xZHFGQ3k5L01rT1c3QzhsWFc0UlEgMDhYY0NQWm53dWpPaEpYQnlVb0NTYjJsZUsxWGtRQ0FjU0xHVGNrVVA3amlrWXAraERUSFhySW5iWWN6YlJ2THVXQXZHM1ZqTmExNCB6eXo0K1p1UjNWYzEwaUtWejMwQWx1NU9UU241K0QzTmJPcDB3RW1DQzR2YkRscUs2M1BUa2IzUXpMaG83YnA3WnRWZXNHTW5oZzhhIDJPa0NicWlxZ3lzMW5iaytuZXRrKzc5TWt3MFYyVHpZbE1jTWZ3NFRabzZVTWxVTE42VVFWNU1rNXpva2NUQkdqS1RCcGVtM2RIY1QgNDBvRGNiV2FITzRxMGwwVlBDbTlpbm9POFlUR1RmVTNWUnlVSXdiSDl3Y0ZXb2hVdW1rcGV2MWtJcnczanYyQjJuamdGVWJDMXNGMCBCREcxUWlxMmpaYWF2TlR2N3JXaXVzOE5aYWxWdTZ6QysxNklXdUhuRW1FYWdFcUE2UUFQQWt3QTBBQUlnQ3hBL2c2Z3l3RjhMNDVhIFJtZHBVWExmLzF3RmNtYjBZWWMzTG1DV2YwaGIvVCtCaDhINFlTanFsMUFkeTZXZXVqcWNkVWxaWnZIczBOb3BwUmh6UldHczYzYk8gY0VJRjM0TEhnSXhDTzliTW1zRUN0ZE8vUHFWNXNDYkdCVEcxVGpKMWoxVHRHeVIzckdXTzVNMlVjM0U1TDM3YlRIMnhMcTc2OFhNSiBCZ0JILy9JRVZ0MzZhemJ4aFpIM2NGLzVTNHpJU1l5SGlhdDF4UFg5UW5GOFplbnV6WmFlVWh4STZsRzZkOUFkVFhaUEdWMTUzZTJ4IEx2OTVBUU9BcHJuVFlDWGw5dVFIVmozSnpJQkttbXVQcGJsMm1iYlVra0J5NFpFREEyNzM1b21EY3NBM1hyWk4wTVhJNVRQZ1cvZXUgN3QvOFFkSkNEM0dpdlNpTTZGN1hDUklrU0pBZ1FZSnpnZjhIc1lOSkJPVUlTbGdBQUFBbGRFVllkR1JoZEdVNlkzSmxZWFJsQURJdyBNVGt0TVRFdE1EWlVNRFE2TkRFNk1qSXRNRGM2TURBMGtIQXZBQUFBSlhSRldIUmtZWFJsT20xdlpHbG1lUUF5TURFNUxURXhMVEEyIFZEQTBPalF4T2pJeUxUQTNPakF3UmMzSWt3QUFBQUJKUlU1RXJrSmdnZz09Ii8+Cjwvc3ZnPg==',59.10271);
        add_submenu_page(
            'woocommerce',
            __( "Ecart Popup", "recover-woocommerce-abandoned-cart"),
            "",
            'manage_options',
            'ecart-popup',
            array($this, 'ecart_popup_callback')
        );
    }

    public function ecart_popup_callback() {
        include 'partials/ecart-chat-admin-display.php';
    }
    // Abandoned Cart Front Page
    public function render_abcart_default_page() {
        ?>
        <div class="ecart_admin_head">
			<div>
				<img src="<?php echo ABCART_PLUGIN_BASE_URL; ?>admin/images/ecart-chat-logo512.png" alt="logo">
			<div class="admin_dash_descr">
				Monitor carts, collect leads <br> chat with customers
				<br>
				<p>
					Ecart.chat helps track your store visitors journey in your woocommerce site and provide them the option of contacting you via WhatsApp. You will also be able to collect customer leads with our innovative wishlist widget.
				</p>
			</div>
			<?php
		 		$shop_token = get_option('abcart_shop_token');
        		$shop_id = get_option('abcart_shop_id');
        		if ($shop_token) {
			 ?>
            <a href="https://app.ecart.chat/" target="_blank" class="ecart_link">Go To Dashboard</a>
			<?php
				}
		 		else{
					?>
				<a href="https://app.ecart.chat/auth/register" target="_blank" class="ecart_link">Connect</a>
			<?php
				}
					
			?>
        </div>

        <?php
    }


    public function render_abcart_report_page() {
        $shop_token = get_option('abcart_shop_token');
        $shop_id = get_option('abcart_shop_id');

        if ($shop_token) {
            ?>

            <p></p>
            <h2><span class="badge badge-secondary">Overview</span></h2>
            <?php include 'report-page.php'; ?>


            <?php if ('product' == $current_type): ?>


                <?php
                $ab_products_url = ABCART_API_ENDPOINT_BASE_V1 . '/reports/abandon-products';


                $abcart_product_amount = apply_filters('getsaas_cart_product_amount_args', array(
                    'method' => 'POST',
                    'headers' => array(
                        "Content-Type" => "application/json",
                        "Shop-Id" => $shop_id,
                        "Plugin-Token" => $shop_token,
                        "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                    ),
                    'body' => json_encode(
                            array(
                                "report" => array(
                                    "scale" => $current_range,
                                    "graph" => array(
                                        "cart_amount",
                                    )
                                )
                    ))
                        )
                );


                $abcart_product_amount_resp = wp_remote_post($ab_products_url, $abcart_product_amount);

                if (is_wp_error($abcart_product_amount_resp) || wp_remote_retrieve_response_code($abcart_product_amount_resp) != 200) {
                    return false;
                }
                $abcart_product_amount_data = wp_remote_retrieve_body($abcart_product_amount_resp);
                $abcart_product_amount_data = json_decode($abcart_product_amount_data);
                //echo '<pre>';print_r($abcart_product_amount_data);exit;

                if ($abcart_product_amount_data->status == 'failure') {

                    if (!$abcart_product_amount_data->shop_exist){

                        delete_option( 'abcart_shop_id' );
                        delete_option( 'abcart_shop_token' );
                        delete_option( 'abcart_allow_consent' );
                        echo "Something went wrong. Please try again later";
                        return;
                    }
                }

                $amount_graph = $abcart_product_amount_data->data->amount_graph;



                $abcart_product_count = apply_filters('getsaas_cart_product_amount_args', array(
                    'method' => 'POST',
                    'headers' => array(
                        "Content-Type" => "application/json",
                        "Shop-Id" => $shop_id,
                        "Plugin-Token" => $shop_token,
                        "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                    ),
                    'body' => json_encode(
                            array(
                                "report" => array(
                                    "scale" => $current_range,
                                    "graph" => array(
                                        "cart_count",
                                    )
                                )
                    ))
                        )
                );


                $abcart_product_cart_resp = wp_remote_post($ab_products_url, $abcart_product_count);

                if (is_wp_error($abcart_product_cart_resp) || wp_remote_retrieve_response_code($abcart_product_cart_resp) != 200) {
                    return false;
                }
                $abcart_product_cart_data = wp_remote_retrieve_body($abcart_product_cart_resp);
                $abcart_product_cart_data = json_decode($abcart_product_cart_data);

                if ($abcart_product_cart_data->status == 'failure') {
                    echo "Something went wrong. Please try again later";
                    return;
                }

                $count_graph = $abcart_product_cart_data->data->count_graph;


                include 'abandoned-products.php';
                ?>


            <?php else: ?>




                <?php
                $overview_url = ABCART_API_ENDPOINT_BASE_V1 . '/reports/dashboard';


                $dashboard_data_section = array(
                    'method' => 'POST',
                    'headers' => array(
                        "Content-Type" => "application/json",
                        "Shop-Id" => $shop_id,
                        "Plugin-Token" => $shop_token,
                        "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                    ),
                    'body' => json_encode(
                            array(
                                "report" => array(
                                    "scale" => $current_range,
                                )
                    ))
                );


                $dashboard_data_resp = wp_remote_post($overview_url, $dashboard_data_section);

                if (is_wp_error($dashboard_data_resp) || wp_remote_retrieve_response_code($dashboard_data_resp) != 200) {
                    return false;
                }
                $dashboard_overview = wp_remote_retrieve_body($dashboard_data_resp);
                $dashboard_overview = json_decode($dashboard_overview);

                if ($dashboard_overview->status == 'failure') {

                    if (!$dashboard_overview->shop_exist){

                        delete_option( 'abcart_shop_id' );
                        delete_option( 'abcart_shop_token' );
                        delete_option( 'abcart_allow_consent' );
                        echo "Something went wrong. Please try again later";
                        return;
                    }
                }

                // $today_count = $dashboard_overview->data->today_count;
                // $today_amount = $dashboard_overview->data->today_amount;
                $active_count = $dashboard_overview->data->active_count;
                $active_amount = $dashboard_overview->data->active_amount;
                $recent_count = $dashboard_overview->data->recent_count;
                $recent_amount = $dashboard_overview->data->recent_amount;
                $recent_days = $dashboard_overview->data->recent_days;



                $graph_url = ABCART_API_ENDPOINT_BASE_V1 . '/reports/graph';

                $current_time = current_time('timestamp');
                $fifteen_days_before = strtotime('-15 days', $current_time);

                $start_date = date('d-m-Y', $fifteen_days_before);
                $end_date = date('d-my-Y', $current_time);


                $cart_amount_query = apply_filters('getsaas_cart_amount_args', array(
                    'method' => 'POST',
                    'headers' => array(
                        "Content-Type" => "application/json",
                        "Shop-Id" => $shop_id,
                        "Plugin-Token" => $shop_token,
                        "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                    ),
                    'body' => json_encode(
                            array(
                                "report" => array(
                                    "scale" => $current_range,
                                    /*
                                    "period" => "month",
                                    "start_date" => $start_date,
                                    "end_date" => $end_date,
                                    */
                                    "graph" => array(
                                        "cart_amount",
                                    )
                                )
                    ))
                        )
                );



                $cart_amount_data_res = wp_remote_post($graph_url, $cart_amount_query);

                if (is_wp_error($cart_amount_data_res) || wp_remote_retrieve_response_code($cart_amount_data_res) != 200) {
                    return false;
                }
                $cart_amount_response = wp_remote_retrieve_body($cart_amount_data_res);
                $cart_amount_data = json_decode($cart_amount_response);

                if ($cart_amount_data->status == 'failure') {
                    echo "Something went wrong. Please try again later";
                    return;
                }

                $crt_am_graph_details = $cart_amount_data->data->amount_graph;
                $crt_am_graphdata = $crt_am_graph_details->graph_data;

                $crt_am_graphdata_keys = array_keys((array) $crt_am_graphdata);

                $crt_am_graphdata_values = array_values((array) $crt_am_graphdata);

                $crt_am_total = $crt_am_graph_details->total_amount;


                $cart_count_query = apply_filters('getsaas_cart_count_args', array(
                    'method' => 'POST',
                    'headers' => array(
                        "Content-Type" => "application/json",
                        "Shop-Id" => $shop_id,
                        "Plugin-Token" => $shop_token,
                        "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                    ),
                    'body' => json_encode(
                            array(
                                "report" => array(
                                    "scale" => $current_range,
                                    /*
                                    "start_date" => $start_date,
                                    "end_date" => $end_date,
                                    */
                                    "graph" => array(
                                        "cart_count",
                                    )
                                )
                    ))
                        )
                );



                $cart_count_data_res = wp_remote_post($graph_url, $cart_count_query);

                if (is_wp_error($cart_count_data_res) || wp_remote_retrieve_response_code($cart_count_data_res) != 200) {
                    return false;
                }
                $cart_count_response = wp_remote_retrieve_body($cart_count_data_res);
                $cart_count_data = json_decode($cart_count_response);


                $crt_cn_graph_details = $cart_count_data->data->count_graph;
                $crt_cn_graphdata = $crt_cn_graph_details->graph_data;
                $crt_cn_graphdata_keys = array_keys((array) $crt_cn_graphdata);

                $crt_cn_graphdata_values = array_values((array) $crt_cn_graphdata);
                $crt_cn_total = $crt_cn_graph_details->total_count;
                ?>



                <style>
                    canvas{
                        -moz-user-select: none;
                        -webkit-user-select: none;
                        -ms-user-select: none;
                    }
                </style>


                <div class="row"><p></p></div>
                <div class="container">



                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-cart text-danger icon-lg mdi-36px"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Amount</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo utf8_encode(get_woocommerce_currency_symbol()), $recent_amount; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-3 mb-0">
                                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Last <?php echo $recent_days, ($recent_days == 1) ? ' day' : ' days'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-cart-plus text-danger icon-lg mdi-36px"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Count</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $recent_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-3 mb-0">
                                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Last <?php echo $recent_days, ($recent_days == 1) ? ' day' : ' days'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-cart-outline text-danger icon-lg mdi-36px"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Active Amount</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo utf8_encode(get_woocommerce_currency_symbol()), $active_amount; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-3 mb-0">
                                      <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-cart-arrow-right text-danger icon-lg mdi-36px"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Active Count</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $active_count; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-3 mb-0">
                                      <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <br/>



                <div style="width:95%;">
                    <canvas id="canvas1"></canvas>
                </div>
                <br>

                <script>

                    var MONTHS = <?php echo json_encode($crt_cn_graphdata_keys); ?>;
                    var config = {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($crt_cn_graphdata_keys); ?>,
                            datasets: [

                                {
                                    label: 'Cart Count Data',
                                    fill: false,
                                    backgroundColor: window.chartColors.blue,
                                    borderColor: window.chartColors.blue,
                                    data: <?php echo json_encode($crt_cn_graphdata_values); ?>,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Cart Count Details'
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: '<?php echo ucwords($current_range); ?>'
                                        }
                                    }],
                                yAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Value'
                                        }
                                    }]
                            }
                        }
                    };



                    var config2 = {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($crt_am_graphdata_keys); ?>,
                            datasets: [

                                {
                                    label: 'Cart Amount Data',
                                    fill: false,
                                    backgroundColor: window.chartColors.blue,
                                    borderColor: window.chartColors.blue,
                                    data:<?php echo json_encode($crt_am_graphdata_values); ?>,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Cart Amount Details'
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: '<?php echo ucwords($current_range); ?>'
                                        }
                                    }],
                                yAxes: [{
                                        display: true,
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Value'
                                        }
                                    }]
                            }
                        }
                    };


                    window.onload = function () {

                        var ctx = document.getElementById('canvas1').getContext('2d');
                        window.myLine = new Chart(ctx, config);

                        var ctx2 = document.getElementById('canvas2').getContext('2d');
                        window.myLine = new Chart(ctx2, config2);
                    };

                </script>


                <div style="width:95%;">
                    <canvas id="canvas2"></canvas>
                </div>

            <?php endif; ?>

            <?php
        } else {
            ?>


            <div class="abcart-message abcart-consent notice notice-info is-dismissible" style="position: relative;">

                <p class="submit" style="font-size: medium;">
                    <?php _e('Please click on the above button to give consent and to display dashboard contents properly. ', 'recover-woocommerce-abandoned-cart'); ?>
                </p>
            </div>

                <?php

        }
    }

    public function abcart_plugin_action_links($links) {

        $plugin_links = array(
            '<a href="' . admin_url('admin.php?page=abcart-report') . '">' . __('Abandoned Cart Report', 'recover-woocommerce-abandoned-cart') . '</a>',
            '<a target="_blank" href="https://wordpress.org/support/plugin/recover-woocommerce-abandoned-cart/">' . __('Support', 'recover-woocommerce-abandoned-cart') . '</a>',
            '<a target="_blank" href="https://wordpress.org/support/plugin/recover-woocommerce-abandoned-cart/reviews/">' . __('Review', 'recover-woocommerce-abandoned-cart') . '</a>',
        );
        if (array_key_exists('deactivate', $links)) {
            $links['deactivate'] = str_replace('<a', '<a class="ecart-deactivate-link"', $links['deactivate']);
        }
        return array_merge($plugin_links, $links);
    }

    public function submit_connect_user_details() {
        $connect_api_url = ABCART_API_ENDPOINT_BASE_V1 . '/shops/activate-user';
        $shop_token = get_option('abcart_shop_token');
        $shop_id = get_option('abcart_shop_id');
        $uuid = $_POST[ 'uuid' ];


        $ecart_connect_prams = apply_filters('getsaas_cart_product_amount_args', array(
            'method' => 'POST',
            'headers' => array(
                "Content-Type" => "application/json",
                "Shop-Id" => $shop_id,
                "Plugin-Token" => $shop_token,
                "Plugin-Version" => ABANDONED_CART_FOR_WOOCOMMERCE_VERSION
                ),
            'body' => json_encode(
                    array(
                        "shop" => array(
                            "uuid" => $uuid,
                        )
                    )
                )
            )
        );

        $ecart_connection_details = wp_remote_post($connect_api_url, $ecart_connect_prams);

        if (is_wp_error($ecart_connection_details) || wp_remote_retrieve_response_code($ecart_connection_details) != 200) {
            wp_send_json_error();
        }

        $ecart_connection_data = wp_remote_retrieve_body($ecart_connection_details);
        $ecart_connection_data = json_decode($ecart_connection_data);

        // Do something on the data
        wp_send_json_success();
    }
}
