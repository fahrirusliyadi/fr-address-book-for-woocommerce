<?php

/**
 * Customer.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Customer {
    /**
     * Get addresses.
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_addresses() {
        $addresses = array();
        
        foreach (wc()->customer->get_meta("fabfw_address", false) as $meta) {
            $addresses[$meta->id] = $meta->value;
        }
        
        return $addresses;
    }
}
