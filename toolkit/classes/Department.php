<?php
class Department extends DbConnect {
	
	// define properties
	protected $accountId;
	protected $departmentId;
	protected $departmentName;
	protected $managerDepartment;
	
	private $_packageType;
	private $_packageDepartment;
	
	public function __construct() {
		parent::__construct();
		$this->managerDepartment = $_SESSION['managerDepartment'];
		$this->accountId = $_SESSION['accountId'];
	} // end construct
	
	
	public function getPackageType() {
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		$this->_packageType = $row['packageType'];
		return $this->_packageType; 
	} // end getPackageType
	
	public function getRemainingPackageDepartment() {
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		$this->_packageDepartment = $row['packageDepartment'];
		return $this->_packageDepartment; 
	} // end getPackageType
	
	
	
	public function deductPackageDepartment() {
		// get number of Departments remaining
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		
		$remainingDepartments = $row['packageDepartment'];
		
		$newRemainingDepartments = $remainingDepartments - 1;
		
		$result = $this->db->query("UPDATE package SET packageDepartment = '$newRemainingDepartments' WHERE accountId = '$this->accountId'");
	} // end deduct Package Department
	
	public function addPackageDepartment() {
		// get number of Departments remaining
		$result = $this->db->query("SELECT * FROM package WHERE accountId = '$this->accountId'");
		$row = $result->fetch_assoc();
		
		$remainingDepartments = $row['packageDepartment'];
		
		$newRemainingDepartments = $remainingDepartments + 1;
		
		$result = $this->db->query("UPDATE package SET packageDepartment = '$newRemainingDepartments' WHERE accountId = '$this->accountId'");
	} // end add Package Department
	
	public function addDepartment() {
		$result = $this->db->prepare("INSERT INTO department_category(accountId,departmentName) VALUES (?,?)");
		$result->bind_param('ss', $this->accountId, $departmentName);
		$departmentName = $_POST['departmentName'];
		$result->execute();
		
		// subtract from package department
		$this->deductPackageDepartment();
		
		header("Location: department_category.php?departmentAdded=yes");
	} // end addTrainingCategory
	
	public function readDepartment() {
			$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId' ORDER BY departmentName ASC");
		
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get department id (used for deleting
				$this->departmentId = $row['departmentId'];
				
				echo "<p><a href='department_category.php?departmentId=$this->departmentId&departmentDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this department?\")'><img src='images/delete.png' alt='Delete Department' class='float_img'></a>" . $row['departmentName'] . "</p>";
			} // end while
		} // end if results exists
		else {
			echo "<p>No Departments Available</p>";
		} // end else
	} // end readDepartment method
	
	
	// this method is for displaying the available departments when creating a new manager
	public function displayDepartmentSelect() {
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId' ORDER BY departmentName ASC");
		} // end if
		else {
			// query will select managers that have same account id, same department, and a role equal or less 	than the logged in manager
			$result = $this->db->query("SELECT * FROM department_category WHERE accountId='$this->accountId' AND departmentName = '$this->managerDepartment'");
		}

		echo "
		<select name='managerDepartment'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['departmentName'] . "'>". $row['departmentName'] . "</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayDepartmentSelect
	
	
	public function deleteDepartment($departmentId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM department_category WHERE departmentId = '$departmentId'");
		
		// add from package department
		$this->addPackageDepartment();
		
	} // end deleteDepartment method
	
	
	
} // end Department class