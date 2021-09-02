<?php

// defined( 'ABSPATH' ) || exit;

function woocommerce_wp_subscription_input($field)
{
  global $thepostid, $post;

  // $thepostid      = empty( $thepostid ) ? $post->ID : $thepostid;
  // $field['value'] = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
  // $field['class'] = isset( $field['class'] ) ? $field['class'] : '';

  // echo '<input type="hidden" class="' . esc_attr( $field['class'] ) . '" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" /> ';
?>
  <p class="form-field form-row form-row-first <?php echo esc_attr($field['id']); ?>_field">
    <label><?php echo $field['label'] ?></label>
    <input type="text" class="<?php esc_attr($field['class']); ?>" />
  </p>
  <p class="form-field form-row form-row-last <?php echo esc_attr($field['id']); ?>_field">
    <label><?php echo $field['label'] ?></label>
    <span class="wrap" style="display: flex;">
      <select>
        <option value="every">Every</option>
      </select>
      <select>
        <option value="daily">Daily</option>
        <option value="monthly">Monthly</option>
        <option value="Annually">Annually</option>
      </select>
    </span>
  </p>
<?php
}
