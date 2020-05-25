<?php

/**
 * The core class of the plugin.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 * 
 * @property string $base_path Base URL for this plugin.
 * @property string $base_url Base URL for this plugin.
 * @property string $file The filename of the plugin.
 * @property string $version Plugin version.
 * @property int $max_addresses Maximum number of addresses.
 * @property Fr_Address_Book_for_WooCommerce_Activator $Activator
 * @property Fr_Address_Book_for_WooCommerce_Admin_Account $Admin_Account
 * @property Fr_Address_Book_for_WooCommerce_Admin_Plugins $Admin_Plugins
 * @property Fr_Address_Book_for_WooCommerce_Asset $Asset
 * @property Fr_Address_Book_for_WooCommerce_Countries $Countries
 * @property Fr_Address_Book_for_WooCommerce_Customer $Customer
 * @property Fr_Address_Book_for_WooCommerce_Frontend_Checkout $Frontend_Checkout
 * @property Fr_Address_Book_for_WooCommerce_Frontend_Checkout_Action $Frontend_Checkout_Action
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookAdd $Frontend_MyAccount_AddressBookAdd
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookAdd_Action $Frontend_MyAccount_AddressBookAdd_Action
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookEdit $Frontend_MyAccount_AddressBookEdit
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookEdit_Action $Frontend_MyAccount_AddressBookEdit_Action
 * @property Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_MyAddress $Frontend_MyAccount_MyAddress
 * @property Fr_Address_Book_for_WooCommerce_Frontend_Template $Frontend_Template
 * @property Fr_Address_Book_for_WooCommerce_I18n $I18n
 * @property Fr_Address_Book_for_WooCommerce_Theme_Support $Theme_Support
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
        if (is_admin()) {
            $this->Admin_Account->init();
            $this->Admin_Plugins->init();
        } else {
            $this->Asset->init();
            $this->Frontend_MyAccount_AddressBookAdd_Action->init();
            $this->Frontend_MyAccount_AddressBookEdit_Action->init();
            $this->Frontend_MyAccount_MyAddress->init();
            $this->Frontend_Template->init();
            $this->Theme_Support->init();
        }
        
        if (!is_admin() || defined('DOING_AJAX') && DOING_AJAX) {
            $this->Frontend_Checkout_Action->init();

            // Also hook on AJAX because Elementor renders elements using AJAX.
            $this->Frontend_Checkout->init();
        }
        
        $this->I18n->init();
        $this->Countries->init();

        // These services has action to register endpoints, so these need to be hooked 
        // not only on public area, but also admin area. This is because the rewrite 
        // rules will be flushed when saving permalink settings.
        $this->Frontend_MyAccount_AddressBookAdd->init();
        $this->Frontend_MyAccount_AddressBookEdit->init();
    }
    
    /**
     * Get plugin base path.
     * 
     * @since 1.0.0
     * @return string
     */
    public function get_base_path() {
        return FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_PATH;
    }
    
    /**
     * Get plugin base URL.
     * 
     * @since 1.0.0
     * @return string
     */
    public function get_base_url() {
        if (!$this->base_url) {
            $this->base_url = plugin_dir_url($this->file);
        }
        
        return $this->base_url;
    }
    
    /**
     * Get the filename of the plugin.
     * 
     * @since 1.0.0
     * @return string
     */
    public function get_file() {
        return FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_FILE;
    }
    
    /**
     * Get plugin version.
     * 
     * @since 1.0.0
     * @return string
     */
    public function get_version() {
        return FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_VERSION;
    }
    
    /**
     * Get the maximum number of addresses.
     * 
     * @since 1.0.0
     * @return int
     */
    public function get_max_addresses() {
        return (int) get_option('fabfw_max_addresses', 10);
    }
}
