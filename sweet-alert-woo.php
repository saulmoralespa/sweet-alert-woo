<?php
/**
 * Plugin Name: Sweet Alert Woo
 * Description: Sweet Alert for WooCommerce replaces the conventional alert with a nicer and more stylish option.
 * Version: 1.0.0
 * Author: Saul Morales Pacheco
 * Author URI: https://saulmoralespa.com
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * WC tested up to: 8.1.1
 * WC requires at least: 4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if(!defined('SWEET_ALERT_WOO_SAW_VERSION')){
    define('SWEET_ALERT_WOO_SAW_VERSION', '1.0.0');
}

add_action('plugins_loaded', 'sweet_alert_woo_saw_init');
add_action(
    'before_woocommerce_init',
    function () {
        if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
        }
    }
);

function sweet_alert_woo_saw_init(){

    if ( !sweet_alert_woo_saw_requirements() )
        return;

    add_action('wp_enqueue_scripts', function (){
        wp_enqueue_script( 'sweet_alert_woo_saw', plugin_dir_url( __FILE__ )  . 'assets/js/sweetalert2.min.js', array( 'jquery' ), SWEET_ALERT_WOO_SAW_VERSION, array('in_footer' => true) );
        wp_enqueue_script( 'sweet_alert_woo_saw_override_alert', plugin_dir_url( __FILE__ )  . 'assets/js/override-alert.js', array( 'wc-add-to-cart-variation', 'jquery' ), SWEET_ALERT_WOO_SAW_VERSION, array('in_footer' => true) );
    });

}

function sweet_alert_woo_saw_notices( $notice ) {
    ?>
    <div class="error notice">
        <p><?php echo $notice; ?></p>
    </div>
    <?php
}

function sweet_alert_woo_saw_requirements(){

    if ( ! is_plugin_active(
        'woocommerce/woocommerce.php'
    ) ) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
            add_action(
                'admin_notices',
                function() {
                    sweet_alert_woo_saw_notices( 'Sweet Alert Woo requiere que se encuentre instalado y activo el plugin: Woocommerce' );
                }
            );
        }
        return false;
    }


    return true;
}