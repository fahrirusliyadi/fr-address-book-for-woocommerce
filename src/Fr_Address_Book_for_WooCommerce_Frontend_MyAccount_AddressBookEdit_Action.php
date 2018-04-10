<?php

/**
 * Front end my-account/edit-address-book page action.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBookEdit_Action extends Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_AddressBook_BaseAction {   
    /**
     * <code>template_redirect</code> action handler.
     * 
     * @since 1.0.0
     * @return void
     */
    public function on_template_redirect() {
        if (!function_exists('wc') || !wc()->customer->get_id() || !wp_verify_nonce(wc_get_post_data_by_key('fabfw_edit_address'), 'fabfw_edit_address')) {
            return;
        }
        
        $this->update_address();
    }
    
    /**
     * Update an address.
     * 
     * @since 1.0.0
     * @return void
     */
    private function update_address() {
        $post_data = filter_input_array(INPUT_POST);
        
        if (!isset($post_data['address_id'])) {
            return;
        }
                
        $this->save_address($post_data);
                
        if (wc_notice_count('error') === 0) {            
            wc_add_notice(__('Address changed successfully.', 'fr-address-book-for-woocommerce'));
            wp_safe_redirect(wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookEdit->get_endpoint_name(), $post_data['address_id'], wc_get_page_permalink('myaccount')));
            exit;
        } 
    }
}
