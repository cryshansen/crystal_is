<?php 
include('conn_function.php');
//include_apps('users/users.class.php');
//include_apps('courses/courses.class.php');

//include_apps('payment/internetsecure.class.php');
$appname = 'shop';

class shopDisplay {
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
    public function __construct()
    {
		$this->default_cat_id = 1; // please change when necessary ... I'm just following the store.php
		$this->table_items = 'products';
		$this->table_categories = 'categories';
		// Data: Item
		$this->data_items = createDataArray ('id','category_id','title','summary','description','virtual_filename','content_date_available','content_date_expiry','content_date_created','content_date_modified', 'vieweable_by_group');
		// Data: Category
		$this->data_categories = createDataArray ('id','status','parent_id','name','summary','description','sort','virtual_filename','date_available','date_expiry','date_created','date_modified');
    }
//______________________________________________________________________________________//	
	public function Run()
	{
		global $gekko_db;

		switch ($_GET['action'])
		{
			case 'orderhistory':$this->viewOrderHistory();break;
			case 'orderdetails':$this->viewOrderDetails($_GET['id']);break;
			case 'payment':$this->checkOutPayment();break;
			case 'finalizecheckout':$this->finalizeCheckout();break;
			case 'addtocart':$this->addToCart();$this->redirectToCart();break;
			case 'emptycart':$this->emptyCart();$this->redirectToCart();break;
			case 'updatecart':$this->updateCartQty($_POST['id'],1 /* hardcode anthony morris $_POST['qty']*/);$this->redirectToCart();break;
			case 'delcartitem':$this->deleteCartItem($_GET['id'], $_GET['custom']);$this->redirectToCart();break;
			case 'checkout':$this->checkOut();break;
			case 'registercheckout': $this->registerAndCheckout();break;
		
			case 'shoppingcart':	 $this->displayShoppingCart();	break;
			case 'displaycat':$this->displayBlog($_GET['cat_id'],true);break;
			case 'displaypage': $this->displayPage($_GET['product_id']);break;
			default: $this->displayMain();break;
		}
	}
	//______________________________________________________________________________________//
	public function viewOrderHistory()
	{
		global $gekko_auth;
		
		$myuserid = $gekko_auth->get_userid();
		$orders = $this->getOrderByUserID($myuserid);
		include ('orderhistory.template.php');
	}
//______________________________________________________________________________________//
	public function viewOrderDetails($id)
	{
		global $gekko_auth, $gekko_db;
		
		$id = intval ($id);
		$myuserid = $gekko_auth->get_userid();
		$order = $this->getOrderByID($id);
		if ($order['customer_id'] == $myuserid)
		{
			$orders_items  = $this->getOrderItemsByOrderID($id);			
			include ('orderdetails.template.php');
		}
		else
			$this->displayErrorMessage ('Permission Denied');
	}
//______________________________________________________________________________________//
	public function getOrderByID($id)
	{
		global $gekko_db;
		$sql = "select * from orders where order_id = '$id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		if ($result)
			return $result[0];
		else
			return false;
	}
	
//______________________________________________________________________________________//
	public function getOrderByUserID($id)
	{
		global $gekko_db;
		$sql = "select * from orders where customer_id = '$id' ORDER by order_id DESC";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result;
	}
//______________________________________________________________________________________//
	public function getOrderItemsByOrderID($order_id)
	{
		global $gekko_db;
		$sql = "select * from orders_items where order_id = '$order_id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result;
	}
//______________________________________________________________________________________//
	public function getProductLinkByID($product_id)
	{
		
	}
	
	public function checkOutPayment($msg='')
	{
		global $gekko_auth;
		if ($gekko_auth->authenticated() === true)
		{
			
			$total_items = $this->displayShoppingCartContent();
			if ($total_items > 0)		
				include('checkout_payment.template.php');
			else
				$this->displayMessage('Nothing to check out','Your shopping cart is empty');
		} else
		{
			$this->displayLoginRegister(); // 2nd check just in case somebody tries to type in the url manually
		}
	}

//______________________________________________________________________________________//
	
	public function registerAndCheckout()
	{
		$userclass = new usersDisplay(); //calling users.class.php
		$userclass->registerUser(true) ; // set true if called from here
	}
	
