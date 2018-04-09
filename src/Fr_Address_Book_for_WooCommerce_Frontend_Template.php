<?php

/**
 * Front end template manager.
 * 
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_Template {
    /**
     * Load a template.
     * 
     * @since 1.0.0
     * @param string $__template Template name.
     * @param array $__args Array of arguments to pass to the template file.
     */
    public function load($__template, $__args = array()) {
        $__template_path = locate_template("fr-address-book-for-woocommerce/$__template", false, false);
        
        if (!$__template_path) {
            $__template_path = FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_PATH . "templates/$__template";
        }
        
        extract($__args);
        include $__template_path;
    }
}
