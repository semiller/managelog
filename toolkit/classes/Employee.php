<?php
class Employee extends DbConnect {
	
	// declare properties
	protected $db;
	
	protected $accountId;
	protected $managerDepartment;
	protected $managerRole;
	
	protected $employeeId;
	protected $employeeNumber;
	protected $employeeFirstName;
	protected $employeeLastName;
	protected $employeeEmail;
	protected $employeeContactPhone;
	protected $employeeAddress;
	protected $employeeCity;
	protected $employeeState;
	protected $employeeZip;
	protected $employeeHireDate;
	protected $employeeDOB;
	
	protected $employeeDepartment;
	protected $employeeJobTitle;
	protected $employeeShift;
	protected $employeeWage;
	
	protected $sortEmployee;
	
	protected $viewAuth = true; // determines whether get has been changed to unauthorized view
	
	public function __construct() {
		parent::__construct(); // use dbconnect to connect to database
		$this->accountId = $_SESSION['accountId']; // sets account id session
		$this->managerDepartment = $_SESSION['managerDepartment']; // this stores the session manager department for query use
		$this->managerRole = $_SESSION['managerRole']; // stores the managers role
	} // end construct
	
	
//********************CREATE EMPLOYEES********************//

public function addEmployee() {
		$result = $this->db->prepare("INSERT INTO employee(accountId,employeeNumber,employeeFirstName,employeeLastName,employeeEmail,employeeContactPhone,employeeAddress,employeeCity,employeeState,employeeZip,employeeHireDate,employeeDOB,employeeDepartment,employeeJobTitle,employeeShift,employeeWage) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$result->bind_param('ssssssssssssssss', $this->accountId, $employeeNumber, $employeeFirstName, $employeeLastName, $employeeEmail, $employeeContactPhone, $employeeAddress, $employeeCity, $employeeState, $employeeZip, $employeeHireDate, $employeeDOB, $employeeDepartment, $employeeJobTitle, $employeeShift, $employeeWage);


$employeeNumber = $_POST['employeeNumber'];
$employeeFirstName = $_POST['employeeFirstName'];
$employeeLastName = $_POST['employeeLastName'];
$employeeEmail = $_POST['employeeEmail'];
$employeeContactPhone = $_POST['employeeContactPhone'];
$employeeAddress = $_POST['employeeAddress'];
$employeeCity = $_POST['employeeCity'];
$employeeState = $_POST['employeeState'];
$employeeZip = $_POST['employeeZip'];
$employeeHireDate = $_POST['employeeHireDate'];
$employeeDOB = $_POST['employeeDOB'];

$employeeDepartment = $_POST['employeeDepartment'];
$employeeJobTitle = $_POST['employeeJobTitle'];
$employeeShift = $_POST['employeeShift'];
$employeeWage = $_POST['employeeWage'];

$result->execute();

header("Location: employees.php?employeeAdded=yes");

	} // end addEmployee method

//********************END CREATE EMPLOYEES********************//

//********************READ EMPLOYEES********************//
		
		// returns true or false based on $_GET values compared to account level
		public function getViewAuth() {
			return $this->viewAuth;
		} // end getViewAuth method
		
		
		public function setEmployeeValues($employeeId) {
			
			// employee id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM employee WHERE employeeId = '$employeeId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of employee information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected employee details.</p></div>";
		} //end if
		else {
			
			
		// get all employee database values based on ID number
		$result = $this->db->query("SELECT * FROM employee WHERE employeeId = '$employeeId'");
		$row = $result->fetch_assoc();
		// store property values
		$this->employeeId = $row['employeeId'];
		$this->employeeNumber = $row['employeeNumber'];
		$this->employeeFirstName = $row['employeeFirstName'];
		$this->employeeLastName = $row['employeeLastName'];
		$this->employeeEmail = $row['employeeEmail'];
		$this->employeeContactPhone = $row['employeeContactPhone'];
		$this->employeeAddress = $row['employeeAddress'];
		$this->employeeCity = $row['employeeCity'];
		$this->employeeState = $row['employeeState'];
		$this->employeeZip = $row['employeeZip'];
		$this->employeeHireDate = $row['employeeHireDate'];
		$this->employeeDOB = $row['employeeDOB'];
		$this->employeeDepartment = $row['employeeDepartment'];
		$this->employeeJobTitle = $row['employeeJobTitle'];
		$this->employeeShift = $row['employeeShift'];
		$this->employeeWage = $row['employeeWage'];
		
		} // end else authorized view
	} // end setEmployeeValues method
	
