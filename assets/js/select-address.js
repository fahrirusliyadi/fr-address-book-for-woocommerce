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
        this.$window    = $(window);
        this.$document  = $(document);
    }
    
    /**
     * Initialize.
     * 
     * @since 1.0.0
     * @returns {undefined}
     */
    SelectAddress.prototype.init = function() {
        this._initFieldValues();
        
        this.$document.on('change.fabfw', '.fabfw-select-address-container [name="fabfw_address_billing_id"]', $.proxy(this.onChangeBillingSelect, this));
        this.$document.on('change.fabfw', '.fabfw-select-address-container [name="fabfw_address_shipping_id"]', $.proxy(this.onChangeShippingSelect, this));
        // Cannot use descendants selector because WooCommerce@3.4.0 is stopping event propagation.
        // https://github.com/woocommerce/woocommerce/blob/e8d8e25de1f0a43e9bd89f1c54625ede125a2b97/assets/js/frontend/woocommerce.js#L35-L37
        this.$document.find('.fabfw-select-address-container .fabfw-edit').on('click.fabfw', $.proxy(this.onClickEditAddress, this));
    };
    
    /**
     * Change event handler for select billing address field.
     * 
     * @since 1.0.0
     * @param {Event} event
     * @returns {undefined}
     */
    SelectAddress.prototype.onChangeBillingSelect = function(event) {
        var $selectedField = $(event.target);
        
        this._toggleFields('billing', $selectedField);
        this._updateFieldValues('billing', $selectedField);
    };
    
    /**
     * Change event handler for select shipping address field.
     * 
     * @since 1.0.0
     * @param {Event} event
     * @returns {undefined}
     */
    SelectAddress.prototype.onChangeShippingSelect = function(event) {
        var $selectedField = $(event.target);
        
        this._toggleFields('shipping', $selectedField);
        this._updateFieldValues('shipping', $selectedField);
    };
    
    /**
     * Click event handler for edit address link.
     * 
     * @since 1.0.0
     * @param {Event} event
     * @returns {undefined}
     */
    SelectAddress.prototype.onClickEditAddress = function(event) {
        var type = $(event.target).closest('#fabfw_address_billing_id_field').length ? 'billing' : 'shipping';
        
        event.preventDefault();        
        this._showFields(type);
    };
    
    /**
     * Initialize address field values on load.
     * 
     * @since 1.0.0
     * @returns {undefined}
     */
    SelectAddress.prototype._initFieldValues = function() {        
        var $selectedBillingField   = $('[name="fabfw_address_billing_id"]:checked');
        var $selectedShippingField  = $('[name="fabfw_address_shipping_id"]:checked');
        
        this._toggleFields('billing', $selectedBillingField);
        this._toggleFields('shipping', $selectedShippingField);
        this._updateFieldValues('billing', $selectedBillingField);
        this._updateFieldValues('shipping', $selectedShippingField);
    };
    
    /**
     * Show the address fields if the customer wants to add a new address, otherwise
     * hide it.
     * 
     * @since 1.0.0
     * @param {string} type Address type (billing|shipping).
     * @param {jQuery} $selectedField
     * @returns {undefined}
     */
    SelectAddress.prototype._toggleFields = function(type, $selectedField) {
        // No saved address yet. The field is a input[type=hidden], so $selectedField 
        // will not contain any element.
        if (!$selectedField.length) {
            return;
        }
        
        var addressId   = $selectedField.val();
        var $newButton  = $selectedField.closest('.fabfw-select-address-container').find('[for="fabfw_address_' + type + '_id_new"] .button');
        
        $('.woocommerce-' + type + '-fields__field-wrapper').toggleClass('hidden', addressId !== 'new');
        $newButton.toggleClass('disabled', addressId === 'new');
    };
    
    /**
     * Show the address fields and focus to the first visible field.
     * 
     * @since 1.0.0
     * @param {string} type Address type (billing|shipping).
     * @returns {undefined}
     */
    SelectAddress.prototype._showFields = function(type) {
        var $fieldsWrapper  = $('.woocommerce-' + type + '-fields__field-wrapper');
        
        $fieldsWrapper.removeClass('hidden');
        $fieldsWrapper.find(':input:visible').first().focus();
    };
    
    /**
     * Update address field values.
     * 
     * @since 1.0.0
     * @param {string} type Address type (billing|shipping).
     * @param {jQuery} $selectedField
     * @returns {undefined}
     */
    SelectAddress.prototype._updateFieldValues = function(type, $selectedField) {
        var $form           = $selectedField.closest('form');
        var address         = fabfw_select_address.addresses[$selectedField.val()];
        
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