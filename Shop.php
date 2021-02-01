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
<link href="inc/crystalis.css" type="text/css" rel="stylesheet" media="screen" />
<link rel="stylesheet" href="inc/lightbox.css" type="text/css" media="screen" />

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
		if($item_id!=""){
			//execute shoping cart code
			
			
		}else{
			$results=$m_image_class->get_Categories();
			if($results){
			while($row=mysql_fetch_array($results))
			{	
				echo "<h2>".$row['cat_name']."</h2>";
				$category_id=$row['cat_id'];
				$result=$m_image_class->get_ImageonCategory($category_id);
				 if($result){
						$count=0;
					 while($count==0)
					{
						
						$row=mysql_fetch_array($result);
						$count++;
						echo"<p><b>Title:</b> <a href='Shop.php?iid=".$row['item_id']."' title='&lt;a href=&quot;shop.php&iid=".$row['item_id']."&quot; target=&rsquo;_blank&rsquo;&gt;Click Here to see ~ ".$row['item_title']." &lt;/a&gt;' >".$row['item_title']." </a>- <b>Purpose:</b> ".$row['I.item_purpose'] ." - <b>Outcome:</b> ".$row['Outcome']."</p>\n ";
						$item_id=$row['item_id'];
						include ('shopform.template.php');
						
					}
				
				  }
				
				}//end while loop
			 
			 }
			
		
		 }
		?>
	
					  </div>
					  
		<?
			if(($category_id ==2) or ($category_id==3)){
			echo "<div class='footer'></div>";
			}
		?>
	    	
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
