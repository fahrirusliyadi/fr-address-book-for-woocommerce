<?php

/**
 * Countries.
 * 
 * @since 1.2.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Countries {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.2.0
     */
    public function init() {
        add_filter('woocommerce_default_address_fields', array($this, 'modify_default_address_fields'));
    }

    /**
     * Modify the default address fields.
     * 
     * Add address name field.
     * 
     * @since 1.2.0
     * @param array $fields Default address fields.
     * @return array Modified address fields.
     */
    public function modify_default_address_fields($fields) {
        if (!isset($fields['address_name'])) {
            $fields = array(
                'address_name' => array(
                    'label'        => __( 'Address name', 'fr-address-book-for-woocommerce' ),
                    'class'        => array( 'form-row-wide' ),
                    'priority'     => 0,
                )
            ) + $fields;
        }

        return $fields;
    }
}