<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/crystal_is_old.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Crystal-is</title>
<meta  name="Keywords" content="Edmonton, Art, Photographs,  Painting, Sculpture, Graphic, Web, Design,Web Design,Graphic Design including Animation, Digital,  Visual  Arts, Crystal Hansen, Gzenda, Red Deer, Saskatoon,  photographer, artist,painter, graphic designer, Web Programming, Web Development,Web Applications, .Net Programming, VB.Net, C#, C#.Net, Java, PHP, MYSQL, MS SQL,PHP and MySQL, ORACLE, e-commerce,">
<meta name="description" content="Crystal-is offers the best artistic expressions and  visual media provided through photographic painting drawing and designing services in quality and a professional manner. Crystal Hansen has extensive training and knowledge in design elements Web Applications and Programming including e-commerce, shoping carts and information retrieval systems." />
<script type="text/javascript" src="inc/js/prototype.js"></script>
<script type="text/javascript" src="inc/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="inc/js/lightbox.js"></script>
<link href="inc/crystalis.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="inc/lightbox.css" type="text/css" media="screen" />
<style type="text/css">
.txt_body{
	opacity:1;
	background-color:#CC6600;
	margin-bottom:35px;
}
.txt_body object{
/*text-align:center;*/
margin:15px 15px 35px 25px;

}
.txt_body embed{
/*text-align:center;*/
margin:15px 15px 35px 25px;

}
</style>

<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body>
	<div class="outer_content">
		<div class="top_nav">
			<ul>
				<li>[ <a href="index.html">home</a> ]</li>
				<li>[ <a href="About.html">about</a> ]</li>
				<li> [ <a href="Sitemap.php">sitemap</a> ] </li> 
				<li>[ <a href="Contact.php">contact</a> ]</li>
				<li>[ <a href="Shop.php">shop</a> ]</li>
			</ul>
		</div>
		<div class="txt_body">
		<!-- InstanceBeginEditable name="body" -->
	  <div class="txt_body_inside">
	<?
		require_once("crystalclass/conn_function.php");
		require_once("crystalclass/imageClass.php");
		//set variables
		$category_id="";
		$item_id="";
		//get passed vars 
		if (isset($_REQUEST['iid'])){
			$item_id=$_REQUEST['iid'];
		}
		if (isset($_REQUEST['cid'])){
			$category_id = $_REQUEST['cid'];
		}
		
		$m_image_class = new imageClass();
		if ($item_id!="")
		 {  
			/*$results=$m_image_class->get_Category($category_id);
			 if($results){
				  while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
				  {
					  	$category_name=$row['cat_name'];
					echo "<h1>". $category_name."s </h1>";
				  }
			  }*/
			
				$results=$m_image_class->get_ItemDetails($item_id);
			 if($results){

				  while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
				  {
				  	//$web_link=$row['item_web'];
					echo"<h2>Title: " .$row['item_title']."</h2>
					 	<p><b>Purpose:</b> ".$row['item_purpose'] ." - <b>Outcome:</b> ".$row['Outcome']."</p>\n ";
					echo"<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='350' height='270'>
						  <param name=movie value='".$row['item_page']."'>
						  <param name=quality value=high>
						  <embed src='".$row['item_page']."' quality=high pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='350' height=270'>
						  </embed> 
					</object>";
				  
				  }
			  }
		 }/*else if ($item_id !=""){
	
		 	$results=$m_image_class->get_ItemDetails($item_id);
		 }*/
		?>
	
					  </div>
	    	
		<!-- InstanceEndEditable -->
		    </div>
			<br clear="all" />
		<div class="bottom_hor">
			<ul>
	
				<li> [ <a href="items.php?cid=1">photographic</a> ] </li>
				<li>[ <a href="items.php?cid=2">drawing</a> ]</li>
				<li> [ <a href="items.php?cid=5">graphic</a> ]</li>
				<li>[ <a href="items.php?cid=4">worldwideweb</a> ]</li>
				<li>[ <a href="items.php?cid=3">animations</a> ]</li>
			</ul>
		
		</div>
			<div class="copyright">2006 Copyright of Crystal Hansen</div>
	</div>
	<br clear="all" />
</body>
<!-- InstanceEnd --></html>
