<?php
  // require configuration file
  require_once 'config/init_login.php';
?>
<?php
	// if submitted, process the forgot password email
	// submit_x and y used when pushing submit img btn to POST
	if (isset($_POST['submit_forgot_x']) && (isset($_POST['submit_forgot_y']))) {
		$passwordmailer = new PasswordMailer();
		$passwordmailer->sendPassword($_POST['managerEmail']);
	} // end if
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Forgot Password</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="login_container">
<div class="login_header"> <img src="images/managelog_login_logo.png" alt="" />
  <p>Welcome to the Manage Log Service Toolkit.<br />
    To reset your password, please enter the email address you registered to your account.</p>
    
  <!-- end .login_header --></div>
<div class="login_box">
<div class="login_form">
  <form method="post" action="forgot_password.php">
    <ol>
      <li>
      	<label for="managerEmail">Email:</label>
      	<span id="sprytextfield1">
        <input type="text" name="managerEmail" class="text">
        <div class="clr"></div>
        <span class="textfieldRequiredMsg">Please enter your email address.</span><span class="textfieldInvalidFormatMsg">This is not a valid email address.</span></span>
      </li>
    <li class="buttons">
    	<input type="image" name="submit_forgot" src="images/sendpassword_btn.png" />
    </li>
    </ol>
  </form>
  <!-- end. login_form --></div>
  <!-- end .login_box --></div>
<div class="login_footer">
  <p><p><a href="index.php">Sign In</a> | <a href="register.php">Register new account</a></p>
  <!-- end .login_footer --></div>
  <!-- end .login_container --></div>
  
  
  
  
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email");
</script>
</body>
</html>