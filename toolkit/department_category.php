<?php
  // require configuration file
  require_once 'config/init.php';
  
  $department = new Department();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Customize Departments</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
if (isset($_GET['departmentAdded'])) {
	echo "<p>Department Successfully Added</p>";
} // end if

if (isset($_GET['departmentDeleted'])) {
	echo "<p>Department Successfully Deleted</p>";
	$department->deleteDepartment($_GET['departmentId']);
} // end if

?>
<!-- end .createMessage --></div>
   
   <?php
   if ($warning->detectDepartment() == false) {
   // warning message if no training categories in the system
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='department_category.php'>department</a> for your account.</p></div>";
   }
	?>
   
    
    <?php
	if (isset($_POST['addDepartment_x']) && (isset($_POST['addDepartment_y']))) {
	$department->addDepartment();
	} // end if
	
	?>
    
    <div class="clr"></div>
        
        <div class="left">
        
        <?php
		// there are departments remaining as part of the package, allow manager to enter departments
		if ($department->getRemainingPackageDepartment() != 0) {
		?>
        
        <form method="post" action="department_category.php" class="generalform">
        <h3>Departments</h3>
        <ol>
        <li><label for="Department">Department:</label>
          <span id="sprytextfield1">
          <input type="text" name="departmentName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a department name.</span></span>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addDepartment" class="submit" src="images/add_department_btn.png">
        </li>
        </ol>
        </form>
        
        <?php
		} // end if not equal to 0 
		else { 
			echo "<h3>Departments</h3><p>Your account has reached the package plan limit of allowed departments.  If you require more Departments for your location, consider upgrading to a different plan or review this message with your system administrator.</p>
			
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


	<h3>Current Departments</h3>
    <?php $department->readDepartment(); ?>

	<!-- end .left --></div>

	<div class="right">
    <?php include 'inc/admin_submenu.inc.php'; ?>
    <!-- end .right --></div>

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>