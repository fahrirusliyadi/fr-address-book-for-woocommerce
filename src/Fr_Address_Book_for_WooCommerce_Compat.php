<?php

/**
 * Theme supports.
 *
 * @since 1.2.7
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Compat {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.2.7
     */
    public function init() {
        add_action('before_woocommerce_init', array($this, 'custom_order_tables'));
    }

    /**
	 * Declare HPOS compatibility.
     * 
     * @since 1.2.7
	 */
	public function custom_order_tables() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', FR_ADDRESS_BOOK_FOR_WOOCOMMERCE_FILE, true );
		}
	}
}
