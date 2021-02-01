<?php $addtocartlink = SEFLink("/index.php?page=shop&action=addtocart"); ?>

<h1> <?php echo $product['model']; ?> - <?php echo $product['name']; ?> </h1>

<table width="480" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td width="180" align="center" valign="top"><?php if ($product['image']): ?>
  <img src="/images/large/<?php echo $product['image']; ?>" border="0">
      <br/><br/>
      <?php endif; ?>
      <form name="add_to_cart" method="post" action="<?php echo $addtocartlink; ?>">
	  <input type="image" src="/images/addtocart.jpg" value="Add to Cart" >
	  <input type="hidden" name="qty" value="1">
	  <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
	  
              <?php /*  Quantity:  <input type="text" name="qty" size="4" value="1">
                &nbsp;&nbsp;
                <input type="submit" value="Add to Cart"> */ ?>
                
      </form></td>
    <td width="310" valign="top"><strong>Price</strong>: <?php echo $product['regular_price']; ?> 
	
	<?php echo $product['description']; ?> <?php echo $product['description2']; ?></td>
  </tr>
</table>
