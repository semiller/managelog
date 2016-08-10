<?php
class Manager extends DbConnect {
	
	// declare properties
	protected $accountId;
	protected $managerId;
	protected $managerNumber;
	protected $managerUsername;
	protected $managerPassword;
	protected $managerCreateDate;
	protected $managerFirstName;
	protected $managerLastName;
	protected $managerEmail;
	protected $managerPhone;
	protected $managerRole;
	protected $managerDepartment;
	
	protected $newEncryptPassword;
	
	protected $managerPaid;
	
	private $_packageType;
	private $_packageManager;
	
	protected $viewAuth = true; // determines whether get has been changed to unauthorized view
	
	
	public function __construct() {
		parent::__construct();
		// this session is created upon Log class
		$this->managerId = $_SESSION['managerId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
		$this->accountId = $_SESSION['accountId'];
		// when adding new manager, make paid equal to 1 so they can log in
		$this->managerPaid = 1;
	} // end construct
	
	
	public function getPackageType() {
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		$this->_packageType = $row['packageType'];
		return $this->_packageType; 
	} // end getPackageType
	
	public function getRemainingPackageManager() {
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		$this->_packageManager = $row['packageManager'];
		return $this->_packageManager; 
	} // end getPackageType
	
	
	
	public function deductPackageManager() {
		// get number of Manager remaining
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		
		$remainingManagers = $row['packageManager'];
		
		$newRemainingManagers = $remainingManagers - 1;
		
		$result = $this->db->query("UPDATE package SET packageManager = '$newRemainingManagers' WHERE accountId = '$this->accountId'");
	} // end deduct Package Manager
	
	public function addPackageManager() {
		// get number of Manager remaining
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		
		$remainingManagers = $row['packageManager'];
		
		$newRemainingManagers = $remainingManagers + 1;
		
		$result = $this->db->query("UPDATE package SET packageManager = '$newRemainingManagers' WHERE accountId = '$this->accountId'");
	} // end add Package Manager
	
	
	public function addManager($managerUsername,$managerEmail) {
		$this->_managerUsername = $managerUsername;
		$this->_managerEmail = $managerEmail;
		// check if email exists before attempting to add new manager and account
		$this->checkEmailExists($this->_managerEmail);
		// check if username exists before attempting to add new manager and account
		$this->checkUsernameExists($this->_managerUsername);
		
		$result = $this->db->prepare("INSERT INTO manager(accountId,managerNumber,managerUsername,managerPassword,managerCreateDate,managerFirstName,managerLastName,managerEmail,managerPhone,managerRole,managerDepartment,managerPaid) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

$result->bind_param('sssssssssssi', $accountId,$managerNumber,$managerUsername,$managerPassword,$managerCreateDate,$managerFirstName,$managerLastName,$managerEmail,$managerPhone,$managerRole,$managerDepartment,$this->managerPaid);

$accountId = $_POST['accountId'];
$managerNumber = $_POST['managerNumber'];
$managerUsername = $_POST['managerUsername'];
// store as hash
$managerPassword = md5($_POST['managerPassword']);
$managerCreateDate = $_POST['managerCreateDate'];
$managerFirstName = $_POST['managerFirstName'];
$managerLastName = $_POST['managerLastName'];
$managerEmail = $_POST['managerEmail'];
$managerPhone = $_POST['managerPhone'];
$managerRole = $_POST['managerRole'];
$managerDepartment = $_POST['managerDepartment'];
$result->execute();


// subtract from package manager
		$this->deductPackageManager();

// send new manager login details
$to = $managerEmail; 
$from = "admin@managelog.com";
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
$headers .= "From: $from" . "\n";

$emailmessage = "
<p>Welcome to the Manage Log Service Toolkit.</p>
<p>You are receiving this message because you have been created as a new $managerDepartment manager by 
your account administrator.  Listed below are the login credentials to begin using the Manage Log Service Toolkit.</p>

<p>
<strong>Name:</strong> $managerFirstName $managerLastName <br />

<strong>Email:</strong> $managerEmail <br />

<strong>Username:</strong> $managerUsername <br />

<strong>Password:</strong> $_POST[managerPassword]
</p>
<p>To login, please visit <a href='http://www.managelog.com/toolkit/index.php'>www.managelog.com/toolkit</a></p>

<p>Please note, upon your first successful login, please visit your profile page to change your password to something you will remember.</p>

<p>Instructions on how to get started can be found at <a href='http://www.managelog.com/faq.php'>FAQ</a> or on the instructions tab on the service toolkit.  Thank you in advance for using our service.</p>

<p>Stephen Miller<br>
Customer Service Rep</p> 
";
mail( $to, "Manage Log Service Toolkit Login Details", $emailmessage, $headers );



header("Location: add_manager.php?managerAdded=yes");

	} // end addManager method
	
	public function checkEmailExists($managerEmail) {
		$result = $this->db->query("SELECT managerEmail FROM manager WHERE managerEmail = '$managerEmail'");
		if ($result->num_rows > 0) {
			header("Location: add_manager.php?email_exists=yes");
			exit();
		} // end if
	} // end checkEmailExists
	
	public function checkUsernameExists($managerUsername) {
		$result = $this->db->query("SELECT managerUsername FROM manager WHERE managerUsername = '$managerUsername'");
		if ($result->num_rows > 0) {
			header("Location: add_manager.php?username_exists=yes");
			exit();
		} // end if
	} // end checkUsernameExists
	
	
	public function getManagerRole() {
		$result = $this->db->query("SELECT managerRole FROM manager WHERE managerID = '$this->managerId'");
		$row = $result->fetch_assoc();
		$this->managerRole = $row['managerRole'];
		return $this->managerRole;
	} // end getManagerRole
	
	
	// this is for the display of departments on the add_training page
	public function displayManagerTrainingDepartmentSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId' AND managerDepartment != 'All'"); // do not show All as it conflicts with adding training cross lines of departments
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		
			echo "
				<select name='trainingDepartment' id='trainingDepartment'>  
				<option value=''></option>
			";
			
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'>". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
		
		
	} // end displayManagerTrainingDepartmentSelect method
	
	
	// this is for the display of departments on the add_projects page
	public function displayManagerProjectsDepartmentSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		
			echo "
				<select name='projectDepartment'>
				<option value=''></option>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'>". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayManagerProjectDepartmentSelect method
	
	
	
	// this is for the display of departments on the add_journal page
	public function displayManagerJournalDepartmentSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		
			echo "
				<select name='journalDepartment'>
				<option value=''></option>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'>". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayManagerJournalDepartmentSelect method
	
	
	
	// this is for the display of departments on the add_work orders page
	public function displayManagerWorkOrdersDepartmentSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		
			echo "
				<select name='workorderDepartment'>
				<option value=''></option>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'>". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayManagerWorkOrdersDepartmentSelect method
	
	// this is for the display of departments on the add_safetrack page
	public function displayManagerSafeTrackDepartmentSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		
			echo "
				<select name='safetrackDepartment'>
				<option value=''></option>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'>". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayManagerSafeTrackDepartmentSelect method
	
	// this is for the display of departments on the add_employee and edit_employee page
	public function displayManagerDepartmentEditSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		
			echo "
				<select name='employeeDepartment'>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'"; 
				if ($this->managerDepartment == $row['managerDepartment']) echo "selected"; 
				
				echo ">". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditSelect method
	
	
	// this is for the display of departments on the add_manager and edit_manager page
	public function displayManagerDepartmentEditManagerSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT managerDepartment FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId='$this->managerId'");
		} // end else
		
