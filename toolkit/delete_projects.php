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
<title>Manage Log | Delete Project</title>
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
if (isset($_GET['projectDeleted'])) {
	echo "<p>Project Successfully Deleted</p>";
	$project->deleteProject($_GET['projectId']);
} // end if
?>
<!-- end .createMessage --></div>    

    <?php 
	// display project menu
	include 'inc/projects_menu.inc.php'; 
	?>
    <div class="clr"></div>   
        <h2>Delete Project</h2>
        <p>Delete project by selecting a project title.</p>
        
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
		// displays listing of projects in the system
        $project->deleteProjectList();
		?>
        
        <!-- end .projectListContainer --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>