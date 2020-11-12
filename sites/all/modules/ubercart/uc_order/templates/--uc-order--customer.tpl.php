<?php

/**
 * @file
 * This file is the default customer invoice template for Ubercart.
 *
 * Available variables:
 * - $products: An array of product objects in the order, with the following
 *   members:
 *   - title: The product title.
 *   - model: The product SKU.
 *   - qty: The quantity ordered.
 *   - total_price: The formatted total price for the quantity ordered.
 *   - individual_price: If quantity is more than 1, the formatted product
 *     price of a single item.
 *   - details: Any extra details about the product, such as attributes.
 * - $line_items: An array of line item arrays attached to the order, each with
 *   the following keys:
 *   - line_item_id: The type of line item (subtotal, shipping, etc.).
 *   - title: The line item display title.
 *   - formatted_amount: The formatted amount of the line item.
 * - $shippable: TRUE if the order is shippable.
 *
 * Tokens: All site, store and order tokens are also available as
 * variables, such as $site_logo, $store_name and $order_first_name.
 *
 * Display options:
 * - $op: 'view', 'print', 'checkout-mail' or 'admin-mail', depending on
 *   which variant of the invoice is being rendered.
 * - $business_header: TRUE if the invoice header should be displayed.
 * - $shipping_method: TRUE if shipping information should be displayed.
 * - $help_text: TRUE if the store help message should be displayed.
 * - $email_text: TRUE if the "do not reply to this email" message should
 *   be displayed.
 * - $store_footer: TRUE if the store URL should be displayed.
 * - $thank_you_message: TRUE if the 'thank you for your order' message
 *   should be displayed.
 *
 * @see template_preprocess_uc_order()
 */
?>
<?php 
	$onadminpage = false;
	if(strpos(current_path(), 'admin/store/orders') !== false and isset($order->uid) and $order->uid != 0) {
		$onadminpage = true;
		$userinfo = user_load($order->uid);
	}
        
        
        if(isset($_SESSION['customer_type_details']['employee_number'])) {
            $order->data['employee_number'] = $_SESSION['customer_type_details']['employee_number'];
            uc_order_save($order);
        }
        
?>

