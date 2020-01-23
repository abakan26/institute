<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://localhost/test.com
 * @since      1.0.0
 *
 * @package    Vnins
 * @subpackage Vnins/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vnins
 * @subpackage Vnins/public
 * @author     noname <abakan_ac545@mail.ru>
 */
class Vnins_Public {

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
        add_filter( 'woocommerce_states', array($this, 'awrr_states_russia') );
        add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );
        add_filter( 'woocommerce_shipping_calculator_enable_postcode', '__return_false' );
        add_filter( 'woocommerce_checkout_fields' , 'no_required_checkout_fields' );
        function no_required_checkout_fields( $fields ) {
            $fields['billing']['billing_last_name']['required'] = false;
            $fields['billing']['billing_address_1']['required'] = false;
            $fields['billing']['billing_address_2']['required'] = false;
            $fields['billing']['billing_city']['required'] = false;
            $fields['billing']['billing_postcode']['required'] = false;
            unset($fields['billing']['billing_last_name']);
            unset($fields['billing']['billing_company']);
            unset($fields['billing']['billing_country']);
            unset($fields['billing']['billing_address_1']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_city']);
            unset($fields['billing']['billing_postcode']);
            unset($fields['shipping']['shipping_country']);
            $fields['billing']['billing_email']['required'] = false;
            return $fields;
        }
        add_action('woocommerce_before_checkout_form', 'bbloomer_print_cart_weight');
        add_action('woocommerce_before_cart', 'bbloomer_print_cart_weight');

        function bbloomer_print_cart_weight( $posted ) {
            global $woocommerce;
            $notice = 'Вес вашей корзины: ' . $woocommerce->cart->cart_contents_weight . get_option('woocommerce_weight_unit');
            if( is_cart() ) {
                wc_print_notice( $notice, 'notice' );
            } else {
                wc_add_notice( $notice, 'notice' );
            }
        }


    }
    public function awrr_states_russia( $states ) {
        global $wpdb;

        $data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}" . VNINS_DBTN);

        $institutes1 = array_map(function ($institute) {
            return $institute->name;
        }, $data);
        $states['KZ'] = array();
        foreach ($institutes1 as $value){
            $states['KZ'][$value] =  $value;
        };
        return $states;
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
		 * defined in Vnins_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vnins_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vnins-public.css', array(), $this->version, 'all' );

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
		 * defined in Vnins_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vnins_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vnins-public.js', array( 'jquery' ), $this->version, true );

	}

}
