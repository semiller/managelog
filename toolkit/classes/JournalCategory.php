<?php
class JournalCategory extends Journal {
	
	// define properties
	protected $accountId;
	protected $journalCategoryId;
	protected $journalCategoryName;
	protected $managerDepartment;
	
	public function __construct() {
		parent::__construct();
	} // end construct
	
	public function addJournalCategory() {
		$result = $this->db->prepare("INSERT INTO journal_category(accountId,journalCategoryName,journalCategoryDepartment) VALUES (?,?,?)");
		$result->bind_param('sss', $this->accountId, $journalCategoryName, $journalCategoryDepartment);
		
		$journalCategoryName = $_POST['journalCategoryName'];
		$journalCategoryDepartment = $this->managerDepartment;
		
		$result->execute();
		
		header("Location: journal_category.php?journalCategoryAdded=yes");
	} // end addJournalCategory
	
	
	public function readJournalCategory() {
		if($this->managerDepartment == 'All') { // get all from account if department is equal to 'all'
			$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' ORDER BY journalCategoryName ASC");
		} // end if
		else { // otherwise select from account based on either the managers department or from 'All'
			$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' AND (journalCategoryDepartment = '$this->managerDepartment' OR journalCategoryDepartment = 'All') ORDER BY journalCategoryName ASC");
		} // end else
		
		if ($result->num_rows > 0) { // check if results exists
			while ($row = $result->fetch_assoc()) {
				
				// get journal category id (used for deleting
				$this->journalCategoryId = $row['journalCategoryId'];
				
				echo "<p>"; // start new line
				// only if journalCategoryDepartment is = to manager Department, allow for deletion
				if ($row['journalCategoryDepartment'] == $this->managerDepartment || $this->managerDepartment=='All') {
				echo "<a href='journal_category.php?journalCategoryId=$this->journalCategoryId&journalCategoryDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this journal category?\")'><img src='images/delete.png' alt='Delete Category' class='float_img'></a>";
				} // end if departments match
				echo $row['journalCategoryName'] . " - (" . $row['journalCategoryDepartment'] . ")</p>";
				
			
			} // end while
		} // end if results exists
		else {
			echo "<p>No Journal Categories Available</p>";
		} // end else
	} // end readJournalCategory method
	
	public function deleteJournalCategory($journalCategoryId) {
		// pulled from the image and read list to get the GET for deletion
		$result = $this->db->query("DELETE FROM journal_category WHERE journalCategoryId = '$journalCategoryId'");
	} // end deleteJournalCategory method
	
	
	
} // end JournalCategory class