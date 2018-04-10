<?php

/**
 * The core class of the plugin.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 * 
 * @property Fr_Address_Book_for_WooCommerce_Asset $Asset
 * @property Fr_Address_Book_for_WooCommerce_Customer $Customer
 * @property Fr_Address_Book_for_WooCommerce_Frontend_Checkout $Frontend_Checkout
 * @property Fr_Address_Book_for_WooCommerce_Frontend_Checkout_Action $Frontend_Checkout_Action
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookEdit $Frontend_MyAccount_AddressBookEdit
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookEdit_Action $Frontend_MyAccount_AddressBookEdit_Action
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_MyAddress $Frontend_MyAccount_MyAddress
 * @property Fr_Address_Book_for_WooCommerce_Frontend_Template $Frontend_Template
 */
class Fr_Address_Book_for_WooCommerce {
    /**
     * Base URL for this plugin.
     * 
     * @since 1.0.0
     * @var string
     */
    private $base_url;
    
    /**
     * Array of services.
     * 
     * @since 1.0.0
     * @var array
     */
    private $services = array();
    
    /**
     * Get a property's value.
     * 
     * @since 1.0.0
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        $getter = "get_$name";
        
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }
        
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        
        $class_name = "Fr_Address_Book_for_WooCommerce_$name";
        
        if (class_exists($class_name)) {            
            return $this->services[$name] = new $class_name;
        }
    }
    
    /**
     * Initialize services.
     * 
     * @since 1.0.0
     */
    public function init() {
        $this->Frontend_Checkout->init();
        $this->Frontend_Checkout_Action->init();
        $this->Frontend_MyAccount_AddressBookEdit->init();
        $this->Frontend_MyAccount_AddressBookEdit_Action->init();
        $this->Frontend_MyAccount_MyAddress->init();
    }
    
    /**
     * Get plugin base URL.
     * 
     * @since 1.0.0
     * @return string
     */
    public function get_base_url() {
        if (!$this->base_url) {
            $this->base_url = plugin_dir_url(FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_PATH . 'fr-address-book-for-woocommerce.php');
        }
        
        return $this->base_url;
    }
}
