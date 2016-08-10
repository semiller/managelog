<?php
  // require configuration file
  require_once 'config/init.php';
  
  $warning = new Warnings();
  
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Search Work Orders</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
    
    <?php 
	// display workorder menu
	include 'inc/workorder_menu.inc.php'; 
	?>
 
        <div class="clr"></div>   
        <h2>Work Order Search <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">View work order information by selecting the work order title.</p>
        
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
	 if (isset($_POST['goButton_x']) && (isset($_POST['goButton_y']))) {
			$workorder = new WorkOrder();
	 		$workorder->searchWorkOrders($_POST['searchWorkOrders']);
	 } // end if
	 ?>
	 
	<!-- end .workorderListContainer --></div>
	 
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>