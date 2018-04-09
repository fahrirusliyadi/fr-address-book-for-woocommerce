<?php

/**
 * Asset manager.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Asset {
    /**
     * Enqueue a script.
     * 
     * @since 1.0.0
     * @param string           $handle    Name of the script. Should be unique.
     * @param string           $src       Path of the script relative to the plugin root directory.
     *                                    Default empty.
     * @param array            $deps      Optional. An array of registered script handles this script depends on. Default empty array.
     * @param string|bool|null $ver       Optional. String specifying script version number, if it has one, which is added to the URL
     *                                    as a query string for cache busting purposes. If version is set to false, a version
     *                                    number is automatically added equal to current installed WordPress version.
     *                                    If set to null, no version is added.
     * @param bool             $in_footer Optional. Whether to enqueue the script before </body> instead of in the <head>.
     *                                    Default 'false'.
     */
    public function enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false) {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            $ver = filemtime(FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_PATH . $src);
            $src = str_replace('.min.js', '.js', $src);
        }
        
        wp_enqueue_script($handle, fr_address_book_for_woocommerce()->get_base_url() . $src, $deps, $ver, $in_footer);
    }
}
