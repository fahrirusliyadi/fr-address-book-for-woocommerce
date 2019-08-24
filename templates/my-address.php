<?php
/**
 * My Addresses.
 * 
 * This template can be overridden by copying it to your-theme/fr-address-book-for-woocommerce/my-address.php.
 * 
 * This template overrides woocommerce/templates/myaccount/my-address.php.
 *
 * However, on occasion we will need to update template files and you (the theme 
 * developer) will need to copy the new files to your theme to maintain 
 * compatibility. 
 *
 * @since 1.0.0
 * @version 2.6.0 
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$addresses  = fr_address_book_for_woocommerce()->Customer->get_addresses();
$col        = 1;

?>

<div class="fabfw-addresses-container">
    <p>
	    <?php echo apply_filters('woocommerce_my_account_my_address_description', __('The following addresses will be used on the checkout page.', 'fr-address-book-for-woocommerce')); ?>
    </p>
    
    <?php if ($addresses) : ?>
        <div class="u-columns woocommerce-Addresses col2-set addresses">
            <?php foreach ($addresses as $id => $address) : 
                $col        = $col * -1;
                $edit_url   = wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookEdit->get_endpoint_name(), $id);
                $delete_url = add_query_arg(array(
                                'fabfw_delete_address'  => wp_create_nonce('fabfw_delete_address'),
                                'address_id'            => $id,
                            ), wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookEdit->get_endpoint_name(), $id));
                ?>
                <div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $col < 0 ? 1 : 2; ?> woocommerce-Address">
                    <header class="woocommerce-Address-title title">
                        <?php if (isset($address['address_name']) && $address['address_name']) : ?>
                            <h3><?php echo $address['address_name'] ?></h3>
                        <?php else: ?>
                            <h3><?php echo $address['first_name'] ?> <?php echo $address['last_name'] ?></h3>
                        <?php endif ?>

                        <a href="<?php echo esc_url($delete_url) ?>" class="edit fabfw-delete-link" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this address?', 'fr-address-book-for-woocommerce') ?>');"><?php _e('Delete', 'fr-address-book-for-woocommerce') ?></a>
                        <a href="<?php echo esc_url($edit_url) ?>" class="edit"><?php _e('Edit', 'fr-address-book-for-woocommerce') ?></a>
                    </header>

                    <address>
                        <?php echo wc()->countries->get_formatted_address($address) ?>
                    </address>
                </div>
            <?php endforeach ?>
        </div>
    <?php else : ?>
        <p>
            <?php _e('You do not have any saved addresses yet.', 'fr-address-book-for-woocommerce') ?>
        </p>
    <?php endif ?>
    
    <?php if (count($addresses) < fr_address_book_for_woocommerce()->max_addresses) : ?>
        <a href="<?php echo esc_url(wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookAdd->get_endpoint_name())); ?>" class="button"><?php _e('Add new address', 'fr-address-book-for-woocommerce') ?></a>
    <?php endif ?>
</div>