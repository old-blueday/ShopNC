<?php
/*
 * orderform.php
 *
 * PHP Toolkit for PayPal v0.51
 * http://www.paypal.com/pdn
 *
 * Copyright (c) 2004 PayPal Inc
 *
 * Released under Common Public License 1.0
 * http://opensource.org/licenses/cpl.php
 *
 */
?>

<html>
<head>
<title>::PHP PayPal Order Form::</title>
</head>

<body>
<form method="post" action="process.php">
  
    <br>
    
  <table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="350" align="left" valign="top"><table width="223" border="0">
        <tr> 
          <td> <p>First 
              Name:  
              <input name="firstname" type="text" id="firstname" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>Last 
              Name:  
              <input name="lastname" type="text" id="lastname" size="40">
            </p></td>
        </tr>
      </table>
            <table width="223" border="0">
               <tr> 
                  <td> <p> Address1: 
                        <input name="address1" type="text" id="address1"  size="40">
                     </p></td>
               </tr>
               <tr>
                  <td>Address2: 
                     <input name="address2" type="text" id="address2"  size="40"> </td>
               </tr>
            </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>City: 
              <input name="city" type="text" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>State: 
              <input name="state" type="text" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>Zip: 
              <input name="zip" type="text" size="40">
            </p></td>
        </tr>
      </table>
            <table width="223" border="0">
               <tr> 
                  <td> <p>Email: 
                        <input name="email" type="text" id="email" size="40">
                     </p></td>
               </tr>
            </table> 
            <table width="223" border="0">
               <tr> 
                  <td height="16" align="left" valign="top"> Phone: <table width="223" border="0" cellpadding="0" cellspacing="0">
                        <tr> 
                           <td width="45"> <input name="phone1" type="text" id="phone1" size="3" maxlength="3">
                              -</td>
                           <td width="43"><input name="phone2" type="text" id="phone2" size="3" maxlength="3">
                              -</td>
                           <td width="135"><input name="phone3" type="text" id="phone3" size="4" maxlength="4"></td>
                        </tr>
                     </table></td>
               </tr>
            </table>
         </td>
    <td align="left" valign="top"><table width="223" border="0">
        <tr> 
          <td> <p>Item Name: 
                        <input name="item_name" type="text" id="item_name" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>Item Number: 
                        <input name="item_number" type="text" id="item_number" size="40">
            </p></td>
        </tr>
      </table>
            <table width="223" border="0">
               <tr> 
                  <td width="116" >Size: <br> <input type="hidden" name="on0" value="Size"> 
                     <select name="os0">
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                     </select> </td>
               </tr>
               <tr> 
                  <td >Color: <br> <input type="hidden" name="on1" value="Color"> 
                     <select name="os1">
                        <option value="Black">Black</option>
                        <option value="Red">Red</option>
                        <option value="Blue">Blue</option>
                     </select></td>
               </tr>
            </table>
            <table width="223" border="0">
        <tr> 
          <td width="203"> <p> Amount: 
                        <input name="amount" type="text" id="amount" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>Quantity: 
                        <input name="quantity" type="text" id="quantity" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>Shipping Amount: 
                        <input name="shipping_amount" type="text" id="shipping_amount" size="40">
            </p></td>
        </tr>
      </table>
      <table width="223" border="0">
        <tr> 
          <td> <p>Tax: 
                        <input name="tax" type="text" id="tax" size="40">
            </p></td>
        </tr>
      </table>
            <br>
            <br>
        <table width="252" border="0">
          <tr> 
            <td width="124">
	
			<input type="submit" name="submit"></td>
            <td width="118"><input type="reset" name="reset"></td>
          </tr>
        </table>
        
      </td>
  </tr>
</table>

 
</form> 

</body>
</html>
