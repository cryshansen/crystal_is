<?php global $shop_gst; ?>
 <div> 
  <table width="450" cellspacing="0" cellpadding="0" border="0" class="shopping_cart_table"> 
     <tr> 
      <td colspan="4" align="right"><p>All Prices are in <?php echo $shop_currency_string; ?> </p></td> 
    </tr> 
     <tr class="header" height="24"> 
      <th width="8%" align="center"> Qty </th> 
      <th width="52%"> Product </th> 
      <th width="15%"> Price Each </th> 
      <th width="15%"> Extended </th> 
    </tr> 
     <?php
   
   foreach ($shoppingcart_items as $shoppingcart_item):
   
					// Real order qty includint BO
					$quantity = $shoppingcart_item["quantity"] + $shoppingcart_item["bo_quantity"];
					// Increment the total cost of all products
					$unit_price = $shoppingcart_item['unit_price'];
					$extended_price = ($quantity * $unit_price);
					$totalCost += ($quantity * $unit_price);
					
					$bgcolor = ($bgcolor == 'bgcolor2') ? 'bgcolor1' : 'bgcolor2';
				?> 
     <tr class="<?= $bgcolor ?>"> 
      <td width="8%" align="center" valign="top"> <p> 
          <?= $quantity ?> 
          x </p></td> 
      <td width="52%" valign="top"> <p> 
          <?php if((isset($shoppingcart_item['product_name'])) && ($shoppingcart_item['product_name'] != $shoppingcart_item["name"])) { ?> 
          <?php echo $shoppingcart_item['product_name']; ?> 
          <!--<br> --> 
          <?php } ?> 
          <?php if(isset($shoppingcart_item['custom_description'])) { ?> 
          <?= $shoppingcart_item["custom_model"] ?> 
          <br> 
          <?= nl2br($shoppingcart_item['custom_description']) ?> 
          <br> 
          <?php } 
		  
		  
		$tax = $shop_gst * $totalCost;
		$grandTotal = $tax + $totalCost;  
		  
		  
		  ?> </td> 
      <td width="15%" valign="top" align="right"> <p>$<?php echo number_format($unit_price, 2, ".", ","); ?> </td> 
      <td width="15%" valign="top" align="right"> <p>$<?php echo number_format($extended_price, 2, ".", ","); ?> </td> 
    </tr> 
     <?php endforeach; ?> 
     <tr> 
      <td width="100%" colspan="4"> <hr size="1" noshade width="100%"> </td> 
    </tr> 
     <tr> 
      <td width="70%" colspan="2"> <br> 
         <p> </td> 
      <td width="30%" colspan="2" align="right">
 <strong>*Tax: $<?php echo number_format($tax, 2, ".", ","); ?> <br>
 </strong><strong>Subtotal: $<?php echo number_format($totalCost, 2, ".", ","); ?> <br>
 </strong><strong>Grand Total: $<?php echo number_format($grandTotal, 2, ".", ","); ?> </strong></td> 
    </tr> 
   </table> 
    <p>* <em><?php echo $shop_gst * 100; ?>% GST applicable for Canadian residents</em>. </p>
</div> 
