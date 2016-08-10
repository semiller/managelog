<?php // retun values for either display warning or menu items
if ($warning->detectWorkOrderCategory() == true) {
	?>

<div class="workorder_menu">
<ul>
<li><a href="workorders.php"><img src="images/workorder_go.png" alt="Work Order List" />Work Order List</a></li>
<li><a href="add_workorders.php"><img src="images/workorder_add.png" alt="Add Work Order" />Add Work Order</a></li>
<li><a href="edit_workorders.php"><img src="images/workorder_edit.png" alt="Edit Work Order" />Edit Work Order</a></li>
<li><a href="delete_workorders.php"><img src="images/workorder_delete.png" alt="Delete Work Order" />Delete Work Order</a></li>
</ul>
<div class="search_bar">
<form method="post" action="search_workorders.php">
<input type="text" name="searchWorkOrders" value="...search by work order title" onClick="javascript: this.value='';">
<input type="image" name="goButton" src="images/search.png">
</form>
<!-- end .search_bar --></div>

<!-- end .workorder_menu --></div>

<?php } // end if 
else { // show warning, not menu
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='workorder_category.php'>work order category</a> for your account.</p></div>";
} // end else
?>