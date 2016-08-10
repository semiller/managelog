<?php
class ProjectCategory extends Projects {
	
	// define properties
	protected $accountId;
	protected $projectCategoryId;
	protected $projectCategoryName;
	protected $managerDepartment;
	
	public function __construct() {
		parent::__construct();
	} // end construct
	
	public function addProjectCategory() {
		$result = $this->db->prepare("INSERT INTO project_category(accountId,projectCategoryName,projectCategoryDepartment) VALUES (?,?,?)");
		$result->bind_param('sss', $this->accountId, $projectCategoryName, $projectCategoryDepartment);
		
		$projectCategoryName = $_POST['projectCategoryName'];
		$projectCategoryDepartment = $this->managerDepartment;
		
		$result->execute();
		
		header("Location: project_category.php?projectCategoryAdded=yes");
	} // end addTrainingCategory
	
	
	public function readProjectCategory() {
		if($this->managerDepartment == 'All') { // get all from account if department is equal to 'all'
			$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' ORDER BY projectCategoryName ASC");
		} // end if
		else { // otherwise select from account based on either the managers department or from 'All'
			$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' AND (projectCategoryDepartment = '$this->managerDepartment' OR projectCategoryDepartment = 'All') ORDER BY projectCategoryName ASC");
		} // end else
		
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get training category id (used for deleting
				$this->projectCategoryId = $row['projectCategoryId'];
				
				echo "<p>"; // start new line
				// only if projectCategoryDepartment is = to manager Department, allow for deletion
				if ($row['projectCategoryDepartment'] == $this->managerDepartment || $this->managerDepartment=='All') {
				echo "<a href='project_category.php?projectCategoryId=$this->projectCategoryId&projectCategoryDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this project category?\")'><img src='images/delete.png' alt='Delete Category' class='float_img'></a>";
				} // end if departments match
				echo $row['projectCategoryName'] . " - (" . $row['projectCategoryDepartment'] . ")</p>";
				
			
			} // end while
		} // end if results exists
		else {
			echo "<p>No Project Categories Available</p>";
		} // end else
	} // end readProjectCategory method
	
	public function deleteProjectCategory($projectCategoryId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM project_category WHERE projectCategoryId = '$projectCategoryId'");
	} // end deleteProjectCategory method
	
	
	
} // end ProjectCategory class