		// if manager account equals ALL, make it readonly to eliminate any change mistakes
			echo "<select name='managerDepartment'>"; 
			
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['managerDepartment'] . "'"; 
				if ($this->managerDepartment == $row['managerDepartment']) echo "selected"; 
				
				echo ">". $row['managerDepartment'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditManagerSelect method
	
	// for general list view of all managers within accountId
	public function managerSelectDisplay($link) { // $link is href to carry GET
	
	// START PAGING AND DISPLAYING OF MANAGERS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL MANAGER
		// QUERY MANAGER DB
		$result = $this->db->query("SELECT COUNT(managerId) FROM manager WHERE accountId='$this->accountId'");

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
	
		$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' ORDER BY managerLastName ASC LIMIT $offset,$recordsperpage");
	
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->managerId = $row['managerId'];
			
			
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
				 "<p><a href='$link?managerId=$this->managerId'>".$row['managerNumber']."</a></p>".
				 "<p>".$row['managerLastName']."</p>".
				 "<p>".$row['managerFirstName']."</p>".
				 "<p>".$row['managerEmail']."</p>".
				 "<p>".$row['managerPhone']."</p>".
				 "<p>".$row['managerDepartment']."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='manager.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='manager.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='manager.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
		
		// END PAGING
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Manager Data Available</p>";
		} // end else
		} // END INITAL IF COUNT = 0 FOR PAGING
	} // end managerSelectDisplay method
	
	// this method is for list edit view.  Only allow to display manager within same department and with role less than or equal to theirs
	public function managerSelectDisplayEditList($link) { // $link is href to carry GET
	
	// START PAGING AND DISPLAYING OF MANAGERS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL MANAGER
		// QUERY MANAGER DB
		$result = $this->db->query("SELECT COUNT(managerId) FROM manager WHERE accountId='$this->accountId'");

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
	
	
		$this->getManagerRole();
		if($this->managerDepartment == 'All') { // disregard the manager department, just worry about same account and higher or equal role
		$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerRole >= '$this->managerRole' ORDER BY managerLastName ASC LIMIT $offset,$recordsperpage");
		} // end if managerDepartment = All
		else {
			$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerRole >= '$this->managerRole' AND managerDepartment='$this->managerDepartment' ORDER BY managerLastName ASC LIMIT $offset,$recordsperpage");
		} // end else
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->managerId = $row['managerId'];
			
			
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
				 "<p><a href='$link?managerId=$this->managerId'>".$row['managerNumber']."</a></p>".
				 "<p>".$row['managerLastName']."</p>".
				 "<p>".$row['managerFirstName']."</p>".
				 "<p>".$row['managerEmail']."</p>".
				 "<p>".$row['managerPhone']."</p>".
				 "<p>".$row['managerDepartment']."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='edit_manager.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='edit_manager.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='edit_manager.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
		
		// END PAGING
		
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Manager Data Available</p>";
		} // end else
		} // END INITAL IF COUNT = 0 FOR PAGING
	} // end managerSelectDisplay method
	
	
	public function getViewAuth() {
		return $this->viewAuth;
	} // end getViewAuth method
	
	public function setManagerValues($managerId) {
		
		// manager id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM manager WHERE managerId = '$managerId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of manager information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected manager details.</p></div>";
		} //end if
		else {
		
		// get all manager database values based on ID number
		$result = $this->db->query("SELECT * FROM manager WHERE managerId = '$managerId'");
		$row = $result->fetch_assoc();
		// store property values
		$this->managerId = $row['managerId'];
		$this->managerNumber = $row['managerNumber'];
		$this->managerFirstName = $row['managerFirstName'];
		$this->managerLastName = $row['managerLastName'];
		$this->managerEmail = $row['managerEmail'];
		$this->managerPhone = $row['managerPhone'];
		$this->managerDepartment = $row['managerDepartment'];
		
		}// end else
	} // end setManagerValues method
	
	public function getManagerId() {
		return $this->managerId;
	} // end getManagerId method
	
	public function getManagerNumber() {
		return $this->managerNumber;
	} // end getManagerNumber method
	
	public function getManagerFirstName() {
		return $this->managerFirstName;
	} // end getManagerFirstName method
	
	public function getManagerLastName() {
		return $this->managerLastName;
	} // end getManagerLastName method
	
	public function getManagerEmail() {
		return $this->managerEmail;
	} // end getManagerEmail method
	
	public function getManagerPhone() {
		return $this->managerPhone;
	} // end getManaagerPhone method
	
	public function getManagerDepartment() {
		return $this->managerDepartment;
	} // end getManagerDepartment method
	
	
	public function updateManager($managerId) {
		$result = $this->db->prepare("UPDATE manager SET managerNumber=?,managerFirstName=?,managerLastName=?,managerEmail=?,managerPhone=?,managerDepartment=? WHERE managerId = '$managerId'");

$result->bind_param('ssssss', $managerNumber, $managerFirstName, $managerLastName, $managerEmail, $managerPhone, $managerDepartment);


$managerNumber = $_POST['managerNumber'];
$managerFirstName = $_POST['managerFirstName'];
$managerLastName = $_POST['managerLastName'];
$managerEmail = $_POST['managerEmail'];
$managerPhone = $_POST['managerPhone'];
$managerDepartment = $_POST['managerDepartment'];



$result->execute();

header("Location: edit_selected_manager.php?managerUpdated=yes&managerId=$managerId");
	} // end updateManager method
	
	
	public function updatePassword($managerId) {
		// query to update manager password with encrypted password
		$result = $this->db->prepare("UPDATE manager SET managerPassword = ? WHERE managerId = ?");
		$result->bind_param('ss', $this->newEncryptPassword,$this->managerId);
		// change plaintext password to encrypted version
		$this->newEncryptPassword = md5($_POST['managerPassword']);
		$this->managerId = $managerId;
        $result->execute();

		header("Location: edit_selected_manager.php?managerPasswordUpdated=yes&managerId=$managerId");
	} // end updatePassword
	
	
