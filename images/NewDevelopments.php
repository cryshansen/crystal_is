<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/NewDevelopments.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<!-- InstanceBeginEditable name="doctitle" -->
<title>David Skrypichayko |  New Developments</title>
<!-- InstanceEndEditable -->
<link href="includes/NewDevelopments.css" rel="stylesheet" type="text/css"/>

<!-- InstanceBeginEditable name="head" -->
<meta name="Keywords" content="ENTER KEYWORDS HERE!!!" />
<meta name="Description" content="ENTER DESCRIPTIONS HERE!!!" />
<!-- InstanceEndEditable -->
</head>

<body>
<div id="LinkNav"><!--gives home and other linking boxes-->
	<div id="LinkNav2">
		<ul>
			<li><a href="index.html">Home</a></li>
		</ul>
	</div>
	<div id="LinkNav3">
		<ul>
			<li><a href="NewDevelopments.php">Hot off the Press</a></li>
		</ul>
	</div>
	
</div>
<div id="title">
	<div class="steppe2"></div>
	<div class="NewDev"></div>
</div>
<div class="BarTop"><!--gives blue faded bar-->

</div>
<div id="main">
  <p>
  <div class="text">
    <!-- InstanceBeginEditable name="main" -->
	<p><em>This communication is intended for information purposes only and does not constitute legal advise. Readers are advised to contact a licensed Member of the Law Society in their jurisdiction for a binding opinon. Mr. Skrypichayko is a Member of the Law Society of Alberta.</em></p>
			<?
require_once("administration/server/tax_decission_processor.php");
$m_tax_decission_processor = new tax_decission_processor();

  //sets all variables to ""
  $currentpage = "";
  $website_id = "";

  
  if (isset($_REQUEST['keyword_text']))
 {
   $keyword_text = trim($_REQUEST['keyword_text']);
   
 }
 else
 {
 $keyword_text="";  
 }

 
 //handles the search button click sets up variables
 if(isset($_REQUEST['bt_search'])||strlen($keyword_text)>2)
 {//$website_id = "1";  
   $url = "NewDevelopments.php?keyword_text=". $keyword_text;
 }
 else if (isset($_REQUEST['pageid']))
 {  
  //$keyword_text = $_REQUEST['keyword_text'];
  $currentpage = $_REQUEST['pageid'];
  }
  
  if (isset($_REQUEST['website_id']))
  {$website_id = "1";}
  else
  {$website_id = 0;} 
  
 //sets the website id from the address bar.
 if ($website_id == 0)
 {   //this is on page load
  $url = "NewDevelopments.php?keyword_text=" . $keyword_text;	
 }
 else
 {   
  $url = "NewDevelopments.php?keyword_text=" . $keyword_text;
 }
  
 //gets the page number from the address bar
 if(isset($_REQUEST['pageid']))
 {
   $currentpage = $_REQUEST['pageid'];
 }


echo "<form method='POST' action='NewDevelopments.php?keyword_text=" . $keyword_text ."'>";
?>
		<table id="websites_table">
			<tr>
				<td>Keyword:</td>
				<td><input name="keyword_text" type="text"></td>
				<td><input type="submit" value="Search" name="bt_search"></td>
			</tr>
		</table>
		</form>
<form action="NewDevelopments.php">
        <SELECT name="type_id">
          <?
		  //PHP5
			/*require_once("administration/server/tax_category_processor.php");
          $m_tax_category_processor = new tax_category_processor();
          $result = $m_tax_category_processor->category_get_list();
		  //if ($result->numRows() == 0){echo "<option value=0 selected>NONE</option>";}//php 5
		   //$num_rows = mysql_num_rows($result);
		 	/*if($num_rows == 0){echo "<option value=0 selected>NONE</option>";}
         	else{*/
		  
		  
		  
		   
		  //PHP4 DeltaWebHosting
		  
          	$dbh = mysql_connect( "localhost", "esteem", "popeye23" );
		   mysql_select_db( "e-steem_net_-_steppe" ) or die ( mysql_error() . "\n" );
   			print "Connection to the database has been established.\n";
			$get_table_data = "Select * from tax_type order by name LIMIT 0, 30";
   		 	$response = mysql_query( $get_table_data, $dbh );

           
		if ($response){ 
		  while ($row = mysql_fetch_array( $response)) //$result->fetchRow(DB_FETCHMODE_ASSOC)) php5
          {
              echo "\n";//newline

              if(isset($_REQUEST['type_id'])&&$row['type_id']==$_REQUEST['type_id'])
              {
                echo "<option selected value='".  $row['type_id'] ."'>" . $row['name'] . "</option><br/>";
              }
              else
              {
              echo "<option value='".  $row['type_id'] ."'>" . $row['name'] . "</option><br/>";
              }
          }
		 }
		 else{ echo "<option value=0 selected>NONE</option>"; print mysql_error () . "\n";}

              ?>
      </SELECT>
            <input type="submit" id="bt_submit" value="View Listing">
    </form>
	
	<p><a href="NewDevelopments.php?keyword_text=%%%">Browse all Tax Decissions</a></p>
              
