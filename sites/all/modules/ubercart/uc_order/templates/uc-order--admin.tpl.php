<?php

/**
 * @file
 * This file is the default admin notification template for Ubercart.
 */
?>


<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9A9A9" style="font-family: verdana, arial, helvetica; font-size: small;">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" style="font-family: verdana, arial, helvetica; font-size: small;">
				<tr>
					<td bgcolor="#A9A9A9" style="vertical-align:middle;font-size:16px;padding:10px">
						New Order at Skyjackshop
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="4" cellspacing="0" border="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
							<tr>
								<td>
									Order number:
								</td>
								<td>
									<?php print $order_admin_link; ?>
								</td>
							</tr>
							
							<?php if(isset($_SESSION['customer_type_details']['customer_type'])) { ?>
							<tr>
								<td>
									Customer Type:
								</td>
								<td>
									<?php 
										if(isset($_SESSION['customer_type_details']['customer_type'])) {
											print ($_SESSION['customer_type_details']['customer_type'] == 'new')?'Guest':$_SESSION['customer_type_details']['customer_type']; 
										} else {
											global $user;
											$roles = array_intersect(array('territory manager', 'manager', 'RVP','administrator'), $user->roles);
											$roles = array_values($roles);
											if(!empty($roles)) {
												print $roles[0];
											  
											}
											
										}
									?>
								</td>
							</tr>
                                                        
                                                        
                                                        
                                                        <?php if(isset($_SESSION['customer_type_details']['employee_number'])):?>
                                                            <tr>
                                                                <td nowrap="nowrap">
                                                                <b><?php print t('Employee Number:'); ?></b>
                                                              </td>
                                                              <td width="98%">
                                                                                      <?php 

                                                                                              echo $_SESSION['customer_type_details']['employee_number'];

                                                                                      ?>
                                                              </td>
                                                            </tr>
                                                            <?php endif;?>
                                                        
                                                        
                                                        
							
							<tr>
								<td>
									Customer:
								</td>
								<td>
									<?php
										if($_SESSION['customer_type_details']['customer_type'] == 'employee') {
			
											if(isset($_SESSION['customer_type_details']['first_name']) and isset($_SESSION['customer_type_details']['last_name']) and isset($_SESSION['customer_type_details']['employee_number'])) {
												print $_SESSION['customer_type_details']['first_name'] .' '. $_SESSION['customer_type_details']['last_name'] .' - '. $order_email . '<br>';
												print t('Employee Number :'). $_SESSION['customer_type_details']['employee_number'] . '<br>';
											}
											
										} elseif($_SESSION['customer_type_details']['customer_type'] == 'territory_manager') {
											
											global $user;
											$roles = array_intersect(array('territory manager','manager','RVP','administrator'), $user->roles);
											$roles = array_values($roles);
											if(!empty($roles)) {
												print $user->name .' - '. $order_email . '<br>';;
											  
											}
											
											//print $order_first_name . $order_last_name .' - '. $order_email . '<br>';
										} elseif ($_SESSION['customer_type_details']['customer_type'] == 'new') {
										
										}
									
									?>
									
									
									
								</td>
							</tr>
							<?php } else { ?>
							<tr>
								<td>
									Customer Type:
								</td>
								<td>
									<?php 
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
									?>
								</td>
							</tr>
                                                        
                                                        
                                                        
                                                        <?php if(isset($_SESSION['customer_type_details']['employee_number'])):?>
                                                        <tr>
                                                            <td nowrap="nowrap">
                                                            <b><?php print t('Employee Number:'); ?></b>
                                                          </td>
                                                          <td width="98%">
                                                                                  <?php 

                                                                                          echo $_SESSION['customer_type_details']['employee_number'];

                                                                                  ?>
                                                          </td>
                                                        </tr>
                                                        <?php endif;?>
                                                        
							
							<tr>
								<td>
									Customer:
								</td>
								<td>
									<?php 
										global $user;
										$roles = array_intersect(array('territory manager','manager','RVP','administrator'), $user->roles);
										$roles = array_values($roles);
										if(!empty($roles)) {
											print $user->name .' - '. $order_email . '<br>';;
										  
										} else {
											
											print $order_first_name.' '.$order_last_name.' - '.$order_email;
										}
									?>
								</td>
							</tr>
							<?php } ?>
							
							<tr>
								<td>
									Order total: 
								</td>
								<td>
									<?php print $order_total; ?>
								</td>
							</tr>
							
							
							<?php 
								$credits_txt = '';
								$credits = ABS(get_credits_in_line_item($order));
								if($credits > 0) {
									
								?>
								
								<tr>
									<td>
										Manager Budget Used: 
									</td>
									<td>
										<?php print '$'.$credits; ?>
									</td>
								</tr>
								
								<?php
									
								} 
							?>
							

							<?php if (isset($resultado_gl_code) && $resultado_gl_code != ""):?>

								<tr>
									<td>
										GL Code
									</td>
									<td>
										<?php print $resultado_gl_code; ?>
									</td>
								</tr>

							<?php endif; ?>

							
							
							<tr>
								<td>
									Shipping method: 
								</td>
								<td>
									<?php print $order_shipping_method; ?>
								</td>
							</tr>
							<?php if(isset($order_shipping_address)) { ?>
							<tr>
								<td>
									Shipping Address:
								</td>
								<td>
									<?php print $order_shipping_address;?>
								</td>
							</tr>
							<?php } ?>
							
							<?php if(isset($order_shipping_phone)) { ?>
							<tr>
								<td>
									Shipping phone:
								</td>
								<td>
									<?php print $order_shipping_phone;?>
								</td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9A9A9" style="font-family: verdana, arial, helvetica; font-size: small;">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" style="font-family: verdana, arial, helvetica; font-size: small;">
				<tr>
					<td bgcolor="#A9A9A9" style="vertical-align:middle;font-size:16px;padding:10px">
						Products
					</td>
				</tr>
				<tr>
					<td>
						<?php foreach ($products as $product): ?>
						- <?php print $product->qty; ?> x <?php print $product->title; ?> - <?php print $product->total_price; ?><br />
						&nbsp;&nbsp;<?php print t('SKU'); ?>: <?php print $product->model; ?><br />
							<?php if (!empty($product->data['attributes'])): ?>
							<?php foreach ($product->data['attributes'] as $attribute => $option): ?>
							&nbsp;&nbsp;<?php print t('@attribute: @options', array('@attribute' => $attribute, '@options' => implode(', ', (array)$option))); ?><br />
							<?php endforeach; ?>
							<?php endif; ?>
						<br />
						<?php endforeach; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9A9A9" style="font-family: verdana, arial, helvetica; font-size: small;">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" style="font-family: verdana, arial, helvetica; font-size: small;">
				<tr>
					<td bgcolor="#A9A9A9" style="vertical-align:middle;font-size:16px;padding:10px">
						Order comments
					</td>
				</tr>
				<tr>
					<td>
						<?php print $order_comments; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>