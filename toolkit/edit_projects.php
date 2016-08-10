<?php
  // require configuration file
  require_once 'config/init.php';
  
  $project = new Projects();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Edit Project</title>
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
	if (isset($_POST['selectProject_x']) && (isset($_POST['selectProject_y']))) {
	$project->updateProject('$_GET[projectId]');
	} // end if
	
	?>
    
    
    <?php 
	// display project menu
	include 'inc/projects_menu.inc.php'; 
	?>
    <div class="clr"></div>
    <h2>Edit Project</h2>    
    <p>Edit project information by selecting the project title.</p>
    
    <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="edit_projects.php">
        <select name="sortProject">
        <option></option>
        <option value="projectTitle">Title</option>
        <option value="projectCategory">Category</option>
        <option value="projectDepartment">Department</option>
        <option value="projectSubmittedBy">Submitted By</option>
        <option value="projectCreateDate">Create Date</option>
        <option value="projectCompletionDate">Completion Date</option>
        </select>
        <input type="image" name="sortResults" class="submit" src="images/sort_results_btn.png">
        </form>
        </div>
        <!-- end .sortForm --></div>
        <div class="clr"></div>
    
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
	   $project->projectSelectDisplay('edit_selected_project.php');
	   ?>


		<!-- end .projectListContainer --></div>
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>