<?php
/**
 * Select address field.
 *
 * This template can be overridden by copying it to your-theme/fr-address-book-for-woocommerce/select-address.php.
 *
 * However, on occasion we will need to update template files and you (the theme 
 * developer) will need to copy the new files to your theme to maintain 
 * compatibility. 
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */

/* @var $type string */
/* @var $addresses array */
/* @var $saved_address_id int */

$field_options  = array();

foreach ($addresses as $id => $value) {
    $field_options[$id] = isset($value['address_name']) && $value['address_name'] 
                        ? sprintf('<strong class="fabfw-address-name">%s</strong><br>', $value['address_name']) 
                        : '';
    $field_options[$id] .= wc()->countries->get_formatted_address($value);
    $field_options[$id] .= sprintf('<br><a href="#" class="fabfw-edit">%s</a>', __('Edit', 'fr-address-book-for-woocommerce'));
}

if (count($addresses) < fr_address_book_for_woocommerce()->max_addresses) {
    $field_options['new'] = sprintf('<a class="button">%s</a>', __('Add new address', 'fr-address-book-for-woocommerce'));
}
?>

<div class="fabfw-select-address-container">                     
    <?php if ($addresses) : ?>
        <?php woocommerce_form_field("fabfw_address_{$type}_id", array(
            'label'     => __('Address book', 'fr-address-book-for-woocommerce'),
            'type'      => 'radio',
            'options'   => $field_options,
        ), $saved_address_id) ?>
    <?php 
        // Hide the field if no addresses saved yet.
        else : ?>
        <input type="hidden" name="<?php echo "fabfw_address_{$type}_id" ?>" value="new">
    <?php endif ?>
</div>