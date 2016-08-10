<?php
  // require configuration file
  require_once 'config/init.php';
  
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Work Order Profile</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){	
	// THIS IS HOW TO REMOVE A MEESAGE AFTER A CERTAIN TIME PERIOD
	setTimeout('$(".createMessage").fadeOut(1500)',1500);
	// or just use hide() instead of fadeout
});
</script>


</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
         
    <?php 
	// display project menu
	include 'inc/workorder_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
		<?php
		if(isset($_GET['workorderId'])) { // if projectId is set
			// create Work Order object  
			$workorder = new WorkOrder();
			// use GET to get work order information from Work Order class
			$workorder->setWorkOrderValues($_GET['workorderId']);
		?>
        
        <?php if ($workorder->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        
        <div class="left">
        
        <h3>Work Order Information<img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h3>
        <div class="profile_display">
        <ol>
        <li><label>Title:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderTitle(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Category:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderCategory(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Department:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderDepartment(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Submitted By:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderSubmittedBy(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Create Date:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderCreateDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Completion Status:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderProfileCompletionDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Description:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderDescription(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Priority:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderPriority(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Location:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderLocation(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Update Comments:</label>
        <div class="profile_data">
        <?php echo $workorder->getWorkOrderUpdateComments(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li class="buttons">
        <!-- button to go to edit page for this work order -->
        <form method="post" action="edit_selected_workorder.php?workorderId=<?php echo $workorder->getWorkOrderId(); ?>">
        <input type="image" class="btn" name="editWorkOrder" src="images/edit_workorder_btn.png">
        </form>
        </li>
        <div class="clr"></div>
        </ol>
        <!-- end .profile_display --></div>
 
 		<!-- end .left --></div>
        
        <?php } // end getViewAuth ?>
        
		<?php	
		} // end if GET is set
		?>
        
        <div class="right">
        
        	<?php if ($workorder->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 	{ ?>
   
    		<?php include 'inc/workorder_submenu.inc.php'; ?>
    		<?php } // end getViewAuth ?>
    	<!-- end .right --></div>
        
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>