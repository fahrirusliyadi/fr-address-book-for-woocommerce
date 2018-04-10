<?php

/**
 * Defines all code necessary to run during the plugin's activation.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Activator {
    /**
     * <code>activate_{$plugin}</code> action handler.
     * 
     * @link https://github.com/WordPress/WordPress/blob/a4b0b219b23fe22eb6168391385b12052cd25e3e/wp-admin/includes/plugin.php#L586
     * @since 1.0.0
     */
    public static function on_activate_() {
        static::flush_rewrite_rules();
    }
    
    /**
     * Flush rewrite rules.
     * 
     * @see https://github.com/woocommerce/woocommerce/wiki/Customising-account-page-tabs
     * @since 1.0.0
     */
    private static function flush_rewrite_rules() {
        // Endpoints need to be added before flushing rewrite rules. The 
        // endpoints have not been added because our hook handlers have not been 
        // attached and `plugins_loaded` action has already been fired.
        fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookEdit->add_rewrite_endpoint();
        fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookAdd->add_rewrite_endpoint();
        flush_rewrite_rules();
    }
}
