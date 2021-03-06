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
<title>Manage Log | Search Journal</title>
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
	// display journal menu
	include 'inc/journal_menu.inc.php'; 
	?>
        
        <div class="clr"></div>   
        <h2>Journal Search <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">View journal information by selecting the journal title.</p>
        
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
	 if (isset($_POST['goButton_x']) && (isset($_POST['goButton_y']))) {
			$journal = new Journal();
	 		$journal->searchJournal($_POST['searchJournal']);
	 } // end if
	 ?>
	 
	<!-- end .journalListContainer --></div>
	 
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>