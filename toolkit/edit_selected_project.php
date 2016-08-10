<?php
  // require configuration file
  require_once 'config/init.php';
  
  $project = new Projects();
  $manager = new Manager();
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
if (isset($_GET['projectUpdated'])) {
	echo "<p>Project Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateProject_x']) && (isset($_POST['updateProject_y']))) {
	$project->updateProject($_GET['projectId']);
	} // end if
	
	?>
    
    
    <?php 
	// display project menu
	include 'inc/projects_menu.inc.php'; 
	?>
    <div class="clr"></div>
    
    
    
   
   <?php $project->setProjectValues($_GET['projectId']); ?>
        
        
        <?php if ($project->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
  
        <form method="post" action="edit_selected_project.php?projectId=<?php echo $project->getProjectId(); ?>"  class="generalform">
        <h3>Project Information</h3>
        <ol>
        <li><label for="Title">Title:</label>
          <span id="sprytextfield1">
          <input type="text" name="projectTitle" class="text" value="<?php echo $project->getProjectTitle(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a project title.</span></span>
        </li>
       
        <li><label for="Category">Category:</label>
          <?php $project->displayProjectCategoryEditSelect(); ?>
          <div class="clr"></div>
        </li>
        
        <li><label for="Department">Department:</label>
          	<?php $project->displayManagerDepartmentEditProjectSelect(); ?>
        </li>
        
        <li><label for="Create Date">Create Date:</label>
          <span id="sprytextfield2">
          <input type="date" name="projectCreateDate" class="text" value="<?php echo $project->getProjectCreateDateEdit(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a create date.</span></span>
        </li>
       
        <li><label for="Description">Description:</label>
        	<textarea name="projectDescription"><?php echo $project->getProjectDescription(); ?></textarea>
        </li>
          <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateProject" class="submit" src="images/edit_project_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

		<div class="right">
        <?php if ($project->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
        <?php include 'inc/projects_submenu.inc.php'; ?>
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