	public function calculateSubTotal($shoppingcart_items)
	{
		$totalCost = 0;
		if ($shoppingcart_items)
		{
		   foreach ($shoppingcart_items as $shoppingcart_item)
			{  
							// Real order qty includint BO
							$quantity = $shoppingcart_item["quantity"] + $shoppingcart_item["bo_quantity"];
							// Increment the total cost of all products
							$unit_price = $shoppingcart_item['unit_price'];
							$extended_price = ($quantity * $unit_price);
							$totalCost += ($quantity * $unit_price);
			}
		}
		return $totalCost;
	}
//______________________________________________________________________________________//
	public function finalizeCheckOut()
	{
		global $gekko_auth, $gekko_db, $shop_gst;
		
		
		$datadefinition = createDataArray ('shipping_instructions','special_instructions','cc_cardholder_name','cc_num','cc_mm','cc_yy','cvv2');
		$datavalues = getVarFromPOST($datadefinition); // clean up sanitize string and whatnot
		
		$ccnumber = $datavalues['cc_num'];
		list($type, $valid) = validateCC($ccnumber);
		 if ( !$valid || empty($datavalues['cc_num']) )
		 {
			$this->checkOut(SPAN('Invalid Credit Card Number. Please try again.','','errortxt'));
			return;
		} 

		$cookieid = $this->getCookieId();
		$cartid = $this->getCartId($cookieid);
		$customer_id =  $gekko_auth->get_userid();
		$userclass = new usersDisplay();
		$userinfo = $userclass->getUserInfoByUserId($customer_id);
		$shoppingcart_items = $this->getShoppingCartItemsByCartID($cartid);
		if (!$shoppingcart_items)
		{
			$this->displayMessage('Nothing to check out. Your shopping cart is empty. Please keep shopping.','Empty Shopping Cart');
//			$payment->outputResult();
			
		}
		$sub_total = $this->calculateSubTotal($shoppingcart_items);
		if (strtolower($userinfo['country']) == 'canada') 
			$tax =  $shop_gst * $sub_total;
		else
			$tax = 0.00; // ideally tax calculation is a separate module
		$shipping_cost = 0.00;
			
		$payment = new internetSecurePayment($userinfo, $datavalues['cc_cardholder_name'], $datavalues['cc_num'], $datavalues['cc_mm'],$datavalues['cc_yy'], $datavalues['cvv2'],false,0);
		$payment->buildProductString ($shoppingcart_items);
		$payment_successful = $payment->submitPayment();

		if ($payment_successful)
		{
			// echo 'Success';
			$guid =  $payment->response['GUID'];
			$order_number = $this->convertShoppingCartToOrders($customer_id, $shipping_cost, $tax, $sub_total, 
															   $datavalues['shipping_instructions'], $datavalues['special_instructions'], 
															   $payment->response['ReceiptNumber'], $payment->response['ApprovalCode'], 
															   $payment->response['CVV2ResponseCode'],    $payment->response['GUID'],
															   $payment->response['Verbiage'], $cartid, $cookieid);
			$this->emailUserReceipt($userinfo, $order_number, $payment);
			$this->clearShoppingCartById($cartid);
			$this->displayOrderSuccess($order_number);
			//$payment->outputResult();
			
		} else
		{
			// echo 'Fail';
			$this->displayErrorMessage('Sorry, your transaction has been declined<br />');
			$payment->outputResult(); // optionall ?? that's why it's twice
		}

	}
//______________________________________________________________________________________//
	
	public function displayOrderSuccess($order_number)
	{
		echo H1('Thank You!');
		$link = SEFLink("/index.php?page=shop&action=orderdetails&id={$order_number}");
		echo P("Your order #: <A HREF='{$link}'>{$order_number}</A> has been successfully placed.");
		$this->viewOrderDetails($order_number);
		
	}
//______________________________________________________________________________________//
	
	public function emailUserReceipt($userinfo, $order_id, $payment)
	{
		global $site_name, $site_infomail,$shop_currency_code;	
		$destination = $userinfo['email'];
		$subject = "{$site_name} Receipt Order #{$order_id}";
		$message = "Thank you for purchasing from {$site_name}. Below is the details of your purchase.\n\n";
		$orders_items = $this->getOrderItemsByOrderID($order_id);
		 foreach ($orders_items as $item)
		 {
			 $message.="{$item['quantity']} x {$item['product_name']} @ ".'$'."{$item['unit_price']} {$shop_currency_code}\n";
		 }
		 $order = $this->getOrderByID($order_id);
		 $total = $order['sub_total'] + $order['tax'];
		 $message.="\nSubtotal: ".'$'."{$order['sub_total']}\n";
		 $message.="Tax: ".'$'."{$order['tax']}\n";	
		 $message.="Total: ".'$'."{$total}\n";		 

		$message.="\nIf you have any questions, please don't hesitate to contact us at {$site_infomail}";
		$header = "From: {$site_infomail}";
		
		mail ($destination, $subject, $message, $header);
		/*
		if ($_SERVER['SERVER_NAME'] != $site_template) mail ($destination, $subject, $message, $header);
		else 
		{
			echo nl2br ($message);
		}*/
	}
//______________________________________________________________________________________//
	
