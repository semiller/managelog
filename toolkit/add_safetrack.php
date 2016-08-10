<?php
  // require configuration file
  require_once 'config/init.php';
  
  $safetrack = new SafeTrack();
  $manager = new Manager();
  $employee = new Employee();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Add Safety Tracker Discrepancy</title>
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
	
	
	// THIS IS HOW TO REMOVE A MEESAGE AFTER A CERTAIN TIME PERIOD
	setTimeout('$(".createMessage").fadeOut(1500)',1500);
	// or just use hide() instead of fadeout
	
	// This is for the employee listing to select for training
	// default no employees selected
	$("#noEmployees").attr('checked',true);
	// when #noEmployees is clicked
	$("#noEmployees").click(function() {
		// remove checked from #allEmployees
		$("#allEmployees").attr('checked',false);
		// remove checked from #employeeList
		$("#employeeList").attr('checked',false);
		// to reshow the employeeList checkbox when changed
		$("#employeeList").show();
		// hide display of employeeListContainer
		$(".employeeListContainer").hide();
	});
	
	// when #employeeList is clicked
	$("#employeeList").click(function() {
		// remove checked from #allEmployees
		$("#allEmployees").attr('checked',false);
		// remove checked from #noEmployees
		$("#noEmployees").attr('checked',false);
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
		// remove checked from #noEmployees
		$("#noEmployees").attr('checked',false);
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
if (isset($_GET['safetrackAdded'])) {
	echo "<p>Safety Tracker Discrepancy Successfully Added</p>";
} // end if

?>
<!-- end .createMessage --></div>
   
    
    <?php
	if (isset($_POST['addSafeTrack_x']) && (isset($_POST['addSafeTrack_y']))) {
	$safetrack->addSafeTrack();
	} // end if
	
	?>
    
    
    <?php 
	// display safetrack menu
	include 'inc/safetrack_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
        <div class="left">
        
        <form method="post" action="add_safetrack.php" enctype="multipart/form-data" class="generalform">
        <h3>Safety Tracker Discrepancy Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="safetrackTitle" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a discrepancy title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $safetrack->displaySafeTrackCategorySelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $manager->displayManagerSafeTrackDepartmentSelect(); ?>
        </li>
        
        <li><label for="Description">Description:</label>
        	<textarea name="safetrackDescription"></textarea>
        </li>
          <div class="clr"></div>
        <li><label for="Action">Action Plan:</label>
        	<textarea name="safetrackAction"></textarea>
        </li>
          <div class="clr"></div>
         <li><label for="BeforePic">Before Fix Image:</label>
        	<input type="file" name="safetrackBeforePic">
        </li>
          <div class="clr"></div>
        <li><label for="Employee List">Add Training</label>
        	<div class="checkbox">
            <input type="checkbox" name="noEmployees" value="noEmployees" id="noEmployees">Do not add a training session<br>
        	<input type="checkbox" name="allEmployees" value="allEmployees" id="allEmployees">All Employees (based on selected Department)<br>
            <?php // if manager department is not equal to all display listing of employees.  otherwise require 'all' manager to put in training for all select department employees
			if($manager->getManagerDepartment() != 'All') { ?>
            
            <input type="checkbox" name="employeeList" id="employeeList">Select / deselect employees for this training
            <?php } // end if not 'all' ?>
            
            <div class="employeeListContainer" style="display:none">
            <?php $employee->getEmployeeList(); ?>	
            <!-- end .employeeListContainer --></div>
            <!-- end .checkbox --></div>
        </li>
          
        <li class="buttons">
        <input type="image" name="addSafeTrack" class="submit" src="images/add_safetrack_btn.png">
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
</script>
</body>
</html>