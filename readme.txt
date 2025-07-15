=== Fr Address Book For Woocommerce ===
Contributors: fahrirusliyadi
Donate link: https://paypal.me/FahriRusliyadi
Tags: multi, multiple, woocommerce, address, addresses, address-book
Requires at least: 4.9
Tested up to: 6.8.1
Stable tag: 1.2.9
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Allow customers to save multiple addresses that they frequently use when placing an order.

== Description ==

The address book contains the customer's default billing and shipping addresses, and any additional addresses that they frequently use when placing an order. This will speed up the checkout process.

== Installation ==

1. Upload `fr-address-book-for-woocommerce` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the **Plugins** menu in WordPress
3. Go to *WooCommerce* &rarr; *Settings* &rarr; *Accounts & Privacy* &rarr; *Address book* to configure the plugin.

Note: this plugin does not support Block Editor, you need to use [woocommerce_checkout] shortcode.

1. Go to *Pages* &rarr; *Checkout*
2. Open the Block Transform menu
3. Choose &quot;Classic Shortcode&quot;

== Frequently Asked Questions ==

= Uninstallation Instructions =

Deactivate and delete the plugin through the **Plugins** menu in WordPress.

= Does it provide a feature to checkout with multiple shipping address? =

No.

== Screenshots ==

1. Addresses page without addresses yet
2. Addresses page
3. Edit address
4. Checkout page
5. Switching to &quot;Classic Shortcode&quot;

== Changelog ==

= 1.2.9 =
* Fix to ensure address fields are properly cleared after deletion.

= 1.2.8 =
* Fix address details not populating for old accounts.

= 1.2.7 =
* Declare HPOS compatibility.

= 1.2.6 =
* Add hooks to the add-address.php template.

= 1.2.5 =
* Fix phone data get removed when used as the shipping address.

= 1.2.4 =
* Update translation template.
* Fix compatibility issue with `woocommerce-extra-checkout-fields-for-brazil` plugin.

= 1.2.3 =
* Fix order total not recalculated when post code changed.
* Use WooCommerce address if no addresses have been created yet.

= 1.2.2 =
* Fix the select address field is not displayed on Elementor editor.
* Fix address options are encoded with HTML entities on WooCommerce 4.2.2.

= 1.2.1 =
* Fix address not saved for new customers who create the account at checkout.

= 1.2.0 =
* Add option to give each addresses a name.

= 1.1.1 =
* Fix missing endpoints after saving permalink settings.

= 1.1.0 =
* Add option to set the maximum number of addresses.
* Add support for Twenty Nineteen theme.
* Fix unselected addresses get deleted after place order on WooCommerce 3.5.0 or newer.

= 1.0.0 =
* Released.
