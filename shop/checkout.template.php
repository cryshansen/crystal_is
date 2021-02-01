<?php


	if ((isset($HTTP_POST_VARS["DM_status"])) && ($HTTP_POST_VARS["DM_status"] == "proceed")) {
		//Check coupon code
		if((isset($HTTP_POST_VARS["coupon_code"])) && ($HTTP_POST_VARS["coupon_code"] != "")) {
			//Get the list of coupons from the database
			$coupon_code = $HTTP_POST_VARS["coupon_code"];
			mysql_select_db($database_dbConn, $dbConn);
			$query_coupon_entered = "SELECT * FROM coupons WHERE coupon_code = '$coupon_code'";
			$coupon_entered = mysql_query($query_coupon_entered, $dbConn) or die(mysql_error());
			$row_coupon_entered = mysql_fetch_assoc($coupon_entered);
			$totalRows_coupon_entered = mysql_num_rows($coupon_entered);
			if ($totalRows_coupon_entered > 0) { 
				//	A valid coupon code has been entered
				//	Advance.
				//header('Location: '. $base_url .'checkout_step3.php?coupon_code='. $HTTP_POST_VARS["coupon_code"]);
			} else {
				$invalid_coupon = 1;
			}
		} else {
			//header('Location: '. $base_url .'checkout_step3.php?coupon_code='.$HTTP_POST_VARS["coupon_code"]);
		}
	}	
	
	//Get the discount if a coupon has been entered 
	if ((isset($coupon_id)) && ($coupon_id != "")) {
		mysql_select_db($database_dbConn, $dbConn);
		$query_coupon = sprintf("SELECT * FROM coupons WHERE coupon_id = '$coupon_id'");
		$coupon = mysql_query($query_coupon, $dbConn) or die(mysql_error());
		$row_coupon = mysql_fetch_assoc($coupon);
		$totalRows_coupon = mysql_num_rows($coupon);
		
		if ($totalRows_coupon > 0) {
			$coupon_code = $row_coupon['coupon_code'];
			$coupon_discount = $row_coupon['discount'];
		}
	}
	// Customer Data to be Transfered to Payment system
	mysql_select_db($database_dbConn, $dbConn);
	$query_customer = sprintf("SELECT * FROM customers WHERE shopping_cart_id='$shopping_cart_id'");
	$customer = mysql_query($query_customer, $dbConn) or die(mysql_error());
	$row_customer = mysql_fetch_assoc($customer);
	$totalRows_customer = mysql_num_rows($customer);

	if ((isset($_SESSION['enabled'])) && ($_SESSION['enabled'] != "")) {
		$message[] = "You are currently enabled as ". $row_customer['organization_name'] ." - ". $row_customer['firstName'] ." ". $row_customer['lastName'];
	}
	
?>

