<?php
  // require configuration file
  require_once 'config/init.php';  
  
  $warning = new Warnings();
  $trainingRecord = new TrainingRecord();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Training | Sign In Sheet</title>

<link rel="stylesheet" href="css/paper_printing.css" type="text/css" />
<link rel="stylesheet" href="css/paper_printing_print.css" type="text/css" media="print" /> 

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
         <div class="paper_printing">
		<?php
		if(isset($_GET['trainingId'])) { // if trainingId is set
			// create Training object  
			$training = new Training();
			// use GET to get training information from Training class
			$training->setTrainingValues($_GET['trainingId']);
		?>
        
        <?php if ($training->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
       
        <form><input type="button" value=" Print this page " onclick="window.print();return false;" /></form> 
        <h2>Training: <?php echo $training->getTrainingTitle(); ?></h2>
        
        <p><span>Audience:</span> <?php echo $training->getTrainingDepartment(); ?></p>
        <p><span>Conducted By:</span> <?php echo $training->getTrainingConductedBy(); ?></p>
        <p><span>Schedule Date:</span> <?php echo $training->getTrainingScheduleDate(); ?></p>
        <hr>
     	<h3>Description</h3>
        <p><?php echo $training->getTrainingDescription(); ?></p>
        
        <h3>Employee List</h3>
        <?php $trainingRecord->readTrainingSignInSheet($_GET['trainingId']); ?>
		<div class="clr"></div>
        <?php } // end getViewAuth ?>
        
		<?php	
		} // end if GET is set
		?>
        
        <!-- end .paper_printing --></div>

</body>
</html>