<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9A9A9" style="font-family: verdana, arial, helvetica; font-size: small;">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" style="font-family: verdana, arial, helvetica; font-size: small;">
        <?php if ($business_header): ?>
        <tr valign="top">
          <td>
            <table width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td>
                  <?php print $site_logo; ?>
                </td>
                <td width="98%">
                  <div style="padding-left: 1em;">
                  <span style="font-size: large;"><?php print $store_name; ?></span><br />
                  <?php print $site_slogan; ?>
                  </div>
                </td>
                <td nowrap="nowrap">
                  <?php print $store_address; ?><br /><?php print $store_phone; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <?php endif; ?>

        <tr valign="top">
          <td>

            <?php if ($thank_you_message): ?>
            <p><b><?php print t('Thanks for your order, !order_first_name!', array('!order_first_name' => $order_first_name)); ?></b></p>

            <?php if (isset($order->data['new_user'])): ?>
            <p><b><?php print t('Username:'); ?></b> <?php print $order_new_username; ?><br />
            <?php endif; ?>

            <?php endif; ?>

            <table cellpadding="4" cellspacing="0" border="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td colspan="2" bgcolor="#A9A9A9" style="color: white;">
                  <b><?php print t('Purchasing Information:'); ?></b>
                </td>
              </tr>
			  <tr>
                <td nowrap="nowrap">
                  <b><?php print t('Customer Type:'); ?></b>
                </td>
                <td width="98%">
                  <?php 
				  
						if($onadminpage) {
							$userinfo_roles = array_values($userinfo->roles);
							unset($userinfo_roles[0]);
							echo implode(',',  $userinfo_roles);
							
						} else {
				  
							if(isset($_SESSION['customer_type_details']['customer_type'])) {
								print ($_SESSION['customer_type_details']['customer_type'] == 'new')?'Guest':$_SESSION['customer_type_details']['customer_type']; 
							} else {
								global $user;
								$roles = array_intersect(array('territory manager','manager','RVP','administrator'), $user->roles);
								$roles = array_values($roles);
								if(!empty($roles)) {
									print $roles[0];
								  
								}
								
							}
						}
						
				?>
                </td>
              </tr>
              
              
              
              
              <?php if(isset($order->data['employee_number'])):?>
              <tr>
                  <td nowrap="nowrap">
                  <b><?php print t('Employee Number:'); ?></b>
                </td>
                <td width="98%">
					<?php 
				  
						echo $order->data['employee_number'];
						
					?>
                </td>
              </tr>
              <?php endif;?>
              
              
              
              
              
              
			  <?php if($onadminpage):?>
			  <tr>
                <td nowrap="nowrap">
                  <b><?php print t('Customer Name:'); ?></b>
                </td>
                <td width="98%">
					<?php 
				  
						echo $userinfo->name;
						
					?>
                </td>
              </tr>
			  <?php endif;?>
			  
			  
			  <?php 
				
				global $user; 
				$roles = array_intersect(array('territory manager','manager','RVP','administrator'), $user->roles);
							
				if(!empty($roles) and !$onadminpage) {
					$user_data = user_load($user->uid);
					if(isset($user_data->field_allowance['und']['0']['value'])) {
				
			?>
			  <tr>
                <td nowrap="nowrap">
                  <b><?php print t('Manager Budget Remain:'); ?></b>
                </td>
                <td width="98%">
                  <?php 
						print '$'.$user_data->field_allowance['und']['0']['value'];
						
				?>
                </td>
              </tr>
					<?php 
					 }
					  }?>
			  
              <tr>
                <td nowrap="nowrap">
                  <b><?php print t('E-mail Address:'); ?></b>
                </td>
                <td width="98%">
                  <?php print $order_email; ?>
                </td>
              </tr>
              <tr>
                <td colspan="2">

                  <table width="100%" cellspacing="0" cellpadding="0" style="font-family: verdana, arial, helvetica; font-size: small;">
                    <tr>
                      <td valign="top" width="50%">
                        <b><?php print t('Billing Address:'); ?></b><br />
                        <?php print $order_billing_address; ?><br />
                        <br />
                        <b><?php print t('Billing Phone:'); ?></b><br />
                        <?php print $order_billing_phone; ?><br />
                      </td>
                      <?php if ($shippable): ?>
                      <td valign="top" width="50%">
                        <b><?php print t('Shipping Address:'); ?></b><br />
                        <?php print $order_shipping_address; ?><br />
                        <br />
                        <b><?php print t('Shipping Phone:'); ?></b><br />
                        <?php print $order_shipping_phone; ?><br />
                      </td>
                      <?php endif; ?>
                    </tr>
                  </table>

                </td>
              </tr>
			  
			  <?php
				  $credits_txt = '';
				  $credits = ABS(get_credits_in_line_item($order));
				  if($credits > 0) {
					  $credits_txt = '($'.$credits.' on budget)';
					  
				  }
			  ?>
			  

              <tr>
                <td nowrap="nowrap">
                  <b><?php print t('Order Grand Total:'); ?></b>
                </td>
                <td width="98%">
                  <b><?php echo '$'.($order_total + $credits).$que ; ?></b>
                </td>
              </tr>

              <?php if (isset($resultado_gl_code) && $resultado_gl_code != ""):?>

                <tr>
                  <td>
                    <b>GL Code</b>
                  </td>
                  <td>
                    <?php print $resultado_gl_code; ?>
                  </td>
                </tr>

              <?php endif; ?>


              <tr>
                <td nowrap="nowrap">
                  <b><?php print t('Payment Method:'); ?></b>
                </td>
                <td width="98%">
                  <?php print $order_payment_method; ?>
                </td>
              </tr>

              <tr>
                <td colspan="2" bgcolor="#A9A9A9" style="color: white;">
                  <b><?php print t('Order Summary:'); ?></b>
                </td>
              </tr>

              <?php if ($shippable): ?>
              <tr>
                <td colspan="2" bgcolor="#EEEEEE">
                  <font color="#CC6600"><b><?php print t('Shipping Details:'); ?></b></font>
                </td>
              </tr>
              <?php endif; ?>

              <tr>
                <td colspan="2">

                  <table border="0" cellpadding="1" cellspacing="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('Order #:'); ?></b>
                      </td>
                      <td width="98%">
						<?php preg_match('/\>(.*)<\/a>/', $order_link, $matches);?>
                        <?php print $matches[1]; ?>
                      </td>
                    </tr>

                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('Order Date: '); ?></b>
                      </td>
                      <td width="98%">
                        <?php print $order_created; ?>
                      </td>
                    </tr>

                    <?php if ($shipping_method && $shippable): ?>
                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('Shipping Method:'); ?></b>
                      </td>
                      <td width="98%">
                        <?php print $order_shipping_method; ?>
                      </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                      <td nowrap="nowrap">
                        <?php print t('Products Subtotal:'); ?>&nbsp;
                      </td>
                      <td width="98%">
                        <?php print $order_subtotal; ?>
                      </td>
                    </tr>

                    <?php foreach ($line_items as $item): ?>
                    <?php if ($item['type'] == 'subtotal' || $item['type'] == 'total')  continue; ?>

                    <tr>
                      <td nowrap="nowrap">
                        <?php print $item['title']; ?>:
                      </td>
                      <td>
                        <?php print $item['formatted_amount']; ?>
                      </td>
                    </tr>

                    <?php endforeach; ?>

                    <tr>
                      <td>&nbsp;</td>
                      <td>------</td>
                    </tr>

                    <tr>
                      <td nowrap="nowrap">
                        <b><?php print t('Total for this Order:'); ?>&nbsp;</b>
                      </td>
                      <td>
                        <b><?php print $order_total; ?></b>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="2">
                        <br /><br /><b><?php print t('Products on order:'); ?>&nbsp;</b>

                        <table width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">

                          <?php foreach ($products as $product): ?>
                          <tr>
                            <td valign="top" nowrap="nowrap">
                              <b><?php print $product->qty; ?> x </b>
                            </td>
                            <td width="98%">
                              <b><?php print $product->title; ?> - <?php print $product->total_price; ?></b>
                              <?php print $product->individual_price; ?><br />
                              <?php print t('SKU'); ?>: <?php print $product->model; ?><br />
                              <?php print $product->details; ?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </table>

                      </td>
                    </tr>
                  </table>

                </td>
              </tr>

              <?php if ($help_text || $email_text || $store_footer): ?>
              <tr>
                <td colspan="2">
                  <hr noshade="noshade" size="1" /><br />

                  <?php if (false and $help_text): ?>
                  <p><b><?php print t('Where can I get help with reviewing my order?'); ?></b><br />
                  <?php print t('To learn more about managing your orders on !store_link, please visit our <a href="!store_help_url">help page</a>.', array('!store_link' => $store_link, '!store_help_url' => $store_help_url)); ?>
                  <br /></p>
                  <?php endif; ?>

                  <?php if ($email_text): ?>
                  <p><?php print t('Please note: This e-mail message is an automated notification. Please do not reply to this message.'); ?></p>

                  <p><?php print t('IMPORTANT: Please bring a copy of this invoice for orders to be picked up at the Customer Access Centre.'); ?></p>

                  <p><?php print t('Thanks again for shopping with us.'); ?></p>
                  <?php endif; ?>

                  <?php if ($store_footer): ?>
                  <p><b><?php print $store_link; ?></b><br /><b><?php print $site_slogan; ?></b></p>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endif; ?>

            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php
function get_credits_in_line_item($order) {
	$credits_in_line_item = 0;
	
	$line_item_type = 'sj_credits';
	foreach($order->line_items as $key => $line_item)
	{
		if($line_item['type'] == $line_item_type)
		{
			$credits_in_line_item += $line_item['amount'];
		}
	}
	return $credits_in_line_item;
}
?>