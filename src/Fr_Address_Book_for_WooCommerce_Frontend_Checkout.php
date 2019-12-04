<?php

/**
 * Front end checkout page.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_Checkout {
    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_action('woocommerce_before_checkout_billing_form', array($this, 'on_woocommerce_before_checkout_billing_form'));
        add_action('woocommerce_before_checkout_shipping_form', array($this, 'on_woocommerce_before_checkout_shipping_form'));
    }
    
    /**
     * <code>woocommerce_before_checkout_billing_form</code> action handler.
     * 
     * @since 1.0.0
     * @param WC_Checkout $checkout
     */
    public function on_woocommerce_before_checkout_billing_form($checkout) {
        if (!wc()->customer->get_id()) {
            echo '<input type="hidden" name="fabfw_address_billing_id" value="new">';
            echo '<input type="hidden" name="fabfw_address_shipping_id" value="new">';
            return;
        }
        
        $this->enqueue_scripts();
        $this->display_select_address_field('billing');
    }
    
    /**
     * <code>woocommerce_before_checkout_shipping_form</code> action handler.
     * 
     * @since 1.0.0
     * @param WC_Checkout $checkout
     */
    public function on_woocommerce_before_checkout_shipping_form($checkout) {
        if (!wc()->customer->get_id()) {
            return;
        }
                
        $this->display_select_address_field('shipping');
    }
    
    /**
     * Enqueue scripts.
     * 
     * @since 0.1.10
     */
    private function enqueue_scripts() {
        fr_address_book_for_woocommerce()->Asset->enqueue_style('fabfw_front_end');
        fr_address_book_for_woocommerce()->Asset->enqueue_script('fabfw_select_address');
    }

    /**
     * Display select address field.
     * 
     * @since 1.0.0
     * @param string $type Address type (billing|shipping).
     */
    private function display_select_address_field($type) {
        $addresses              = fr_address_book_for_woocommerce()->Customer->get_addresses();
        $address_ids            = array_keys($addresses);
        $saved_address_id       = wc()->customer->get_meta("fabfw_address_{$type}_id");
        $saved_address_id       = isset($addresses[$saved_address_id]) 
                                ? $saved_address_id 
                                // Use the first saved address.
                                : reset($address_ids);
        
        fr_address_book_for_woocommerce()->Frontend_Template->load('select-address.php', compact('type', 'addresses', 'saved_address_id'));
    }
}