	public function getEmployeeId() {
		return $this->employeeId;
	} // end getEmployeeId method
	
	public function getEmployeeNumber() {
		return $this->employeeNumber;
	} // end getEmployeeNumber method
	
	public function getEmployeeFirstName() {
		return $this->employeeFirstName;
	} // end getEmployeeFirstName method
	
	public function getEmployeeLastName() {
		return $this->employeeLastName;
	} // end getEmployeeLastName method
	
	public function getEmployeeEmail() {
		return $this->employeeEmail;
	} // end getEmployeeEmail method
	
	public function getEmployeeContactPhone() {
		return $this->employeeContactPhone;
	} // end getEmployeeContactPhone method
	
	public function getEmployeeAddress() {
		return $this->employeeAddress;
	} // end getEmployeeAddress method
	
	public function getEmployeeCity() {
		return $this->employeeCity;
	} // end getEmployeeCity method
	
	public function getEmployeeState() {
		return $this->employeeState;
	} // end getEmployeeState method
	
	public function getEmployeeZip() {
		return $this->employeeZip;
	} // end getEmployeeZip method
	
	public function getEmployeeHireDate() {
			// date format for hire date
			$timestamp = strtotime($this->employeeHireDate);
			$this->employeeHireDate = date('F d, Y', $timestamp);
			return $this->employeeHireDate;
	} // end getEmployeeHireDate method
	
	public function getEmployeeHireDateEdit() {
		return $this->employeeHireDate;
	} // end getEmployeeHireDate method
	
	public function getEmployeeDOB() {
		// date format for dob
			$timestamp = strtotime($this->employeeDOB);
			$this->employeeDOB = date('F d, Y', $timestamp);
		return $this->employeeDOB;
	} // end getEmployeeDOB method
	
	public function getEmployeeDOBEdit() {
		return $this->employeeDOB;
	} // end getEmployeeDOB method
	
	public function getEmployeeDepartment() {
		return $this->employeeDepartment;
	} // end getEmployeeDeapartment method
	
	public function getEmployeeJobTitle() {
		return $this->employeeJobTitle;
	} // end getEmployeeJobTitle method
	
	public function getEmployeeShift() {
		return $this->employeeShift;
	} // end getEmployeeShift method
	
	public function getEmployeeWage() {
		return $this->employeeWage;
	} // end getEmployeeWage method
	
	
	// Get all id, first and last names to display checkboxes when adding training, work orders, etc...
	public function getEmployeeList() {
		if($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId' ORDER BY employeeLastName ASC");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId' AND employeeDepartment='$this->managerDepartment' ORDER BY employeeLastName ASC");
		}
		// This is how to echo db results horizontally
		$i = 0; // start at 0. display 3 names per row
		while ($row = $result->fetch_assoc()) {
			// if remainder is 0 make new line
			if($i % 3 == 0) {
				echo "<br>";
			}// end if
			echo "<div class='employeeTrainingNameWrapper'><div class='employeeTrainingNameSpacer'><input type='checkbox' name='employeeId[]' class='employeeId' value='" . $row['employeeId'] . "'>" . $row['employeeLastName'] . ", " . $row['employeeFirstName'] . "</div></div>";
			
			$i++; // increment $i by one
		} // end while
	} // end getEmployeeTrainingList

	
	
	public function employeeSelectDisplay($link) { // $link is href to carry GET
	
	// Sort Employee Selection - store value
	// stores initial value
	$this->sortEmployee = $_POST['sortEmployee'];
	// this is used for paging.  if sort value is set, get the value to keep the sortEmployee property loaded
	if (isset($_GET['sort'])) {
	$this->sortEmployee = $_GET['sort'];
	} // end if get page is set
	
	// START PAGING AND DISPLAYING OF EMPLOYEES  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL EMPLOYEES
		// QUERY EMPLOYEES DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT COUNT(employeeId) FROM employee WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(employeeId) FROM employee WHERE accountId='$this->accountId' AND employeeDepartment = '$this->managerDepartment'");
		} // end else if managerdepartment