	public function convertShoppingCartToOrders($customer_id, $shipping_cost, $tax, $sub_total, $shipping_carrier, $special_instructions , $receiptnumber, $approvalcode, 
												 $cvv2response, $guid,$response_message, $previous_cartid, $previous_cookieid, $recurring='')
	{
		global $gekko_db;
		
		if ($previous_cartid && $previous_cookieid)
		{
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$shipping_carrier = sanitizeString($shipping_carrier);
			$special_instructions = sanitizeString($special_instructions);
			$response_message = sanitizeString($response_message);
			$sql =  "insert into orders (customer_id,shipping_cost,  tax, sub_total, shipping_carrier,special_instructions,reference_number,cvv2_response_code,response_code,guid,response_message, previouscart_id, previouscookie_id, ip_address,recurring) VALUES ('{$customer_id}', '{$shipping_cost}',  '{$tax}',  '{$sub_total}', {$shipping_carrier}, {$special_instructions}, '{$receiptnumber}', '{$cvv2_response_code}',  '{$approvalcode}',  '{$guid}', {$response_message}, '{$previous_cartid}', '{$previous_cookieid}', '{$ip_address}', '{$recurring}')";
			$gekko_db->query($sql);
			$sql =  "SELECT order_id FROM orders WHERE customer_id = '{$customer_id}' AND 
					previouscookie_id = '{$previous_cookieid}' AND previouscart_id = '{$previous_cartid}' AND
					ip_address = '{$ip_address}' AND reference_number = '{$receiptnumber}'"; 
					//echo $sql.'<BR/>';
			$gekko_db->query($sql);
			$result = $gekko_db->get_result_as_array();
			
			$order_id = $result[0]['order_id'];
			if ($order_id > 0)
			{
				$order_id = $result[0]['order_id'];
				// now convert shopping cart items to order items
				$shoppingcart_items = $this->getShoppingCartItemsByCartID($previous_cartid);
				foreach ($shoppingcart_items as $item)
				{
					$this->AddItemToOrder($order_id, $item['product_id'], $item['custom_model'], $item['product_name'], $item['custom_description'], $item['quantity'], $item['bo_quantity'], $item['unit_price']);
					$this->reduceItemFromInventory($item['product_id'], $item['quantity']);
				}
				return $order_id;
				// done
			} else 
			{
				$this->displayErrorMessage('Insert product error during shopping cart conversion: '.$sql);
				return false;
			}
		} else return false;
 	}
//______________________________________________________________________________________//
	
	public function reduceItemFromInventory($product_id, $qty)
	{
		// TODO
	}
//______________________________________________________________________________________//
	
	protected function AddItemToOrder($order_id, $product_id, $custom_model, $product_name, 
			$custom_description, $quantity, $bo_quantity, $unit_price)
	{
		global $gekko_db;
		
		
		$sql =  "INSERT INTO orders_items (order_id, product_id, custom_model, product_name, custom_description, quantity, unit_price) values('{$order_id}', '{$product_id}', '{$custom_model}', '{$product_name}', '{$custom_description}', '{$quantity}', '{$unit_price}')";
		$gekko_db->query($sql);
		
 	}
	
//______________________________________________________________________________________//	
	public function clearShoppingCartById($id)
	{
		global $gekko_db;	
		/*$sql = "DELETE FROM shopping_cart where cart_id = '$id'";
		$gekko_db->query($sql);
		echo $sql;
		*/
		$sql = "DELETE FROM shopping_cart_items where cart_id = '$id'";
		$gekko_db->query($sql);
		
	}
//______________________________________________________________________________________//
	public function displayErrorMessage($error)
	{
		
		echo H1('Error');
		echo P($error);
	}
	
//______________________________________________________________________________________//
	public function displayMessage($title,$error)
	{
		
		echo H1($title);
		echo P($error);
	}
	
	
//______________________________________________________________________________________//
	public function checkOut($msg='')
	{
		global $gekko_auth;
		
		if ($gekko_auth->authenticated() === false)
			$this->displayLoginRegister();
		else
		{
			$this->checkOutPayment($msg);
		}
	}
	
//______________________________________________________________________________________//
	public function redirectToCart()
	{
		redirect_to (SEFLink('/index.php?page=shop&action=shoppingcart'));
	}
	
