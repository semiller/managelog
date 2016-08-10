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
<title>Manage Log | Training Profile</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

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
         
    <?php 
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
		<?php
		if(isset($_GET['trainingId'])) { // if trainingId is set
			// create Training object  
			$training = new Training();
			// use GET to get training information from Training class
			$training->setTrainingValues($_GET['trainingId']);
		?>
        
        <?php if ($training->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        
        <div class="left">
        
        <!-- make link for editing and deleting this employee -->
        <h3>Training Information <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h3>
        <div class="profile_display">
        <ol>
        <li><label>Title:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingTitle(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Category:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingCategory(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Department:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingDepartment(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Conducted By:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingConductedBy(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Schedule Date:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingScheduleDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Completion Status:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingAllTrainedDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Description:</label>
        <div class="profile_data">
        <?php echo $training->getTrainingDescription(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li class="buttons">
        <!-- button to go to edit page for this employee -->
        <form method="post" action="edit_selected_training.php?trainingId=<?php echo $training->getTrainingId(); ?>">
        <input type="image" class="btn" name="editTraining" src="images/edit_training_btn.png">
        </form>
        </li>
        <div class="clr"></div>
        </ol>
        <!-- end .profile_display --></div>
 
 		<!-- end .left --></div>
        
        <?php } // end getViewAuth ?>
        
		<?php	
		} // end if GET is set
		?>
        
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

</body>
</html>