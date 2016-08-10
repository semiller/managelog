<?php // retun values for either display warning or menu items
if ($warning->detectSafeTrackCategory() == false) {
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='safetrack_category.php'>safety tracker category</a> for your account to view the safety tracker menu.</p></div>";
} // end if
elseif ($warning->detectEmployee() == false) {
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='employees.php'>employee</a> for your account to view the safety tracker menu.</p></div>";
	
} // end elseif
else { // display menu
	?>


<div class="safetrack_menu">
<ul>
<li><a href="safetrack.php"><img src="images/safetrack_go.png" alt="Safety Tracker List" />Safety Tracker List</a></li>
<li><a href="add_safetrack.php"><img src="images/safetrack_add.png" alt="Add Discrepancy" />Add Discrepancy</a></li>
<li><a href="edit_safetrack.php"><img src="images/safetrack_edit.png" alt="Edit Discrepancy" />Edit Discrepancy</a></li>
<li><a href="delete_safetrack.php"><img src="images/safetrack_delete.png" alt="Delete Discrepany" />Delete Discrepancy</a></li>
</ul>
<div class="search_bar">
<form method="post" action="search_safetrack.php">
<input type="text" name="searchSafeTrack" value="...search by discrepancy" onClick="javascript: this.value='';">
<input type="image" name="goButton" src="images/search.png">
</form>
<!-- end .search_bar --></div>

<!-- end .safetrack_menu --></div>

<?php } // end else ?>