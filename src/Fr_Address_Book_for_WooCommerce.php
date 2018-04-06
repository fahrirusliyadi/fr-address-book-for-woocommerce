<?php

/**
 * The core class of the plugin.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class Fr_Address_Book_for_WooCommerce {
    
    /**
     * Array of services.
     * 
     * @since 1.0.0
     * @var array
     */
    private $services = array();
    
    /**
     * Initialize services.
     * 
     * @since 1.0.0
     */
    public function init() {
        
    }
    
    /**
     * Get a property's value.
     * 
     * @since 1.0.0
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        
        $class_name = "Fr_Address_Book_for_WooCommerce_$name";
        
        if (class_exists($class_name)) {            
            return $this->services[$name] = new $class_name;
        }
    }
}
