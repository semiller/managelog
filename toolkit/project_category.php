<?php
  // require configuration file
  require_once 'config/init.php';
  
  $projectCategory = new ProjectCategory();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Customize Project Category</title>
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
if (isset($_GET['projectCategoryAdded'])) {
	echo "<p>Project Category Successfully Added</p>";
} // end if

if (isset($_GET['projectCategoryDeleted'])) {
	echo "<p>Project Category Successfully Deleted</p>";
	$projectCategory->deleteProjectCategory($_GET['projectCategoryId']);
} // end if

?>
<!-- end .createMessage --></div>

   
    
    <?php
	if (isset($_POST['addProjectCategory_x']) && (isset($_POST['addProjectCategory_y']))) {
	$projectCategory->addProjectCategory();
	} // end if
	
	?>
    
    
    <?php 
	// display project menu
	include 'inc/projects_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
        <div class="left">
        
        <form method="post" action="project_category.php" class="generalform">
        <h3>Project Category</h3>
        <ol>
        <li><label for="Category">Category:</label>
          <span id="sprytextfield1">
          <input type="text" name="projectCategoryName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a project category.</span></span>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addProjectCategory" class="submit" src="images/add_category_btn.png">
        </li>
        </ol>
        </form>


	<h3>Current Categories</h3>
    <?php $projectCategory->readProjectCategory(); ?>

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