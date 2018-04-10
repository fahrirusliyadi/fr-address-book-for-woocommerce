<?php
/**
 * Addresss.
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

<div class="fabfw-address-book">
    <h2 class="fabfw-title"><?php _e('Additional Addresses', 'fr-address-book-for-woocommerce') ?></h2>
    
    <div class="u-columns woocommerce-Addresses col2-set addresses">
        <?php foreach ($addresses as $id => $address) : $col = $col * -1 ?>
            <div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $col < 0 ? 1 : 2; ?> woocommerce-Address">
                <header class="woocommerce-Address-title title">
                    <h3><?php echo $address['first_name'] ?> <?php echo $address['last_name'] ?></h3>
                    <a href="<?php echo esc_url(wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookEdit->get_endpoint_name(), $id)); ?>" class="edit"><?php _e('Edit', 'fr-address-book-for-woocommerce') ?></a>
                </header>
                
                <address>
                    <?php echo wc()->countries->get_formatted_address($address) ?>
                </address>
            </div>
        <?php endforeach ?>
    </div>
    
    <a href="<?php echo esc_url(wc_get_endpoint_url(fr_address_book_for_woocommerce()->Frontend_MyAccount_AddressBookAdd->get_endpoint_name())); ?>" class="button"><?php _e('Add new address', 'fr-address-book-for-woocommerce') ?></a>
</div>