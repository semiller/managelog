<?php
  // require configuration file
  require_once 'config/init.php';
  
  $training = new Training();
  $trainingRecord = new TrainingRecord();
  $manager = new Manager();
  $employee = new Employee();
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
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
if (isset($_GET['trainingUpdated'])) {
	echo "<p>Training Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateTraining_x']) && (isset($_POST['updateTraining_y']))) {
	$training->updateTraining($_GET['trainingId']);
	} // end if
	
	?>
    
    
    <?php 
	
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    <div class="clr"></div>
    
    
    
   
   <?php $training->setTrainingValues($_GET['trainingId']); ?>
        
        
        <?php if ($training->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
  
        <form method="post" action="edit_selected_training.php?trainingId=<?php echo $training->getTrainingId(); ?>"  class="generalform">
        <h3>Training Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="trainingTitle" class="text" value="<?php echo $training->getTrainingTitle(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a training title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $training->displayTrainingCategoryEditSelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $training->displayManagerDepartmentEditTrainingSelect(); ?>
        </li>
  
        <li><label for="Conducted By">Conducted By:</label>
          <span id="spryselect3">
          <?php $training->displayTrainingConductedByEditSelect(); ?>
          <div class="clr"></div>
          <span class="selectRequiredMsg">Please select an item.</span></span>
        </li>
        
        <li><label for="Schedule Date">Schedule Date:</label>
          <span id="sprytextfield2">
          <input type="date" name="trainingScheduleDate" class="text" value="<?php echo $training->getTrainingScheduleDateEdit(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a schedule date. (ex. 1970-01-31)</span></span>
        </li>
        
      
        
        <li><label for="Description">Description:</label>
        	<textarea name="trainingDescription"><?php echo $training->getTrainingDescription(); ?></textarea>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateTraining" class="submit" src="images/edit_training_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

		<div class="right">
        <?php if ($training->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
        <?php include 'inc/training_submenu.inc.php'; ?>
        <?php } // end getViewAuth ?>
        <!-- end .right --></div>

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");

var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");

</script>
</body>
</html>