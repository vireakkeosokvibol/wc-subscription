<?php
/*
  Plugin Name: WC Subscription
  Plugin URI: https://github.com/softlibrary/wc-subscription
  Description: This extend WooCommerce to be able pricing the product in subscription or recurring.
  Version: 0.1
  Requires at least: 5.0
  Requires PHP: 7.3
  Tested up to: 7.4
  Author: softlibrary
  Author URI: https://softlibrary.org
  Text Domain: wp-subscription
  Copyright 2021  softlibrary  (email: contact@softlibrary.org)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// include only file
if (!defined('ABSPATH')) {
  die('Do not open this file directly.');
}

require_once dirname(__FILE__) . '/woocommerce/admin/wc-meta-box-functions.php';

class WC_SUBSCRIPTION
{
  function __construct()
  {

    add_action('woocommerce_variation_options', array($this, 'add_custom_variation_options'), 10, 3);

    add_action('admin_init', array($this, 'child_plugin_require_notice'));
    add_action('product_type_options', array($this, 'add_custom_product_type_options'));
    add_action('woocommerce_product_after_variable_attributes', array($this, 'add_custom_product_variable_attributes_fields'), 2);
  }

  /**
   * Required plugin to make the plugin work properly
   */
  function child_plugin_require_notice(): void
  {
    if (!is_plugin_active('woocommerce/woocommerce.php') && current_user_can('activate_plugins')) {
      add_action('admin_notices', 'notice');
    }

    function notice()
    {
?>
      <div class="error">
        <p>WP Subscription will not work propperly without <a href="?><?php admin_url(); ?>/plugin-install.php?s=woocommerce">Woocommerce</a>.</p>
      </div>
<?php
    }
  }

  function add_custom_product_variable_attributes_fields(): void
  {
    // woocommerce_wp_text_input(array(
    //   'id' => 'wp-subscription-product-variable-attributes-fields',
    //   'label' => 'Subscriptions price ($)',
    //   'description' => 'This is a custom field, you can write here anything you want.',
    //   'desc_tip' => 'true',
    //   'placeholder' => 'Custom text'
    // ));

    woocommerce_wp_subscription_input(array(
      'id' => 'wp-subscription-product-variable-attributes-fields',
      'label' => __('Subscriptions price ($)'),
    ));
  }

  function add_custom_variation_options($loop, $variation_data, $variation): void
  {
    // $is_subscription = yit_get_prop($variation, '_ywsbs_subscription');
    // $checked         = checked($is_subscription, 'yes', false);
    echo '<label><input type="checkbox" class="checkbox" />Subscription</label>'; // phpcs:ignore
  }

  function add_custom_product_type_options($types): array
  {
    $types['ywsbs_subscription'] = array(
      'id'            => '_ywsbs_subscription',
      'class'         => 'checkbox_ywsbs_subscription',
      'wrapper_class' => 'show_if_simple',
      'label'         => esc_html__('Subscription', 'yith-woocommerce-subscription'),
      'description'   => esc_html__('Create a subscription for this product', 'yith-woocommerce-subscription'),
      'default'       => 'no',
    );

    return $types;
  }
}

if (class_exists('WC_SUBSCRIPTION')) {
  $wphostbill = new WC_SUBSCRIPTION();
}
