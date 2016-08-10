<?php
  // require configuration file
  require_once 'config/init.php';
  
  $employee = new Employee();
  $warning = new Warnings();
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" > -->
<title>Manage Log | Employees</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />
<link href="css/print_report.css" rel="stylesheet" type="text/css" media="print" />

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

<!-- This div is deleted based on settimeout in jquery script -->
<div class="createMessage">
<?php 
if (isset($_GET['employeeAdded'])) {
	echo "<p>Employee Successfully Added</p>";
} // end if


if (isset($_GET['employeeUpdated'])) {
	echo "<p>Employee Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>


    <?php 
	// warning message for no departments
	$warning->detectDepartment();
	// warning message for no job titles
	$warning->detectJobtitle();
	// display employee menu
	include 'inc/employee_menu.inc.php'; 
	?>
    
    <div class="clr"></div>   
        <h2>Employee Listing <img src="images/printer.png" alt="Print Report" class="print_report_btn" onclick="window.print();return false;"></h2>
        <p class="directions">View employee profile and training records by selecting their ID number.</p>
        
        
        <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="employees.php">
        <select name="sortEmployee">
        <option></option>
        <option value="employeeNumber">ID</option>
        <option value="employeeLastName">Last Name</option>
        <option value="employeeFirstName">First Name</option>
        <option value="employeeHireDate">Hire Date</option>
        </select>
        <input type="image" name="sortResults" class="submit" src="images/sort_results_btn.png">
        </form>
        </div>
        <!-- end .sortForm --></div>
        <div class="clr"></div>
        
		<div class="employeeListContainer"><!-- Holds all employee list information -->
        
		<div class="employeeListHeader">
		<div class="employeeListHeaderItems">
        <p>ID #</p>
        <!-- end .employeeListHeaderItems"--></div>
		<div class="employeeListHeaderItems">
        <p>Last Name</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>First Name</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>Email</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>Phone</p>
        <!-- end .employeeListHeaderItems"--></div>
        <div class="employeeListHeaderItems">
        <p>Hire Date</p>
        <!-- end .employeeListHeaderItems"--></div>
		<!-- end .employeeListHeader --></div>
		<div class="clr"></div>
		
		
		<?php
		// displays listing of employees in the system
        $employee->employeeSelectDisplay('employee_profile.php');
		?>
        
        <!-- end .employeeListMain --></div>
        
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>