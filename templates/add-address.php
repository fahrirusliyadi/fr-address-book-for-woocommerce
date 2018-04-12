<?php
/**
 * Add new address form.
 *
 * This template can be overridden by copying it to your-theme/fr-address-book-for-woocommerce/add-address.php.
 *
 * However, on occasion we will need to update template files and you (the theme 
 * developer) will need to copy the new files to your theme to maintain 
 * compatibility. 
 *
 * @since 1.0.0
 * @version 1.0.0 Markup based on woocommerce/myaccount/form-edit-address.php@3.3.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="fabfw-add-address-container">
    <form method="post">
        <div class="woocommerce-address-fields">
            <div class="woocommerce-address-fields__field-wrapper">
                <?php
                foreach ($address_fields as $key => $field) {
                    if (isset($field['country_field'], $address_fields[$field['country_field']])) {
                        $field['country'] = wc_get_post_data_by_key($field['country_field']);
                    }

                    woocommerce_form_field($key, $field, wc_get_post_data_by_key($key));
                }
                ?>
            </div>

            <p>
                <button type="submit" class="button"><?php esc_html_e('Add address', 'fr-address-book-for-woocommerce') ?></button>
                <?php wp_nonce_field('fabfw_add_address', 'fabfw_add_address') ?>
            </p>
        </div>
    </form>
</div>
