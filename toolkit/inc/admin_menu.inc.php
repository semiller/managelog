<div class="admin_menu">
<h3>Customization Menu</h3>
<ul>
<?php if ($_SESSION['managerDepartment'] == 'All') { // only for managers who oversee entire account ?>
<li><a href="department_category.php">Departments</a></li>
<?php } // end if ?>
<li><a href="manager.php">Managers</a></li>
<li><a href="training_category.php">Training Categories</a></li>
<li><a href="jobtitle_category.php">Job Titles</a></li>
<li><a href="project_category.php">Project Categories</a></li>
<li><a href="journal_category.php">Journal Categories</a></li>
<li><a href="workorder_category.php">Work Order Categories</a></li>
</ul>
<!-- end .admin_menu --></div>