<?php

/**
 * Plugin Name: TutsPlus Shipping
 * Plugin URI: http://code.tutsplus.com/tutorials/create-a-custom-shipping-method-for-woocommerce--cms-26098
 * Description: Custom Shipping Method for WooCommerce
 * Version: 1.0.0
 * Author: Igor Benić
 * Author URI: http://www.ibenic.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /lang
 * Text Domain: tutsplus
 */

if ( ! defined( 'WPINC' ) ) {

    die;

}

/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    function tutsplus_shipping_method() {
        if ( ! class_exists( 'TutsPlus_Shipping_Method' ) ) {
            class TutsPlus_Shipping_Method extends WC_Shipping_Method {
                /**
                 * Constructor for your shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct() {
                    $this->id                 = 'tutsplus';
                    $this->method_title       = __( 'TutsPlus Shipping', 'tutsplus' );
                    $this->method_description = __( 'Custom Shipping Method for TutsPlus', 'tutsplus' );

                    // Availability & Countries
                    $this->availability = 'including';
                    $this->countries = array(
                        'KZ'
                    );
                    $this->supports = array(
                        'shipping-zones'
                    );
                    $this->init();

                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'TutsPlus Shipping', 'tutsplus' );
                }

                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {
                    // Load the settings API
                    $this->init_form_fields();
                    $this->init_settings();

                    // Save settings in admin if you have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                /**
                 * Define settings field for this shipping
                 * @return void
                 */
                function init_form_fields() {

                    $this->form_fields = array(

                        'enabled' => array(
                            'title' => __( 'Enable', 'tutsplus' ),
                            'type' => 'checkbox',
                            'description' => __( 'Enable this shipping.', 'tutsplus' ),
                            'default' => 'yes'
                        ),

                        'title' => array(
                            'title' => __( 'Title', 'tutsplus' ),
                            'type' => 'text',
                            'description' => __( 'Title to be display on site', 'tutsplus' ),
                            'default' => __( 'TutsPlus Shipping', 'tutsplus' )
                        ),

                        'weight' => array(
                            'title' => __( 'Weight (kg)', 'tutsplus' ),
                            'type' => 'number',
                            'description' => __( 'Maximum allowed weight', 'tutsplus' ),
                            'default' => 100
                        ),

                    );

                }

                /**
                 * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping( $package = array() ) {

                    $weight = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];

                    foreach ( $package['contents'] as $item_id => $values )
                    {
                        $_product = $values['data'];
                        $weight = $weight + $_product->get_weight() * $values['quantity'];
                    }

                    $weight = wc_get_weight( $weight, 'kg' );

                    if( $weight <= 3 ) {

                        $cost = 2300;

                    } elseif( $weight <= 20 ) {

                        $cost = 2500;

                    } else {

                        $cost = 2500;

                    }

                    $countryZones = array(
                        'KZ' => 1
                    );

                    $zonePrices = array(
                        1 => 10
                    );

//                    $zoneFromCountry = $countryZones[ $country ];
//                    $priceFromZone = $zonePrices[ $zoneFromCountry ];

                    //$cost += $priceFromZone;

                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost
                    );

                    $this->add_rate( $rate );

                }
            }
        }
    }


    add_action( 'woocommerce_shipping_init', 'tutsplus_shipping_method' );
    function add_tutsplus_shipping_method( $methods ) {
        $methods["tutsplus_shipping_method"] = 'TutsPlus_Shipping_Method';
        return $methods;
    }

    add_filter( 'woocommerce_shipping_methods', 'add_tutsplus_shipping_method' );
    add_filter( 'woocommerce_before_cart', 'display_total_weight_notice' );
    function display_total_weight_notice( $message ) {

        $packages = WC()->shipping->get_packages();

        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

        if( is_array( $chosen_methods ) && in_array( 'tutsplus', $chosen_methods ) ) {

            foreach ( $packages as $i => $package ) {

                if ( $chosen_methods[ $i ] != "tutsplus" ) {

                    continue;

                }

                $TutsPlus_Shipping_Method = new TutsPlus_Shipping_Method();
                $weightLimit = (int) $TutsPlus_Shipping_Method->settings['weight'];
                $weight = 0;

                foreach ( $package['contents'] as $item_id => $values )
                {
                    $_product = $values['data'];
                    $weight = $weight + $_product->get_weight() * $values['quantity'];
                }

                $weight = wc_get_weight( $weight, 'kg' );

                if( $weight > $weightLimit ) {

                    $message = sprintf( __( 'Sorry, %d kg exceeds the maximum weight of %d kg for %s', 'tutsplus' ), $weight, $weightLimit, $TutsPlus_Shipping_Method->title );
                    $message .= " ####TUPLUS#### display_total_weight_notice";
//                    wc_print_notice( sprintf(
//                        __( 'Your order has a total weight of %s. The remaining available weight is %s for the current shipping cost' ),
//                        '<strong>' . wc_format_weight($weight) . '</strong>',
//                        '<strong>' . wc_format_weight($weight - $weightLimit) . '</strong>'
//                    ),'notice' );

                    $messageType = "error";

                    if( ! wc_has_notice( $message, $messageType ) ) {

                        wc_add_notice( $message, $messageType );

                    }
                }
            }
        }


    }




    function tutsplus_validate_order( $posted )   {

        $packages = WC()->shipping->get_packages();

        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

        if( is_array( $chosen_methods ) && in_array( 'tutsplus', $chosen_methods ) ) {

            foreach ( $packages as $i => $package ) {

                if ( $chosen_methods[ $i ] != "tutsplus" ) {

                    continue;

                }

                $TutsPlus_Shipping_Method = new TutsPlus_Shipping_Method();
                $weightLimit = (int) $TutsPlus_Shipping_Method->settings['weight'];
                $weight = 0;

                foreach ( $package['contents'] as $item_id => $values )
                {
                    $_product = $values['data'];
                    $weight = $weight + $_product->get_weight() * $values['quantity'];
                }

                $weight = wc_get_weight( $weight, 'kg' );

                if( $weight > $weightLimit ) {

                    $message = sprintf( __( 'Sorry, %d kg exceeds the maximum weight of %d kg for %s', 'tutsplus' ), $weight, $weightLimit, $TutsPlus_Shipping_Method->title );
                    $message .= " ****TUPLUS****";
                    $messageType = "error";

                    if( ! wc_has_notice( $message, $messageType ) ) {

                        wc_add_notice( $message, $messageType );

                    }
                }
            }
        }
    }

    add_action( 'woocommerce_review_order_before_cart_contents', 'tutsplus_validate_order' , 10 );
    add_action( 'woocommerce_after_checkout_validation', 'tutsplus_validate_order' , 10 );
}
