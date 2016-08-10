<div class="right_submenu">
<h3>Employee Menu</h3>
<ul>
<li><a href="training_record.php?employeeId=<?php echo $employee->getEmployeeId(); ?>"><img src="images/training.png" alt="View Training Record" />View Training Record</a></li>
<li><a href="delete_employee.php?employeeDeleted=yes&employeeId=<?php echo $_GET['employeeId']; ?>" onClick="return confirm('Are you sure you want to delete this employee?')"><img src="images/delete.png" alt="Delete Employee" class="float_img" />Delete This Employee</a></li>
</ul>
<!-- end .right_submenu --></div>