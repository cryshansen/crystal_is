<h1>Product List - <?php echo $category_info['category']; ?></h1>
<?php if ($category_info['image']): ?>
	<img src="category_images/<?php echo $category_info['image']; ?>" border="0" style="border-color:#324550;">
<?php endif; ?>
<?php /*
<p align="center">Now Showing <?= $from + 1 ?> to <?= $from + $limit ?> of <?= $total_results ?><br></p>
*/?>


<?php

foreach ($products as $product): 
	$link = SEFLink("/index.php?page=shop&action=displaypage&product_id={$product['product_id']}");
?>
<h3> <a href="<?php echo $link; ?>" ><?php echo $product['model']; ?> -  <?php echo $product['name']; ?> </a></h3>
<table width="510" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td width="180" valign="top"><?php if ($product['image']): ?>
    <a href="<?php echo $link; ?>" >
    <img src="/images/small/<?php echo $product['image']; ?>" border="0">
	</a>
	<?php endif; ?></td>
    <td valign="top"><strong>Price</strong>: <?php echo $product['regular_price']; ?>
    <?php echo $product['description']; ?>
    <p><?php echo A('View Details',$link); ?></p>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<?php endforeach; ?>
