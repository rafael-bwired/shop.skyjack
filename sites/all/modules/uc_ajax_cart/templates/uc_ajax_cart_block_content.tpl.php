<?php
/**
 * @file
 *
 * Theme file for non empty cart.
 */
?>
<?php


  $total = uc_currency_format($total_sin_formato,'$');



  /*
  echo "<h1>";
  echo($total_sin_formato);
  echo "</h1>";
  echo "<pre>";print_r($raw_content);echo "</pre>"; 
  exit;
  */
  




  $items_text = (strpos($items_text, '<span class="num-items">0</span>') !== FALSE)?t('EMPTY'):$items_text;

  if(strpos($items_text, 'Items') !== FALSE)
  {
	$items_text = str_replace('Items', '<span class="cart-small">Items</span>', $items_text);
  }
  else
  {
	$items_text = str_replace('Item', '<span class="cart-small">Item</span>', $items_text);
  }
  $total_num = str_replace(array('$',','),'',$total);
  $total = str_replace('$', '<span class="uc-price cart-small">$</span>', $total);
  $total = str_replace('.', '<span class="cart-upper">', $total).'</span>';

  $credits_available = false;
  $credit = 0;
  global $user;
  $role_name = array('administrator','manager', 'territory manager', 'RVP'); //only these 4 user rolls can use credits.

  $user_data = user_load($user->uid);

  if(user_is_logged_in() and (in_array($role_name[0], $user->roles) || in_array($role_name[1], $user->roles) || in_array($role_name[2], $user->roles)) and isset($user_data->field_allowance['und']['0']['value']))
  {
	$credits_available = true;
	$credit = db_query('SELECT field_allowance_value AS amount
		FROM field_data_field_allowance WHERE entity_id = :uid', array(':uid' => $user->uid))->fetchField();
  }


  
?>

<input type="hidden" id="total_order_sin_formato" value="<?php echo $total_num; ?>">

<div id="cart-block-contents-ajax">
  <table class="cart-block-items">
    <tbody>
      <?php foreach ( $items as $item ):?>
      <tr class="odd">
        <td class="cart-block-item-qty">
          <?php print $item['qty'] ?>
        </td>
        <td class="cart-block-item-title">
          <?php print $item['title']; print $item['descr']; ?>
        </td>
        <td>
          <?php print $item['total'] ?>
        </td>
		<td class="cart-block-item-desc">
          <?php if(strpos(strtolower($item['title']), 'coupon') === false):?>
          <?php print str_replace('Remove product','<i class="fa fa-times-circle"></i>',$item['remove_link']) ?>
		  <?php endif;?>
        </td>
      </tr>
	  
      <?php endforeach; ?>
	  <tr class="cart-block-summary-links">
	    <td colspan="4">
		  <?php print $cart_links; ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<table class="cart-block-summary">
  <tbody>
    <tr>
      <td class="cart-block-summary-items">
        <?php print $items_text; ?>
      </td>
      <td class="cart-block-summary-total">
        <?php print str_replace(',','',$total);?>
      </td>
	  <?php if($credits_available):?>
	  <td class="cart-block-user-credits <?php print (($credit - $total_num) >= 0)?'c-green':'c-red' ;?>">
        <div class="<?php print (($credit - $total_num) >= 0)?'c-green':'c-red' ;?>">
		<?php
			$c_num = $credit - $total_num;
			$c_num = number_format((float)$c_num, 2, '.', '');
			$c_num = str_replace('.', '<span class="cart-upper">', $c_num).'</span>';
		?>
		<span class="uc-price cart-small">budget</span><?php print $c_num;?>
		</div>
      </td>
	  <?php endif;?>
	  <td class="view-cart-txt">VIEW CART</td>
    </tr>
    
  </tbody>
</table>
