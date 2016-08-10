<?php
  // require configuration file
  require_once 'config/init.php';
  
  $journal = new Journal();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Journal</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

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
	if (isset($_GET['markProjectComplete'])) {
	echo "<p>Project Successfully Updated</p>";
	} // end if
	?>
<!-- end .createMessage --></div>

	<?php
		if(isset($_GET['markProjectComplete'])) {
			$project->updateProjectComplete($_GET['projectId']);
		} // end if markProjectComplete
	?>

    <?php 
	// display project menu
	$warning->detectManager();
	include 'inc/journal_menu.inc.php'; 
	?>
    
    <div class="clr"></div>   
        <h2>Journal Listing <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">All journal items are listed below.  Click on journal title to view more details.</p>
        
        
        <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="journal.php">
        <select name="sortJournal">
        <option></option>
        <option value="journalTitle">Title</option>
        <option value="journalCategory">Category</option>
        <option value="journalDepartment">Department</option>
        <option value="journalSubmittedBy">Submitted By</option>
        <option value="journalDate">Create Date</option>
        </select>
        <input type="image" name="sortResults" class="submit" src="images/sort_results_btn.png">
        </form>
        </div>
        <!-- end .sortForm --></div>
        <div class="clr"></div>
        
		<div class="journalListContainer"><!-- Holds all project list information -->
        
		<div class="journalListHeader">
		<div class="journalListHeaderItems">
        <p>Title</p>
        <!-- end .journalListHeaderItems"--></div>
		<div class="journalListHeaderItems">
        <p>Category</p>
        <!-- end .journalListHeaderItems"--></div>
        <div class="journalListHeaderItems">
        <p>Department</p>
        <!-- end .journalListHeaderItems"--></div>
        <div class="journalListHeaderItems">
        <p>Submitted By</p>
        <!-- end .journalListHeaderItems"--></div>
        <div class="journalListHeaderItems">
        <p>Create Date</p>
        <!-- end .journalListHeaderItems"--></div>
        <div class="journalListHeaderItems">
        <p>Notes</p>
        <!-- end .journalListHeaderItems"--></div>
		<!-- end .journalListHeader --></div>
		<div class="clr"></div>
		
		
		<?php
		// displays listing of journal entries in the system
        $journal->journalSelectDisplay('journal_profile.php');
		?>
        
        <!-- end .projectListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>