<?php
class TrainingCategory extends Training {
	
	// define properties
	protected $accountId;
	protected $trainingCategoryId;
	protected $trainingCategoryName;
	protected $managerDepartment;
	
	public function __construct() {
		parent::__construct();
	} // end construct
	
	public function addTrainingCategory() {
		$result = $this->db->prepare("INSERT INTO training_category(accountId,trainingCategoryName,trainingCategoryDepartment) VALUES (?,?,?)");
		$result->bind_param('sss', $this->accountId, $trainingCategoryName, $trainingCategoryDepartment);
		
		$trainingCategoryName = $_POST['trainingCategoryName'];
		$trainingCategoryDepartment = $this->managerDepartment;
		
		$result->execute();
		
		header("Location: training_category.php?trainingCategoryAdded=yes");
	} // end addTrainingCategory
	
	
	public function readTrainingCategory() {
		if($this->managerDepartment == 'All') { // get all from account if department is equal to 'all'
			$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' ORDER BY trainingCategoryName ASC");
		} // end if
		else { // otherwise select from account based on either the managers department or from 'All'
			$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' AND (trainingCategoryDepartment = '$this->managerDepartment' OR trainingCategoryDepartment = 'All') ORDER BY trainingCategoryName ASC");
		} // end else
		
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get training category id (used for deleting
				$this->trainingCategoryId = $row['trainingCategoryId'];
				
				echo "<p>"; // start new line
				// only if projectCategoryDepartment is = to manager Department, allow for deletion
				if ($row['trainingCategoryDepartment'] == $this->managerDepartment || $this->managerDepartment=='All') {
				
				
				echo "<a href='training_category.php?trainingCategoryId=$this->trainingCategoryId&trainingCategoryDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this training category?\")'><img src='images/delete.png' alt='Delete Category' class='float_img'></a>";
				} // end if departments match
				 echo $row['trainingCategoryName'] . " - (" . $row['trainingCategoryDepartment'] . ")</p>";
			} // end while
		} // end if results exists
		else {
			echo "<p>No Training Categories Available</p>";
		} // end else
	} // end readTrainingCategory method
	
	public function deleteTrainingCategory($trainingCategoryId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM training_category WHERE trainingCategoryId = '$trainingCategoryId'");
	} // end deleteTrainingCategory method
	
	
	
} // end TrainingCategory class