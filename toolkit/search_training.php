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
<title>Manage Log | Search Training</title>
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
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
        
        <div class="clr"></div>   
        <h2>Training Search <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">View training information by selecting the training title.</p>
        
		<div class="trainingListContainer"><!-- Holds all training list information -->
        
		<div class="trainingListHeader">
		<div class="trainingListHeaderItems">
        <p>Title</p>
        <!-- end .trainingListHeaderItems"--></div>
		<div class="trainingListHeaderItems">
        <p>Category</p>
        <!-- end .trainingListHeaderItems"--></div>
        <div class="trainingListHeaderItems">
        <p>Department</p>
        <!-- end .trainingListHeaderItems"--></div>
        <div class="trainingListHeaderItems">
        <p>Conducted By</p>
        <!-- end .trainingListHeaderItems"--></div>
        <div class="trainingListHeaderItems">
        <p>Schedule Date</p>
        <!-- end .trainingListHeaderItems"--></div>
        <div class="trainingListHeaderItems">
        <p>Completion Status / Date</p>
        <!-- end .trainingListHeaderItems"--></div>
		<!-- end .trainingListHeader --></div>
		<div class="clr"></div>
	
        
        
    
    
     <?php
	 if (isset($_POST['goButton_x']) && (isset($_POST['goButton_y']))) {
			$training = new Training();
	 		$training->searchTraining($_POST['searchTraining']);
	 } // end if
	 ?>
	 
	<!-- end .trainingListContainer --></div>
	 
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>