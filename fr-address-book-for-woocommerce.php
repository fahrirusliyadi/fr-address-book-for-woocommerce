<?php
/**
 * Plugin Name:     Fr Address Book for Woocommerce
 * Plugin URI:      https://wordpress.org/plugins/fr-address-book-for-woocommerce
 * Description:     Allow customers to save multiple addresses that they frequently use when placing an order.
 * Author:          Fahri Rusliyadi
 * Author URI:      https://profiles.wordpress.org/fahrirusliyadi
 * Text Domain:     fr-address-book-for-woocommerce
 * Domain Path:     /languages
 * Version:         1.2.2
 * WC tested up to: 4.2.2
 *
 * @package         Fr_Address_Book_For_Woocommerce
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Current plugin version.
 * 
 * @since 1.0.0
 */
define('FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_VERSION', '1.2.2');

/**
 * Plugin base path.
 * 
 * @since 1.0.0
 */
define('FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_PATH', plugin_dir_path(__FILE__));

/**
 * The filename of the plugin.
 * 
 * @since 1.0.0
 */
define('FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_FILE', __FILE__);

/**
 * Autoloader.
 * 
 * @since 1.0.0
 * @param string $class Class name.
 */
function fr_address_book_for_woocommerce_autoloader($class) {
    if (strpos($class, 'Fr_Address_Book_for_WooCommerce') === false) {
        return;
    }
    
    $path = FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_PATH . "src/$class.php";    
    if (file_exists($path)) {
        require $path;
    }
}
spl_autoload_register('fr_address_book_for_woocommerce_autoloader');

/**
 * Returns the core instance of the plugin.
 * 
 * @since 1.0.0
 * @staticvar Fr_Address_Book_for_WooCommerce $fr_address_book_for_woocommerce
 * @return Fr_Address_Book_for_WooCommerce
 */
function fr_address_book_for_woocommerce() {
    static $fr_address_book_for_woocommerce = null;
    
    if ($fr_address_book_for_woocommerce === null) {
        $fr_address_book_for_woocommerce = new Fr_Address_Book_for_WooCommerce();
    }
    
    return $fr_address_book_for_woocommerce;
}
add_action('plugins_loaded', array(fr_address_book_for_woocommerce(), 'init'));

/**
 * Register plugin activation handler.
 */
register_activation_hook(__FILE__, array('Fr_Address_Book_for_WooCommerce_Activator', 'on_activate_'));
