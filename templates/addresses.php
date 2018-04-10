<?php
/**
 * Addresses.
 *
 * This template can be overridden by copying it to yourtheme/fr-address-book-for-woocommerce/addresses.php.
 *
 * However, on occasion we will need to update template files and you (the theme 
 * developer) will need to copy the new files to your theme to maintain 
 * compatibility. 
 *
 * @since 1.0.0
 * @version 1.0.0 woocommerce/myaccount/my-account.php@2.6.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$col = 1;

?>

<div class="fabfw-addresses-container">
    <h2 class="fabfw-title"><?php _e('Additional Addresses', 'fr-address-book-for-woocommerce') ?></h2>
    
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
                        <h3><?php echo $address['first_name'] ?> <?php echo $address['last_name'] ?></h3>

                        <a href="<?php echo esc_url($delete_url) ?>" class="edit fabfw-delete-link" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this address?', 'fr-address-book-for-woocommerce') ?>');"><?php _e('Delete', 'fr-address-book-for-woocommerce') ?></a>
                        <a href="<?php echo esc_url($edit_url) ?>" class="edit"><?php _e('Edit', 'fr-address-book-for-woocommerce') ?></a>
                    </header>

                    <address>
                        <?php 
                        // Remove first name and last name. It has already displayed as the title.
                        unset($address['first_name']); 
                        unset($address['last_name']);
                        echo wc()->countries->get_formatted_address($address);
                        ?>
                    </address>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    
    <a href="<?php echo esc_url(wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookAdd->get_endpoint_name())); ?>" class="button"><?php _e('Add new address', 'fr-address-book-for-woocommerce') ?></a>
</div>