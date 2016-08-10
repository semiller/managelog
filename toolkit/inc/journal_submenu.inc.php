<div class="right_submenu">
<h3><?php echo $journal->getJournalTitle(); ?></h3>
<ul>	
<li><a href="delete_journal.php?journalDeleted=yes&journalId=<?php echo $_GET['journalId']; ?>" onClick="return confirm('Are you sure you want to delete this journal entry?')"><img src="images/delete.png" alt="Delete Journal Entry" class="float_img" />Delete This Journal Entry</a></li>
</ul>
<div class="clr"></div>
<!-- end .right_submenu --></div>