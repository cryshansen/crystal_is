<?
//require_once("conn_function.php");

class userClass{

	//public $username,$password,$age,$visit;
//constructor
//	public function __construct( $m_username,$m_password,$m_age,$m_visit)
//	  {
//		$this->username = $m_username;
//		$this->password = $m_password;
//		$this->age = $m_age;
//		$this->visit=$m_visit;
//	  }
//
	function userClass()
	{}
	
	
	
	/***************************			Database Design 		********************/
	
	// User Create
	function create_User($username,$password){
		$sql="INSERT INTO `userTable` ( `username` , `password` )
			VALUES ('".$username."', '".$password."');";
		$result = getconn($sql);
		return $result;
	}
	// User Login Check
	function userlogin_read($username)
	{
		$sql = "SELECT username, password  FROM userTable WHERE username = '".$username."'";
		$result = getconn($sql);
		return $result;
	}
	
	//function CreateUserTable{
//		$sql="CREATE TABLE `userTable` (
//			`username` VARCHAR( 50 ) NOT NULL ,
//			`password` VARCHAR( 250 ) NOT NULL ,
//			PRIMARY KEY ( `username` )
//			);";
//		$result = getconn($sql);
//		return $result;
//	}
	function updateUser($var,$varname,$name)
	{
		$sql="UPDATE `userTable` SET `".$varname."` = '".$var."'
			  WHERE `username` = '".$name."' LIMIT 1;";
		$result = getconn($sql);
		return $result;
	}
	
}

?>