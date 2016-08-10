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
<title>Manage Log | Search Projects</title>
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
	// display project menu
	include 'inc/projects_menu.inc.php'; 
	?>
        
        <div class="clr"></div>   
        <h2>Project Search <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">View project information by selecting the project title.</p>
       
		<div class="projectListContainer"><!-- Holds all project list information -->
        
		<div class="projectListHeader">
		<div class="projectListHeaderItems">
        <p>Title</p>
        <!-- end .projectListHeaderItems"--></div>
		<div class="projectListHeaderItems">
        <p>Category</p>
        <!-- end .projectListHeaderItems"--></div>
        <div class="projectListHeaderItems">
        <p>Department</p>
        <!-- end .projectListHeaderItems"--></div>
        <div class="projectListHeaderItems">
        <p>Submitted By</p>
        <!-- end .projectListHeaderItems"--></div>
        <div class="projectListHeaderItems">
        <p>Create Date</p>
        <!-- end .projectListHeaderItems"--></div>
        <div class="projectListHeaderItems">
        <p>Completion Status / Date</p>
        <!-- end .projectListHeaderItems"--></div>
		<!-- end .projectListHeader --></div>
		<div class="clr"></div>
    
     <?php
	 if (isset($_POST['goButton_x']) && (isset($_POST['goButton_y']))) {
			$project = new Projects();
	 		$project->searchProjects($_POST['searchProjects']);
	 } // end if
	 ?>
	 
	<!-- end .projectListContainer --></div>
	 
      <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>