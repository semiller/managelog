<div class="right_submenu">
<h3>Customization Menu</h3>
<ul>
<?php if ($_SESSION['managerDepartment'] == 'All') { // only for managers who oversee entire account ?>
<li><a href="department_category.php"><img src="images/department.png" alt="Departments">Departments</a></li>
<?php } // end if ?>
<li><a href="manager.php"><img src="images/user.png" alt="Managers">Managers</a></li>
<li><a href="training_category.php"><img src="images/training.png" alt="Training Categories">Training Categories</a></li>
<li><a href="jobtitle_category.php"><img src="images/jobtitle.png" alt="Job Titles">Job Titles</a></li>
<li><a href="project_category.php"><img src="images/project.png" alt="Project Categories">Project Categories</a></li>
<li><a href="journal_category.php"><img src="images/journal.png" alt="Journal Categories">Journal Categories</a></li>
<li><a href="workorder_category.php"><img src="images/workorder.png" alt="Work Order Categories">Work Order Categories</a></li>
<li><a href="safetrack_category.php"><img src="images/safetrack.png" alt="Safety Tracker Categories">Safety Tracker Categories</a></li>
</ul>
<!-- end .right_submenu --></div>