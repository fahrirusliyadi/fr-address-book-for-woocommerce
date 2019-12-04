<?php

/**
 * Actions on the front end checkout page.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_Checkout_Action {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_action('woocommerce_checkout_update_customer', array($this, 'on_woocommerce_checkout_update_customer'), 10, 2);
    }
    
    /**
     * <code>woocommerce_checkout_update_customer</code> action handler.
     * 
     * @since 1.0.0
     * @param WC_Customer $customer
     * @param array $data Posted data.
     * @return void
     */
    public function on_woocommerce_checkout_update_customer($customer, $data) {
        $this->save_address('billing', $customer, $data);
        
        if ($data['ship_to_different_address']) {
            $this->save_address('shipping', $customer, $data);
        }
    }
    
    /**
     * Save the new/updated address.
     * 
     * @since 1.0.0
     * @param string $type Address type (billing|shipping).
     * @param WC_Customer $customer
     * @param array $data Posted data.
     */
    private function save_address($type, $customer, $data) {
        $selected_address_id = filter_input(INPUT_POST, "fabfw_address_{$type}_id");        
        if (!$selected_address_id) {
            return;
        }
        
        $address_data = $customer->{"get_$type"}();
        
        // Save custom address fields that may be provided by other plugins.
        foreach ($data as $key => $value) {            
            // Exclude non-scalar and non-address values.
            if (!is_scalar($value) || strpos($key, "{$type}_") !== 0) {
                continue;
            }
            
            $key = preg_replace("/^{$type}_/", '', $key);
            
            if (!isset($address_data[$key])) {
                $address_data[$key]  = $value;
            }
        }
        
        if ($selected_address_id === 'new') {
            if (count(fr_address_book_for_woocommerce()->Customer->get_addresses()) < fr_address_book_for_woocommerce()->max_addresses) {
                $customer->add_meta_data("fabfw_address", $address_data);
            }
        } else {
            // Cast to integer because WooCommerce uses strict comparison.
            // https://github.com/woocommerce/woocommerce/blob/3.5.7/includes/abstracts/abstract-wc-data.php#L428
            $selected_address_id    = (int) $selected_address_id;
            $old_addresses          = fr_address_book_for_woocommerce()->Customer->get_addresses();
            $address_data           = isset($old_addresses[$selected_address_id]) ? array_merge($old_addresses[$selected_address_id], $address_data) : $address_data;
            
            $customer->update_meta_data("fabfw_address", $address_data, $selected_address_id);
            $customer->update_meta_data("fabfw_address_{$type}_id", $selected_address_id);
        }
    }
}