		// IF RECORDS EXIST, USE PAGING AND DISPLAY RESULTS
		$row = $result->fetch_array();
		if ($row[0] != 0) { // not equal to zero means there are results
		$totrecords = $row[0];
		if (!isset($_GET['page']))
      		$thispage = 1;
   		else
      		$thispage = $_GET['page']; // get current page
   			$recordsperpage = 20; // # of records to display per page
			// calculation to dtermine how many pages are needed
   			$offset = ($thispage - 1) * $recordsperpage;
   			$totpages = ceil($totrecords / $recordsperpage);
		// END PAGING
	
	
		// IF SORT BY LAST NAME
		if ($this->sortEmployee == 'employeeLastName') { 
	
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' ORDER BY employeeLastName ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeLastName ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by employee last name
		
		// IF SORT BY FIRST NAME
		if ($this->sortEmployee == 'employeeFirstName') { 
	
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' ORDER BY employeeFirstName ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeFirstName ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by employee first name
		
		// IF SORT BY EMPLOYEE ID NUMBER
		if ($this->sortEmployee == 'employeeNumber') { 
	
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' ORDER BY employeeNumber ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeNumber ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by employee number
		
		// IF SORT BY HIRE DATE
		if ($this->sortEmployee == 'employeeHireDate') { 
	
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' ORDER BY employeeHireDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeHireDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by employee hire date
		
					
if ($this->sortEmployee == '' || !isset($this->sortEmployee)) {
//******* THIS IS THE DEFAULT IF NO SORTING SELECTION IS MADE - SORT BY TITLE *********// 
			
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' ORDER BY employeeLastName ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeLastName ASC LIMIT $offset,$recordsperpage");
			} // end else
} // end if sort employee is not set or blank
			
			
			
			
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->employeeId = $row['employeeId'];
			
			// date format for hire date
			$timestamp = strtotime($row['employeeHireDate']);
			$fmat_hire_date = date('F d, Y', $timestamp);
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			
			// Display for employee list
			echo "<div class='employeeListContent'>".
				 "<p><a href='$link?employeeId=$this->employeeId'>".$row['employeeNumber']."</a></p>".
				 "<p>".$row['employeeLastName']."</p>".
				 "<p>".$row['employeeFirstName']."</p>".
				 "<p>".$row['employeeEmail']."</p>".
				 "<p>".$row['employeeContactPhone']."</p>".
				 "<p>".$fmat_hire_date."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='employees.php?page=$page&sort=$this->sortEmployee'>Previous</a>";  // LINK FOR PREVIOUS PAGE
		} // END IF
		else {
			$prevpage = " ";
		} // END ELSE

		$bar = '';
		if ($totpages > 1) { 
			for($page = 1; $page <= $totpages; $page++) {
				if ($page ==$thispage) {
					$bar .= " $page ";
				} // END IF
		else {
		// SPACE BEFORE AND AFTER $PAGE IN THE LINK BELOW WILL SPACE OUT ALL THE LINKS
			$bar .= "<a href='employees.php?page=$page&sort=$this->sortEmployee'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='employees.php?page=$page&sort=$this->sortEmployee'>Next</a>";  // LINK FOR NEXT PAGE
		} // END IF
		else {
			$nextpage = " ";
		} // END ELSE

		// THIS ECHOES THE PAGING DISPLAY

		echo "
			<div class='paging'>
			$prevpage  $bar  $nextpage
			<!-- end .paging --></div>
			";
			} // END INITAL IF COUNT = 0 FOR PAGING
		// END PAGING
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Employee Data Available</p>";
		} // end else
		
	} // end employeeSelectDisplay method
	
	
	public function searchEmployee($searchEmployee) {
			// SEARCH RESULTS
			$foundEmployee = $searchEmployee;
			$words = explode(" ", $foundEmployee);
			$phrase = implode("%' AND employeeLastName LIKE '%", $words);

			// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeLastName LIKE '%$phrase%' ORDER BY employeeLastName DESC");
	} // end if
	else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' AND employeeLastName LIKE '%$phrase%' ORDER BY employeeLastName ASC");
	}
    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->employeeId = $row['employeeId'];
			
			// date format for hire date
			$timestamp = strtotime($row['employeeHireDate']);
			$fmat_hire_date = date('F d, Y', $timestamp);
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			
			// Display for employee list
			echo "<div class='employeeListContent'>".
				 "<p><a href='employee_profile.php?employeeId=$this->employeeId'>".$row['employeeNumber']."</a></p>".
				 "<p>".$row['employeeLastName']."</p>".
				 "<p>".$row['employeeFirstName']."</p>".
				 "<p>".$row['employeeEmail']."</p>".
				 "<p>".$row['employeeContactPhone']."</p>".
				 "<p>".$fmat_hire_date."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		} // end if
		else { // if no results display this
			echo "<p>No Employee Data Available</p>";
		} // end else
	} // end searchEmployee method
	
