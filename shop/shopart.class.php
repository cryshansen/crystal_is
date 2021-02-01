<?php 
include ('shop.class.php');

var $appname = 'shop';

class shopArt extends shopDisplay {
//______________________________________________________________________________________//
	 function getProductNameById($id)
	{
		global $gekko_db;
		$sql = "SELECT * FROM courses WHERE id = '$id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result[0]['name'];
	}

//______________________________________________________________________________________//
	public function getCoursesNameById($id)
	{
		global $gekko_db;
		$sql = "SELECT * FROM courses WHERE id = '$id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result[0]['name'];
	}
	//______________________________________________________________________________________//
	public function getFirstCategoryNameByCategoryId($id)
	{
		global $gekko_db;
		$sql = "SELECT * FROM course WHERE id = '$id'";
		$sql = "SELECT category_id, cat_id, category from course_categories, categories where category_id = cat_id AND course_categories.id = '{$id}' ";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result[0]['category'];
	}

//______________________________________________________________________________________//
	////////////////////////////////////////////////////
	//	Add an product to the shopping cart.
	////////////////////////////////////////////////////

	public function addToCart() {
		global $gekko_db;
		
	
		$id = intval($_POST['id']);  // prevent sql injection - Prana
		
		$qty = intval($_POST['qty']); // prevent sql injection - Prana
//		$custom_description = $_POST['custom_description'];		

		$name = $this->getCoursesNameById($id);
		//$stock = $this->getProductStockById($product_id);
		//$category_name = $this->getFirstCategoryNameByCourseId($id);

		// Check if this product already exists in the users cart table
		$cookie_id = $this->getCookieId();
		$cart_id = $this->getCartId($cookie_id);
 		$unit_price = $this->getPrice($id);
	
		//$existing_Course = $this->getExistingCourseInShoppingCart($cookie_id, $product_id);
		/*$existing_Course = true;
		if($existing_Course) {
		
			$qty = $qty + $existing_Course['quantity'] + 
			$existing_Course['bo_quantity'];
			$cart_item_id = $existing_Course['cart_item_id'];			
			
		}*/
 		//	Check inventory on this order line for availablity
		$qty = 1; // NOTE - THIS IS ONLY FOR ANTHONY MORRIS HARDCODED STUFF  - PRANA .. no time
		//$available_stock = $this->getProductStockById($product_id);
		$bo_quantity=5;
		$available_stock =1;
		if ($available_stock > 0)
		{ 
			//$composite_model = $_GET['custom_model']; skipped
			if (!$existing_Course) // no item in the shopping cart, add new
			{
			$this->AddItemToShoppingCart($cart_id, $id, $custom_model, $name, $custom_description, $qty, $bo_quantity, $unit_price);
			$product_added = 1;
			$message = $qty ." item(s) (". $custom_description .") has been added to your cart (". $cart_id ."). <br />.";
			} 
			else // we have an item in the shopping cart, just update quantity
			{
			$this->UpdateItemInShoppingCart($cart_item_id, $name, $custom_description, $qty, $bo_quantity, $unit_price);
			$product_added = 2;
			$message = $qty ." item(s) (". $custom_description .") has been updated in your cart (". $cart_id .").";			
			}
		} else
		
		{
			$message = 'No item in stock';
		}
		return $message;
		
 	}
//________________________________________________//	

//______________________________________________________________________________________//
	
