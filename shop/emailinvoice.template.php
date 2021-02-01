<?php
	global $shop_currency_code;
	
		$destination = $email;
		$subject = "{$site_name} Receipt Order #{$order_id}";
		$message = "Thank you for purchasing from {$site_name}. Below is the details of your purchase.\n";
		$order_items = $this->getOrderItemsByOrderID($order_id);
		 foreach ($orders_items as $item)
		 {
			 $message.="\n{$item['quantity'] x $item['product_name'] @ $item['unit_price']} {$shop_currency_code}\n";
		 }
		 

		$message.="\nIf you have any questions, please don't hesitate to contact us at {$site_infomail}";
		$header = "From: {$site_infomail}";
		if ($_SERVER['SERVER_NAME'] != $site_template) mail ($destination, $subject, $message, $header);
		else 
		{
			echo nl2br ($message);
		}

?>