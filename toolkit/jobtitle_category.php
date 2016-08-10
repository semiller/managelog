<?php
  // require configuration file
  require_once 'config/init.php';
  
  $jobtitle = new JobTitle();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Customize Job Titles</title>
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
if (isset($_GET['jobtitleAdded'])) {
	echo "<p>Job Title Successfully Added</p>";
} // end if

if (isset($_GET['jobtitleDeleted'])) {
	echo "<p>Job Title Successfully Deleted</p>";
	$jobtitle->deleteJobTitle($_GET['jobtitleId']);
} // end if

?>
<!-- end .createMessage --></div>
   
    
    <?php
	if (isset($_POST['addJobTitle_x']) && (isset($_POST['addJobTitle_y']))) {
	$jobtitle->addJobTitle();
	} // end if
	
	?>
    
   
    
    <div class="clr"></div>
        
        <div class="left">
        
        <form method="post" action="jobtitle_category.php" class="generalform">
        <h3>Job Titles</h3>
        <ol>
        <li><label for="Job Titles">Job Titles:</label>
          <span id="sprytextfield1">
          <input type="text" name="jobtitleName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a job title.</span></span>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addJobTitle" class="submit" src="images/add_jobtitle_btn.png">
        </li>
        </ol>
        </form>


	<h3>Current Job Titles</h3>
    <?php $jobtitle->readJobTitle(); ?>

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