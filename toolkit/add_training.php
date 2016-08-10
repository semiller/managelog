<?php
  // require configuration file
  require_once 'config/init.php';
  
  $training = new Training();
  $manager = new Manager();
  $employee = new Employee();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Add Training</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function(){	
	// THIS IS HOW TO REMOVE A MEESAGE AFTER A CERTAIN TIME PERIOD
	setTimeout('$(".createMessage").fadeOut(1500)',1500);
	// or just use hide() instead of fadeout
	
	// This is for the employee listing to select for training
	// this starts all employees checked for training (default setting)
	$("#allEmployees").attr('checked',true);
	
	// when #employeeList is clicked
	$("#employeeList").click(function() {
		// remove checked from #allEmployees
		$("#allEmployees").attr('checked',false);
		// remove employeeList checkbox
		$("#employeeList").hide();
		// check every employee.  manual deselect to remove
		$(".employeeId").attr('checked', false);
		// and display the employeeListContainer
		$(".employeeListContainer").show();
	});

	// when #allEmployees checkbox is clicked
	$("#allEmployees").click(function() {
		// remove checked from #employeeList
		$(".employeeId").attr('checked', false);
		// to reshow the employeeList checkbox when changed
		$("#employeeList").show();
		// and make it unchecked
		$("#employeeList").attr('checked',false);
		// and hide the employeeListContainer
		$(".employeeListContainer").hide();
	});
	
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
if (isset($_GET['trainingAdded'])) {
	echo "<p>Training Successfully Added</p>";
} // end if

?>
<!-- end .createMessage --></div>
   
    
    <?php
	if (isset($_POST['addTraining_x']) && (isset($_POST['addTraining_y']))) {
	$training->addTraining();
	} // end if
	
	?>
    
    
    <?php 
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
        <div class="left">
        
        <form method="post" action="add_training.php" class="generalform">
        <h3>Training Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="trainingTitle" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a training title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $training->displayTrainingCategorySelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $manager->displayManagerTrainingDepartmentSelect(); ?>
        </li>
        
        <li><label for="Employee List">Employee List</label>
        	<div class="checkbox">
        	<input type="checkbox" name="allEmployees" value="allEmployees" id="allEmployees" <?php if($manager->getManagerDepartment() == 'All') { echo "onclick='return false'"; } // this prevents 'All' from unclicking since this is the only given option ?> >All Employees (based on selected Department)<br>
            <?php // if manager department is not equal to all display listing of employees.  otherwise require 'all' manager to put in training for all select department employees
			if($manager->getManagerDepartment() != 'All') { ?>
            
            <input type="checkbox" name="employeeList" id="employeeList">Select / deselect employees for this training
            <?php } // end if not 'all' ?>
            
            <div class="employeeListContainer" style="display:none">
            <?php $employee->getEmployeeList(); ?>	
            <!-- end .employeeListContainer --></div>
            <!-- end .checkbox --></div>
        </li>
        
        <li><label for="Conducted By">Conducted By:</label>
          <span id="spryselect3">
          <?php $training->displayTrainingConductedBySelect(); ?>
          <div class="clr"></div>
          <span class="selectRequiredMsg">Please select an item.</span></span>
        </li>
        
        <li><label for="Schedule Date">Schedule Date:</label>
          <span id="sprytextfield2">
          <input type="date" name="trainingScheduleDate" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a schedule date. (ex. 1970-01-31)</span></span>
        </li>
        
        <li><label for="Description">Description:</label>
        	<textarea name="trainingDescription"></textarea>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addTraining" class="submit" src="images/add_training_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
        
    
    <div class="right">
 
    <!-- end .right --></div>

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>