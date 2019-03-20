<?php

/**
 * Theme supports.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Theme_Support {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_action('init', array($this, 'theme_support_init'));
    }
    
    /**
     * Initialize theme supports.
     * 
     * @since 1.0.0
     * @access private
     */
    public function theme_support_init() {
        $theme_name = get_template();
        $init_method = str_replace(array(' ', '-'), '_', $theme_name) . '_init';

        if (method_exists($this, $init_method)) {
            $this->$init_method();
        }
    }
    
    /**
     * Initialize Twenty Seventeen theme support.
     * 
     * @since 1.0.0
     */
    protected function twentyseventeen_init() {
        add_action('wp_enqueue_scripts', array($this, 'twentyseventeen_scripts'));
    }
    
    /**
     * Enqueue Twenty Seventeen scripts and styles.
     * 
     * @since 1.0.0
     * @access private
     */
    public function twentyseventeen_scripts() {
        $css = "
            .fabfw-addresses-container .fabfw-delete-link {
                margin-left: 0;
            }
        ";
        
        wp_add_inline_style('fabfw_front_end', $css);
    }
    
    /**
     * Initialize Twenty Nineteen theme support.
     * 
     * @since 1.1.0
     */
    protected function twentynineteen_init() {
        add_action('wp_enqueue_scripts', array($this, 'twentyseventeen_scripts'));
    }
    
    /**
     * Enqueue Twenty Nineteen scripts and styles.
     * 
     * @since 1.1.0
     * @access private
     */
    public function twentynineteen_scripts() {
        $css = "
            .fabfw-addresses-container .fabfw-delete-link {
                margin-left: 0;
            }
        ";
        
        wp_add_inline_style('fabfw_front_end', $css);
    }
}
