<?php
  // require configuration file
  require_once 'config/init.php';
  
  $employee = new Employee();
  $manager = new Manager();
  $jobtitle = new JobTitle();
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
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
if (isset($_GET['employeeUpdated'])) {
	echo "<p>Employee Successfully Updated</p>";
} // end if
?>
<!-- end .createMessage --></div>
        
    
    
    <?php
	if (isset($_POST['updateEmployee_x']) && (isset($_POST['updateEmployee_y']))) {
	$employee->updateEmployee($_GET['employeeId']);
	} // end if
	
	?>
    
    
    <?php 
	// display employee menu
	include 'inc/employee_menu.inc.php'; 
	?>
    <div class="clr"></div>
    
    
    
   
   <?php $employee->setEmployeeValues($_GET['employeeId']); ?>
        
        
        <?php if ($employee->getViewAuth()) // if get value is not part of account, do not allow view (true to view, false fo no)
		 { ?>
        
        <div class="left">
  
        <form method="post" action="edit_selected_employee.php?employeeId=<?php echo $employee->getEmployeeId(); ?>"  class="generalform">
        <h3>Employee Information</h3>
        <ol>
        <li><label for="Employee ID">Employee ID #:</label>
          <span id="sprytextfield1">
          <input type="text" name="employeeNumber" class="text" value="<?php echo $employee->getEmployeeNumber(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter an employee id number.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
        </li>
        
        <li><label for="Employee First Name">First Name:</label>
          <span id="sprytextfield2">
          <input type="text" name="employeeFirstName" class="text" value="<?php echo $employee->getEmployeeFirstName(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a first name.</span></span>
        </li>
        <li><label for="Employee Last Name">Last Name:</label>
          <span id="sprytextfield3">
          <input type="text" name="employeeLastName" class="text" value="<?php echo $employee->getEmployeeLastName(); ?>">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a last name.</span></span>
         </li>
         <li><label for="Employee Email">Email Address:</label>
           <span id="sprytextfield4">
           <input type="text" name="employeeEmail" class="text" value="<?php echo $employee->getEmployeeEmail(); ?>">
           <div class="clr"></div>
			<span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Employee Contact Phone">Phone Number:</label>
           <span id="sprytextfield5">
           <input type="text" name="employeeContactPhone" class="text" value="<?php echo $employee->getEmployeeContactPhone(); ?>">
           <div class="clr"></div>
           <span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Employee Address">Street Address:</label>
           <span id="sprytextfield6">
           <input type="text" name="employeeAddress" class="text" value="<?php echo $employee->getEmployeeAddress(); ?>">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a street address.</span></span>
         </li>
         <li><label for="Employee City">City:</label>
           <span id="sprytextfield7">
           <input type="text" name="employeeCity" class="text" value="<?php echo $employee->getEmployeeCity(); ?>">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a city.</span></span>
         </li>
         <li>
         <label for="Employee State">State:</label>
         <?php $employee->displayEmployeeStateEditSelect($_GET['employeeId']); ?>
         </li>
         <li><label for="Employee Zip">Zip Code:</label>
           <span id="sprytextfield9">
           <input type="text" name="employeeZip" class="text" value="<?php echo $employee->getEmployeeZip(); ?>">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a zip code.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Employee Hire Date">Hire Date:</label>
           <span id="sprytextfield10">
           <input type="date" name="employeeHireDate" class="text" value="<?php echo $employee->getEmployeeHireDateEdit(); ?>">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter hire date. (ex. 1970-01-31)</span></span>
         </li>
         <li><label for="Employee Date of Birth">Date of Birth:</label>
           <span id="sprytextfield11">
           <input type="date" name="employeeDOB" class="text" value="<?php echo $employee->getEmployeeDOBEdit(); ?>">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter date of birth. (ex. 1970-01-31)</span></span>
         </li>
         
          <div class="clr"></div>
         <h3>Employee Job Data</h3>
         
         <li><label for="Employee Department">Department:</label>
         <?php $manager->displayManagerDepartmentEditSelect(); ?>
         
         </li>
         <li><label for="Employee Job Title">Job Title:</label>
           <?php $jobtitle->displayJobTitleEditSelect($_GET['employeeId']); ?>
         </li>
         <li><label for="Employee Shift">Shift:</label>
           <span id="spryselect3">
           <select name="employeeShift">
             <option value="Day" <?php if ($employee->getEmployeeShift() == 'Day') echo "selected"; ?>>Day</option>
             <option value="Evening" <?php if ($employee->getEmployeeShift() == 'Evening') echo "selected"; ?>>Evening</option>
             <option value="Night" <?php if ($employee->getEmployeeShift() == 'Night') echo "selected"; ?>>Night</option>
           </select>
           <div class="clr"></div>
           <span class="selectRequiredMsg">Please select an item.</span></span>
         </li>
         <li><label for="Employee Wage">Hourly Wage:</label>
           <span id="sprytextfield12">
           <input type="text" name="employeeWage" class="text" value="<?php echo $employee->getEmployeeWage(); ?>">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Enter a hourly wage.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         
         
           <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="updateEmployee" class="submit" src="images/edit_employee_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>
    
    <?php } // end getViewAuth ?>

		<div class="right">
        <?php include 'inc/employee_submenu.inc.php'; ?>
        <!-- end .right --></div>

    <!-- end .body_resize --></div>
    <!-- end .body --></div>
 
 <div class="clr"></div>
 
<?php include 'inc/footer.inc.php'; ?>
 
  <!-- end .main --></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {useCharacterMasking:true});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {isRequired:false});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "phone_number", {isRequired:false, useCharacterMasking:true, format:"phone_custom", pattern:"000-000-0000"});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "zip_code", {useCharacterMasking:true, format:"zip_custom", pattern:"00000"});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "currency", {useCharacterMasking:true});
</script>
</body>
</html>