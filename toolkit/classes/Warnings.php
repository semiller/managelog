<?php
class Warnings extends DbConnect {
	
	// define properties
	protected $db;
	protected $accountId;
	protected $managerDepartment;
	
	public function __construct() {
		parent::__construct();
		$this->accountId = $_SESSION['accountId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
	} // end construct
	
	
	// show warning to view instructions if there are not any departments in the system
	public function displayInstructions() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId' AND departmentName='$this->managerDepartment'");
		} // end else
		
		if ($result->num_rows == 0) {
			echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please review <a href='instructions.php'>full instructions</a> on preparing your account.</p></div>";
		} // end if
			
	} // end displayInstructions
	
	
	public function detectDepartment() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId' AND departmentName='$this->managerDepartment'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectDepartment
	
	public function detectJobTitle() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM jobtitle_category WHERE accountId='$this->accountId' AND jobtitleDepartment='$this->managerDepartment' OR jobtitleDepartment='All'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectJobTitle
	
	public function detectTrainingCategory() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' AND trainingCategoryDepartment='$this->managerDepartment' OR trainingCategoryDepartment='All'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectTrainingCategory
	
	public function detectEmployee() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId' AND employeeDepartment='$this->managerDepartment'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectEmployee
	
	public function detectManager() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM manager WHERE accountId='$this->accountId' AND managerDepartment='$this->managerDepartment'");
		} // end else
		
		if ($result->num_rows == 0) {
			echo "<div class='setup_warning'><p><img src='images/warning_icon.png' alt=''>Initial setup required.  Please create a minimum of one <a href='add_manager.php'>manager</a> for your account.</p></div>";
		} // end if
	} // end detectManager
	
	public function detectProjectCategory() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' AND projectCategoryDepartment='$this->managerDepartment' OR projectCategoryDepartment='All'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectProjectCategory
	
	public function detectJournalCategory() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' AND journalCategoryDepartment='$this->managerDepartment' OR journalCategoryDepartment='All'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectJournalCategory
	
	public function detectWorkOrderCategory() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' AND workorderCategoryDepartment='$this->managerDepartment' OR workorderCategoryDepartment='All'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectWorkOrderCategory
	
	
	public function detectSafeTrackCategory() {
		if ($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' AND safetrackCategoryDepartment='$this->managerDepartment' OR safetrackCategoryDepartment='All'");
		} // end else
		
		if ($result->num_rows == 0) {
			return false;
		} // end if
		else { return true; }
	} // end detectSafeTrackCategory
	
} // end Dashboard class

?>