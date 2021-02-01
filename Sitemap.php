<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/crystal_is_old.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Crystal-is</title>
<meta  name="Keywords" content="Edmonton, Art, Photographs,  Painting, Sculpture, Graphic, Web, Design,Web Design,Graphic Design including Animation, Digital,  Visual  Arts, Crystal Hansen, Gzenda, Red Deer, Saskatoon,  photographer, artist,painter, graphic designer, Web Programming, Web Development,Web Applications, .Net Programming, VB.Net, C#, C#.Net, Java, PHP, MYSQL, MS SQL,PHP and MySQL, ORACLE, e-commerce,">
<meta name="description" content="Crystal-is offers the best artistic expressions and  visual media provided through photographic painting drawing and designing services in quality and a professional manner. Crystal Hansen has extensive training and knowledge in design elements Web Applications and Programming including e-commerce, shoping carts and information retrieval systems." />
<link href="inc/crystalis.css" type="text/css" rel="stylesheet" />
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
		  <?
		  		require_once("crystalclass/conn_function.php");
				require_once("crystalclass/imageClass.php");
		  		$m_image_class = new imageClass();
		  ?>
		  <div class="txt_body_inside">
		  <h1>Sitemap</h1>
			<ul>
				
				<li><a href="About.html">About</a></li>
				<li><a href="Sitemap.html">Sitemap</a></li> 
				<li><a href="Contact.php">Contact</a></li>
				<li><a href="index.html">Home</a>
					<ul>
						<li><a href="items.php?cid=1">Photographic</a> ~ digital pix, photoshop manipulations 
							<ul>
							<?
								
								$results=$m_image_class->get_ItemsonCategory(1);
								if($results){
									while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
									{
										echo"<li>".$row['item_title']."</li>";	
									}	
								}
							?>
							</ul>
						</li>
						<li><a href="items.php?cid=2">Drawing</a> ~ hand drawn images or illustrations 
							<ul>
							<?
								
								$results=$m_image_class->get_ItemsonCategory(2);
								if($results){
									while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
									{
										echo"<li>".$row['item_title']."</li>";	
									}	
								}
							?>
							</ul>
						</li>
						<li><a href="items.php?cid=5">Graphic</a> ~ graphic layouts and designs 
							<ul>
							<?
								
								$results=$m_image_class->get_ItemsonCategory(5);
								if($results){
									while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
									{
										echo"<li>".$row['item_title']."</li>";	
									}	
								}
							?>
							</ul>
						</li>
						<li><a href="items.php?cid=4">WorldWideWeb</a> ~ web layouts and designs 
							<ul>
							<?
								
								$results=$m_image_class->get_ItemsonCategory(4);
								if($results){
									while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
									{
										echo"<li>".$row['item_title']."</li>";	
									}	
								}
							?>
							</ul>
						</li>
						<li><a href="items.php?cid=3">Animations</a> ~ animated images and interactions 
							<ul>
							<?
								
								$results=$m_image_class->get_ItemsonCategory(3);
								if($results){
									while ($row = mysql_fetch_array($results) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
									{
										echo"<li>".$row['item_title']."</li>";	
									}	
								}
							?>
							</ul>
						</li>
					</ul>	
				</li>
				<br />
				<li><strong>Resources</strong> ~
				  	<a href="http://www.lokeshdhakar.com/projects/lightbox2/" target="_blank"> Lightbox 2 |</a>
					<a href="http://www.csszengarden.com/" target="_blank">Zen Garden |</a>
					<a href="http://www.alistapart.com/" target="_blank"> A-List Apart |</a>
					<a href="http://html-color-codes.info/" target="_blank"> HTML Colors </a></li>
				<li><strong>Links</strong> ~ 
					<a href="http://www.artssheets.com" target="_blank"> artssheets |</a>	
				  	<a href="http://members.shaw.ca/crystal-is/" target="_blank"> Crystal-is old |</a>
				  	<a href="http://members.shaw.ca/Snap123/" target="_blank"> Snap123 | </a>
				  	<a href="http://members.shaw.ca/RedPheonix/" target="_blank"> Red Pheonix |</a><br />
					<a href="http://www.e-steem.net/Steppe/" target="_blank"> &nbsp; &nbsp; &nbsp;Steppe |</a>
					<a href="http://www.e-steem.net/cSharpAX/" target="_blank"> cSharpAX |</a>
					<a href="http://www.albertasource.ca" target="_blank">albertasource.ca</a>
				</li>
				
				<li><strong>Memberships</strong> ~ 
					<a href="http://www.artssheets.com" target="_blank"> cips |</a>	
				  	<a href="http://members.shaw.ca/crystal-is/" target="_blank"> capic |</a>
				</li>
			</ul>
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
