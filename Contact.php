<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/crystal_is_old.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Crystal-is</title>
<meta  name="Keywords" content="">
<script type="text/javascript" src="inc/scripts.js"></script>
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
		  <div class="txt_body_inside">	
          <h1>Contact Crystal-is</h1>
			<?
				
				function checkmail($email)
				{
					if(eregi("to:",$email) || eregi("cc:",$email) || eregi("bcc:",$email))
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				if(isset($_REQUEST['submit_contact']))
				{
					$author_email = Trim(stripslashes($_POST['author_email']));
					$check = checkmail($author_email);
					$limitedtextarea = Trim(stripslashes($_POST['limitedtextarea']));
					$found_url = strpos($limitedtextarea, "http:");
					if($check == true)
					{
						echo "<strong>Sorry, Invalid Email!</strong>";
					}
					else
					{
						if ($found_url === false)
						{
							//create variables to capture from html form
							$first_name = Trim(stripslashes($_POST['first_name']));
							$last_name = Trim(stripslashes($_POST['last_name']));
							$middle_name = Trim(stripslashes($_POST['middle_name']));
							$prov = Trim(stripslashes($_POST['ProvinceState']));
							$author_phone = Trim(stripslashes($_POST['author_phone']));
							$author_email = Trim(stripslashes($_POST['author_email']));
							$address1 = Trim(stripslashes($_POST['address1']));
							$address2 = Trim(stripslashes($_POST['address2']));
							$city = Trim(stripslashes($_POST['city']));
							$country = Trim(stripslashes($_POST['country']));
							$limitedtextarea = Trim(stripslashes($_POST['limitedtextarea']));
							//page vars
							$email_to ="crystal-is@shaw.ca";
	
							$subject = "Contact Crystal-is";
							//prepare body of email
							$body = "Contact Info: ".$author_phone." ".$author_email."\n";
							$body .= "Name: ".$first_name." ".$middle_name." ". $last_name."\n";
							$body .= "Content: ".$limitedtextarea."\n";
							//send email
							if (mail($email_to,$subject, $body,"From:<$author_email>" )) 
							{
								echo "<strong>Thank you for your submission. Your Email has been sent</strong>\n";
								echo "<div class='footer'></div>";
							} 
							else 
							{
								echo "<strong>Sorry, an internal error occured. Your Email was not sent. <br />Please try again.</strong>\n";
							}
						}
						else
						{
							echo "<strong>Sorry, Invalid Email Content!</strong>";
						}
					}//end of else
				}//end of if
				else
				{//display submit form
					echo "	<p><strong><font color=\"red\">Please Note:</font></strong> all form fields are required.</p>\n";
					echo "<form name='form' id='contact' action='Contact.php' method='post' onsubmit='return validate();'>\n";	
					echo "	<fieldset style='width:290px;'>\n";
					echo "		<legend><strong>Personal Information</strong></legend>\n";
					echo "		<table id='biography' width='240' border='0'>\n";
					echo "			<tr valign='top'>\n";
					echo'				<select type="text" size="1" Value="Mr/Ms" name="Title">
											<option selected>Mr.</option>
											<option>Mrs.</option>
											<option>Ms.</option>
											<option>Dr.</option>
										</select>';
			
					echo "				<td>First Name<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo "					<input name='first_name' type='text' size='20' />\n";
					echo "				</td>\n";
					echo "				<td>Last Name<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo "					<input name='last_name' type='text' size='20' />\n";
					echo "				</td>\n";
					echo "				<td>Middle &nbsp;&nbsp;<br />\n";
					echo "					<input name='middle_name' type='text' size='3' />\n";
					echo "				</td>\n";
					echo "			</tr>\n";
					echo "			<tr valign='top'>\n";
					echo "				<td>Address<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo '						<input type="text" size="20" value="Address 1" name="address1" maxlength="45">';
					echo "				</td>\n";
					echo "				<td>&nbsp;&nbsp;<br />\n";
					echo '					<input type="text" size="20" value="Address more" name="address2"  maxlength="45">';
					echo "				</td>\n";
					echo "			</tr>\n";
					echo "			<tr valign='top'>\n";
					echo "				<td>City<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo '						<input type="text" size="20" value="City" name="city"  maxlength="45">';
					echo "				</td>\n";	
					echo "				<td>Province<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo '					<select type="text" size="1" value="Province/State" name="ProvinceState" >';
					echo '						  <option selected>Alberta </option>';
					echo '						  <option>British Columbia</option>';
					echo '						  <option>Manitoba</option>';
					echo '						  <option>New Brunswick</option>';
					echo '						  <option>Newfoundland</option>';
					echo '						  <option>Northwest Territories </option>';
					echo '						  <option>Nova Scotia</option>';
					echo '						  <option>Nunavut</option>';
					echo '						  <option>Ontario</option>';
					echo '						  <option>Prince Edward Island </option>';
					echo '						  <option>Quebec</option>';
					echo '						  <option>Saskatchewan</option>';
					echo '						  <option>Yukon </option>';
					echo '						  <option>----------------------</option>';
					echo '						  <option>Alabama</option>';
					echo '						  <option>Alaska</option>';
					echo '						  <option>Arizon</option>';
					echo '					  	<option>aArkansas</option>';
					echo '				  		<option>California </option>';
					echo '				  		<option>Colorado</option>';
					echo '				  		<option>Conneticut</option>';
					echo '				  		<option>Delaware</option>';
					echo '						  <option>Florida</option>';
					echo '						  <option>Georgia </option>';
					echo '						  <option>Hawaii</option>';
					echo '						  <option>Idaho</option>';
					echo '						  <option>Illinois</option>';
					echo '						  <option>Iowa</option>';
					echo '						  <option>Kansas </option>';
					echo '						  <option>Kentucky</option>';
					echo '						  <option>Louisiana</option>';
					echo '						  <option>Maine</option>';
					echo '						  <option>Maryland</option>';
					echo '						  <option>Massachusetts </option>';
					echo '						  <option>Michigan</option>';
					echo '						  <option>Minnesota</option>';
					echo '						  <option>Mississippi</option>';
					echo '						  <option>Missouri</option>';
					echo '						  <option>Montana</option>';
					echo '						  <option>Nebraska </option>';
					echo '						  <option>Nevada</option>';
					echo '						  <option>New Hampshire</option>';
					echo '						  <option>New Jersey</option>';
					echo '						  <option>New Mexico </option>';
					echo '						  <option>New York</option>';
					echo '						  <option>North Caroline</option>';
					echo '						  <option>North Dakota</option>';
					echo '						  <option>Ohio</option>';
					echo '						  <option>Oklahoma</option>';
					echo '						  <option>Oregon </option>';
					echo '						  <option>Pennsylvania</option>';
					echo '						  <option>Rhode Island</option>';
					echo '						  <option>South Carolina </option>';
					echo '						  <option>South Dakota</option>';
					echo '						  <option>Tennessee</option>';
					echo '						  <option>Texas</option>';
					echo '						  <option>Utah</option>';
					echo '						  <option>Vermont </option>';
					echo '						  <option>Virginia</option>';
					echo '						  <option>Washington</option>';
					echo '						  <option>West virginia</option>';
					echo '						  <option>Wisconsin</option>';
					echo '						  <option>Wyoming </option>';
					echo '						  <option>other</option>';
					echo '						</select>';
					echo "				</td>\n";
					echo "				<td>Country<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo '						<select name="Country">';
					echo '						  <option>Canada</option>';
					echo '						  <option>USA</option>';
					echo '						  <option>Britain</option>';
					echo '						</select>';
					echo "				</td>\n";
					echo "			</tr>\n";
					echo "			<tr valign='top'>\n";
					echo "				<td>Phone Number:<font color=\"red\">*</font>&nbsp;&nbsp;<br />\n";
					echo "					<input name='author_phone' type='text' size='20' />\n";
					echo "				</td>\n";
					echo "				<td colspan='2'>email:<font color=\"red\">*</font>&nbsp;&nbsp;\n";
					echo "					<br />\n";
					echo "					<input name='author_email' type='text' size='30' />\n";
					echo "				</td>\n";
					echo "			</tr>\n";
					echo "			<tr valign='top'>\n";
					echo "				<td colspan='3'><br />\n";
					echo "					Place Comments or Questions Here <font color=\"red\">*</font><br />\n";
					echo "					<textarea name='limitedtextarea' \n";
					echo "					onKeyDown='limitText(this.form.limitedtextarea, this.form.countdown, 2400);' \n";
					echo "					onKeyUp='limitText(this.form.limitedtextarea, this.form.countdown, 2400);' \n";
					echo "					rows='10' cols='50' ></textarea><br />\n";
					echo "					<font size='1'>(Maximum characters: 2400) <br />\n";
					echo "					You have \n";
					echo " 					<input type='text' readonly='readonly' name='countdown' size='3' value='2400' /> \n";
					echo "		 			characters left.</font>\n";
					echo "				</td>\n";
					echo "			</tr>\n";
					echo "		</table>\n";
					echo "	</fieldset>\n";
					echo "	<br />\n";
					echo '				<input value="Contact Me" type="submit" name="submit_contact">&nbsp;&nbsp;<input type="reset"></form>';
			}
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
