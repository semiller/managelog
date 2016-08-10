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
<title>Manage Log | Work Orders</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

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
	if (isset($_GET['markWorkOrderComplete'])) {
	echo "<p>Work Order Successfully Updated</p>";
	} // end if
	?>
<!-- end .createMessage --></div>

	<?php
		if(isset($_GET['markWorkOrderComplete'])) {
			$workorder->updateWorkOrderComplete($_GET['workorderId']);
		} // end if markWorkOrderComplete
	?>

    <?php 
	// display project menu
	$warning->detectManager();
	include 'inc/workorder_menu.inc.php'; 
	?>
    
    <div class="clr"></div>   
        <h2>Work Order Listing <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">All work orders are listed below.  Click on work order title to view more details.</p>
        
        <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="workorders.php">
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
		// displays listing of projects in the system
        $workorder->workorderSelectDisplay('workorder_profile.php');
		?>
        
        <!-- end .workorderListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>