<?php include('template_header.php'); ?>
<script language="JavaScript" type="text/JavaScript" src="validate_card.js"></script>
	<table width="100%" callpadding="4">
		<tr>
			<td valign="top" align="left">
				<h1>Checkout - Step 2 - Payment</h1>
				<p class="message"><?= displayMessage() ?></p>
				<?php ShowCheckout(); ?>
				<?php //include('currency_selection.php'); ?>
				<?php if (isset($coupon_discount)) {
					//	Get Total with discount
					$order_total = $cart_total + $shipping_cost - ($cart_total * ($coupon_discount/100));
					$tax = $order_total * 0.06; // GST
					$order_total = $order_total + $tax;
				?>
					<p><b>You have entered a valid coupon code.</b></p>
					<table align="center">
						<tr>
							<td align="right">
								<p><b>Sub Total:&nbsp;
							</td>
							<td>
								<p>$<?= number_format($cart_total, 2, ".", ","); ?>
							</td>
						</tr>
						<tr>
							<td align="right">
								<p><b>Discount for coupon <?= $coupon_code ?>:&nbsp;
							</td>
							<td>
								<p><?= $coupon_discount ?>%
							</td>
						</tr>
						<tr>
							<td align="right">
								<p><b>Tax (GST):&nbsp;
							</td>
							<td>
								<p>$<?= number_format($tax, 2, ".", ","); ?>
							</td>
						</tr>
<!--						<tr>
							<td align="right">
								<p><b>Shipping:&nbsp;
							</td>
							<td>
								<p>$<?= number_format($shipping_cost, 2, ".", ","); ?>
							</td>
						</tr>
-->
						<tr>
							<td align="right">
								<p><b>Total Price:&nbsp;
							</td>
							<td>
								<p><b>$<?= number_format($order_total, 2, ".", ","); ?>
							</td>
						</tr>

					</table>
				<?php } else { 
					$order_total = $cart_total + $shipping_cost;
					$tax = $order_total * 0.06; // GST 
					$order_total = $order_total + $tax;
				?>
				<p align="center"><b>Please review your total order price</b></p>
				<script language="JavaScript">
					function update_requisisioner(a) {
						//document.ccform.special_instructions.value = a.value;
						//document.order_on_account.special_instructions.value = a.value;
						//document.pay_by_cheque.special_instructions.value = a.value;
						//document.pay_cash.special_instructions.value = a.value;
						document.pay_by_phone.requisisioner.value = a.value;
					}
					function update_cheque_no(a) {
						//document.ccform.special_instructions.value = a.value;
						//document.order_on_account.special_instructions.value = a.value;
						//document.pay_by_cheque.special_instructions.value = a.value;
						//document.pay_cash.special_instructions.value = a.value;
						document.pay_by_phone.cheque_no.value = a.value;
					}
					function update_special_instructions(a) {
						//document.ccform.special_instructions.value = a.value;
						//document.order_on_account.special_instructions.value = a.value;
						//document.pay_by_cheque.special_instructions.value = a.value;
						//document.pay_cash.special_instructions.value = a.value;
						document.pay_by_phone.special_instructions.value = a.value;
					}
					function update_carrier(a) {
						//document.ccform.special_instructions.value = a.value;
						//document.order_on_account.special_instructions.value = a.value;
						//document.pay_by_cheque.special_instructions.value = a.value;
						//document.pay_cash.special_instructions.value = a.value;
						for (var i=0; i < document.sc.carrier.length; i++) {
							if (document.sc.carrier[i].checked) {
							  	rad_val = document.sc.carrier[i].value;
							}
						}
						document.pay_by_phone.carrier.value = rad_val + " - " + document.sc.shipping_instructions.value;
					}
					
					function update_carrier_custom(a) {
						//document.ccform.special_instructions.value = a.value;
						//document.order_on_account.special_instructions.value = a.value;
						//document.pay_by_cheque.special_instructions.value = a.value;
						//document.pay_cash.special_instructions.value = a.value;
						document.pay_by_phone.carrier.value = rad_val + " - " + a.value;
					}

				</script>

				<h1 style="background-color:#000000; color:#FFFFFF; width:100%; margin: 0px; padding: 0px;" >Shipping Instructions</h1>
				<p align="left" style="margin: 0px; padding: 4px 0px;">Please indicate your preferred method of shipping:</p>
				<form action="checkout_step3.php" method="post" name="ccform">
				<table width="400" cellpadding="0" cellspacing="0">
				  <tr>
				    <td style="font-family:verdana; font-size:10px; color:#990000;"><label> <input type="radio" name="carrier" value="Canada Post" onblur="update_carrier(this);">Canada Post</label></td>
			      	<td style="font-family:verdana; font-size:10px; color:#990000;"><label><input type="radio" name="carrier" value="FedEx" onblur="update_carrier(this);">FedEx</label></td>
					<td style="font-family:verdana; font-size:10px; color:#990000;"><label><input type="radio" name="carrier" value="Other" onblur="update_carrier(this);">Other (please specify)</label></td>
			      </tr>
				  <tr>
				    <td  style="font-family:verdana; font-size:10px; color:#990000;"><label><input type="radio" name="carrier" value="Greyhound" onblur="update_carrier(this);">Greyhound</label></td>
					<td style="font-family:verdana; font-size:10px; color:#990000;"><label> <input type="radio" name="carrier" value="Purolator" onblur="update_carrier(this);">Purolator</label></td>
					<td style="font-family:verdana; font-size:10px; color:#990000;" rowspan="2">&nbsp;&nbsp;&nbsp;<textarea name="shipping_instructions" cols="20" rows="2" onblur="update_carrier_custom(this);"></textarea></td>
			      </tr>
				  <tr>
				    <td style="font-family:verdana; font-size:10px; color:#990000;"><label><input type="radio" name="carrier" value="radio">UPS</label></td>
					<td style="font-family:verdana; font-size:10px; color:#990000;"></td>
			      </tr>
				  </table>
				
				<h1 style="background-color:#000000; color:#FFFFFF; width:100%; margin: 10px 0px; padding: 0px;" >Special Instructions</h1>
				<p align="left" style="margin: 0px; padding: 4px 0px;">If you have any special instructions regarding your order, please enter them below.<br>
					<textarea name="special_instructions" cols="35" rows="4" onblur="update_special_instructions(this);"></textarea>
				

				<?php } ?>
				<p align="center">
				<?php
					// Test Variables
					//$shipping_cost = 0;
					//$order_total = .01;
				?>
				<table align="center" width="95%">
					<tr>
						<td valign="top" align="left">
							 <!--onsubmit="return validateCard(this.cardNumber.value,this.cardType.value,this.cardMonth.value,this.cardYear.value);"-->
								<input type="hidden" name="special_instructions">
								<input type="hidden" name="cmd" value="_ext-enter">
								<input type="hidden" name="redirect_cmd" value="_xclick">
								<input type="hidden" name="business" value="<?= $paypal_account ?>">
								<!-- <input type="hidden" name="business" value="rob@devicemedia.ca"> -->
								<input type="hidden" name="item_name" value="Order # <?php echo GetCartId(); ?>">
								<input type="hidden" name="currency_code" value="<?= $_SESSION['currency'] ?>">
								<input type="hidden" name="item_number" value="<?php echo GetCartId(); ?>">
								<!--- <input type="text" name="carrier"> --->
								<input type="hidden" name="shipping" value="">
								<input type="hidden" name="shipping2" value="">
								<input type="hidden" name="return" value="<?= $base_url ?>complete_order.php">
								<input type="hidden" name="cancel_return" value="<?= $base_url ?>cancel_order.php">
								<input type="hidden" name="image_url" value="<?= $base_url ?>images/logo.gif">
								
								<input type="hidden" name="amount" value="<?= $order_total ?>">
								
								<!-- Extended Customer Vars -->
								<input type="hidden" name="email" value="<?= $row_customer['email'] ?>">
								<input type="hidden" name="first_name" value="<?= $row_customer['firstName'] ?>">
								<input type="hidden" name="last_name" value="<?= $row_customer['lastName'] ?>">
								<input type="hidden" name="address1" value="<?= $row_customer['address'] ?>">
								<input type="hidden" name="address2" value="<?= $row_customer['address2'] ?>">
								<input type="hidden" name="city" value="<?= $row_customer['city'] ?>">
								<input type="hidden" name="state" value="<?= $row_customer['province'] ?>">
								<input type="hidden" name="country" value="<?= $row_customer['country'] ?>">
								<input type="hidden" name="zip" value="<?= $row_customer['postalcode'] ?>">
								<input type="hidden" name="day_phone_a" value="<?= $row_customer['areacode'] ?>">
								<input type="hidden" name="day_phone_b" value="<?= $row_customer['phone'] ?>">
								<input type="hidden" name="order_type" value="Credit">
								<input type="hidden" name="terms" value="Due On Receipt">
								<h1 style="background-color:#000000; color:#FFFFFF; width:100%; margin: 10px 0px; padding: 0px;" >Pay by Credit Card</h1>
								
								<TABLE cellspacing="0" cellpadding="0">
								<tr>
									<td align="right"><p>Cardholder Name:</td>
									<td><p><input type="text" name="cardholder_name"></td>
								</tr>
								<TR>
								<TD align="right" valign="middle" nowrap><P>Credit Card Number:</P></TD>
								<TD valign="bottom" nowrap>
										<P><INPUT type="Text" name="cardNumber" size="17" maxlength="16"></P>
									</TD>
								</TR>
								<TR>
								<TD align="right" valign="middle" nowrap><P>Expiration Date:</P></TD>
								<TD valign="bottom" nowrap>
										<P>
										<SELECT name="cardMonth">
											<OPTION value="01"> 01
											<OPTION value="02"> 02
											<OPTION value="03"> 03
											<OPTION value="04"> 04
											<OPTION value="05"> 05
											<OPTION value="06"> 06
											<OPTION value="07"> 07
											<OPTION value="08"> 08
											<OPTION value="09"> 09
											<OPTION value="10"> 10
											<OPTION value="11"> 11
											<OPTION value="12"> 12
										</SELECT>
										<SELECT name="cardYear">
											<OPTION value="09"> 09
											<OPTION value="10"> 10
											<OPTION value="11"> 11
											<OPTION value="12"> 12
											<OPTION value="13"> 13
											<OPTION value="14"> 14
											<OPTION value="15"> 15
											<OPTION value="16"> 16
											<OPTION value="17"> 17
											<OPTION value="18"> 18
											<OPTION value="19"> 19
											<OPTION value="20"> 20
										</SELECT>
										</P>
									</TD>
								</TR>
								</TABLE>
							</form>
						</td>
					</tr>
					<tr>
							<td valign="top" align="left" width="50%">
								
								<p align="center">
									<input type="submit" value="Complete Order >>">
									<input type="hidden" value="DM_submit">
								</p>
							</form>
						</td>
					</tr>
					<?php //} ?>

				</table>
				
			</td>
		</tr>
	</table>
</td>
