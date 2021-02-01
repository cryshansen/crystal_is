<h1>Order Details for Order #<?= $order['order_id']; ?> </h1>
<table width="80%" border="0" cellpadding="5" cellspacing="5">
  <tr>
    <td width="150"><strong>Date</strong></td>
    <td><?php echo $order['date']; ?></td>
  </tr>
  <tr>
    <td width="150"><strong>Order Status</strong></td>
    <td><?php echo $order['order_status']; ?></td>
  </tr>
  <tr>
    <td width="150"><strong>Response Code</strong></td>
    <td><?php echo $order['response_code']; ?></td>
  </tr>
  <tr>
    <td width="150"><strong>GUID</strong></td>
    <td><?php echo $order['guid']; ?></td>
  </tr>
  <tr>
    <td width="150"><strong>Response Message</strong></td>
    <td><?php echo $order['response_message']; ?></td>
  </tr>
  <tr>
    <td width="150"><strong>Reference Number</strong></td>
    <td><?php echo $order['reference_number']; ?></td>
  </tr>
  <?php if ($order['special_instructions']): ?>
  <tr>
    <td width="150"><strong>Special Instruction</strong></td>
    <td><?php echo $order['special_instructions']; ?></td>
  </tr>
  <?php endif; ?>
  <?php if ($order['recurring']): ?>
  <tr>
    <td width="150"><strong>Recurring Tracking #</strong></td>
    <td><?php echo $order['recurring']; ?></td>
  </tr>
 <?php endif; ?> 
</table>

<p>If you have items to download from your order, please right click on the Product Name below and click
  &quot;Save As&quot;. Download links will be available in your Order History whenever you login.</p>
<table width="430" border="0" cellspacing="0" cellpadding="0" class="order_details_table">
  <tr>
    <th width="50">Quantity</th>
    <th width="200">Product Name</th>
    <th width="90">Unit Price</th>
    <th width="90" nowrap>Total</th>
  </tr>
 <?php foreach ($orders_items as $item): ?> 
  <tr>
    <td width="50"><?php echo $item['quantity']; ?></td>
    <td width="200"><?php
	$link = $this->getProductLinkByID($item['product_id']);
	if ($link) echo A($item['product_name'], $link); else
	echo $item['product_name']; 
	
	?></td>
    <td width="90" align="right"><?php echo $item['unit_price']; ?></td>
    <td align="right" nowrap>$<?php echo $item['unit_price'] * $item['quantity']; ?></td>
  </tr>
    <?php endforeach; ?>
</table>
<br />
<table width="430" border="0" cellpadding="0" cellspacing="0" class="order_total_table" >
  <tr>
    <td width="50">&nbsp;</td>
    <td width="200">&nbsp;</td>
    <td width="90"><strong>Subtotal</strong></td>
    <td align="right" nowrap>$<?php echo number_format($order['sub_total'], 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td width="50">&nbsp;</td>
    <td width="200">&nbsp;</td>
    <td width="90"><strong>Tax</strong></td>
    <td align="right" nowrap>$<?php echo number_format($order['tax'], 2, ".", ","); ?></td>
  </tr>
  <tr>
    <td width="50">&nbsp;</td>
    <td width="200">&nbsp;</td>
    <td width="90"><strong>Grand Total </strong></td>
    <td align="right" nowrap>$<?php echo number_format($order['tax'] + $order['sub_total'], 2, ".", ","); ?> </td>
  </tr>
</table>
<p>* All prices are in <?php global $shop_currency_string; echo $shop_currency_string; ?> </p>
