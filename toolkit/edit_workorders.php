<?php
  // require configuration file
  require_once 'config/init.php';
  
  $workorder = new WorkOrder();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Edit Work Orders</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
    
    <?php
	if (isset($_POST['selectWorkOrder_x']) && (isset($_POST['selectWorkOrder_y']))) {
	$workorder->updateWorkOrder('$_GET[workorderId]');
	} // end if
	
	?>
    
    
    <?php 
	// display workorder menu
	include 'inc/workorder_menu.inc.php'; 
	?>
    <div class="clr"></div>
    <h2>Edit Work Order</h2>    
    <p>Edit work order information by selecting a work order title.</p>
    
    <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="edit_workorders.php">
        <select name="sortWorkOrder">
        <option></option>
        <option value="workorderTitle">Title</option>
        <option value="workorderCategory">Category</option>
        <option value="workorderDepartment">Department</option>
        <option value="workorderSubmittedBy">Submitted By</option>
        <option value="workorderCreateDate">Create Date</option>
        <option value="workorderCompletionDate">Completion Date</option>
        </select>
        <input type="image" name="sortResults" class="submit" src="images/sort_results_btn.png">
        </form>
        </div>
        <!-- end .sortForm --></div>
        <div class="clr"></div>
    
       <div class="workorderListContainer"><!-- Holds all workorder list information -->
        
		<div class="workorderListHeader">
		<div class="workorderListHeaderItems">
        <p>Title</p>
        <!-- end .workorderListHeaderItems"--></div>
		<div class="workorderListHeaderItems">
        <p>Category</p>
        <!-- end .workorderListHeaderItems"--></div>
        <div class="workorderListHeaderItems">
        <p>Department</p>
        <!-- end .workorderListHeaderItems"--></div>
        <div class="workorderListHeaderItems">
        <p>Submitted By</p>
        <!-- end .workorderListHeaderItems"--></div>
        <div class="workorderListHeaderItems">
        <p>Create Date</p>
        <!-- end .workorderListHeaderItems"--></div>
        <div class="workorderListHeaderItems">
        <p>Completion Status / Date</p>
        <!-- end .workorderListHeaderItems"--></div>
		<!-- end .workorderListHeader --></div>
		<div class="clr"></div>
        
       <?php 
	   $workorder->workorderSelectDisplay('edit_selected_workorder.php');
	   ?>


		<!-- end .workorderListContainer --></div>
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>