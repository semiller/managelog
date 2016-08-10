<div class="right_submenu">
<h3><?php echo $workorder->getWorkOrderTitle(); ?></h3>
<ul>	
<?php 
// if work order is already complete, do not display this link
if ($workorder->getWorkOrderCompletionDateMenu() == '0000-00-00') { ?>
<li><a href="workorders.php?markWorkOrderComplete=yes&workorderId=<?php echo $_GET['workorderId']; ?>" onClick="return confirm('Are you sure you want to mark this work order complete?')"><img src="images/accept.png" alt="Mark Complete" class="float_img" />Mark This Work Order Complete</a></li>
<?php } // end if work order not complete ?>
<li><a href="delete_workorders.php?workorderDeleted=yes&workorderId=<?php echo $_GET['workorderId']; ?>" onClick="return confirm('Are you sure you want to delete this work order?')"><img src="images/delete.png" alt="Delete Work Order" class="float_img" />Delete This Work Order</a></li>
</ul>
<div class="clr"></div>
<!-- end .right_submenu --></div>