	public function AddItemToShoppingCart($cart_id, $product_id, $custom_model, $product_name, 
			$custom_description, $quantity, $bo_quantity, $unit_price)
	{
		global $gekko_db;
		$sql =  "insert into shopping_cart_items(cart_id, product_id, custom_model, product_name, custom_description, quantity, bo_quantity, unit_price) values('{$cart_id}', '{$product_id}', '{$custom_model}', '{$product_name}', '{$custom_description}', '{$quantity}', '{$bo_quantity}', '{$unit_price}')";
		
		$gekko_db->query($sql);
 	}
//______________________________________________________________________________________//
	public function getProductLinkByID($product_id)
	{
		global $gekko_db;
		$sql = "select link from courses where id = '$product_id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		if ($result)
			return $result[0]['link'];
		else
			return false;
	}
//______________________________________________________________________________________//	
	public function getPriceString($product_id)
	{
		global $gekko_db;
		$query_get_price = "SELECT * FROM courses WHERE id = '$product_id'";
		$gekko_db->query($query_get_price);
		$row_get_prices  = $gekko_db->get_result_as_array();
		$row_get_price = $row_get_prices[0];
		
		if($row_get_price['no_discount'] == 1){
			 return "$". $row_get_price['regular_price'];
		} else {
			 return "$". $row_get_price['regular_price'];
		}
	}
//_______________
	
	public function DisplayBlog($id,$display_summary)
	{
		global $gekko_db;
		$id = intval($id);
		if ($id > 0)
		{

			$cat_path = implode(', ', $this->getCategoryPath($id));
			$query_courses = "SELECT courses.name, courses.image, courses.thumb, courses.model, courses.stock, ";
			$query_courses .= "courses.regular_price, courses.sale_price, courses.id, courses.description, ";
			$query_courses .= "attributes.attribute_id ";
			$query_courses .= "FROM courses ";
//			$query_courses .= "LEFT JOIN course_categories ON courses.id = courses_categories.id ";
//			$query_courses .= "LEFT JOIN attributes ON courses.id = attributes.id ";
//			$query_courses .= "WHERE courses_categories.category_id IN (" . $cat_path . ") ";
			$query_courses .= "where id =".$id;
			
/*			if (($_SESSION['level'] != 1) && ($_SESSION['level'] != 6)) {
				$query_courses .= " AND (hide_product != 1 OR hide_product IS NULL) ";
			}
		*/
			$query_courses .= "GROUP BY courses.id ";
			$query_courses .= "ORDER BY courses.sort_order, courses.id, courses.name";
//			$query_courses .= "LIMIT $from, $limit";
			$gekko_db->query($query_courses);
			$courses  = $gekko_db->get_result_as_array();
			$total_results = count($courses);
			
			$query_category_info = "SELECT cat_id, category, image FROM categories WHERE cat_id = '{$id}'";
			$gekko_db->query($query_category_info);
			$categories_info = $gekko_db->get_result_as_array();
			$category_info = $categories_info[0];
			include('course_list.template.php');
				
		} else echo H1("404 - Not found");
	} 


//______________________________________________________________________________________//
	public function getProductIdByModel($model)
	{
		global $gekko_db;
		$sql = "SELECT * FROM courses WHERE model = '$model'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result[0]['id'];
	}
//
//______________________________________________________________________________________//
	public function getProductRecurringFrequencyById($id)
	{
		global $gekko_db;
		$sql = "SELECT * FROM courses WHERE id = '$id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result[0]['recurring'];
	}
//______________________________________________________________________________________//
	public function getProductStockById($id)
	{
		global $gekko_db;
		$sql = "SELECT stock, non_inventory FROM courses WHERE id = '$id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		if ($result[0]['non_inventory']) return 1;
			else
		return $result[0]['stock'];
	}
	//______________________________________________________________________________________//
	public function displayShoppingCart()
	{
		global $gekko_db,$shop_currency_string;
		print_r ($_GET['id']);
		$cookieid = $this->getCookieId();
		print_r($cookieid);
		$shoppingcarts = $this->getShoppingCartByCookieID($cookieid);
		//result:
		$shoppingcart = $shoppingcarts[0];
		$shoppingcart_items = $this->getShoppingCartItemsByCartID($shoppingcart['cart_id']);
		include ('shoppingcart.template.php');
	}	
	//______________________________________________________________________________________//
	public function getShoppingCartItemsByCartID($cart_id)
	{
		global $gekko_db;
		$sql = "select * from shopping_cart_items where cart_id = '$cart_id'";
		$gekko_db->query($sql);
		$result  = $gekko_db->get_result_as_array();
		return $result;
	}
	
}
?>