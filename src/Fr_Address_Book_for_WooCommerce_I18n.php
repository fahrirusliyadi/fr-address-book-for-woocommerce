<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_I18n {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_action('init', array($this, 'on_init'));
    }
    
    /**
     * <code>init</code> action handler.
     * 
     * @since 1.0.0
     */
    public function on_init() {
        $this->load_plugin_textdomain();
    }
    
    /**
     * Load the plugin text domain for translation.
     *
     * @since 1.0.0
     */
    private function load_plugin_textdomain() {        
        load_plugin_textdomain('fr-address-book-for-woocommerce', false, dirname(plugin_basename(fr_address_book_for_woocommerce()->file)) . '/languages/');
    }
}
