<?php
  // require configuration file
  require_once 'config/init.php';
  
  $manager = new Manager();
  $department = new Department();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Add Manager</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){	
	// THIS IS HOW TO REMOVE A MEESAGE AFTER A CERTAIN TIME PERIOD
	setTimeout('$(".createMessage").fadeOut(1500)',1500);
	// or just use hide() instead of fadeout
});
</script>


<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
    <?php
	if (isset($_POST['addManager_x']) && (isset($_POST['addManager_y']))) {
	$manager->addManager($_POST['managerUsername'],$_POST['managerEmail']);
	} // end if
	?>
    
   <!-- This div is deleted based on settimeout in jquery script -->
<div class="createMessage">
<?php 
if (isset($_GET['managerAdded'])) {
	echo "<p>Manager Successfully Added.  An email with the new managers login credentials has been automatically mailed to the manager.</p>";
} // end if
?>
<!-- end .createMessage --></div>
   
   <?php include 'inc/manager_menu.inc.php'; ?>
   
    <div class="clr"></div>
    
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
        
        <div class="left">
        
        <?php
			// there are managers remaining as part of the package, allow manager to enter new managers
			if ($manager->getRemainingPackageManager() != 0) {
		?>
        
        <h3>Manager Information</h3>
        <form method="post" action="add_manager.php" class="generalform">
        <input type="hidden" name="accountId" value="<?php echo $_SESSION['accountId']; ?>">
        <input type="hidden" name="managerCreateDate" value="<?php echo date('Y-m-d'); ?>">
        <ol>
        <li><label for="Manager ID">Manager ID #:</label>
          <span id="sprytextfield1">
          <input type="text" name="managerNumber" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter an manager id number.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
        </li>
        
        <li><label for="Manager First Name">First Name:</label>
          <span id="sprytextfield2">
          <input type="text" name="managerFirstName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a first name.</span></span>
        </li>
        <li><label for="Manager Last Name">Last Name:</label>
          <span id="sprytextfield3">
          <input type="text" name="managerLastName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a last name.</span></span>
         </li>
         <li><label for="Manager Email">Email Address:</label>
           <span id="sprytextfield4">
           <input type="text" name="managerEmail" class="text">
           <div class="clr"></div>
			<span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Manager Phone">Phone Number:</label>
           <span id="sprytextfield5">
           <input type="text" name="managerPhone" class="text">
           <div class="clr"></div>
           <span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Manager Username">Username:</label>
           <span id="sprytextfield6">
           <input type="text" name="managerUsername" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a username.</span></span>
         </li>
         <li><label for="Manager Password">Password:</label>
           <span id="sprytextfield7">
           <input type="password" name="managerPassword" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a password.</span></span>
         </li>
         <li><label for="Manager Role">Role:</label>
           <span id="spryselect1">
           <select name="managerRole">
             <option value="2">Manager</option>
             <option value="2">General Manager</option>
             <option value="2">Director</option>
             <option value="3">Assistant Manager</option>
             <option value="3">Assistant Director</option>
             <option value="4">Supervisor</option>
             <option value="4">Day Supervisor</option>
             <option value="4">Evening Supervisor</option>
             <option value="4">Night Supervisor</option>
             <option value="4">Shift Leader</option>
           </select>
           <div class="clr"></div>
           <span class="selectRequiredMsg">Please select an item.</span></span>
         </li>
         <li><label for="Manager Department">Department:</label>
           <?php $department->displayDepartmentSelect(); ?>
         </li>
           <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addManager" class="submit" src="images/add_manager_btn.png">
        </li>
        </ol>
        </form>
        
        <?php
		} // end if not package manager is equal 0
		else { 
			echo "<h3>Manager Information</h3><p>Your account has reached the package plan limit of allowed managers.  If you require more Managers for your location, consider upgrading to a different plan or review this message with your system administrator.</p>
			
			<h3>Upgrade to Gold Package Plan</h3>
			<ul>
			<li>Departments: unlimited</li>
			<li>Managers: unlimited</li>
			<li>Upgrade Price: $4.99</li>
			</ul>
			"; ?>
            <?php
			// only show pay button or admin of the account
			$manager = new Manager();
			if($manager->getManagerRole() == '1') {
			?>
            <a href="index.php?upgrade_success=yes">Upgrade Plan</a>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="padding-left: 55px">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="W5M7TS7PKW9SS">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		<?php
			} // end if Admin to show payment button
			else { echo "<p>See administrator for upgrade options</p>"; } // end else
		} // end else
		?>

	<!-- end .left --></div>
    
    <div class="right">
    <?php include 'inc/admin_submenu.inc.php'; ?>
    <!-- end .right --></div>
    

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "phone_number", {isRequired:false, useCharacterMasking:true, format:"phone_custom", pattern:"000-000-0000"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>