	// this is for the display of employee state on the edit_employee page
	public function displayEmployeeStateEditSelect($employeeId) {	
			$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeId='$this->employeeId'");
		
			echo "
				<select name='employeeState'>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['employeeState'] . "'"; 
				if ($this->employeeState == $row['employeeState']) echo "selected"; 
				
				echo ">". $row['employeeState'] . "</option>
				";
			} // end while
			echo "
				<option value='AL'>Alabama</option>
            <option value='AK'>Alaska</option>
            <option value='AZ'>Arizona</option>
            <option value='AR'>Arkansas</option>
            <option value='CA'>California</option>
            <option value='CO'>Colorado</option>
            <option value='CT'>Connecticut</option>
            <option value='DE'>Delaware</option>
            <option value='DC'>District Of Columbia</option>
            <option value='FL'>Florida</option>
            <option value='GA'>Georgia</option>
            <option value='HI'>Hawaii</option>
            <option value='ID'>Idaho</option>
            <option value='IL'>Illinois</option>
            <option value='IN'>Indiana</option>
            <option value='IA'>Iowa</option>
            <option value='KS'>Kansas</option>
            <option value='KY'>Kentucky</option>
            <option value='LA'>Louisiana</option>
            <option value='ME'>Maine</option>
            <option value='MD'>Maryland</option>
            <option value='MA'>Massachusetts</option>
            <option value='MI'>Michigan</option>
            <option value='MN'>Minnesota</option>
            <option value='MS'>Mississippi</option>
            <option value='MO'>Missouri</option>
            <option value='MT'>Montana</option>
            <option value='NE'>Nebraska</option>
            <option value='NV'>Nevada</option>
            <option value='NH'>New Hampshire</option>
            <option value='NJ'>New Jersey</option>
            <option value='NM'>New Mexico</option>
            <option value='NY'>New York</option>
            <option value='NC'>North Carolina</option>
            <option value='ND'>North Dakota</option>
            <option value='OH'>Ohio</option>
            <option value='OK'>Oklahoma</option>
            <option value='OR'>Oregon</option>
            <option value='PA'>Pennsylvania</option>
            <option value='RI'>Rhode Island</option>
            <option value='SC'>South Carolina</option>
            <option value='SD'>South Dakota</option>
            <option value='TN'>Tennessee</option>
            <option value='TX'>Texas</option>
            <option value='UT'>Utah</option>
            <option value='VT'>Vermont</option>
            <option value='VA'>Virginia</option>
            <option value='WA'>Washington</option>
            <option value='WV'>West Virginia</option>
            <option value='WI'>Wisconsin</option>
            <option value='WY'>Wyoming</option>
			</select>
			";
	} // end displayEmployeeStateEditSelect method
	
		
//********************END READ EMPLOYEES********************//

//********************UPDATE EMPLOYEES********************//
		
		public function updateEmployee($employeeId) {
		$result = $this->db->prepare("UPDATE employee SET employeeNumber=?,employeeFirstName=?,employeeLastName=?,employeeEmail=?,employeeContactPhone=?,employeeAddress=?,employeeCity=?,employeeState=?,employeeZip=?,employeeHireDate=?,employeeDOB=?,employeeDepartment=?,employeeJobTitle=?,employeeShift=?,employeeWage=? WHERE employeeId = '$employeeId'");

$result->bind_param('sssssssssssssss', $employeeNumber, $employeeFirstName, $employeeLastName, $employeeEmail, $employeeContactPhone, $employeeAddress, $employeeCity, $employeeState, $employeeZip, $employeeHireDate, $employeeDOB, $employeeDepartment, $employeeJobTitle, $employeeShift, $employeeWage);


$employeeNumber = $_POST['employeeNumber'];
$employeeFirstName = $_POST['employeeFirstName'];
$employeeLastName = $_POST['employeeLastName'];
$employeeEmail = $_POST['employeeEmail'];
$employeeContactPhone = $_POST['employeeContactPhone'];
$employeeAddress = $_POST['employeeAddress'];
$employeeCity = $_POST['employeeCity'];
$employeeState = $_POST['employeeState'];
$employeeZip = $_POST['employeeZip'];
$employeeHireDate = $_POST['employeeHireDate'];
$employeeDOB = $_POST['employeeDOB'];

$employeeDepartment = $_POST['employeeDepartment'];
$employeeJobTitle = $_POST['employeeJobTitle'];
$employeeShift = $_POST['employeeShift'];
$employeeWage = $_POST['employeeWage'];

$result->execute();

header("Location: employees.php?employeeUpdated=yes");
	} // end updateEmployee method

