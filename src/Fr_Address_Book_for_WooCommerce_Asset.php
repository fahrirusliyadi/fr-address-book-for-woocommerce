<?php

/**
 * Asset manager.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Asset {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_action('wp_enqueue_scripts', array($this, 'on_wp_enqueue_scripts'));
    }
    
    /**
     * <code>wp_enqueue_scripts</code> action handler.
     * 
     * @since 1.0.0
     */
    public function on_wp_enqueue_scripts() {
        $this->register_styles();
        $this->register_scripts();
    }
    
    /**
     * Enqueue a CSS stylesheet.
     *
     * @since 1.0.0
     * @param string $handle Name of the stylesheet. Should be unique.
     */
    public function enqueue_style($handle) {        
        wp_enqueue_style($handle);
        
        $after_method = "after_{$handle}_style";
        
        if (method_exists($this, $after_method)) {
            $this->{$after_method}();
        }
    }
    
    /**
     * Enqueue a script.
     * 
     * @since 1.0.0
     * @param string $handle Name of the script. Should be unique.
     */
    public function enqueue_script($handle) {
        wp_enqueue_script($handle);
        
        $after_method = "after_{$handle}_script";
        
        if (method_exists($this, $after_method)) {
            $this->{$after_method}();
        }
    }
    
    /**
     * Register stylesheets.
     * 
     * @since 1.0.0
     */
    private function register_styles() {
        $this->register_style('fabfw_front_end', 'assets/css/frontend.min.css', array(), fr_address_book_for_woocommerce()->version);
    }
    
    /**
     * Register scripts.
     * 
     * @since 1.0.0
     */
    private function register_scripts() {
        $this->register_script('fabfw_select_address', 'assets/js/select-address.min.js', array('jquery'), fr_address_book_for_woocommerce()->version, true);
    }
    
    /**
     * Register a CSS stylesheet.
     *
     * @since 1.0.0
     * @param string           $handle Name of the stylesheet. Should be unique.
     * @param string           $src    Path of the stylesheet relative to the plugin root directory.
     * @param array            $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
     * @param string|bool|null $ver    Optional. String specifying stylesheet version number, if it has one, which is added to the URL
     *                                 as a query string for cache busting purposes. If version is set to false, a version
     *                                 number is automatically added equal to current installed WordPress version.
     *                                 If set to null, no version is added.
     * @param string           $media  Optional. The media for which this stylesheet has been defined.
     *                                 Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
     *                                 '(orientation: portrait)' and '(max-width: 640px)'.
     * @return bool Whether the style has been registered. True on success, false on failure.
     */
    private function register_style($handle, $src, $deps = array(), $ver = false, $media = 'all') {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            $src = str_replace('.min.css', '.css', $src);
            $ver = filemtime(fr_address_book_for_woocommerce()->base_path . $src);
        }
        
        wp_register_style($handle, fr_address_book_for_woocommerce()->base_url . $src, $deps, $ver, $media);
    }
    
    /**
     * Register a new script.
     *
     * @since 1.0.0
     * @param string           $handle    Name of the script. Should be unique.
     * @param string           $src       Path of the script relative to the plugin root directory.
     * @param array            $deps      Optional. An array of registered script handles this script depends on. Default empty array.
     * @param string|bool|null $ver       Optional. String specifying script version number, if it has one, which is added to the URL
     *                                    as a query string for cache busting purposes. If version is set to false, a version
     *                                    number is automatically added equal to current installed WordPress version.
     *                                    If set to null, no version is added.
     * @param bool             $in_footer Optional. Whether to enqueue the script before </body> instead of in the <head>.
     *                                    Default 'false'.
     * @return bool Whether the script has been registered. True on success, false on failure.
     */
    private function register_script($handle, $src, $deps = array(), $ver = false, $in_footer = false) {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            $src = str_replace('.min.js', '.js', $src);
            $ver = filemtime(fr_address_book_for_woocommerce()->base_path . $src);
        }
                
        wp_register_script($handle, fr_address_book_for_woocommerce()->base_url . $src, $deps, $ver, $in_footer);
    }
    
    /**
     * Do something after enqueueing <code>fabfw_front_end</code> style.
     * 
     * Add custom CSS.
     * 
     * @since 1.0.0
     */
    private function after_fabfw_front_end_style() {
        $wc_email_base_color = get_option('woocommerce_email_base_color');
        
        // Use email base color as primary color.
        if ($wc_email_base_color) {
            $css = "
                .fabfw-select-address-container .form-row :checked+.radio { 
                    border-color: $wc_email_base_color; 
                }
            ";
            
            wp_add_inline_style('fabfw_front_end', $css);
        }
    }
    
    /**
     * Do something after enqueueing <code>fabfw_select_address</code> script.
     * 
     * Add `fabfw_select_address` variable.
     * 
     * @since 1.0.0
     */
    private function after_fabfw_select_address_script() {
        wp_localize_script('fabfw_select_address', 'fabfw_select_address', array(
            'addresses' => fr_address_book_for_woocommerce()->Customer->get_addresses(),
        ));
    }
}
