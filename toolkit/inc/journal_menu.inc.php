<?php // retun values for either display warning or menu items
if ($warning->detectJournalCategory() == true) {
	?>

<div class="journal_menu">
<ul>
<li><a href="journal.php"><img src="images/journal_go.png" alt="Journal List" />Journal List</a></li>
<li><a href="add_journal.php"><img src="images/journal_add.png" alt="Add Entry" />Add Entry</a></li>
<li><a href="edit_journal.php"><img src="images/journal_edit.png" alt="Edit Entry" />Edit Entry</a></li>
<li><a href="delete_journal.php"><img src="images/journal_delete.png" alt="Delete Entry" />Delete Entry</a></li>
</ul>
<div class="search_bar">
<form method="post" action="search_journal.php">
<input type="text" name="searchJournal" value="...search by journal title" onClick="javascript: this.value='';">
<input type="image" name="goButton" src="images/search.png">
</form>
<!-- end .search_bar --></div>

<!-- end .journal_menu --></div>

<?php } // end if 
else { // show warning, not menu
	echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='journal_category.php'>journal category</a> for your account.</p></div>";
} // end else
?>