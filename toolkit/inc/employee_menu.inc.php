<?php // retun values for either display warning or menu items
if ($warning->detectJobTitle() == true) {
	?>

<div class="employee_menu">
<ul>
<li><a href="employees.php"><img src="images/user_go.png" alt="Employee List" />Employee List</a></li>
<li><a href="add_employee.php"><img src="images/user_add.png" alt="Add Employee" />Add Employee</a></li>
<li><a href="edit_employee.php"><img src="images/user_edit.png" alt="Edit Employee" />Edit Employee</a></li>
<li><a href="delete_employee.php"><img src="images/user_delete.png" alt="Delete Employee" />Delete Employee</a></li>
</ul>
<div class="search_bar">
<form method="post" action="search_employee.php">
<input type="text" name="searchEmployee" value="...search by last name" onClick="javascript: this.value='';">
<input type="image" name="goButton" src="images/search.png">
</form>
<!-- end .search_bar --></div>

<!-- end .employee_menu --></div>

<?php } // end if 
else { // show warning, not menu
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='jobtitle_category.php'>job title</a> for your account to add an employee.</p></div>";
} // end else
?>