	public function updateCartQty($pid, $qty)
	{
		global $gekko_db;
		
		$cookieid = $this->getCookieId();
		$cartid = $this->getCartId($cookieid);
		$pid = intval($pid);
		$qty = intval ($qty);
		if ($pid > 0 && $qty > 0 && $cartid > 0) // disable negative number validation check ...
		{
 			$sql = "UPDATE shopping_cart_items SET quantity = '{$qty}' WHERE product_id = '{$pid}' AND cart_id = '{$cartid}'";	
			$gekko_db->query($sql);	
		}
	}
//______________________________________________________________________________________//
	public function deleteCartItem($pid, $custom)
	{
		global $gekko_db;

		$cookieid = $this->getCookieId();
		$cartid = $this->getCartId($cookieid);
		$pid = intval($pid); // SQL injection thingy,  typecast
//		$custom = ''; please help fix. I left out the custom thing

 		$sql = "DELETE FROM shopping_cart_items WHERE product_id = '{$pid}' AND cart_id = '{$cartid}'";		
		$gekko_db->query($sql);
	}

//______________________________________________________________________________________//	

	public function getCategoryPath($parent_id=1){
		global $gekko_db;
		
		$mpath = array();
		
		$query_topcategories_q = sprintf("SELECT categories.cat_id
								FROM categories, categories_asc
								WHERE categories_asc.parent_id = '{$parent_id}' 
								AND categories.cat_id = categories_asc.child_id
								ORDER BY categories_asc.sort_order, categories.cat_id");
		
		$mpath[] = $parent_id;
		
		$gekko_db->query($query_topcategories_q);
		$topcategories_q  = $gekko_db->get_result_as_array();
		$totalRows_topcategories_q = count($topcategories_q);
		
		if($totalRows_topcategories_q > 0) {
			foreach ($topcategories_q as $qqqq)
			{
				$mpath = array_merge($mpath, $this->getCategoryPath($qqqq['cat_id']));
			}
		}
		
		return $mpath;
	}
//______________________________________________________________________________________//	
	public function getPriceString($product_id)
	{
		
	}
//______________________________________________________________________________________//	
	public function getPrice($id)
	{
		global $gekko_db;
		$query_get_price = "SELECT * FROM courses WHERE id = '$id'";
		$gekko_db->query($query_get_price);
		$row_get_prices  = $gekko_db->get_result_as_array();
		$row_get_price = $row_get_prices[0];
		
		//if($row_get_price['no_discount'] == 1){
//			 return  $row_get_price['regular_price'];
//		} else {
			 return $row_get_price['regular_price'];
		//}
	}

//______________________________________________________________________________________//	
	
	public function DisplayBlog($id,$display_summary)
	{
		//global $gekko_db;
//		$id = intval($id);
//		if ($id > 0)
//		{
//
//			$cat_path = implode(', ', $this->getCategoryPath($id));
//			$query_products = "SELECT products.name, products.image, products.thumb, products.model, products.stock, ";
//			$query_products .= "products.regular_price, products.sale_price, products.product_id, products.description, ";
//			$query_products .= "attributes.attribute_id ";
//			$query_products .= "FROM products ";
//			$query_products .= "LEFT JOIN course_categories ON products.product_id = products_categories.product_id ";
//			$query_products .= "LEFT JOIN attributes ON products.product_id = attributes.product_id ";
//			$query_products .= "WHERE products_categories.category_id IN (" . $cat_path . ") ";
//			
///*			if (($_SESSION['level'] != 1) && ($_SESSION['level'] != 6)) {
//				$query_products .= " AND (hide_product != 1 OR hide_product IS NULL) ";
//			}
//		*/
//			$query_products .= "GROUP BY products.product_id ";
//			$query_products .= "ORDER BY products.sort_order, products.product_id, products.name, products.model ";
////			$query_products .= "LIMIT $from, $limit";
//
//			$gekko_db->query($query_products);
//			$products  = $gekko_db->get_result_as_array();
//			$total_results = count($products);
//			
//			$query_category_info = "SELECT cat_id, category, image FROM categories WHERE cat_id = '{$id}'";
//			$gekko_db->query($query_category_info);
//			$categories_info = $gekko_db->get_result_as_array();
//			$category_info = $categories_info[0];
//			include('product_list.template.php');
//				
//		} else echo H1("404 - Not found");
	} 

//______________________________________________________________________________________//
	public function DisplayHeader()
	{	
		global $gekko_db, $site_name;
		
	/*	$catid = 1;//intval($_GET['cat_id']);
		$productid = intval($_GET['id']);
		print_r($_POST);
		if ($catid > 0 || $productid > 0)
		{
		
			if ($_GET['action'] == 'displaycat' || $_GET['action'] == 'displaycategory')
			$sql = "SELECT category as title FROM {$this->table_categories} where cat_id={$catid}";
			else if ($_GET['action'] == 'displaypage' && $_GET['product_id'] > 0)
			$sql = "SELECT name as title FROM {$this->table_items } where id={$productid}";
			$gekko_db->query($sql);
			$items  = $gekko_db->get_result_as_array();
			
			$item = $items[0];		
			$header['title'] = $item['title'].' - '.$site_name; 
			$header['meta_key'] = $item['meta_key']; 
			$header['meta_description'] = $item['meta_description']; 
		} 
		
		if (empty($header['title']))
		{
//			$header['title'] = '404 - Not found';
			$header['title'] = $site_name.' - Store';
		}
		
		?>
		<title><?php echo $header['title']; ?></title>
		<meta name="description" content="<?php echo $header['meta_description']; ?>">
		<meta name="keywords" content="<?php echo $header['meta_key']; ?>">		
		<?php*/
		
	}
//______________________________________________________________________________________//	
	
	public function displayMain()
	{
		include('displaymain.inc.php');
	}
//______________________________________________________________________________________//	
	public function DisplayPage($id)
	{
		global $gekko_db;
		global $gekko_auth;
		
		$id = intval($id);
		if ($id > 0)
		{
			$sql = "SELECT * FROM {$this->table_items} where product_id={$id}";
			$gekko_db->query($sql);
			$resultx  = $gekko_db->get_result_as_array();
			
			if ($resultx)
			{
 				$product = $resultx[0];
				include('product_detail.template.php');
			}  
		}
		if (!$resultx) echo H1("This item is unavailable");
	}
//______________________________________________________________________________________//
	public function displayLoginRegister()
	{
		include('loginregister.template.php');
	}	
//______________________________________________________________________________________//
	public function emptyCart()
	{
		global $gekko_db;

		$cookieid = $this->getCookieId();
		$cartid = $this->getCartId($cookieid);
		
		$sql = "DELETE FROM shopping_cart WHERE cookie_id = '{$cookieid}'";
		$gekko_db->query($sql);
		$sql = "DELETE FROM shopping_cart_items WHERE cart_id = '{$cartid}'";		
		$gekko_db->query($sql);
	}

//______________________________________________________________________________________//
	public function displayShoppingCart()
	{
		//global $gekko_db,$shop_currency_string;
//		print_r ($_GET['id']);
//		$cookieid = $this->getCookieId();
//		print_r($cookieid);
//		$shoppingcarts = $this->getShoppingCartByCookieID($cookieid);
//		//result:
//		$shoppingcart = $shoppingcarts[0];
//		$shoppingcart_items = $this->getShoppingCartItemsByCartID($shoppingcart['cart_id']);
//		include ('shoppingcart.template.php');
	}	
//______________________________________________________________________________________//
	public function displayShoppingCartContent()
	{
		global $gekko_db,$shop_currency_string;
		
		$cookieid = $this->getCookieId();
		$shoppingcarts = $this->getShoppingCartByCookieID($cookieid);
		//result:
		$shoppingcart = $shoppingcarts[0];
		$shoppingcart_items = $this->getShoppingCartItemsByCartID($shoppingcart['cart_id']);
		include ('shoppingcartcontent.template.php');
		return count($shoppingcart_items);
	}	
//______________________________________________________________________________________//
	public function getProductIdByModel($model)
	{
	}
//______________________________________________________________________________________//
	public function getProductRecurringFrequencyById($id)
	{
	}
//______________________________________________________________________________________//
	public function getProductNameById($id)
	{
		
	}
//______________________________________________________________________________________//
	public function getProductStockById($id)
	{
		
	}
	
//______________________________________________________________________________________//
	public function getFirstCategoryNameByProductId($id)
	{
		
	}
//______________________________________________________________________________________//
	public function getShoppingCartByCookieID($cookieid)
	{
		global $gekko_db;
		$sql = "select * from shopping_cart where cookie_id = '$cookieid'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result;
	}
//______________________________________________________________________________________//
	public function getShoppingCartItemsByCartID($cart_id)
	{
		//global $gekko_db;
//		$sql = "select * from shopping_cart_items where cart_id = '$cart_id'";
//		$gekko_db->query($sql);
//		$result  = $gekko_db->get_result_as_array();
//		return $result;
	}
	
//______________________________________________________________________________________//
	public function CreateNewShoppingCartWithCookieId($cookieid)
	{
		global $gekko_db;
		if ($cookieid != '')
		{
			$sql = "INSERT INTO shopping_cart (cookie_id) values ('$cookieid')";
			$gekko_db->query($sql);
			return true;
		} else return false;
		
	}
//______________________________________________________________________________________//
	////////////////////////////////////////
	//	Retrieve shopping cart cookie ID.
	////////////////////////////////////////
	function getCookieId() {
		global $site_session_name, $gekko_db;

 		$cookieid = $_COOKIE[$site_session_name];
		$duplicates  = $this->getShoppingCartByCookieID($cookieid);
		$number_of_duplicates = count($duplicates);
		if ($number_of_duplicates < 1) $this->CreateNewShoppingCartWithCookieId($cookieid);
 		return $cookieid; // prana
	}
//______________________________________________________________________________________//

	////////////////////////////////////////
	//	Retrieve shopping cart cookie ID.
	////////////////////////////////////////
	function getCartId($cookie_id) {
		global $database_dbConn, $dbConn;
		 
		$cart = $this->getShoppingCartByCookieID($cookie_id);
		return $cart[0]['cart_id'];
	}
//______________________________________________________________________________________//

	function remove_all_cookies() {
		$cookiesSet = array_keys($_COOKIE);
		for ($x = 0; $x < count($cookiesSet); $x++) {
		   if (is_array($_COOKIE[$cookiesSet[$x]])) {
			   $cookiesSetA = array_keys($_COOKIE[$cookiesSet[$x]]);
			   for ($c = 0; $c < count($cookiesSetA); $c++) {
				   $aCookie = $cookiesSet[$x].'['.$cookiesSetA[$c].']';
				   setcookie($aCookie,"",time()-1);
			   }
		   }
		   setcookie($cookiesSet[$x],"",time()-1);
		} 
	}
//______________________________________________________________________________________//
	public function getExistingProductInShoppingCart($cookie_id, $product_id)
	{
		global $gekko_db;
/*if (isset($_GET['custom_model']) && ($_GET['custom_model'] != "")) {
			$query_exists = "select * from shopping_cart, shopping_cart_items where shopping_cart.cookie_id = '$cookie_id' and shopping_cart_items.product_id = '$product_id' and custom_model = '". $_GET['custom_model'] ."' and shopping_cart.cart_id = shopping_cart_items.cart_id";
		} else {*/
		$sql = "SELECT * FROM shopping_cart, shopping_cart_items WHERE shopping_cart.cookie_id = '$cookie_id' and shopping_cart_items.product_id = '$product_id' and shopping_cart.cart_id = shopping_cart_items.cart_id";
		
		//}
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		if ($result)
			return $result[0];
 		else
			return false;
	}	
//______________________________________________________________________________________//
	
	public function AddItemToShoppingCart($cart_id, $product_id, $custom_model, $product_name, 
			$custom_description, $quantity, $bo_quantity, $unit_price)
	{
	/*	global $gekko_db;
		$sql =  "insert into shopping_cart_items(cart_id, product_id, custom_model, product_name, custom_description, quantity, bo_quantity, unit_price) values('{$cart_id}', '{$product_id}', '{$custom_model}', '{$product_name}', '{$custom_description}', '{$quantity}', '{$bo_quantity}', '{$unit_price}')";
		
		$gekko_db->query($sql);*/
 	}
//______________________________________________________________________________________//
	
	protected function UpdateItemInShoppingCart($cart_item_id, $product_name, 
			$custom_description, $quantity, $bo_quantity, $unit_price)
	{
		global $gekko_db;
		$sql =  "update shopping_cart_items set quantity='{$quantity}', bo_quantity='{$bo_quantity}', unit_price='{$unit_price}',  product_name='{$product_name}', custom_description='{$custom_description}' where cart_item_id = '{$cart_item_id}'";
		$gekko_db->query($sql);
 	}
	
//______________________________________________________________________________________//
	////////////////////////////////////////////////////
	//	Add an product to the shopping cart.
	////////////////////////////////////////////////////

	public function addToCart() {
 	}
//________________________________________________//	
}

?>
