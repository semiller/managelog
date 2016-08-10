<?php
  // require configuration file
  require_once 'config/init.php';
  
  $training = new Training();
  $trainingRecord = new TrainingRecord();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Training</title>
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
	if (isset($_GET['markAllTrainingComplete'])) {
	echo "<p>Training Successfully Updated</p>";
	} // end if
	?>
<!-- end .createMessage --></div>

	<?php
		if(isset($_GET['markAllTrainingComplete'])) {
			$trainingRecord->updateMarkAllTrainingComplete($_GET['trainingId']);
		} // end if markAllTrainingComplete
	?>

    <?php 
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    
    <div class="clr"></div>   
        <h2>Training List <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">All training sessions are listed below.  Click on training title to view more details and mark complete.</p>
        
        <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="training.php">
        <select name="sortTraining">
        <option></option>
        <option value="trainingTitle">Title</option>
        <option value="trainingCategory">Category</option>
        <option value="trainingDepartment">Department</option>
        <option value="trainingConductedBy">Conducted By</option>
        <option value="trainingScheduleDate">Schedule Date</option>
        <option value="trainingCompletionDate">Completion Date</option>
        </select>
        <input type="image" name="sortResults" class="submit" src="images/sort_results_btn.png">
        </form>
        </div>
        <!-- end .sortForm --></div>
        <div class="clr"></div>
        
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
		// displays listing of trainings in the system
        $training->trainingSelectDisplay('training_profile.php');
		?>
        
        <!-- end .trainingListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>