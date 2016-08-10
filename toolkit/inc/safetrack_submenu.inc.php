<div class="right_submenu">
<h3><?php echo $safetrack->getSafeTrackTitle(); ?></h3>
<ul>	
<li><a href="safetrack_profile.php?safetrackId=<?php echo $_GET['safetrackId']; ?>"><img src="images/safetrack_go.png" alt="" class="float_img" />View Discrepancy Details</a></li>
<?php 
// if safetrack is already complete, do not display this link
if ($safetrack->getSafeTrackCompletionDateMenu() == '0000-00-00') { ?>
<li><a href="safetrack.php?markSafeTrackComplete=yes&safetrackId=<?php echo $_GET['safetrackId']; ?>" onClick="return confirm('Are you sure you want to mark this discrepancy complete?')"><img src="images/accept.png" alt="Mark Complete" class="float_img" />Mark This Discrepancy Complete</a></li>
<?php } // end if safetrack not complete ?>
<li><a href="delete_safetrack.php?safetrackDeleted=yes&safetrackId=<?php echo $_GET['safetrackId']; ?>" onClick="return confirm('Are you sure you want to delete this discrepancy?')"><img src="images/delete.png" alt="Delete Discrepancy" class="float_img" />Delete This Discrepancy</a></li>
<li><a href="safetrack_alert.php?safetrackId=<?php echo $_GET['safetrackId']; ?>" target="_blank"><img src="images/printer.png" alt="Print Safety Alert" class="float_img" />Print Safety Alert</a></li>
</ul>
<div class="clr"></div>
<!-- end .right_submenu --></div>