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
        if (!wp_verify_nonce(filter_input(INPUT_POST, 'fabfw_save'), 'fabfw_save')) {
            return;
        }
        
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
        if (count(fr_address_book_for_woocommerce()->Customer->get_addresses()) >= fr_address_book_for_woocommerce()->max_addresses) {
            return;
        }
        
        $selected_address_id = filter_input(INPUT_POST, "fabfw_address_{$type}_id");
        
        if (!$selected_address_id) {
            return;
        }
        
        $address = $customer->{"get_$type"}();
        
        // Save custom address fields that may be provided by other plugins.
        foreach ($data as $key => $value) {            
            // Exclude array and object values.
            if (is_array($value) || is_object($value) || strpos($key, "{$type}_") !== 0) {
                continue;
            }
            
            $key = preg_replace("/^{$type}_/", '', $key);
            
            if (!isset($address[$key])) {
                $address[$key]  = $value;
            }
        }
        
        if ($selected_address_id === 'new') {
            $customer->add_meta_data("fabfw_address", $address);
        } else {
            $customer->update_meta_data("fabfw_address", $address, $selected_address_id);
            $customer->update_meta_data("fabfw_address_{$type}_id", $selected_address_id);
        }
    }
}
