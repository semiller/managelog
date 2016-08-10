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
<title>Manage Log | Delete Work Order</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

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
if (isset($_GET['workorderDeleted'])) {
	echo "<p>Work Order Successfully Deleted</p>";
	$workorder->deleteWorkOrder($_GET['workorderId']);
} // end if
?>
<!-- end .createMessage --></div>    

    <?php 
	// display workorder menu
	include 'inc/workorder_menu.inc.php'; 
	?>
    <div class="clr"></div>   
        <h2>Delete Work Order</h2>
        <p>Delete work orders by selecting a work order title.</p>
        
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
		// displays listing of workorder in the system
    	$workorder->deleteWorkOrderList();
		?>
        
        <!-- end .workorderListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>