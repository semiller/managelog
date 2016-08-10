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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<title>Manage Log | Add Employees</title>
<link href="css/desktop.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
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
	if (isset($_POST['addEmployee_x']) && (isset($_POST['addEmployee_y']))) {
		$employee->addEmployee();
	} // end if
	
	?>
    
    
    <?php 
	// display employee menu
	include 'inc/employee_menu.inc.php'; 
	?>
    <div class="clr"></div>
        
        <div class="left">
        
        <form method="post" action="add_employee.php" class="generalform">
        <h3>Employee Information</h3>
        <ol>
        <li><label for="Employee ID">Employee ID #:</label>
          <span id="sprytextfield1">
          <input type="text" name="employeeNumber" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter an employee id number.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
        </li>
        
        <li><label for="Employee First Name">First Name:</label>
          <span id="sprytextfield2">
          <input type="text" name="employeeFirstName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a first name.</span></span>
        </li>
        <li><label for="Employee Last Name">Last Name:</label>
          <span id="sprytextfield3">
          <input type="text" name="employeeLastName" class="text">
          <div class="clr"></div>
          <span class="textfieldRequiredMsg">Please enter a last name.</span></span>
         </li>
         <li><label for="Employee Email">Email Address:</label>
           <span id="sprytextfield4">
           <input type="text" name="employeeEmail" class="text">
           <div class="clr"></div>
			<span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Employee Contact Phone">Phone Number:</label>
           <span id="sprytextfield5">
           <input type="text" name="employeeContactPhone" class="text">
           <div class="clr"></div>
           <span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Employee Address">Street Address:</label>
           <span id="sprytextfield6">
           <input type="text" name="employeeAddress" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a street address.</span></span>
         </li>
         <li><label for="Employee City">City:</label>
           <span id="sprytextfield7">
           <input type="text" name="employeeCity" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a city.</span></span>
         </li>
         <li><label for="Employee State">State:</label>
         <select name="employeeState">
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
          </select>
         </li>
         <li><label for="Employee Zip">Zip Code:</label>
           <span id="sprytextfield9">
           <input type="text" name="employeeZip" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter a zip code.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
         <li><label for="Employee Hire Date">Hire Date:</label>
           <span id="sprytextfield10">
           <input type="date" name="employeeHireDate" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter hire date. (ex. 1970-01-31)</span></span>
         </li>
         <li><label for="Employee Date of Birth">Date of Birth:</label>
           <span id="sprytextfield11">
           <input type="date" name="employeeDOB" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Please enter date of birth. (ex. 1970-01-31)</span></span>
         </li>
         <div class="clr"></div>
         <h3>Employee Job Data</h3>
         
         <li><label for="Employee Department">Department:</label>
           <?php $manager->displayManagerDepartmentEditSelect(); ?>
         </li>
         <li><label for="Employee Job Title">Job Title:</label>
           <?php $jobtitle->displayJobTitleSelect(); ?>
         </li>
         <li><label for="Employee Shift">Shift:</label>
           <span id="spryselect3">
           <select name="employeeShift">
             <option value="Day">Day</option>
             <option value="Evening">Evening</option>
             <option value="Night">Night</option>
             <option value="Split">Split</option>
           </select>
           <div class="clr"></div>
           <span class="selectRequiredMsg">Please select an item.</span></span>
         </li>
         <li><label for="Employee Wage">Hourly Wage:</label>
           <span id="sprytextfield12">
           <input type="text" name="employeeWage" class="text">
           <div class="clr"></div>
           <span class="textfieldRequiredMsg">Enter a hourly wage.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span>
         </li>
           <div class="clr"></div>
        <li class="buttons">
        <input type="image" name="addEmployee" class="submit" src="images/add_employee_btn.png">
        </li>
        </ol>
        </form>

	<!-- end .left --></div>

		<div class="right">
        
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