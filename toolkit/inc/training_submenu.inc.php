<div class="right_submenu">
<h3><?php echo $training->getTrainingTitle(); ?></h3>
<ul>	
	
<li><a href="training.php?markAllTrainingComplete=yes&trainingId=<?php echo $_GET['trainingId']; ?>" onClick="return confirm('Are you sure you want to mark all training for this topic complete?')"><img src="images/accept.png" alt="Mark Complete" class="float_img" />Mark This Training Complete (all employees)</a></li>

<li><a href="training_record_list.php?trainingId=<?php echo $_GET['trainingId']; ?>"><img src="images/training_go.png" alt="View Training List" class="float_img" />View Scheduled Employees (current training)</a></li>
<li><a href="delete_training.php?trainingDeleted=yes&trainingId=<?php echo $_GET['trainingId']; ?>" onClick="return confirm('Are you sure you want to delete this training?')"><img src="images/delete.png" alt="Delete Training" class="float_img" />Delete This Training</a></li>
<li><a href="training_signin_sheet.php?trainingId=<?php echo $_GET['trainingId']; ?>" target="_blank"><img src="images/printer.png" alt="Print Sign In Sheet" class="float_img" />Print Sign In Sheet</a></li>
</ul>
<div class="clr"></div>

<div class="employeeTrainingSearchForm">
<h3>Select Employee Training Record</h3>
<form method="get" action="training_record.php">
<ol>
<li>
<label for="Employee Name">Employee Name:</label>
<?php 
$trainingRecord = new TrainingRecord(); 
$trainingRecord->displayTrainingEmployeeNameSelect(); 
?>
</li>
<li class="buttons">
<input type="image" name="selectIndividualEmployee" src="images/select_employee_btn.png" />
</li>
</ol>
</form>
<!-- end .employeeTrainingSearchForm --></div>
<!-- end .right_submenu --></div>