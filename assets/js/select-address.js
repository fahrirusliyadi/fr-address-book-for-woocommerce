/* global fabfw_select_address */
/**
 * Select address script on checkout page.
 * 
 * @since 1.0.0
 * @param {jQuery} $
 * @returns {undefined}
 */
(function($) {
    "use strict";
    
    /**
     * Select address class.
     * 
     * @since 1.0.0
     * @returns {SelectAddress}
     */
    function SelectAddress() {
        this.$document = $(document);
    }
    
    /**
     * Initialize.
     * 
     * @since 1.0.0
     * @returns {undefined}
     */
    SelectAddress.prototype.init = function() {
        this._initFieldValues();
        
        this.$document.on('change.fabfw', '[name="fabfw_address_billing_id"]', $.proxy(this.onChangeBillingSelect, this));
        this.$document.on('change.fabfw', '[name="fabfw_address_shipping_id"]', $.proxy(this.onChangeShippingSelect, this));
    };
    
    /**
     * Change event handler for select billing address field.
     * 
     * @since 1.0.0
     * @param {Event} event
     * @returns {undefined}
     */
    SelectAddress.prototype.onChangeBillingSelect = function(event) {
        this._updateFieldValues('billing', $(event.target));
    };
    
    /**
     * Change event handler for select shipping address field.
     * 
     * @since 1.0.0
     * @param {Event} event
     * @returns {undefined}
     */
    SelectAddress.prototype.onChangeShippingSelect = function(event) {
        this._updateFieldValues('shipping', $(event.target));
    };
    
    /**
     * Initialize address field values on load.
     * 
     * @since 1.0.0
     * @returns {undefined}
     */
    SelectAddress.prototype._initFieldValues = function() {        
        this._updateFieldValues('billing', $('[name="fabfw_address_billing_id"]:checked'));
        this._updateFieldValues('shipping', $('[name="fabfw_address_shipping_id"]:checked'));
    };
    
    /**
     * Update address field values.
     * 
     * @since 1.0.0
     * @param {string} type Address type (billing|shipping).
     * @param {jQuery} $selectAddress
     * @returns {undefined}
     */
    SelectAddress.prototype._updateFieldValues = function(type, $selectAddress) {
        var $form           = $selectAddress.closest('form');
        var address         = fabfw_select_address.addresses[$selectAddress.val()];
        
        if (!address) {
            return;
        }
        
        $.each(address, function(key, value) {
            var $field = $form.find('#' + type + '_' + key);
            
            if (!$field.length || $field.val() === value) {
                return;
            }
            
            // Create the select option if it does not exists yet.
            if ($field.is('select') && !$field.find('option[value="' + value + '"]').length) {
                $field.append('<option value="' + value + '">' + value + '</option>');
            }
            
            $field.val(value);
            // `onchange` only fires when the user types into the input and then the input loses focus.
            // https://stackoverflow.com/a/3179392
            $field.trigger('change');
        });
    };

    new SelectAddress().init();
    
})(jQuery);