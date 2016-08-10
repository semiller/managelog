<?php
class JobTitle extends DbConnect {
	
	// define properties
	protected $accountId;
	protected $jobtitleName;
	protected $jobtitleDepartment;
	protected $managerDepartment;
	
	protected  $employeeId;
	
	public function __construct() {
		parent::__construct();
		$this->managerDepartment = $_SESSION['managerDepartment'];
		$this->accountId = $_SESSION['accountId'];
	} // end construct
	
	public function addJobTitle() {
		$result = $this->db->prepare("INSERT INTO jobtitle_category(accountId,jobtitleName,jobtitleDepartment) VALUES (?,?,?)");
		$result->bind_param('sss', $this->accountId, $jobtitleName, $jobtitleDepartment);
		
		$jobtitleName = $_POST['jobtitleName'];
		$jobtitleDepartment = $this->managerDepartment;
		
		$result->execute();
		
		header("Location: jobtitle_category.php?jobtitleAdded=yes");
	} // end addJobTitle
	
	
	public function readJobTitle() {
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId='$this->accountId' ORDER BY jobtitleName ASC");
		} // end if manager Department = 'all'
		else {
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId='$this->accountId' AND  (jobtitleDepartment = 'All' OR jobtitleDepartment = '$this->managerDepartment') ORDER BY jobtitleName ASC");
		} // end else
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get jobtitle id (used for deleting
				$this->jobtitleId = $row['jobtitleId'];
				
				echo "<p>"; // start new line
				// only if projectCategoryDepartment is = to manager Department, allow for deletion
				if ($row['jobtitleDepartment'] == $this->managerDepartment || $this->managerDepartment=='All') {
				
				echo "<a href='jobtitle_category.php?jobtitleId=$this->jobtitleId&jobtitleDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this job title?\")'><img src='images/delete.png' alt='Delete Job Title' class='float_img'></a>";
				} // end if jobtitles match
				echo $row['jobtitleName'] . " - (" . $row['jobtitleDepartment'] . ")</p>";
			} // end while
		} // end if results exists
		else {
			echo "<p>No Job Titles Available</p>";
		} // end else
	} // end readJobTitle method
	
	
	// this is for the display of jobtitles on the add_employee page
	public function displayJobTitleSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId = '$this->accountId' AND (jobtitleDepartment = '$this->managerDepartment' OR jobtitleDepartment = 'All')");
		} // end else
		
		
			echo "
				<select name='employeeJobTitle'>
				<option value=''></option>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['jobtitleName'] . "'>". $row['jobtitleName'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayJobTitleSelect method
	
	// this is for the display of jobtitles on the edit_employee page
	public function displayJobTitleEditSelect($employeeId) {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId = '$this->accountId' AND jobtitleDepartment = '$this->managerDepartment' OR jobtitleDepartment = 'All'");
		} // end else
		
		
			echo "
				<select name='employeeJobTitle'>
			";
			while ($row = $result->fetch_assoc()) {
				echo " 
				<option value='" . $row['jobtitleName'] . "'"; 
				$this->employeeId = $employeeId; // get property value to place in query (from parameter)
				$result2 = $this->db->query("SELECT employeeJobTitle FROM employee WHERE employeeId = '$this->employeeId'");
				$row2 = $result2->fetch_assoc();
				// compare the employee job title to the job title list and chose the value that employee previously had
				if ($row2['employeeJobTitle'] == $row['jobtitleName']) echo "selected"; 
				
				echo ">". $row['jobtitleName'] . "</option>
				";
			} // end while
			echo "
				</select>
			";
	} // end displayJobTitleEditSelect method
	
	public function deleteJobTitle($jobtitleId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM jobtitle_category WHERE jobtitleId = '$jobtitleId'");
	} // end deleteJobTitle method
	
	
} // end JobTitle class