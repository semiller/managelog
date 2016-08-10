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
<title>Manage Log | Edit Work Order</title>
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
if (isset($_GET['workorderUpdated'])) {
	echo "<p>Work Order Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateWorkOrder_x']) && (isset($_POST['updateWorkOrder_y']))) {
	$workorder->updateWorkOrder($_GET['workorderId']);
	} // end if
	
	?>
    
    
    <?php 
	// display workorder menu
	include 'inc/workorder_menu.inc.php'; 
	?>
    <div class="clr"></div>
    
    
    
   
   <?php $workorder->setWorkOrderValues($_GET['workorderId']); ?>
        
        
        <?php if ($workorder->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
  
        <form method="post" action="edit_selected_workorder.php?workorderId=<?php echo $workorder->getWorkOrderId(); ?>"  class="generalform">
        <h3>Work Order Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="workorderTitle" class="text" value="<?php echo $workorder->getWorkOrderTitle(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a work order title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $workorder->displayWorkOrderCategoryEditSelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $workorder->displayManagerDepartmentEditWorkOrderSelect(); ?>
        </li>
        
        <li><label for="Create Date">Create Date:</label>
          <span id="sprytextfield2">
          <input type="date" name="workorderCreateDate" class="text" value="<?php echo $workorder->getWorkOrderCreateDateEdit(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a create date.</span></span>
        </li>
       
        <li><label for="Description">Description:</label>
        	<textarea name="workorderDescription"><?php echo $workorder->getWorkOrderDescription(); ?></textarea>
        </li>
        
        <li><label for="Priority">Priority:</label>
          	<select name="workorderPriority">
             <option value="High" <?php if ($workorder->getworkOrderPriority() == 'High') echo "selected"; ?>>High</option>
             <option value="Medium" <?php if ($workorder->getworkOrderPriority() == 'Medium') echo "selected"; ?>>Medium</option>
             <option value="Low" <?php if ($workorder->getworkOrderPriority() == 'Low') echo "selected"; ?>>Low</option>
            
            </select>
        </li>
        
        <li><label for="Location">Location:</label>
        	<input type="text" name="workorderLocation" class="text" value="<?php echo $workorder->getWorkOrderLocation(); ?>">
            </li>
        	
        
        <li><label for="Update Comments">Update Comments:</label>
        	<textarea name="workorderUpdateComments"><?php echo $workorder->getWorkOrderUpdateComments(); ?></textarea>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateWorkOrder" class="submit" src="images/edit_workorder_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

		<div class="right">
        <?php if ($workorder->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
        <?php include 'inc/workorder_submenu.inc.php'; ?>
        <?php } // end getViewAuth ?>
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