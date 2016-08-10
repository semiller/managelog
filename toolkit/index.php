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
<title>Manage Log</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="login_container">
<div class="login_header"> <img src="images/managelog_login_logo.png" alt="" />
  <p>Welcome to the Manage Log Service Toolkit.<br />
    To access this site, you must provide your Username and Password. </p>
    
  <?php
	   // IF FORGOTTEN PASSWORD SENT
	   if (isset($_GET['password_sent'])) {
		   echo "
		   <p><strong>Your new password has been emailed to the provided email address.</strong></p>
		   ";
	   } // END IF
	   
	   // IF PAYMENT SUCCESSFUL
	   if (isset($_GET['payment_success'])) {
		   $register->updateManagerPaid();
		   echo "
		   <p><strong>Thank you for your payment.  Your registration and payment have been successfully completed.  Your registration information has been sent to your registered email address.  Please use your registered username and password to login and begin using the Manage Log Service Toolkit.</strong></p>
		   ";
	   } // END IF
	   
	   // IF COUPON CODE SUCCESSFUL - Payment not necessary
	   if (isset($_GET['coupon_success'])) {
		   echo "
		   <p><strong>Congratulations.  Your entered coupon code has granted you free access to the Manage Log Service Toolkit.  Your registration information has been sent to your registered email address.</strong></p>
		   ";
	   } // END IF
	   
	   // IF PAYMENT CANCELLED
	   if (isset($_GET['payment_cancel'])) {
		   $register->deleteRegistration();
	   } // END IF
	   // ONCE PAYMENT IS FINALIZED AND CANCELLED (DELETION OF MANAGER AND ACCOUNT IN DB)
	   if (isset($_GET['payment_cancel_final'])) {
		   echo "
		   <p><strong>You Paypal payment and registration has been successfully cancelled.  Please complete the registration process again if you would like access.</strong></p>
		   ";
	   } // END IF
	   
	   
	   // IF UPGRADE SUCCESSFUL
	   if (isset($_GET['upgrade_success'])) {
		   $register->updatePackagePlan();
		   echo "
		   <p><strong>Thank you for your payment.  Your upgrade and payment have been successfully completed.    Please use your registered username and password to login and finalize the upgrade process.</strong></p>
		   ";
	   } // END IF
	   // IF UPGRADE CANCEL
	   if (isset($_GET['upgrade_cancel'])) {
		   echo "
		   <p><strong>You have cancelled your upgrade.  Please use your login username and password to log into your account.</strong></p>
		   ";
	   } // END IF
	   
	   
      ?>
      
      <?php
	// if submitted, process the login
	// submit_x and y used when pushing submit img btn to POST
	if (isset($_POST['submit_login_x']) && (isset($_POST['submit_login_y']))) {
		$log = new Log();
		$log->login($_POST['managerUsername'],$_POST['managerPassword']);
	} // end if
?>
      
      
      
  <!-- end .login_header --></div>
<div class="login_box">
<div class="login_form">
  <form method="post" action="index.php">
    <ol>
      <li>
      	<label for="managerUsername">Username:</label>
      	<span id="sprytextfield1">
      	<input type="text" name="managerUsername" class="text">
        <div class="clr"></div>
      	<span class="textfieldRequiredMsg">Please enter your username.</span></span>
      </li>
      <li>
      	<label for="managerPassword">Password:</label>
      	<span id="sprytextfield2">
      	<input type="password" name="managerPassword" class="text">
        <div class="clr"></div>
      	<span class="textfieldRequiredMsg">Please enter your password.</span></span>
      </li>
    <li class="buttons">
    	<input type="image" name="submit_login" src="images/login_btn.png" />
    </li>
    </ol>
  </form>
  <!-- end. login_form --></div>
  <!-- end .login_box --></div>
<div class="login_footer">
  <p><a href="register.php">Register new account</a> | <a href="forgot_password.php">Reset your password</a></p>
  <!-- end .login_footer --></div>
  <!-- end .login_container --></div>
  
  
  
  
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>