<?php

if ($msg) $this->displayErrorMessage($msg); 
if (!$_POST['cc_cardholder_name'])
$thename = $gekko_auth->getFullName();
else $thename = $_POST['cc_cardholder_name'];

?>
<form name="paymentForm" action="<?php echo SEFLink('/index.php?page=shop&action=finalizecheckout'); ?>" method="post">
<fieldset><legend>Special Instructions</legend>
<p>
  <textarea name="special_instructions" cols="50" rows="4"></textarea>
</p></fieldset>
<fieldset><legend>Credit Card Information</legend>
          <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
              <td align="right">Cardholder Name</td>
              <td><input id="cc_cardholder_name" type="text" name="cc_cardholder_name" value="<?php echo $thename;  ?>" /></td>
            </tr>
            <tr>
              <td width="200" align="right">Credit Card Number</td>
              <td>
                <input id="cc_num" type="text" name="cc_num" value="<?php echo $_POST['cc_num']; ?>" /></td>
            </tr>
            <tr>
              <td width="200" align="right">Expiry Date (mm/yy)</td>
              <td>        <SELECT name="cc_mm">
          <OPTION value="01"> 01</OPTION>
          <OPTION value="02"> 02</OPTION>
          <OPTION value="03"> 03</OPTION>
          <OPTION value="04"> 04</OPTION>
          <OPTION value="05"> 05</OPTION>
          <OPTION value="06"> 06</OPTION>
          <OPTION value="07"> 07</OPTION>
          <OPTION value="08"> 08</OPTION>
          <OPTION value="09"> 09</OPTION>
          <OPTION value="10"> 10</OPTION>
          <OPTION value="11"> 11</OPTION>
          <OPTION value="12"> 12</OPTION>
        </SELECT>

                  <SELECT name="cc_yy">
          <OPTION value="09"> 09</OPTION>
          <OPTION value="10"> 10</OPTION>
          <OPTION value="11"> 11</OPTION>
          <OPTION value="12"> 12</OPTION>
          <OPTION value="13"> 13</OPTION>
          <OPTION value="14"> 14</OPTION>
          <OPTION value="15"> 15</OPTION>
          <OPTION value="16"> 16</OPTION>
          <OPTION value="17"> 17</OPTION>
          <OPTION value="18"> 18</OPTION>
          <OPTION value="19"> 19</OPTION>
          <OPTION value="20"> 20</OPTION>
        </SELECT></td>
            </tr>
            <tr>
              <td width="200" align="right">CVV2</td>
              <td>
                <input name="cvv2" id="cvv2" type="text" size="4" maxlength="4" <?php echo $_POST['cvv2']; ?>/></td>
            </tr>
            <tr>
              <td width="200" align="right"></td>
              <td valign="middle">We accept <img src="/images/cc/cc1.gif" width="37" height="23" align="absmiddle" /><img src="/images/cc/cc2.gif" width="37" height="23" align="absmiddle" /><img src="/images/cc/cc3.gif" width="37" height="21" align="absmiddle" /><img src="/images/cc/cc5.gif" width="37" height="21" align="absmiddle" />
                  <!--<img src="/images/cc/cc6.gif" width="37" height="21" align="absmiddle" /> --></td>
            </tr>
          </table>
  </fieldset>
	<p><em>By providing this information you agree to Elavon's Privacy Policy and Terms of Use<br>
Privacy Policy: <a href="http://www.internetsecure.com/privacy.html" target="_blank">http://www.internetsecure.com/privacy.html</a><br>
Terms of Use: <a href="http://www.internetsecure.com/termsofuse.html" target="_blank">http://www.internetsecure.com/termsofuse.html</a></em></p>

<p>
  <input type="submit" name="Submit" value="Submit">
</p>
</form>
