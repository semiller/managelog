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
<title>Manage Log | Edit Employees</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>
<body>
<div class="main">
  
<?php include 'inc/header.inc.php'; ?>
<?php include 'inc/menu.inc.php'; ?>
  
  <div class="body">
    <div class="body_resize">
    
    <?php
	if (isset($_POST['selectEmployee_x']) && (isset($_POST['selectEmployee_y']))) {
	$employee->updateEmployee('$_GET[employeeId]');
	} // end if
	
	?>
    
    
    <?php 
	// display employee menu
	include 'inc/employee_menu.inc.php'; 
	?>
    <div class="clr"></div>
    <h2>Edit Employee</h2>
    <p>Edit employee information by selecting their ID number.</p>
        
        <div class="sortForm">
        <div class="sortFormContent">
        <form method="post" action="edit_employee.php">
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
        
       <?php //$employee->selectUpdateEmployee('$_GET[employeeId]'); __autoload(
	   $employee->employeeSelectDisplay('edit_selected_employee.php');
	   ?>


		<!-- end .employeeListContainer --></div>
    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
</body>
</html>