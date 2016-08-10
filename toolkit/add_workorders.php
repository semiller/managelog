<?php
  // require configuration file
  require_once 'config/init.php';
  
  $workorder = new WorkOrder();
  $manager = new Manager();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Add Work Orders</title>
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
if (isset($_GET['workorderAdded'])) {
	echo "<p>Work Order Successfully Added</p>";
} // end if

?>
<!-- end .createMessage --></div>
   
    
    <?php
	if (isset($_POST['addWorkOrder_x']) && (isset($_POST['addWorkOrder_y']))) {
	$workorder->addworkOrder();
	} // end if
	
	?>
    
    
    <?php 
	// display project menu
	include 'inc/workorder_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
        <div class="left">
        
        <form method="post" action="add_workorders.php" class="generalform">
        <h3>Work Order Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="workorderTitle" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a work order title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $workorder->displayWorkOrderCategorySelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $manager->displayManagerWorkOrdersDepartmentSelect(); ?>
        </li>
        
        <li><label for="Priority">Priority Level:</label>
        	<select name="workorderPriority">
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
            </select>
        </li>
        
        <li><label for="Location">Location:</label>
          <span id="sprytextfield2">
          <input type="text" name="workorderLocation" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a location for this work order.</span></span></li>
        
        <li><label for="Description">Description:</label>
        	<textarea name="workorderDescription"></textarea>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addWorkOrder" class="submit" src="images/add_workorder_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
        
    
    <div class="right">
 
    <!-- end .right --></div>

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>