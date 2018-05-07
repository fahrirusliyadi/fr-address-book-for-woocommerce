<?php

/**
 * Front end template manager.
 * 
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_Template {
    /**
     * WooCommerce templates that will be overridden.
     * 
     * @since 1.0.0
     * @var array
     */
    private $wc_template_override = array(
        'myaccount/my-address.php' => 'my-address.php',
    );
    
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_filter('wc_get_template', array($this, 'on_wc_get_template'), 10, 5);
    }
    
    /**
     * <code>wc_get_template</code> filter handler.
     * 
     * @since 1.0.0
     * @param string $located Located template path.
     * @param string $template_name Template name.
     * @param array $args Array of variables that will be passed to the template file.
     * @param string $template_path Template path.
     * @param string $default_path Default path.
     * @return string
     */
    public function on_wc_get_template($located, $template_name, $args, $template_path, $default_path) {
        return $this->override_wc_template($located, $template_name);
    }
    
    /**
     * Load a template.
     * 
     * @since 1.0.0
     * @param string $__template Template name.
     * @param array $__args Array of arguments to pass to the template file.
     */
    public function load($__template, $__args = array()) {
        extract($__args);
        include $this->locate_template($__template);
    }
    
    /**
     * Override WooCommerce template.
     * 
     * @since 1.0.0
     * @param string $located Located template path.
     * @param string $template_name Template name.
     * @return string
     */
    private function override_wc_template($located, $template_name) {
        if (!isset($this->wc_template_override[$template_name])) {
            return $located;
        }
                
        return $this->locate_template($this->wc_template_override[$template_name]);
    }
    
    /**
     * Locate a template.
     * 
     * This is the load order:
     * your-theme/fr-address-book-for-woocommerce/$template_name
     * this-plugin/templates/$template_name
     * 
     * @since 1.0.0
     * @param string $template_name Template name.
     * @return string
     */
    private function locate_template($template_name) {
        $template_path = locate_template("fr-address-book-for-woocommerce/$template_name", false, false);
        
        if (!$template_path) {
            $template_path = fr_address_book_for_woocommerce()->base_path . "templates/$template_name";
        }
        
        /**
         * Filters the located template.
         * 
         * @since 1.0.0
         * @param string $template_path Located template path.
         * @param string $template_name Template name.
         */
        return apply_filters('fr_address_book_for_woocommerce_frontend_template__locate_template', $template_path, $template_name);
    }
}
