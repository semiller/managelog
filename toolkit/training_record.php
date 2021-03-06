<?php
  // require configuration file
  require_once 'config/init.php';
  
  $employee = new Employee();
  $training = new Training();
  $trainingRecord = new TrainingRecord();
  
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Employee Training Record</title>
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
if (isset($_GET['updateTrainingRecord'])) {
	echo "<p>Successfully Completed Training</p>";
} // end if
?>
<!-- end .createMessage --></div>

<?php 
if (isset($_GET['trainingCompleted'])) {
			$trainingRecord->updateTrainingRecord($_GET['trainingCompletionId'],$_GET['employeeId'],$_GET['trainingId']);
} // end if
?>


    <?php 
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    <div class="clr"></div>   
    
    <?php if ($trainingRecord->setViewAuthEmployee($_GET['employeeId'])) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
         <?php $employee->setEmployeeValues($_GET['employeeId']); ?>
        <h2>Employee Training Record - <?php echo $employee->getEmployeeFirstName() . " " . $employee->getEmployeeLastName(); ?>  <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">Update training by clicking the Completion Status for the desired training.</p>
        
		<div class="employeeListContainer"><!-- Holds all employee list information -->
        
		<div class="employeeListHeader">
		<div class="employeeListHeaderItems">
        <p>Completion Status</p>
        <!-- end .employeeListHeaderItems"--></div>
		<div class="employeeListHeaderItems">
        <p>Last Name</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>First Name</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>Training Title</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>Schedule Date</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>Completion Date</p>
        <!-- end .employeeListHeaderItems"--></div>
		<!-- end .employeeListHeader --></div>
		<div class="clr"></div>
		
        <?php
// from selection of name in right training menu
if (isset($_GET['selectIndividualEmployee_x']) && isset($_GET['selectIndividualEmployee_y'])) {
	$trainingRecord->readTrainingRecord($_GET['employeeId']);
} // end if selectIndividualemployee
else { // read from start up list (like click on the link)
// displays listing of employees in the system
        $trainingRecord->readTrainingRecord($_GET['employeeId']);
} // end else
?>
        
        <!-- end .employeeListContainer --></div>
        
        <?php } // end setViewAuthEmployee ?>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>