//********************END UPDATE EMPLOYEES********************//

//********************DELETE EMPLOYEES********************//

public function deleteEmployeeList() {
	
	// START PAGING AND DISPLAYING OF EMPLOYEES  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL EMPLOYEES
		// QUERY EMPLOYEES DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT COUNT(employeeId) FROM employee WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(employeeId) FROM employee WHERE accountId='$this->accountId' AND employeeDepartment = '$this->managerDepartment'");
		} // end else if managerdepartment

		// IF RECORDS EXIST, USE PAGING AND DISPLAY RESULTS
		$row = $result->fetch_array();
		if ($row[0] != 0) { // not equal to zero means there are results
		$totrecords = $row[0];
		if (!isset($_GET['page']))
      		$thispage = 1;
   		else
      		$thispage = $_GET['page']; // get current page
   			$recordsperpage = 20; // # of records to display per page
			// calculation to dtermine how many pages are needed
   			$offset = ($thispage - 1) * $recordsperpage;
   			$totpages = ceil($totrecords / $recordsperpage);
		// END PAGING
	
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' ORDER BY employeeLastName ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM employee WHERE accountId = '$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeLastName ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->employeeId = $row['employeeId'];
			
			// date format for hire date
			$timestamp = strtotime($row['employeeHireDate']);
			$fmat_hire_date = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			
			// Display for employee list
			echo "<div class='employeeListContent'>".
				 "<p><a href='delete_employee.php?employeeId=$this->employeeId&employeeDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this employee?\")'>"
				 .$row['employeeNumber']."</a></p>".
				 "<p>".$row['employeeLastName']."</p>".
				 "<p>".$row['employeeFirstName']."</p>".
				 "<p>".$row['employeeEmail']."</p>".
				 "<p>".$row['employeeContactPhone']."</p>".
				 "<p>".$fmat_hire_date."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_employee.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
		} // END IF
		else {
			$prevpage = " ";
		} // END ELSE

		$bar = '';
		if ($totpages > 1) { 
			for($page = 1; $page <= $totpages; $page++) {
				if ($page ==$thispage) {
					$bar .= " $page ";
				} // END IF
		else {
		// SPACE BEFORE AND AFTER $PAGE IN THE LINK BELOW WILL SPACE OUT ALL THE LINKS
			$bar .= "<a href='delete_employee.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_employee.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
		} // END IF
		else {
			$nextpage = " ";
		} // END ELSE

		// THIS ECHOES THE PAGING DISPLAY

		echo "
			<div class='paging'>
			$prevpage  $bar  $nextpage
			<!-- end .paging --></div>
			";
			} // END INITAL IF COUNT = 0 FOR PAGING
		// END PAGING
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Employee Data Available</p>";
		} // end else	
		
	} // end deleteEmployeeList method
	
	public function deleteEmployee($employeeId) {
		$result = $this->db->query("DELETE FROM employee WHERE employeeId = '$employeeId'");
		
		
		
		// if no employees, select and delete the training
		$result2 = $this->db->query("SELECT * FROM training_completion WHERE employeeId = '$employeeId'");
		$row2 = $result2->fetch_assoc();
		
		$result3 = $this->db->query("DELETE FROM training WHERE trainingId = '$row2[trainingId]'");
		
		// delete employee data from training records only after training has been deleted
		$result4 = $this->db->query("DELETE FROM training_completion WHERE employeeId = '$employeeId'");
		
	} // end deleteEmployee method
	
	

//********************END DELETE EMPLOYEES********************//
	
	
	
	
} // end Employee class
?>