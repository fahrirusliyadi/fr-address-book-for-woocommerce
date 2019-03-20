<?php

/**
 * WordPress plugins page.
 *
 * @since 1.1.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Admin_Plugins {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.1.0
     */
    public function init() {
        add_filter('plugin_action_links_' . plugin_basename(FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_FILE), array($this, 'add_action_links'));
    }
    
    /**
     * Add settings link to the list of links on the plugins page.
     * 
     * @since 1.1.0
     * @param array $actions Plugin action links
     * @return array Modified plugin action links.
     */
    public function add_action_links($actions) {
        $links = array(
            '<a href="' . admin_url('admin.php?page=wc-settings&tab=account&section=fabfw') . '">' . __('Settings', 'fr-address-book-for-woocommerce') . '</a>',
        );
        
        return array_merge($actions, $links);
    }
}
