<?php
  // require configuration file
  require_once 'config/init.php';
  
  $manager = new Manager();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<title>Manage Log | Edit Manager</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){	
	// THIS IS HOW TO REMOVE A MEESAGE AFTER A CERTAIN TIME PERIOD
	setTimeout('$(".createMessage").fadeOut(1500)',1500);
	// or just use hide() instead of fadeout
});
</script>


</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
    
<!-- This div is deleted based on settimeout in jquery script -->
<div class="createMessage">
<?php 
if (isset($_GET['managerUpdated'])) {
	echo "<p>Manager Successfully Updated</p>";
} // end if
if (isset($_GET['managerPasswordUpdated'])) {
	echo "<p>Manager Password Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateManager_x']) && (isset($_POST['updateManager_y']))) {
	$manager->updateManager($_GET['managerId']);
	} // end if
	if (isset($_POST['updatePassword_x']) && (isset($_POST['updatePassword_y']))) {
	$manager->updatePassword($_GET['managerId']);
	} // end if
	?>
    
    
    <?php include 'inc/manager_menu.inc.php'; ?>
    <div class="clr"></div>
    
    
    
   
   <?php $manager->setManagerValues($_GET['managerId']); ?>
   
   <?php if ($manager->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
   
        
        <div class="left">
  
        <form method="post" action="edit_selected_manager.php?managerId=<?php echo $manager->getManagerId(); ?>"  class="generalform">
        <h3>Manager Information</h3>
        <ol>
        <li><label for="Manager ID">Manager ID #:</label>
          <span id="sprytextfield1">
          <input type="text" name="managerNumber" class="text" value="<?php echo $manager->getManagerNumber(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter an manager id number.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
        </li>
        
        <li><label for="Manager First Name">First Name:</label>
          <span id="sprytextfield2">
          <input type="text" name="managerFirstName" class="text" value="<?php echo $manager->getManagerFirstName(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a first name.</span></span>
        </li>
        <li><label for="Manager Last Name">Last Name:</label>
          <span id="sprytextfield3">
          <input type="text" name="managerLastName" class="text" value="<?php echo $manager->getManagerLastName(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a last name.</span></span>
         </li>
         <li><label for="Manager Email">Email Address:</label>
           <span id="sprytextfield4">
           <input type="text" name="managerEmail" class="text" value="<?php echo $manager->getManagerEmail(); ?>">
           <div class="clr"></div>
			<span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Manager Phone">Phone Number:</label>
           <span id="sprytextfield5">
           <input type="text" name="managerPhone" class="text" value="<?php echo $manager->getManagerPhone(); ?>">
           <div class="clr"></div>
           <span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
        
         <li><label for="Manager Department">Department:</label>
         <?php $manager->displayManagerDepartmentEditManagerSelect(); ?>    
         </li>
   
           <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateManager" class="submit" src="images/edit_manager_btn.png">
        </li>
        </ol>
        </form>

		<!-- IF SESSION MANAGER ACCOUNT, ALLOW TO CHANGE PASSWORD -->
        <?php if($manager->getManagerId() == $_SESSION['managerId']) { ?>
        <form method="post" action="edit_selected_manager.php?managerId=<?php echo $manager->getManagerId(); ?>"  class="generalform">
        <h3>Change Password</h3>
        <ol>
        <li><label for="Manager Password">Password:</label>
          <input type="password" name="managerPassword" class="text">
        <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updatePassword" class="submit" src="images/edit_password_btn.png">
        </li>
        </ol>
        </form>
        <?php } // end if ?>







	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

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

</script>
</body>
</html>