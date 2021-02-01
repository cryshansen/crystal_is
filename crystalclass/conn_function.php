<?php global $results;
 function getConn($sql)
      {
        global $results;
		//this is production site access
        /*$db=DB::connect("mysql://uofa1:centennial2007@localhost/uofa");*/
		
		//This is my local machine access driver=mysql,username=root,passwd = banana23 host = localhost db=test
/*		$db=DB::connect("mysql://esteem:popeye23@localhost/e-steem_net_-_crystal_is");
        $results = $db->query($sql);

        echo "<br/><div id='debug'><div>Debugging Info</div><b>SQL:</b><blockquote>".$sql."</blockquote><b>Affected Rows:</b> [". DB_OK ."]&nbsp;&nbsp;&nbsp;<b>Result: </b>[".$results."]</div>";

         $db->disconnect();*/
       
		 //$dbh = mysql_connect( "localhost", "ncapsule_root", "root" );
		 $dbh = mysql_connect( "localhost", "ncapsule_crystal", "friEyE8" );

		 //$dbh = mysql_connect( "localhost", "esteem", "popeye23" );
		 mysql_select_db( "ncapsule_crystalis" ) or die ( mysql_error() . "\n" );

		 //$dbh = mysql_connect( "localhost", "esteem", "popeye23" );
		 //mysql_select_db( "e-steem_net_-_crystal_is" ) or die ( mysql_error() . "\n" );
		  $result = mysql_query( $sql, $dbh );
		return $result;
		  
      }
?>

		