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
<title>Manage Log | Delete Journal</title>
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
if (isset($_GET['journalDeleted'])) {
	echo "<p>Journal Successfully Deleted</p>";
	$journal->deleteJournal($_GET['journalId']);
} // end if
?>
<!-- end .createMessage --></div>    

    <?php 
	// display journal menu
	include 'inc/journal_menu.inc.php'; 
	?>
    <div class="clr"></div>   
        <h2>Delete Journal</h2>
        <p>Delete journal by selecting a journal title.</p>
        
		<div class="journalListContainer"><!-- Holds all journal list information -->
        
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
        <p>Date</p>
        <!-- end .journalListHeaderItems"--></div>
        <div class="journalListHeaderItems">
        <p>Notes</p>
        <!-- end .journalListHeaderItems"--></div>
		<!-- end .journalListHeader --></div>
		<div class="clr"></div>
		
		
		
		<?php
		// displays listing of journal in the system
        $journal->deleteJournalList();
		?>
        
        <!-- end .journalListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>