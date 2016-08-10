<?php // retun values for either display warning or menu items
if ($warning->detectTrainingCategory() == false) {
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='training_category.php'>training category</a> for your account to view the training menu.</p></div>";
} // end if
elseif ($warning->detectEmployee() == false) {
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='employees.php'>employee</a> for your account to view the training menu.</p></div>";
	
} // end elseif
else { // display menu
	?>


<div class="training_menu">
<ul>
<li><a href="training.php"><img src="images/training_go.png" alt="Training List" />Training List</a></li>
<li><a href="add_training.php"><img src="images/training_add.png" alt="Add Training" />Add Training</a></li>
<li><a href="edit_training.php"><img src="images/training_edit.png" alt="Edit Training" />Edit Training</a></li>
<li><a href="delete_training.php"><img src="images/training_delete.png" alt="Delete Training" />Delete Training</a></li>
</ul>
<div class="search_bar">
<form method="post" action="search_training.php">
<input type="text" name="searchTraining" value="...search by training title" onClick="javascript: this.value='';">
<input type="image" name="goButton" src="images/search.png">
</form>
<!-- end .search_bar --></div>

<!-- end .training_menu --></div>

<?php } // end else ?>