<?

                   if(isset($_REQUEST['type_id']))
                   {
                       $url = "NewDevelopments.php?type_id=". $_REQUEST['type_id'];
					   $taxtype = $_REQUEST['type_id'];
 
                       if(isset($_REQUEST['pageid']))
                       {
                           $currentpage = $_REQUEST['pageid'];
                       }
                       else
                       {
                           $currentpage ="";
                       }
								   
						$dbh = mysql_connect( "localhost", "esteem", "popeye23" );
					   mysql_select_db( "e-steem_net_-_steppe" ) or die ( mysql_error() . "\n" );
						print "Connection to the database has been established.\n";
					   $get_table_data="Select legal_decissions.id, title, decission from legal_decissions inner join legal_decission_on_taxtype on legal_decissions.id = legal_decission_on_taxtype.decission_id where legal_decission_on_taxtype.type_id = ".$taxtype;
                      $result = mysql_query( $get_table_data, $dbh );
					  echo "<ul style=\"list-style-type:none\">";
					  if($result){
						  while ($row = mysql_fetch_array($result) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
						  {
								echo "\n";
								echo "<li><a href=\"NewDevelopmentsDisplay.php?decission_id=" . $row['id'] . "\">" . $row['title'] . "</a></li>";
								echo "<li>" . $row['decission']. "</li>";
								echo "<br><br>";
						  }
					  }
					   else{ print mysql_error () . "\n";}
					  echo "</ul>";
                   }//end if document clicked             
?>
<?
//to 'normalize the code
 if (!($keyword_text == ""))
 {
 
 //echo $url;
						$dbh = mysql_connect( "localhost", "esteem", "popeye23" );
					   mysql_select_db( "e-steem_net_-_steppe" ) or die ( mysql_error() . "\n" );
						print "Connection to the database has been established.\n";
					   $get_table_data="Select id,title,decission, MATCH (title,decission,adv_tax_rule,interpretation,discussion) AGAINST('%" . $keyword_text . "%') as score from legal_decissions where (MATCH(title,decission,adv_tax_rule,interpretation,discussion) AGAINST('" . $keyword_text . "')"." or title like ('%" . $keyword_text . "%')" ." or adv_tax_rule like ('%".$keyword_text."%')"." or interpretation like ('%" .$keyword_text."%')"." or discussion like ('%".$keyword_text."%') )order by title";
  					   $result = mysql_query( $get_table_data, $dbh );
 						}

  echo "</td></tr>";
  echo "</table>";
  echo "<ul style=\"list-style-type:none\">";
  //loop to display all records
  if ((!($keyword_text == "")))
  {

  
   echo "<li>";
   $result = mysql_query( $get_table_data, $dbh );
					  echo "<ul style=\"list-style-type:none\">";
					  if($result){
						  while ($row = mysql_fetch_array($result) )   // $result->fetchRow(DB_FETCHMODE_ASSOC))php5
						  {
								echo "\n";
								echo "<li><a href=\"NewDevelopmentsDisplay.php?decission_id=" . $row['id'] . "\">" . $row['title'] . "</a></li>";
								echo "<li>" . $row['decission']. "</li>";
								echo "<br><br>";
						  }
					  }
					   else{ print mysql_error () . "\n";}
					  echo "</ul>";
                   }//end if document clicked      
   /*while ($row = mysql_fetch_array($result) )//$result->fetchRow(DB_FETCHMODE_ASSOC)) php 5
   {
     echo "<li>";
     echo "<a href=\"NewDevelopmentsDisplay.php?type_id=". $row["id"] ."\">" . $row['title'] ."</a></li>";
	 echo "<li>" . $row['decission']. "</li>";
	 echo "<br>";
   }*/
    echo "</li>";

 ?>
		<!-- InstanceEndEditable -->

		

  </div>
</div>
</body>
<!-- InstanceEnd --></html>
