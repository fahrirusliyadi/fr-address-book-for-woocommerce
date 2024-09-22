<?php

/**
 * Customer.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Customer {
    /**
     * Customer.
     * 
     * Use custom customer because WooCommerce may use customer-session data store which will not able to get the latest
     * address data.
     * 
     * @since 1.2.8
     * @var WC_Customer
     */
    private $customer;

    /**
     * Constructor.
     * 
     * @since 1.2.8
     */
    public function __construct() {
        $this->customer = new WC_Customer(wc()->customer->get_id());
    }

    /**
     * Get addresses.
     * 
     * @since 1.0.0
     * @return array
     */
    public function get_addresses() {
        $addresses = array();
        $metas = $this->customer->get_meta("fabfw_address", false);

        // If no address found, add the current billing address to the address book.
        if (empty($metas)) {
            $address = $this->customer->get_billing();

            // Assumes the user has a billing address.
            if (isset($address['postcode'])) {
                $this->customer->add_meta_data("fabfw_address", $address);
                $this->customer->save_meta_data();

                $metas = $this->customer->get_meta("fabfw_address", false);
            }
        }
        
        foreach ($metas as $meta) {
            $addresses[$meta->id] = $meta->value;
        }
        
        return $addresses;
    }
}
