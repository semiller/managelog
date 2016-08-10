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
<title>Manage Log | Search Safety Tracker</title>
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
	// display safetrack menu
	include 'inc/safetrack_menu.inc.php'; 
	?>
        
        <div class="clr"></div>   
        <h2>Safety Tracker Search <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">View safety tracker information by selecting the safety tracker title.</p>
        
		<div class="safetrackListContainer"><!-- Holds all safetrack list information -->
        
		<div class="safetrackListHeader">
		<div class="safetrackListHeaderItems">
        <p>Title</p>
        <!-- end .safetrackListHeaderItems"--></div>
		<div class="safetrackListHeaderItems">
        <p>Category</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Department</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Submitted By</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Create Date</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Completion Status / Date</p>
        <!-- end .safetrackListHeaderItems"--></div>
		<!-- end .safetrackListHeader --></div>
		<div class="clr"></div>
	
        
        
    
    
     <?php
	 if (isset($_POST['goButton_x']) && (isset($_POST['goButton_y']))) {
			$safetrack = new SafeTrack();
	 		$safetrack->searchSafeTrack($_POST['searchSafeTrack']);
	 } // end if
	 ?>
	 
	<!-- end .safetrackListContainer --></div>
	 
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>