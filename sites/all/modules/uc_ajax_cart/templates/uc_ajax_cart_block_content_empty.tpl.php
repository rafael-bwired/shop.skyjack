<?php
/**
 * @file
 *
 * Theme file for an empty cart.
 */
?>
<?php
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

<!--
<div id="cart-block-contents-ajax" class="cart-empty">
  <?php print t('No products in cart');?>
</div>
-->
<p class="cart-block-items collapsed uc-cart-empty" style="display: none;">There are no products in your shopping cart.</p>
<table class="cart-block-summary">
	<tbody>
		<tr>
			<td class="cart-block-summary-items">EMPTY</td>
			<td class="cart-block-summary-total">
				<span class="uc-price cart-small">$</span>
				0
				<span class="cart-upper">00</span>
			</td>
			<?php if($credits_available):?>
			  <?php
				$credit = str_replace('.', '<span class="cart-upper">', $credit).'</span>';
			  ?>
			  <td class="cart-block-user-credits">
				<span class="uc-price cart-small">budget</span><?php print $credit;?>
				</div>
			  </td>
			<?php endif;?>
			<td class="view-cart-txt">VIEW CART</td>
		</tr>
	</tbody>
</table>