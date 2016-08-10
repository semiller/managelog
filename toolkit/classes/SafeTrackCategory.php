<?php

class SafeTrackCategory extends SafeTrack {
	
	// define properties
	protected $accountId;
	protected $safetrackCategoryId;
	protected $safetrackCategoryName;
	protected $managerDepartment;
	
	protected $db;
	
	public function __construct() {
		parent::__construct();
		$this->accountId = $_SESSION['accountId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
	} // end construct
	
	public function addSafeTrackCategory() {
		$result = $this->db->prepare("INSERT INTO safetrack_category(accountId,safetrackCategoryDepartment,safetrackCategoryName) VALUES (?,?,?)");
		$result->bind_param('sss', $this->accountId, $safetrackCategoryDepartment, $safetrackCategoryName);
		
		$safetrackCategoryName = $_POST['safetrackCategoryName'];
		$safetrackCategoryDepartment = $this->managerDepartment;
		
		$result->execute();
		
		header("Location: safetrack_category.php?safetrackCategoryAdded=yes");
	} // end addSafeTrackCategory
	
	
	public function readSafeTrackCategory() {
		if($this->managerDepartment == 'All') { // get all from account if department is equal to 'all'
			$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' ORDER BY safetrackCategoryName ASC");
		} // end if
		else { // otherwise select from account based on either the managers department or from 'master'
			$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' AND (safetrackCategoryDepartment = '$this->managerDepartment' OR safetrackCategoryDepartment = 'All') ORDER BY safetrackCategoryName ASC");
		} // end else
	
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get safetrack category id (used for deleting
				$this->safetrackCategoryId = $row['safetrackCategoryId'];
				
				
				
				
				echo "<p>"; // start new line
				// only if safetrackCategoryDepartment is = to manager Department, allow for deletion
				if ($row['safetrackCategoryDepartment'] == $this->managerDepartment || $this->managerDepartment=='All') {
				
				
				echo "<a href='safetrack_category.php?safetrackCategoryId=$this->safetrackCategoryId&safetrackCategoryDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this category?\")'><img src='images/delete.png' alt='Delete Category' class='float_img'></a>";
				} // end if departments match
				 echo $row['safetrackCategoryName'] . " - (" . $row['safetrackCategoryDepartment'] . ")</p><div class='clr'></div>";
			} // end while
		} // end if results exists
		else {
			echo "<p>No Safety Tracker Categories Available</p>";
		} // end else
	} // end readSafeTrackCategory method
	
	public function deleteSafeTrackCategory($safetrackCategoryId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM safetrack_category WHERE safetrackCategoryId = '$safetrackCategoryId'");
	} // end deleteSafeTrackCategory method
	
	
	
} // end SafeTrackCategory class