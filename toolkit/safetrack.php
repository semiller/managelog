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
<title>Manage Log | Safety Tracker</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>

  <div class="body">
    <div class="body_resize">
    
    <?php
		if(isset($_GET['markSafeTrackComplete'])) {
			$safetrack->updateSafeTrackComplete($_GET['safetrackId']);
		} // end if markSafeTrackComplete
	?>
    

<?php include 'inc/safetrack_menu.inc.php'; ?>
<div class="clr"></div>
	<h2>Safety Tracker Listing <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
    <p class="directions">All safety tracker discrepancies are listed below.  Click on discrepancy title to view more details and mark complete.</p>
  
  <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="safetrack.php">
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
        <p>Completion Status/Date</p>
        <!-- end .safetrackListHeaderItems"--></div>
		<!-- end .safetrackListHeader --></div>
		<div class="clr"></div>
		
		
		<?php
		// displays listing of discrepancies in the system
        $safetrack->safetrackSelectDisplay('safetrack_profile.php');
		?>
        
        <!-- end .safetrackListMain --></div>
  
  
      
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>