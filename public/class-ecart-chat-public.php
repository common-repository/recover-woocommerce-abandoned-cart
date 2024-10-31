<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ecart.chat
 * @since      1.0.0
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ecart_Chat_For_Woocommerce
 * @subpackage Ecart_Chat_For_Woocommerce/public
 * @author     tradebuk <info@tradebuk.com>
 */
class Ecart_Chat_For_Woocommerce_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ecart-chat-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ecart-chat-public.js', array( 'jquery' ), $this->version, false );

		// Load ec widget javascript and data
		$this->enqueue_ec_widget_scripts();

	}

	/**
  * EcartChat Wishlist Widget
  *
  * @since    2.0.1
  */
  public function enqueue_ec_widget_scripts() {
		if(is_product()) {
			wp_enqueue_script( 'ec-widgets', plugin_dir_url( __FILE__ ) . 'js/ecart-chat-widgets.js', array( 'jquery' ), $this->version, false );

			$shop_id = get_option('abcart_shop_id');
			$root_url = get_site_url();

			$ec_widget_data = array(
				'shop_id' => $shop_id,
				'root_url' => $root_url
			);

			$current_user = wp_get_current_user();
			if (is_object($current_user)){
				$ec_widget_data['user'] = array(
					'ref_id' => $current_user->ID,
					'name' => $current_user->user_login,
					'email' => $current_user->user_email
				);
			}

			$product_id = get_the_ID();
			if ($product_id){
				$product = wc_get_product($product_id);
				if (is_object($product)){
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $param ), 'thumbnail' );

					$ec_widget_data['product'] = array(
						'ref_id' => $product_id,
						'name' => $product->get_name(),
            'slug' => $product->get_slug(),
			'thumbnail' => $image[0],
			'is_in_stock' => $product->is_in_stock()
					);
				}
			}

			wp_localize_script('ec-widgets', 'ecWidgetData', $ec_widget_data);
		}
	}

	/**
  * EcartChat Wishlist Widget
  *
  * @since    2.0.1
  */
  public function ec_wishlist_widget() {

	/**
	  *
	  * An instance of this class should be passed to the run() function
	  * defined in Ecart_Chat_For_Woocommerce_Loader as all of the hooks are defined
	  * in that particular class.
	  *
	  * The Ecart_Chat_For_Woocommerce_Loader will then create the relationship
	  * between the defined hooks and the functions defined in this
	  * class.
	  */

		echo '<div id="ec-wishlist-widget"></div>';
	}

	/**
  * EcartChat WhatsApp Chat Widget
  *
  * @since    2.0.1
  */
  public function ec_whatsapp_widget() {

		/**
			*
			* An instance of this class should be passed to the run() function
			* defined in Ecart_Chat_For_Woocommerce_Loader as all of the hooks are defined
			* in that particular class.
			*
			* The Ecart_Chat_For_Woocommerce_Loader will then create the relationship
			* between the defined hooks and the functions defined in this
			* class.
			*/

			echo '<div id="ec-whatsapp-widget"></div>';
		}

}
