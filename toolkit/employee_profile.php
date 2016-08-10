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
<title>Manage Log | Employee Profile</title>

<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>

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
	// display employee menu
	include 'inc/employee_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
		<?php
		if(isset($_GET['employeeId'])) { // if employeeId is set
			// create Employee object  
			$employee = new Employee();
			// use GET to get employee information from Employee class
			$employee->setEmployeeValues($_GET['employeeId']);
		?>
        
        <?php if ($employee->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
        
        <!-- make link for editing and deleting this employee -->
        <h3>Employee Information<img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h3>
        <div class="profile_display">
        <ol>
        <li><label>Employee Id #:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeNumber(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Name:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeFirstName() . " " . $employee->getEmployeeLastName(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Email:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeEmail(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Phone:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeContactPhone(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Address:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeAddress() . "<br />" . $employee->getEmployeeCity() . ", " . $employee->getEmployeeState() . " " . $employee->getEmployeeZip(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Hire Date:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeHireDate(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Date of Birth:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeDOB(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        
        <h3>Employee Job Data</h3>
        
        <li><label>Department:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeDepartment(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Job Title:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeJobTitle(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Shift:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeShift(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li><label>Hourly Wage:</label>
        <div class="profile_data">
        <?php echo $employee->getEmployeeWage(); ?>
        <!-- end .profile_data --></div>
        </li>
        <div class="clr"></div>
        <li class="buttons">
        <!-- button to go to edit page for this employee -->
        <form method="post" action="edit_selected_employee.php?employeeId=<?php echo $employee->getEmployeeId(); ?>" style="float:left">
        <input type="image" class="btn" name="editEmployee" src="images/edit_employee_btn.png">
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
        <?php include 'inc/employee_submenu.inc.php'; ?>
        <!-- end .right --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>

</body>
</html>