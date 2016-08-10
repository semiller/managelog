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
<title>Manage Log | Safety Tracker Discrepancy Profile</title>
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
		if(isset($_GET['safetrackId'])) { // if safetrackId is set
			// create SafeTrack object  
			$safetrack = new SafeTrack();
			// use GET to get safetrack information from SafeTrack class
			$safetrack->setSafeTrackValues($_GET['safetrackId']);
		?>
        
         <?php 
	// display safetrack menu
	include 'inc/safetrack_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
        <?php if ($safetrack->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        
        <div class="left">
        
        <!-- make link for editing and deleting this safetrack -->
        <h3>Safety Tracker Discrepancy<img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h3>
        <div class="profile_display">
        <ol>
        <li><label>Title:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackTitle(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Category:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackCategory(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Department:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackDepartment(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Submitted By:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackSubmittedBy(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Create Date:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackCreateDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Completion Status:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackCompletionDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Description:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackDescription(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Action Plan:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackAction(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Before Pic:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackBeforePic(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>After Pic:</label>
        <div class="profile_data">
        <?php echo $safetrack->getSafeTrackAfterPic(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li class="buttons">
        <!-- button to go to edit page for this employee -->
        <form method="post" action="edit_selected_safetrack.php?safetrackId=<?php echo $safetrack->getSafeTrackId(); ?>">
        <input type="image" class="btn" name="editSafeTrack" src="images/edit_safetrack_btn.png">
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
        
        
        
        	<?php if ($safetrack->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
            <div class="right">
   			<?php include 'inc/safetrack_submenu.inc.php'; ?>
    		<!-- end .right --></div>
    		<?php } // end getViewAuth ?>
    	
        
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>