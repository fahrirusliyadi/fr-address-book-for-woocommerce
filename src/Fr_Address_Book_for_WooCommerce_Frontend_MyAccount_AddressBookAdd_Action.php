<?php

/**
 * Front end my-account/edit-address-book page action.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookAdd_Action extends Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBook_BaseAction {   
    /**
     * <code>template_redirect</code> action handler.
     * 
     * @since 1.0.0
     * @return void
     */
    public function on_template_redirect() {
        if (!function_exists('wc') || !wc()->customer->get_id()) {
            return;
        }
        
        if (wp_verify_nonce(wc_get_post_data_by_key('fabfw_add_address'), 'fabfw_add_address')) {
            $this->add_address();
        }
        
        if (wp_verify_nonce(filter_input(INPUT_GET, 'fabfw_delete_address'), 'fabfw_delete_address') && $address_id = filter_input(INPUT_GET, 'address_id', FILTER_SANITIZE_NUMBER_INT)) {
            $this->delete_address($address_id);
        }
    }
    
    /**
     * Add a new address.
     * 
     * @since 1.0.0
     * @return void
     */
    private function add_address() {
        if (count(fr_address_book_for_woocommerce()->Customer->get_addresses()) >= fr_address_book_for_woocommerce()->max_addresses) {
            wc_add_notice(__('You have reached the maximum number of addresses.', 'fr-address-book-for-woocommerce'), 'error');
            return;
        }
        
        $post_data = filter_input_array(INPUT_POST);
        
        $this->save_address($post_data);
                
        if (wc_notice_count('error') === 0) {            
            wc_add_notice(__('Address added successfully.', 'fr-address-book-for-woocommerce'));
            wp_safe_redirect(wc_get_endpoint_url('edit-address', null, wc_get_page_permalink('myaccount')));
            exit;
        } 
    }
    
    /**
     * Delete an address.
     * 
     * @since 1.0.0
     * @param int $address_id
     */
    private function delete_address($address_id) {
        $customer = new WC_Customer(wc()->customer->get_id());
        
        $customer->delete_meta_data_by_mid($address_id);
        $customer->save_meta_data();
        
        wc_add_notice(__('Address deleted successfully.', 'fr-address-book-for-woocommerce'));
        wp_safe_redirect(wc_get_endpoint_url('edit-address', null, wc_get_page_permalink('myaccount')));
        exit;
    }
}
