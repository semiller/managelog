<?php
  // require configuration file
  require_once 'config/init.php';
  
  $safetrack = new SafeTrack();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Delete Safety Tracker Discrepancy</title>
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
if (isset($_GET['safetrackDeleted'])) {
	echo "<p>Safety Tracker Discrepancy Successfully Deleted</p>";
	$safetrack->deleteSafeTrack($_GET['safetrackId']);
} // end if
?>
<!-- end .createMessage --></div>    

    <?php 
	// display safetrack menu
	include 'inc/safetrack_menu.inc.php'; 
	?>
    <div class="clr"></div>   
        <h2>Delete Safety Tracker</h2>
        <p>Delete safety tracker discrepancy by selecting a safety tracker title.</p>
        
		<div class="safetrackListContainer"><!-- Holds all safetrack list information -->
        
		<div class="safetrackListHeader">
		<div class="safetrackListHeaderItems">
        <p>Title</p>
        <!-- end .safetrackListHeaderItems"--></div>
		<div class="safetrackListHeaderItems">
        <p>Category</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Department</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Submitted By</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Create Date</p>
        <!-- end .safetrackListHeaderItems"--></div>
        <div class="safetrackListHeaderItems">
        <p>Completion Status / Date</p>
        <!-- end .safetrackListHeaderItems"--></div>
		<!-- end .safetrackListHeader --></div>
		<div class="clr"></div>
		
		
		
		<?php
		// displays listing of safetracks in the system
        $safetrack->deleteSafeTrackList();
		?>
        
        <!-- end .safetrackListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>