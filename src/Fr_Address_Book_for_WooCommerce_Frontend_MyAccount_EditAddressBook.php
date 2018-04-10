<?php

/**
 * Front end my-account/edit-address-book page.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_EditAddressBook {
    /**
     * Endpoint name.
     * 
     * @since 1.0.0
     * @var string
     */
    private $endpoint_name = 'edit-address-book';

    /**
     * Register actions and filters with WordPress.
     * 
     * @since 1.0.0
     */
    public function init() {
        add_action('init', array($this, 'on_init'));
        add_action("woocommerce_account_{$this->endpoint_name}_endpoint", array($this, 'on_woocommerce_account__endpoint'));
        add_filter('query_vars', array($this, 'filter_query_vars'));
        add_filter('the_title', array($this, 'filter_the_title'), 10, 2);
    }
    
    /**
     * <code>init</code> action handler.
     * 
     * @since 1.0.0
     */
    public function on_init() {
        $this->add_rewrite_endpoint();
    }
    
    /**
     * <code>woocommerce_account_{$key}_endpoint</code> action handler.
     * 
     * @link https://github.com/woocommerce/woocommerce/blob/c01b7287989eaa0de7e80d2da9ca3cedf37971e4/includes/wc-template-functions.php#L2480
     * 
     * @param string $value Endpoint query var value.
     */
    public function on_woocommerce_account__endpoint($value) {
        $this->display_edit_address($value);
    }
    
    /**
     * <code>query_vars</code> filter handler.
     * 
     * @since 1.0.0
     * @param array $public_query_vars The array of whitelisted query variables.
     * @return array
     */
    public function filter_query_vars($public_query_vars) {
        $public_query_vars = $this->add_query_vars($public_query_vars);
        
        return $public_query_vars;
    }
    
    /**
     * <code>the_title</code> filter handle.
     * 
     * @since 1.0.0
     * @param string $title The post title.
     * @param int $id The post ID.
     * @return string
     */
    public function filter_the_title($title, $id) {
        return $this->change_endpoint_title($title);
    }
    
    /**
     * Register new endpoint to use inside My Account page.
     *
     * @see https://github.com/woocommerce/woocommerce/wiki/Customising-account-page-tabs
     * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
     * 
     * @since 1.0.0
     */
    public function add_rewrite_endpoint() {
        add_rewrite_endpoint($this->endpoint_name, EP_ROOT | EP_PAGES);
    }
    
    /**
     * Get the endpoint name.
     * 
     * @since 1.0.0
     * @return string
     */
    public function get_endpoint_name() {
        return $this->endpoint_name;
    }
    
    /**
     * Display edit address form.
     * 
     * @link https://github.com/woocommerce/woocommerce/blob/c01b7287989eaa0de7e80d2da9ca3cedf37971e4/includes/shortcodes/class-wc-shortcode-my-account.php#L158-L197
     * 
     * @since 1.0.0
     * @param int $address_id
     */
    private function display_edit_address($address_id) {
        $saved_addresses = fr_address_book_for_woocommerce()->Customer->get_addresses();
        
        if (!isset($saved_addresses[$address_id])) {
            return;
        }
        
        $saved_address  = $saved_addresses[$address_id];
        $address        = wc()->countries->get_address_fields(get_user_meta(get_current_user_id(), 'billing_country', true));

        // Enqueue scripts.
        wp_enqueue_script('wc-country-select');
        wp_enqueue_script('wc-address-i18n');

        // Prepare values.
        foreach ($address as $key => $field) {
            $saved_key      = preg_replace('/^billing_/', '', $key);
            $field['value'] = isset($saved_addresses[$address_id][$saved_key]) ? $saved_addresses[$address_id][$saved_key] : '';
            $address[$key]  = $field;
        }

        fr_address_book_for_woocommerce()->Frontend_Template->load('edit-address.php', compact('address_id', 'address', 'saved_address'));
    }

    /**
     * Add new query variables.
     *
     * @see https://github.com/woocommerce/woocommerce/wiki/Customising-account-page-tabs
     * @since 1.0.0
     * @param array $public_query_vars
     * @return array
     */
    private function add_query_vars($public_query_vars) {
        $public_query_vars[] = $this->endpoint_name;
        
        return $public_query_vars;
    }
    
    /**
     * Change endpoint title.
     * 
     * @since 1.0.0
     * @global WP_Query $wp_query
     * @param string $title
     * @return string
     */
    private function change_endpoint_title($title) {
        global $wp_query;

	$is_endpoint = isset($wp_query->query_vars[$this->endpoint_name]);

	if ($is_endpoint && !is_admin() && is_main_query() && in_the_loop() && is_account_page()) {
            // New page title.
            $title = __('Edit Address', 'fr-address-book-for-woocommerce');

            remove_filter('the_title', array($this, 'filter_the_title'));
	} 

	return $title;
    }
}
