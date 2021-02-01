<?
require_once("conn_function.php");

class imageClass{
//constructor
	function imageClass()
	{}
	
	function get_ItemsonCategory($cat_id){
		$sql="SELECT DISTINCT I.item_id, I.item_title, I.item_purpose, I.item_notes AS Outcome,CONCAT('images/', I.item_link) as i_image,I.item_web, C.cat_name
			FROM Categories_Items CI, Items I, Categories C
			INNER JOIN Items ON I.item_id = CI.item_id
			INNER JOIN Categories ON C.cat_id = CI.cat_id
			WHERE CI.cat_id =".$cat_id;
		$results = getConn($sql);
		return $results;
	}
	function get_Categories(){
		$sql="Select * from Categories";
		
		$results=getConn($sql);
		return $results;
		
	}
	function get_ImageonCategory($category_id){
		$sql="select I.item_id, I.item_title, I.item_purpose, I.item_notes AS Outcome,CONCAT('images/', I.item_link) as i_image,I.item_web from Categories_Items CI, Items I, Categories C
			  inner join Categories ON C.cat_id = CI.cat_id
			WHERE CI.cat_id =".$category_id;
			$result=getConn($sql);
			return $result;
	
	}
	function get_Category($category_id){
		$sql="Select C.cat_name  from Categories C
			where C.cat_id=".$category_id;
		$results = getConn($sql);
		
		return $results;
	}
	function get_ItemDetails($item_id){
			$sql="SELECT I.item_id, I.item_title, I.item_purpose, I.item_notes AS Outcome,I.item_page 
			FROM  Items I
			WHERE I.item_id =".$item_id;
		$results = getConn($sql);
		return $results;
	}
}

?>