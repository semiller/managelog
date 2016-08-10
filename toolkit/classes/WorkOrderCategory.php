<?php
class WorkOrderCategory extends WorkOrder {
	
	// define properties
	protected $accountId;
	protected $workorderCategoryId;
	protected $workorderCategoryName;
	protected $managerDepartment;
	
	public function __construct() {
		parent::__construct();
	} // end construct
	
	public function addWorkOrderCategory() {
		$result = $this->db->prepare("INSERT INTO workorder_category(accountId,workorderCategoryName,workorderCategoryDepartment) VALUES (?,?,?)");
		$result->bind_param('sss', $this->accountId, $workorderCategoryName, $workorderCategoryDepartment);
		
		$workorderCategoryName = $_POST['workorderCategoryName'];
		$workorderCategoryDepartment = $this->managerDepartment;
		
		$result->execute();
		
		header("Location: workorder_category.php?workorderCategoryAdded=yes");
	} // end addWorkOrderCategory
	
	
	public function readWorkOrderCategory() {
		if($this->managerDepartment == 'All') { // get all from account if department is equal to 'all'
			$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' ORDER BY workorderCategoryName ASC");
		} // end if
		else { // otherwise select from account based on either the managers department or from 'All'
			$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' AND (workorderCategoryDepartment = '$this->managerDepartment' OR workorderCategoryDepartment = 'All') ORDER BY workorderCategoryName ASC");
		} // end else
		
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get training category id (used for deleting
				$this->workorderCategoryId = $row['workorderCategoryId'];
				
				echo "<p>"; // start new line
				// only if workorderCategoryDepartment is = to manager Department, allow for deletion
				if ($row['workorderCategoryDepartment'] == $this->managerDepartment || $this->managerDepartment=='All') {
				echo "<a href='workorder_category.php?workorderCategoryId=$this->workorderCategoryId&workorderCategoryDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this work order category?\")'><img src='images/delete.png' alt='Delete Category' class='float_img'></a>";
				} // end if departments match
				echo $row['workorderCategoryName'] . " - (" . $row['workorderCategoryDepartment'] . ")</p>";
				
			
			} // end while
		} // end if results exists
		else {
			echo "<p>No Work Order Categories Available</p>";
		} // end else
	} // end readWorkOrderCategory method
	
	public function deleteWorkOrderCategory($workorderCategoryId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM workorder_category WHERE workorderCategoryId = '$workorderCategoryId'");
	} // end deleteWorkOrderCategory method
	
	
	
} // end WorkOrderCategory class