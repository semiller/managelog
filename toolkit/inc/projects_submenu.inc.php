<div class="right_submenu">
<h3><?php echo $project->getProjectTitle(); ?></h3>
<ul>	
<?php 
// if project is already complete, do not display this link
if ($project->getProjectCompletionDateMenu() == '0000-00-00') { ?>
<li><a href="projects.php?markProjectComplete=yes&projectId=<?php echo $_GET['projectId']; ?>" onClick="return confirm('Are you sure you want to mark this project complete?')"><img src="images/accept.png" alt="Mark Complete" class="float_img" />Mark This Project Complete</a></li>
<?php } // end if project not complete ?>
<li><a href="delete_projects.php?projectDeleted=yes&projectId=<?php echo $_GET['projectId']; ?>" onClick="return confirm('Are you sure you want to delete this project?')"><img src="images/delete.png" alt="Delete Project" class="float_img" />Delete This Project</a></li>
</ul>
<div class="clr"></div>
<!-- end .right_submenu --></div>