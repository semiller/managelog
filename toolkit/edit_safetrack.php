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
<title>Manage Log | Edit Safety Tracker Discrepancy</title>
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
	if (isset($_POST['selectSafeTrack_x']) && (isset($_POST['selectSafeTrack_y']))) {
	$safetrack->updateSafeTrack('$_GET[safetrackId]');
	} // end if
	
	?>
    
    
    <?php 
	// display safetrack menu
	include 'inc/safetrack_menu.inc.php'; 
	?>
    <div class="clr"></div>
     <h2>Edit Safety Tracker</h2>   
    <p>Edit safety tracker information by selecting the safety tracker title.</p>
    
    	<div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="edit_safetrack.php">
        <select name="sortSafeTrack">
        <option></option>
        <option value="safetrackTitle">Title</option>
        <option value="safetrackCategory">Category</option>
        <option value="safetrackDepartment">Department</option>
        <option value="safetrackSubmittedBy">Submitted By</option>
        <option value="safetrackCreateDate">Create Date</option>
        <option value="safetrackCompletionDate">Completion Date</option>
        </select>
        <input type="image" name="sortResults" class="submit" src="images/sort_results_btn.png">
        </form>
        </div>
        <!-- end .sortForm --></div>
        <div class="clr"></div>
    
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
	   $safetrack->safetrackSelectDisplay('edit_selected_safetrack.php');
	   ?>


		<!-- end .safetrackListContainer --></div>
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>