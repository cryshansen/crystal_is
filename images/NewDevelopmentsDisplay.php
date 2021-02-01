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
	<p>The recent case of Mr Gifford affects everyone who has a clientele for sale(example only).</p>
	<?

          if(isset($_REQUEST['decission_id']))
          {

          $id=$_REQUEST['decission_id'];
		  //PHP 5
          //require_once("administration/tax_decission_processor.php");
//		  $m_tax_decission_processor = new tax_decission_processor();
//          this function should display the selected listing
//          $result = $m_tax_decission_processor->get_tax_decission($id);
//          $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
   
			$dbh = mysql_connect( "localhost", "esteem", "popeye23" );
		   mysql_select_db( "e-steem_net_-_steppe" ) or die ( mysql_error() . "\n" );
			print "Connection to the database has been established.\n";
		   $get_table_data="Select id, title,decission,ccra_policy,adv_tax_rule,rev_can_letter,interpretation,discussion,steppe_name,disclosure from legal_decissions where id=".$id;
		  $result = mysql_query( $get_table_data, $dbh );
		if($result){
			$row = mysql_fetch_array($result);
          echo "<p CTitle><strong>" . $row['title'] . "</strong></p>";
		  $decission=nl2br($row['decission']);
		  echo "<p>".$decission."</p>";
		  echo "<p><a href='".$row['ccra_policy']. "'>CCRA POLICY</a></p>";
		  echo "<p>".$row['adv_tax_rule']."</p>";
		  echo "<p><a href='".$row['rev_can_letter']. "'>Revenue Canada Letter</a></p>";
		  echo "<p>".$row['interpretation']."</p>";
		  echo "<p>".$row['discussion']."</p>";
		  echo "<p>".$row['steppe_name']."</p>";
		  echo "\n";
		  echo "<p><em>" .$row['disclosure']."</em></p>";
			}
			else{print mysql_error () . "\n";}
         
		 }
?>
	
		<!-- InstanceEndEditable -->

		

  </div>
</div>
</body>
<!-- InstanceEnd --></html>
