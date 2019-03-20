<?php

/**
 * Account settings.
 *
 * @since 1.1.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Admin_Account {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.1.0
     */
    public function init() {
        add_filter('woocommerce_get_sections_account', array($this, 'add_address_book_section'));
        add_filter('woocommerce_get_settings_account', array($this, 'address_book_settings'));
    }
    
    /**
     * Add address book setting section.
     * 
     * @since 1.1.0
     * @access private
     * @param array $sections Setting sections.
     * @return array Modified setting sections.
     */
    public function add_address_book_section($sections) {
        // WooCommerce:3.5.7 account settings does not have tabs.
        if (!$sections) {
            $sections[''] = __('General', 'fr-address-book-for-woocommerce');
        }
        
        $sections['fabfw'] = __('Address book', 'fr-address-book-for-woocommerce');
                
        return $sections;
    }
    
    /**
     * Set address book settings configuration.
     * 
     * @since 1.1.0
     * @access private
     * @global string $current_section Current setting section.
     * @param array $settings Settings configuration.
     * @return array Modified settings configuration.
     */
    public function address_book_settings($settings) {
        global $current_section;
        
        if ($current_section === 'fabfw') {
            $settings = array(
                array(
                    'title' => __('General', 'fr-address-book-for-woocommerce'),
                    'type'  => 'title',
                    'id'    => 'fabfw_general',
                ),
                array(
                    'title'    => __('Max addresses', 'fr-address-book-for-woocommerce'),
                    'desc'     => __('The maximum number of addresses a customer allowed to save.', 'fr-address-book-for-woocommerce'),
                    'id'       => 'fabfw_max_addresses',
                    'default'  => 10,
                    'type'     => 'number',
                    'desc_tip' => true,
                ),
                array(
                    'type' => 'sectionend',
                    'id'   => 'fabfw_general',
                ),
            );
        }
        
        return $settings;
    }
}
