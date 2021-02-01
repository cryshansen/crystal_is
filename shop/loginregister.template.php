<?php

		function getvalue_selectbox ($checkbox,$value)
		{
			if ($checkbox==$value) echo " selected";
		}
		
global $current_user_countryname;
$current_user_countryname = get_countryname_from_ip($_SERVER['REMOTE_ADDR']);
$current_user_countryname = ucwords(strtolower($current_user_countryname));
		
?>
 <form name="loginform" method="post" action="<?php echo SEFLink('/index.php?page=shop&action=checkout'); ?>"  > 
 <input name="login" type="hidden" value="login" >
  <table> 
    <tr> 
      <td>Username:</td> 
      <td> 
        <input id="xlogin_username" type="text" name="username" class="loginboxtxt" value=""></td> 
    <tr> 
      <td>Password:</td> 
      <td> <input id="xlogin_password" type="password" name="password" class="loginboxtxt" value=""> 
&nbsp; </td> <tr>
      <td></td> 
      <td> <input type="submit" name="Submit" value="Submit" id="loginsubmit"></td> </tr>
  </table> 
</form>

<hr/>

Or register
<!-- Registration form -->
 <form method="post" action="<?php echo SEFLink('/index.php?page=shop&action=registercheckout'); ?>" name="registeruser" onSubmit="return validateShoppingCartRegister();"> 

        
          <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
    <!-- -->
		  <fieldset><legend>Login Information</legend>
          <table width="100%"  border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="200" align="right">E-mail address </td>
              <td><strong>
                <input id="email" name="email" type="text" class="input_register_txt" value="<?= $_POST['email']; ?>"/>
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">Username</td>
              <td><strong>
                <input id="xusername" name="username" type="text"  maxlength="15" class="input_register_txt" value="<?= $_POST['username']; ?>"/>
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">Password</td>
              <td><strong>
                <input id="xpassword" name="password" type="password" class="input_register_txt" value="<?= $_POST['password']; ?>"/>
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">Verify Password </td>
              <td><strong>
                <input id="xpassword_verify" name="password2" type="password" class="input_register_txt" value="<?= $_POST['password']; ?>"/>
              </strong></td>
            </tr>
          </table>
		  </fieldset>
           <fieldset><legend>Registration and Billing Information</legend>
          <table width="100%"  border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td width="200" align="right">First Name</td>
              <td><strong>
                <input id="firstname" name="firstname" type="text" class="input_register_txt" value="<?= $_POST['firstname']; ?>">
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">Last Name</td>
              <td><strong>
                <input id="lastname" name="lastname" type="text" class="input_register_txt" value="<?= $_POST['lastname']; ?>"/>
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">Company</td>
              <td><strong>
                <input id="company" name="company" type="text" class="input_register_txt" value="<?= $_POST['company']; ?>">
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">Address</td>
              <td><strong>
                <input id="address" name="address" type="text" maxlength="200" class="input_register_txt" value="<?= $_POST['address']; ?>"/>
              </strong></td>
            </tr>
            <tr>
              <td width="200" align="right">City</td>
              <td><strong>
                <input name="city" type="text" id="city" class="input_register_txt" value="<?= $_POST['city']; ?>"/>
              </strong></td>
            </tr>
            <tr>
              <td align="right">Postal Code</td>
              <td><input name="postal" type="text" id="postal" size="7" maxlength="7" class="input_register_txt" value="<?= $_POST['postal']; ?>"/></td>
            </tr>
            <tr>
              <td width="200" align="right">Province/State</td>
              <td><?php include_apps('users/provinceselection.inc.php'); ?></td>
            </tr>
            <tr>
              <td width="200" align="right">Country</td>
              <td><?php include_apps('users/countryselection.inc.php'); ?></td>
            </tr>
          </table>
       </fieldset>
                 <div align="center" style="margin-left:-20px"> 
            <input type="submit" name="savebutton" id="savebutton" value="Submit"> 
          </div> 
</form> 
<!-- end Registration form -->
