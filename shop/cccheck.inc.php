<?php 


function validateCC($ccnum){ 

    // Clean up input  
    $ccnum = ereg_replace('[-[:space:]]', '',$ccnum); 


    // What kind of card do we have
    $type = check_type($ccnum);

    // Does the number matchup ?
    $valid = check_number($ccnum);

    return array($type, $valid);

}


// Prefix and Length checks
function check_type( $cardnumber ) { 

   $cardtype = "UNKNOWN";

   $len = strlen($cardnumber);
   if     ( $len == 15 && substr($cardnumber, 0, 1) == '3' )                 { $cardtype = "amex"; }
   elseif ( $len == 16 && substr($cardnumber, 0, 4) == '6011' )              { $cardtype = "discover"; }
   elseif ( $len == 16 && substr($cardnumber, 0, 1) == '5'  )                { $cardtype = "mc"; }
   elseif ( ($len == 16 || $len == 13) && substr($cardnumber, 0, 1) == '4' ) { $cardtype = "visa"; }

   return ( $cardtype );

}


// MOD 10 checks 
function check_number( $cardnumber ) {    

    $dig = toCharArray($cardnumber); 
    $numdig = sizeof ($dig); 
    $j = 0; 
    for ($i=($numdig-2); $i>=0; $i-=2){ 
        $dbl[$j] = $dig[$i] * 2; 
        $j++; 
    }     
    $dblsz = sizeof($dbl); 
    $validate =0; 
    for ($i=0;$i<$dblsz;$i++){ 
        $add = toCharArray($dbl[$i]); 
        for ($j=0;$j<sizeof($add);$j++){ 
            $validate += $add[$j]; 
        } 
    $add = ''; 
    } 
    for ($i=($numdig-1); $i>=0; $i-=2){ 
        $validate += $dig[$i]; 
    } 
    if (substr($validate, -1, 1) == '0') { return 1;  }
    else { return 0; }
} 


// takes a string and returns an array of characters 

function toCharArray($input){ 
    $len = strlen($input); 
    for ($j=0;$j<$len;$j++){ 
        $char[$j] = substr($input, $j, 1);     
    } 
    return ($char); 
} 

?> 
