<?php
  // require configuration file
  require_once 'config/init.php';
  
  $journal = new Journal();
  $manager = new Manager();
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
if (isset($_GET['journalUpdated'])) {
	echo "<p>Journal Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateJournal_x']) && (isset($_POST['updateJournal_y']))) {
	$journal->updateJournal($_GET['journalId']);
	} // end if
	
	?>
    
    
    <?php 
	// display journal menu
	include 'inc/journal_menu.inc.php'; 
	?>
    <div class="clr"></div>
    
    
    
   
   <?php $journal->setJournalValues($_GET['journalId']); ?>
        
        
        <?php if ($journal->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
  
        <form method="post" action="edit_selected_journal.php?journalId=<?php echo $journal->getJournalId(); ?>"  class="generalform">
        <h3>Journal Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="journalTitle" class="text" value="<?php echo $journal->getJournalTitle(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a journal title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $journal->displayJournalCategoryEditSelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $journal->displayManagerDepartmentEditJournalSelect(); ?>
        </li>
        
        <li><label for="Date">Date:</label>
          <span id="sprytextfield2">
          <input type="date" name="journalDate" class="text" value="<?php echo $journal->getJournalDateEdit(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a date.</span></span>
        </li>
       
        <li><label for="Notes">Notes:</label>
        	<textarea name="journalNotes"><?php echo $journal->getJournalNotes(); ?></textarea>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateJournal" class="submit" src="images/edit_journal_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

		<div class="right">
        <?php if ($journal->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
        <?php include 'inc/journal_submenu.inc.php'; ?>
        <?php } // end getViewAuth ?>
        <!-- end .right --></div>

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");

</script>
</body>
</html>