<?php // retun values for either display warning or menu items
if ($warning->detectProjectCategory() == true) {
	?>

<div class="project_menu">
<ul>
<li><a href="projects.php"><img src="images/project_go.png" alt="Project List" />Project List</a></li>
<li><a href="add_projects.php"><img src="images/project_add.png" alt="Add Project" />Add Project</a></li>
<li><a href="edit_projects.php"><img src="images/project_edit.png" alt="Edit Project" />Edit Project</a></li>
<li><a href="delete_projects.php"><img src="images/project_delete.png" alt="Delete Project" />Delete Project</a></li>
</ul>
<div class="search_bar">
<form method="post" action="search_projects.php">
<input type="text" name="searchProjects" value="...search by project title" onClick="javascript: this.value='';">
<input type="image" name="goButton" src="images/search.png">
</form>
<!-- end .search_bar --></div>

<!-- end .project_menu --></div>

<?php } // end if 
else { // show warning, not menu
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='project_category.php'>project category</a> for your account.</p></div>";
} // end else
?>