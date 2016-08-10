<?php
  // require configuration file
  require_once 'config/init.php';
  
  $training = new Training();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Edit Training</title>
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
	if (isset($_POST['selectTraining_x']) && (isset($_POST['selectTraining_y']))) {
	$training->updateTraining('$_GET[trainingId]');
	} // end if
	
	?>
    
    
    <?php 
	
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    <div class="clr"></div>
    <h2>Edit Training</h2> 
    <p>Edit training information by selecting the training title.</p>
    
    <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="edit_training.php">
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
	   $training->trainingSelectDisplay('edit_selected_training.php');
	   ?>


		<!-- end .trainingListContainer --></div>
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>