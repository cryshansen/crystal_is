<table width="100%"  border="0" cellspacing="5" cellpadding="5" class="order_history_table">
  <tr>
    <th>ID</th>
    <th>Date</th>
    <th>Sub Total </th>
    <th>Tax </th>	
    <th>Status</th>
  </tr>
<?php  foreach ($orders as $order): ?>
<?php $link = SEFLink("/index.php?page=shop&action=orderdetails&id={$order['order_id']}"); ?>
  <tr>
    <td><?= $order['order_id']; ?></td>
    <td><A href="<?php echo $link; ?>"><?= $order['date']; ?></td>
    <td><?= $order['sub_total']; ?></td>
	   <td><?= $order['tax']; ?></td>
    <td><?= $order['order_status']; ?></td>
  </tr>
<?php endforeach; ?>
  
</table>
