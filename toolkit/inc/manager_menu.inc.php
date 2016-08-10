<?php // if no department, do not display manager menu
if ($warning->detectDepartment() == true) {
?>

<div class="manager_menu">

<ul>
<li><a href="manager.php"><img src="images/user_go.png" alt="Manager List" />Manager List</a></li>
<?php
// create manager object and display these options only for managers with a role of '3 or below'
		$manager = new Manager();
		if($manager->getManagerRole() <= '2') { // all=1 manager=2 asst. manager=3 
?>

<li><a href="add_manager.php"><img src="images/user_add.png" alt="Add Manager" />Add Manager</a></li>
<?php } // end if managerRole ?>
<li><a href="edit_manager.php"><img src="images/user_edit.png" alt="Edit Manager" />Edit Manager</a></li>
<li><a href="delete_manager.php"><img src="images/user_delete.png" alt="Delete Manager" />Delete Manager</a></li>
</ul>

<!-- end .manager_menu --></div>

<?php } // end if
else {
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='department_category.php'>department</a> for your account to view the manager menu.</p></div>";
} // end else 
?>