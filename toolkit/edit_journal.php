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
<title>Manage Log | Edit Journal</title>
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
	if (isset($_POST['selectJournal_x']) && (isset($_POST['selectJournal_y']))) {
	$journal->updateJournal('$_GET[journalId]');
	} // end if
	
	?>
    
    
    <?php 
	// display journal menu
	include 'inc/journal_menu.inc.php'; 
	?>
    <div class="clr"></div>
    <h2>Edit Journal</h2>
    <p>Edit journal information by selecting the journal title.</p>
    
     <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="edit_journal.php">
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
	   $journal->journalSelectDisplay('edit_selected_journal.php');
	   ?>


		<!-- end .journalListContainer --></div>
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>