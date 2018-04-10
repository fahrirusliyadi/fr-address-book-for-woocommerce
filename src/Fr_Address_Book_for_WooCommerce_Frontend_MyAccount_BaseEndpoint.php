<?php


/**
 * Base front end my-account endpoint.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
abstract class Fr_Address_Book_for_WooCommerce_Frontend_MyAccount_BaseEndpoint {
    /**
     * Endpoint name.
     * 
     * @since 1.0.0
     * @var string
     */
    protected $endpoint_name = 'address-book';
    
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
        $this->display_endpoint_content($value);
    }
    
    /**
     * <code>query_vars</code> filter handler.
     * 
     * @since 1.0.0
     * @param array $public_query_vars The array of whitelisted query variables.
     * @return array
     */
    public function filter_query_vars($public_query_vars) {        
        return $this->add_query_var($public_query_vars);
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
        return $this->change_endpoint_title($title, $id);
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
     * @since 1.0.0
     * @param string $value Endpoint query var value.
     */
    protected function display_endpoint_content($value) {
        
    }

    /**
     * Add new query variable.
     *
     * @see https://github.com/woocommerce/woocommerce/wiki/Customising-account-page-tabs
     * @since 1.0.0
     * @param array $public_query_vars
     * @return array
     */
    protected function add_query_var($public_query_vars) {
        $public_query_vars[] = $this->endpoint_name;
        
        return $public_query_vars;
    }
    
    /**
     * Change endpoint title.
     * 
     * @since 1.0.0
     * @param string $title
     * @param int $id The post ID.
     * @return string
     */
    private function change_endpoint_title($title, $id) {
	return $title;
    }
}
