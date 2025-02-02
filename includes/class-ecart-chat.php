<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/includes
 * @author     tradebuk <info@tradebuk.com>
 */
class Ecart_Chat_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ecart_Chat_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ABANDONED_CART_FOR_WOOCOMMERCE_VERSION' ) ) {
			$this->version = ABANDONED_CART_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '2.0.2';
		}
		$this->plugin_name = 'recover-woocommerce-abandoned-cart';
		$this->plugin_base_name = 'recover-woocommerce-abandoned-cart/recover-woocommerce-abandoned-cart.php'; //plugin_basename(__FILE__);


		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ecart_Chat_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Ecart_Chat_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Ecart_Chat_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Ecart_Chat_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ecart-chat-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ecart-chat-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ecart-chat-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ecart-chat-public.php';

		$this->loader = new Ecart_Chat_For_Woocommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ecart_Chat_For_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ecart_Chat_For_Woocommerce_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ecart_Chat_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );


		$this->loader->add_action( 'woocommerce_cart_updated', $plugin_admin, 'abcart_prepare_cart_details' );

		// Tested Hooks
		//$this->loader->add_action( 'woocommerce_update_cart_action_cart_updated', $plugin_admin, 'abcart_send_cart_details' );
		//$this->loader->add_action( 'woocommerce_add_to_cart', $plugin_admin, 'abcart_prepare_cart_details' );
		//$this->loader->add_action( 'woocommerce_cart_item_removed', $plugin_admin, 'abcart_prepare_cart_details' );
		//$this->loader->add_action( 'woocommerce_cart_item_restored', $plugin_admin, 'abcart_prepare_cart_details' );
		//$this->loader->add_action( 'woocommerce_after_cart_item_quantity_update', $plugin_admin, 'abcart_prepare_cart_details' );
		//$this->loader->add_action( 'woocommerce_after_calculate_totals', $plugin_admin, 'abcart_store_cart_details' );



		$this->loader->add_action( 'rest_api_init', $plugin_admin, 'add_api_product_route' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'abcart_data_usage_consent' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'dashboard_info_notice' );

		$this->loader->add_action( 'wp_ajax_abcart_admin_notices', $plugin_admin, 'abcart_admin_notices' );

		$this->loader->add_action( 'woocommerce_new_order',  $plugin_admin , 'abcart_prepare_cart_details_order_placed');


		$this->loader->add_action( 'admin_menu',  $plugin_admin , 'register_abandon_cart_report_page');


		//$this->loader->add_filter('plugin_action_links_' . plugin_basename(__FILE__),  'abcart_plugin_action_links');
		$this->loader->add_filter('plugin_action_links_' . $this->get_plugin_base_name(), $plugin_admin, 'abcart_plugin_action_links');

		// Lets Connect Popup
		$this->loader->add_action('wp_ajax_submit_connect_user_details', $plugin_admin, "submit_connect_user_details");
	}




  /**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ecart_Chat_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'ec_whatsapp_widget' );

		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'ec_wishlist_widget' );

	}

  /**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

  /**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ecart_Chat_For_Woocommerce_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


  public function get_plugin_base_name() {
    return $this->plugin_base_name;
  }
}
