<?php
  // require configuration file
  require_once 'config/init_login.php';
	$register = new Register();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Register New Account | Payment</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<style>
.center_btn { width: 400px; margin: 0 auto; text-align:center; }
</style>

</head>

<body>

<div class="login_container">
<div class="login_header"> <img src="images/managelog_login_logo.png" alt="" />

<?php
// IF Successful register
	   if (isset($_GET['register_success'])) {
		   echo "
		   <p><strong>You have successfully registered a new account.<br>  To complete your registration, please click the Paypal payment button below to submit your payment.</strong></p>
		   ";
	   } // END IF
?>
  
  <!-- end .login_header --></div>
<div class="login_box">
<div class="login_form">
<p>Click the payment button below to submit payment details.  You will be redirectly back to Manage Log upon payment completion.</p>
<div class="center_btn">

<?php
if ($_GET['packageType'] == 'Bronze') {
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="358XZLPV5RH7A">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php 
} // end Bronze package
elseif ($_GET['packageType'] == 'Silver') {
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="XLZV29YTTGWXN">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php } // end Silver package
elseif ($_GET['packageType'] == 'Gold') {
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="FXWKNGHMYTKY2">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php } // end Gold package ?>
    

<!-- end .center_btn --></div>
  <!-- end. login_form --></div>
  <!-- end .login_box --></div>

  <!-- end .login_container --></div>
  

</body>
</html>