/**************************************DELETE MANAGER************************************************/

public function deleteManagerList() {
	
	// START PAGING AND DISPLAYING OF MANAGERS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL MANAGER
		// QUERY MANAGER DB
		$result = $this->db->query("SELECT COUNT(managerId) FROM manager WHERE accountId='$this->accountId'");

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
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every manager
		$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerId != '$this->managerId' ORDER BY managerLastName ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on manager department
		$result = $this->db->query("SELECT * FROM manager WHERE accountId = '$this->accountId' AND managerDepartment = '$this->managerDepartment' AND managerId != '$this->managerId' AND managerRole > '$this->managerRole' ORDER BY managerLastName ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->managerId = $row['managerId'];
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			
			// Display for manager list
			echo "<div class='employeeListContent'>".
				 "<p><a href='delete_manager.php?managerId=$this->managerId&managerDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this manager?\")'>"
				 .$row['managerNumber']."</a></p>".
				 "<p>".$row['managerLastName']."</p>".
				 "<p>".$row['managerFirstName']."</p>".
				 "<p>".$row['managerEmail']."</p>".
				 "<p>".$row['managerPhone']."</p>".
				 "<p>".$row['managerDepartment']."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_manager.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='delete_manager.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_manager.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
		
		// END PAGING
		
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Manager Data Available</p>";
		} // end else	
		} // END INITAL IF COUNT = 0 FOR PAGING
	} // end deleteManagerList method
	
	public function deleteManager($managerId) {
		$result = $this->db->query("DELETE FROM manager WHERE managerId = '$managerId'");
		
		// subtract from package manager
		$this->addPackageManager();
		
	} // end deleteManager method

/**************************************END DELETE MANAGER********************************************/

	
} // end Manager class