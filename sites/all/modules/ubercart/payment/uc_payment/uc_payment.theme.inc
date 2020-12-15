<?php

/**
 * @file
 * Theme functions for the uc_payment module.
 */

/**
 * Generates markup for payment totals.
 *
 * @ingroup themeable
 */
function theme_uc_payment_totals($variables) {
  $order = $variables['order'];
  $line_items = uc_order_load_line_items_display($order);
  $coupon_total = array();
  
  foreach ($_SESSION['_coupon_total'] as $key => $value) {
    foreach($line_items as $kItem => $vItem){
      if($vItem['type'] == 'coupon' && $vItem['data']['code'] == $key){
          unset($line_items[$kItem]);
          $coupon_total[] = array(
            'title' => 'Coupon '.$key,
            'type' => 'coupon',
            'amount' => $value,
            'sig' => '-',
          );

      }
    }
  }
  
  $line_items = array_merge($coupon_total,$line_items);

  $output = '<table id="uc-order-total-preview">';

  foreach ($line_items as $line) {
    if (!empty($line['title'])) {
      $sig = '';
      if(isset($line['sig'])){
        $sig = $line['sig'];
      }
      $attributes = drupal_attributes(array('class' => array('line-item-' . $line['type'])));
      $output .= '<tr' . $attributes . '><td class="title">' . filter_xss($line['title']) . ':</td>'
        . '<td class="price">'.$sig. theme('uc_price', array('price' => $line['amount'])) . '</td></tr>';
    }
  }

  $output .= '</table>';

  return $output;
}
