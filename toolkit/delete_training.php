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
<title>Manage Log | Delete Training</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

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
if (isset($_GET['trainingDeleted'])) {
	echo "<p>Training Successfully Deleted</p>";
	$training->deleteTraining($_GET['trainingId']);
} // end if
?>
<!-- end .createMessage --></div>    

    <?php 
	// display training menu
	include 'inc/training_menu.inc.php'; 
	?>
    <div class="clr"></div>   
        <h2>Delete Training</h2>
        <p>Delete training by selecting a training title.</p>
       
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
		// displays listing of training in the system
        $training->deleteTrainingList();
		?>
        
        <!-- end .trainingListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>