<?php
  // require configuration file
  require_once 'config/init.php';
  
  $safetrack = new SafeTrack();
  $manager = new Manager();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Edit Safety Tracker Discrepancy</title>
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
if (isset($_GET['safetrackUpdated'])) {
	echo "<p>Safety Tracker Discrepancy Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateSafeTrack_x']) && (isset($_POST['updateSafeTrack_y']))) {
	$safetrack->updateSafeTrack($_GET['safetrackId']);
	} // end if
	
	?>
    
    
    <?php 
	// display safetrack menu
	include 'inc/safetrack_menu.inc.php'; 
	?>
    <div class="clr"></div>
    
    
    
   
   <?php $safetrack->setSafeTrackValues($_GET['safetrackId']); ?>
        
        
        <?php if ($safetrack->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
  
        <form method="post" action="edit_selected_safetrack.php?safetrackId=<?php echo $safetrack->getSafeTrackId(); ?>"  enctype="multipart/form-data" class="generalform">
        <h3>Safety Tracker Discrepancy Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="safetrackTitle" class="text" value="<?php echo $safetrack->getSafeTrackTitle(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a safetrack title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $safetrack->displaySafeTrackCategoryEditSelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $safetrack->displayManagerDepartmentEditSafeTrackSelect(); ?>
        </li>
       
        <li><label for="Description">Description:</label>
        	<textarea name="safetrackDescription"><?php echo $safetrack->getSafeTrackDescription(); ?></textarea>
        </li>
        <li><label for="Action">Action Plan:</label>
        	<textarea name="safetrackAction"><?php echo $safetrack->getSafeTrackAction(); ?></textarea>
        </li>
          <div class="clr"></div>  
        <li><label for="AfterPic">After Fix Image:</label>
        	<input type="file" name="safetrackAfterPic">
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateSafeTrack" class="submit" src="images/edit_safetrack_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

		<div class="right">
        <?php if ($safetrack->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
        <?php include 'inc/safetrack_submenu.inc.php'; ?>
        <?php } // end getViewAuth ?>
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