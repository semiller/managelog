<?php
  // require configuration file
  require_once 'config/init_login.php';
?>
<?php
	// if submitted, process the login
	// submit_x and y used when pushing submit img btn to POST
	if (isset($_POST['submit_register_x']) && (isset($_POST['submit_register_y']))) {
		$register = new Register();
		$register->registerManager($_POST['managerNumber'],$_POST['managerUsername'],$_POST['managerPassword'],$_POST['managerFirstName'],$_POST['managerLastName'],$_POST['managerEmail'],$_POST['managerPhone'],$_POST['accountName'],$_POST['managerCoupon'],$_POST['packageType']);
		//$register->addAccount($_POST['accountName']);
	} // end if
?>
 
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Register New Account</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="login_container">
<div class="login_header"> <img src="images/managelog_login_logo.png" alt="" />
  <p>Welcome to the Manage Log Service Toolkit.<br />
    To register for a new account, please complete all fields listed below.<br>Upon successful completion of the form below, you will be redirected to the payment page to finalize your registration.</p>
  
  
  		<?php
	   // IF EMAIL EXISTS
	   if (isset($_GET['email_exists'])) {
		   echo "
		   <p><strong>The email address you entered already exists.  Please use a different email account.</strong></p>
		   ";
	   } // END IF
	   // IF USERNAME EXISTS
	   if (isset($_GET['username_exists'])) {
		   echo "
		   <p><strong>The username you entered already exists.  Please use a different username.</strong></p>
		   ";
	   } // END IF
	   ?>
  
  <!-- end .login_header --></div>
<div class="login_box">
<div class="login_form">
  <form method="post" action="register.php">
    <ol>
      <li>
      	<label for="accountName">Account Name:</label>
      	<span id="sprytextfield8">
      	<input type="text" name="accountName" class="text">
        <div class="clr"></div>
      	<span class="textfieldRequiredMsg">Please enter your account / facility name.</span></span>
      </li>
      <li>
      	<label for="managerNumber">Employee Id #:</label>
      	<span id="sprytextfield3">
      	<input type="text" name="managerNumber" class="text">
        <div class="clr"></div>
      	<span class="textfieldRequiredMsg">Please enter your employee id number.</span></span>
      </li>
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
      <li>
      	<label for="managerFirstName">First Name:</label>
      	<span id="sprytextfield4">
      	<input type="text" name="managerFirstName" class="text">
        <div class="clr"></div>
      	<span class="textfieldRequiredMsg">Please enter your first name.</span></span>
      </li>
      <li>
      	<label for="managerLastName">Last Name:</label>
      	<span id="sprytextfield5">
      	<input type="text" name="managerLastName" class="text">
        <div class="clr"></div>
      	<span class="textfieldRequiredMsg">Please enter your last name.</span></span>
      </li>
      <li>
      	<label for="managerEmail">Email:</label>
      	<span id="sprytextfield6">
        <input type="text" name="managerEmail" class="text">
        <div class="clr"></div>
        <span class="textfieldRequiredMsg">Please enter your email address.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
      </li>
      <li>
      	<label for="managerPhone">Phone Number:</label>
      	<span id="sprytextfield7">
        <input type="text" name="managerPhone" class="text">
        <div class="clr"></div>
        <span class="textfieldRequiredMsg">Please enter your phone number.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
      </li>
      <li>
      	<label for="packageType">Package Level:</label>
        <select name="packageType" style="width: 205px; height:32px">
        	<option value="Bronze">Bronze</option>
            <option value="Silver">Silver</option>
            <option value="Gold">Gold</option>
        </select>
      	<div class="clr"></div>
      </li>
      <li>
      	<label for="managerCoupon">Coupon Code:</label>
        <input type="text" name="managerCoupon" class="text">
        <div class="clr"></div>
      </li>
      <!-- This gets the current timestamp on form load.  deduct from process page to see if form submitted too quickly -->
	<input type="hidden" name="loadtime" value="<?php echo time(); ?>" />
    <li class="buttons">
    	<input type="image" name="submit_register" src="images/register_btn.png" />
    </li>
    </ol>
  </form>
  <!-- end. login_form --></div>
  <!-- end .login_box --></div>
<div class="login_footer">
  <p><a href="index.php">Sign In</a> | <a href="forgot_password.php">Reset your password</a></p>
  <!-- end .login_footer --></div>
  <!-- end .login_container --></div>
  
  
  
  
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "email", {useCharacterMasking:true});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "phone_number", {format:"phone_custom", pattern:"000-000-0000", useCharacterMasking:true});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>
</body>
</html>
