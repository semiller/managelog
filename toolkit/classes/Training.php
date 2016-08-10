<?php
class Training extends Employee {
	// declare properties
	protected $accountId;
	protected $managerDepartment;
	protected $managerRole;
	
	protected $trainingId;
	protected $trainingTitle;
	protected $trainingCategory;
	protected $trainingDepartment;
	protected $trainingDescription;
	protected $trainingConductedBy;
	protected $trainingAllTrainedDate;
	
	protected $trainingScheduleDate;
	protected $trainingCompletionDate;
	
	protected $sortTraining;
	
	protected $viewAuth = true; // determines whether get has been changed to unauthorized view
	
	public function __construct() {
		parent::__construct();
		$this->accountId = $_SESSION['accountId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
	} // end construct
	
	
	public function addTraining() {
		$result = $this->db->prepare("INSERT INTO training(accountId,trainingTitle,trainingCategory,trainingDepartment,trainingConductedBy,trainingDescription,trainingScheduleDate) VALUES (?,?,?,?,?,?,?)");
		
$result->bind_param('sssssss', $this->accountId, $trainingTitle, $trainingCategory, $trainingDepartment, $trainingConductedBy, $trainingDescription,$trainingScheduleDate);

// get values entered from form
$trainingTitle = $_POST['trainingTitle'];
$trainingCategory = $_POST['trainingCategory'];
$trainingDepartment = $_POST['trainingDepartment'];
$trainingConductedBy = $_POST['trainingConductedBy'];
$trainingScheduleDate = $_POST['trainingScheduleDate'];
$trainingDescription = $_POST['trainingDescription'];
$trainingCompletionDate = '';

// this gets the employee list based on the manager department
// used to schedule individual employees to training
$allEmployees = $_POST['allEmployees'];
$this->allEmployees = $allEmployees;
// employeeId is an array of all selected employee id checkboxes
$employeeId = $_POST['employeeId'];
$this->employeeId = $employeeId;

$result->execute();

// sets the properties so they can be used when calling addTrainingCompletion()
$this->trainingId = $result->insert_id;
$this->trainingDepartment = $trainingDepartment;
$this->trainingScheduleDate = $trainingScheduleDate;
$this->trainingCompletionDate = $trainingCompletionDate;
// call to store data
$this->addTrainingCompletion();
		
header("Location: add_training.php?trainingAdded=yes");

	} // end addTraining method


/*******************************TRAINING COMPLETION******************************/

	public function addTrainingCompletion() {
		// if All Employees checkbox is checked, add all employees.  Otherwise, add only selected
		// if no employees selected add them all by default
		if(isset($this->allEmployees) || $this->employeeId == '') {
		// add to training_completion database to link employees to training id
		
		// gets all the employee ids with the session accountId and the same employee department as the selected training department
		$result2 = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId' AND employeeDepartment='$this->trainingDepartment'");
		// while getting all employee ids loop and insert all the preset info into the training_completion database
		while($row2=$result2->fetch_assoc()) {
			
			$this->employeeId = $row2['employeeId'];	
			
			// insert into training_completion database
			$result3 = $this->db->prepare("INSERT INTO 		training_completion(trainingId,employeeId,accountId,trainingDepartment,trainingScheduleDate,trainingCompletionDate) VALUES (?,?,?,?,?,?)");
		$result3->bind_param('ssssss', $this->trainingId, $this->employeeId, $this->accountId, $this->trainingDepartment, $this->trainingScheduleDate, $this->trainingCompletionDate);
		$result3->execute();
		} // end while
		
		
		} // end if all employees is checked
		else { // get all selected employees and add them
		
			foreach($this->employeeId as $employeeIds) {
				// add to training_completion database to link employees to training id
				// insert into training_completion database
				
				$result3 = $this->db->prepare("INSERT INTO 		training_completion(trainingId,employeeId,accountId,trainingDepartment,trainingScheduleDate,trainingCompletionDate) VALUES (?,?,?,?,?,?)");
				$result3->bind_param('ssssss', $this->trainingId, $employeeIds, $this->accountId, $this->trainingDepartment, $this->trainingScheduleDate, $this->trainingCompletionDate);
				$result3->execute();	
			} // end foreach
		} // end else
	} // end addTrainingCompletion method
	
	/*******************************END TRAINING COMPLETION******************************/
	
	
	
	
	
	
	
	public function trainingSelectDisplay($link) { // $link is href to carry GET
	
	// Sort Training Selection - store value
	// stores initial value
	$this->sortTraining = $_POST['sortTraining'];
	// this is used for paging.  if sort value is set, get the value to keep the sortTraining property loaded
	if (isset($_GET['sort'])) {
	$this->sortTraining = $_GET['sort'];
	} // end if get page is set
	
	
	// START PAGING AND DISPLAYING OF TRAINING  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL TRAINING
		// QUERY TRAINING DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every training
			$result = $this->db->query("SELECT COUNT(trainingId) FROM training WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(trainingId) FROM training WHERE accountId='$this->accountId' AND trainingDepartment = '$this->managerDepartment'");
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
	
	
		// SORTING QUERYING - BASE ON SORTING SELECTION MADE
		
		// IF SORT BY TITLE
		if ($this->sortTraining == 'trainingTitle') {
		
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		}// end if sort by training title
		
	// IF SORT BY CATEGORY
		if ($this->sortTraining == 'trainingCategory') {
		
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingCategory ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingCategory ASC LIMIT $offset,$recordsperpage");
			} // end else
		}// end if sort by training category
		
	// IF SORT BY DEPARTMENT
		if ($this->sortTraining == 'trainingDepartment') {
		
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingDepartment ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingDepartment ASC LIMIT $offset,$recordsperpage");
			} // end else
		}// end if sort by training department
		
	// IF SORT BY CONDUCTED BY
		if ($this->sortTraining == 'trainingConductedBy') {
		
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingConductedBy ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingConductedBy ASC LIMIT $offset,$recordsperpage");
			} // end else
		}// end if sort by training conducted by
		
		
		
		// IF SORT BY SCHEDULE DATE
		if ($this->sortTraining == 'trainingScheduleDate') {
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingScheduleDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingScheduleDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		}// end if sort by training schedule date
		
		// IF SORT BY Completion DATE
		if ($this->sortTraining == 'trainingCompletionDate') {
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingAllTrainedDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingAllTrainedDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		}// end if sort by training completion date
		
		
		if ($this->sortTraining == '' || !isset($this->sortTraining)) {
			//******* THIS IS THE DEFAULT IF NO SORTING SELECTION IS MADE - SORT BY TITLE *********//
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every employee
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on employee department
			$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sorting is not set or blank...default to this
	
	
	
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// get the schedule and completion date from training_completion
			$result2 = $this->db->query("SELECT * FROM training_completion WHERE accountId='$this->accountId' AND trainingId='$row[trainingId]'");
			$row2 = $result2->fetch_assoc();
			
			// stores each employeeId to property for later use
			$this->trainingId = $row['trainingId'];
			
			// date format for schedule date
			$timestamp = strtotime($row2['trainingScheduleDate']);
			$fmat_schedule_date = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set training values
			$this->setTrainingValues($this->trainingId);
			
			// Display for employee list
			echo "<div class='trainingListContent'>".
				 "<p><a href='$link?trainingId=$this->trainingId'>".$row['trainingTitle']."</a></p>".
				 "<p>".$row['trainingCategory']."</p>".
				 "<p>".$row['trainingDepartment']."</p>".
				 "<p>".$row['trainingConductedBy']."</p>".
				 "<p>".$fmat_schedule_date."</p>".
				 "<p>".$this->getTrainingAllTrainedDate()."</p>".
				 "<!-- end .trainingListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='training.php?page=$page&sort=$this->sortTraining'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='training.php?page=$page&sort=$this->sortTraining'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='training.php?page=$page&sort=$this->sortTraining'>Next</a>";  // LINK FOR NEXT PAGE
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
		
		}// end if for displaying content
		else { // if no results display this
			echo "<p>No Training Data Available</p>";
		} // end else
		
	} // end trainingSelectDisplay method
	
	
	public function getViewAuth() {
			return $this->viewAuth;
		} // end getViewAuth method
	
	
	public function setTrainingValues($trainingId) {
		
		// training id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM training WHERE trainingId = '$trainingId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of training information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected training details.</p></div>";
		} //end if
		else {
		
		
		// get all training database values based on ID number
		$result = $this->db->query("SELECT * FROM training WHERE trainingId = '$trainingId'");
		$row = $result->fetch_assoc();
		
		$result2 = $this->db->query("SELECT * FROM training_completion WHERE trainingId = '$trainingId'");
		$row2 = $result2->fetch_assoc();
		
		
		// store property values
		$this->trainingId = $row['trainingId'];
		$this->trainingTitle = $row['trainingTitle'];
		$this->trainingCategory = $row['trainingCategory'];
		$this->trainingDepartment = $row['trainingDepartment'];
		$this->trainingConductedBy = $row['trainingConductedBy'];
		$this->trainingDescription = $row['trainingDescription'];
		$this->trainingAllTrainedDate = $row['trainingAllTrainedDate'];
		
		$this->trainingScheduleDate = $row2['trainingScheduleDate'];
		$this->trainingCompletionDate = $row2['trainingCompletionDate'];
		
		
		} // end else authorized view
	} // end setTrainingValues method
	
	public function getTrainingId() {
		return $this->trainingId;
	} // end getTrainingId method
	
	public function getTrainingTitle() {
		return $this->trainingTitle;
	} // end getTrainingTitle method
	
	public function getTrainingCategory() {
		return $this->trainingCategory;
	} // end getTrainingCategory method
	
	public function getTrainingDepartment() {
		return $this->trainingDepartment;
	} // end getTrainingDepartment method
	
	public function getTrainingConductedBy() {
		return $this->trainingConductedBy;
	} // end getTrainingConductedBy method
	
	public function getTrainingScheduleDate() {
		// date format for schedule date
			$timestamp = strtotime($this->trainingScheduleDate);
			$this->trainingScheduleDate = date('F d, Y', $timestamp);
		return $this->trainingScheduleDate;
	} // end getTrainingScheduleDate method
	
	public function getTrainingScheduleDateEdit() {
		// edit version is so date loads in 0000-00-00 format
		return $this->trainingScheduleDate;
	} // end getTrainingScheduleDate method
	
	public function getTrainingCompletionDate() {
		// if training is not complete, don't show 0's, show n/a
		if($this->trainingCompletionDate != '0000-00-00') {
			// date format for completion date
			$timestamp = strtotime($this->trainingCompletionDate);
			$this->trainingCompletionDate = date('F d, Y', $timestamp);
			return $this->trainingCompletionDate;
		} // end if
		else {
			return "n/a";
		} // end else
	} // end getTrainingCompletionDate method
	
	public function getTrainingAllTrainedDate() {
		// if training is not complete, don't show 0's, show n/a
		if($this->trainingAllTrainedDate != '0000-00-00') {
			// date format for schedule date
			$timestamp = strtotime($this->trainingAllTrainedDate);
			$this->trainingAllTrainedDate = date('F d, Y', $timestamp);
			return $this->trainingAllTrainedDate;
		} // end if
		else {
			//return "n/a";
			return $this->getTrainingPercentage($this->trainingId);
		} // end else
	} // end getTrainingAllTrainedDate method
	
	public function getTrainingDescription() {
		return $this->trainingDescription;
	} // end getTrainingDescription method
	
	
	public function displayTrainingConductedBySelect() {
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same account id, same department, and a role equal or less 	than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId='$this->accountId' AND managerDepartment = '$this->managerDepartment' AND managerRole >= '$this->managerRole'");
		}
		echo "
		<select name='trainingConductedBy'>
		<option value=''></option>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['managerFirstName'] . " " . $row['managerLastName'] . "'>". $row['managerFirstName'] . " " . $row['managerLastName'] . "</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayTrainingConductedBySelect
	
	
	public function displayTrainingConductedByEditSelect() {
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM manager WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same account id, same department, and a role equal or less 	than the logged in manager
			$result = $this->db->query("SELECT * FROM manager WHERE accountId='$this->accountId' AND managerDepartment = '$this->managerDepartment' AND managerRole >= '$this->managerRole'");
		}
		echo "
		<select name='trainingConductedBy'>
		";
		while ($row = $result->fetch_assoc()) {
			
			
			$result2 = $this->db->query("SELECT * FROM training WHERE accountId='$this->accountId'");
				$row2=$result2->fetch_assoc();
			
			echo " 
				<option value='" . $row['managerFirstName'] . " " . $row['managerLastName'] . "'"; 
				if ($this->trainingConductedBy == ($row['managerFirstName'] . " " . $row['managerLastName'])) echo "selected"; 
				
				echo ">". $row['managerFirstName'] . " " . $row['managerLastName'] . "</option>
				";
			
		} // end while
		echo "
		</select>
		";
	} // end displayTrainingConductedByEditSelect
	
	
	public function displayTrainingCategorySelect() {
			// gets all training categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' ORDER BY trainingCategoryName ASC");
			} // end if managerDepartment = All
			else {
			$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' AND (trainingCategoryDepartment = '$this->managerDepartment' OR trainingCategoryDepartment = 'All') ORDER BY trainingCategoryName ASC");
			} // end else
		echo "
		<select name='trainingCategory'>
		<option value=''></option>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['trainingCategoryName'] . "'>" . $row['trainingCategoryName'];
			if ($this->managerDepartment == 'All') {
				echo "- (" . $row['trainingCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayTrainingCategorySelect
	
	public function displayTrainingCategoryEditSelect() {
			// gets all training categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' ORDER BY trainingCategoryName ASC");
			} // end if
			else {
			$result = $this->db->query("SELECT * FROM training_category WHERE accountId='$this->accountId' AND trainingCategoryDepartment = '$this->managerDepartment' ORDER BY trainingCategoryName ASC");
			} // end else
		echo "
		<select name='trainingCategory'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
				<option value='" . $row['trainingCategoryName'] . "'"; 
				$result2 = $this->db->query("SELECT * FROM training WHERE accountId='$this->accountId' and trainingId = '$this->trainingId'");
				$row2  = $result2->fetch_assoc();
				if ($row2['trainingCategory'] == $row['trainingCategoryName']) echo "selected"; 
				
				echo ">". $row['trainingCategoryName'];
				if ($this->managerDepartment == 'All') {
				echo "- (" . $row['trainingCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				 </option>
				 ";
			
		} // end while
		echo "
		</select>
		";
	} // end displayTrainingCategoryEditSelect
	
	
	// this is for the display of departments on the edit_training page
	public function displayManagerDepartmentEditTrainingSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId = '$this->accountId' AND departmentName = '$this->managerDepartment'");
		} // end else
		
		
			echo "
				<select name='trainingDepartment'>
			";
			// get all manager departments
			while ($row = $result->fetch_assoc()) {
				
				$result2 = $this->db->query("SELECT * FROM training WHERE accountId='$this->accountId'");
				$row2=$result2->fetch_assoc();
				
			// display select form for available department selection
				echo " 
				<option value='" . $row['departmentName'] . "'"; 
				// if the property trainingDepartment is equal the department name from loop make default selection
				if ($this->trainingDepartment == $row['departmentName']) echo "selected"; 
				
				echo ">". $row['departmentName'] . "</option>
				";
				
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditTrainingSelect method
	
	
	
	public function updateTraining($trainingId) {
		$result = $this->db->prepare("UPDATE training SET trainingTitle=?,trainingCategory=?,trainingDepartment=?,trainingConductedBy=?,trainingDescription=?,trainingScheduleDate=? WHERE trainingId = '$trainingId'");

$result->bind_param('ssssss', $trainingTitle,$trainingCategory,$trainingDepartment,$trainingConductedBy,$trainingDescription,$trainingScheduleDate);


$trainingTitle = $_POST['trainingTitle'];
$trainingCategory = $_POST['trainingCategory'];
$trainingDepartment = $_POST['trainingDepartment'];
$trainingConductedBy = $_POST['trainingConductedBy'];
$trainingScheduleDate = $_POST['trainingScheduleDate'];
$trainingDescription = $_POST['trainingDescription'];


$result->execute();

// update info in training_completion database table
$result2 = $this->db->prepare("UPDATE training_completion SET trainingDepartment=?,trainingScheduleDate=? WHERE trainingId = '$trainingId'");

$result2->bind_param('ss', $trainingDepartment,$trainingScheduleDate);
$result2->execute();


header("Location: edit_selected_training.php?trainingUpdated=yes&trainingId=$trainingId");
	} // end updateTraining method
	
	
//********************DELETE TRAINING********************//

public function deleteTrainingList() {
	
	// START PAGING AND DISPLAYING OF TRAINING THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL TRAINING
		// QUERY TRAINING DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every training
			$result = $this->db->query("SELECT COUNT(trainingId) FROM training WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(trainingId) FROM training WHERE accountId='$this->accountId' AND trainingDepartment = '$this->managerDepartment'");
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
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every training
		$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingTitle ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on training department
		$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingTitle ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each employeeId to property for later use
			$this->trainingId = $row['trainingId'];
			
			// to get schedule date
			$result2 = $this->db->query("SELECT * FROM training_completion WHERE accountId = '$this->accountId' AND trainingId='$this->trainingId'");
			$row2=$result2->fetch_assoc();
			// date format for schedule date
			$timestamp = strtotime($row2['trainingScheduleDate']);
			$fmat_schedule_date = date('F d, Y', $timestamp);
			
			// gets dates from training_completion db
			$result2 = $this->db->query("SELECT * FROM training_completion WHERE trainingId = '$this->trainingId'");
			$row2 = $result2->fetch_assoc();
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set training values
			$this->setTrainingValues($this->trainingId); // primarily for the return of completion date
			
			// Display for training list
			echo "<div class='trainingListContent'>".
				 "<p><a href='delete_training.php?trainingId=$this->trainingId&trainingDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this training?\")'>"
				 .$row['trainingTitle']."</a></p>".
				 "<p>".$row['trainingCategory']."</p>".
				 "<p>".$row['trainingDepartment']."</p>".
				 "<p>".$row['trainingConductedBy']."</p>".
				 "<p>".$fmat_schedule_date."</p>".
				 "<p>".$this->getTrainingAllTrainedDate()."</p>".
				 "<!-- end .trainingListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_training.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='delete_training.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_training.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Training Data Available</p>";
		} // end else	
		
	} // end deleteTrainingList method
	
	public function deleteTraining($trainingId) {
		$result = $this->db->query("DELETE FROM training WHERE `trainingId` = '$trainingId'");
		
		$result2 = $this->db->query("DELETE FROM training_completion WHERE trainingId = '$trainingId'");
		
	} // end deleteTraining method

//********************END DELETE TRAINING********************//


public function searchTraining($searchTraining) {
			// SEARCH RESULTS
			$foundTraining = $searchTraining;
			$words = explode(" ", $foundTraining);
			$phrase = implode("%' AND trainingTitle LIKE '%", $words);

			// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every training
		$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingTitle LIKE '%$phrase%' ORDER BY trainingTitle ASC");
	} // end if
	else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' AND trainingTitle LIKE '%$phrase%' ORDER BY trainingTitle ASC");
	}
    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			
			// stores each trainingId to property for later use
			$this->trainingId = $row['trainingId'];
			
			// to get schedule date
			$result2 = $this->db->query("SELECT * FROM training_completion WHERE accountId = '$this->accountId' AND trainingId='$this->trainingId'");
			$row2=$result2->fetch_assoc();
			// date format for schedule date
			$timestamp = strtotime($row2['trainingScheduleDate']);
			$fmat_schedule_date = date('F d, Y', $timestamp);
			
			// check for completion date
			if($row['trainingAllTrainedDate'] != '0000-00-00') {
				// date format for all completed date
				$timestamp = strtotime($row['trainingAllTrainedDate']);
				$fmat_alltrained_date = date('F d, Y', $timestamp);
			} // end if for completion date check
			else {
				// if equal to 0000-00-00, display percentage instead
				$fmat_alltrained_date = $this->getTrainingPercentage($this->trainingId);
			} // end else
			
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			
			// Display for training list
			echo "<div class='trainingListContent'>".
				 "<p><a href='training_profile.php?trainingId=$this->trainingId'>".$row['trainingTitle']."</a></p>".
				 "<p>".$row['trainingCategory']."</p>".
				 "<p>".$row['trainingDepartment']."</p>".
				 "<p>".$row['trainingConductedBy']."</p>".
				 "<p>".$fmat_schedule_date."</p>".
				 "<p>".$fmat_alltrained_date."</p>".
				 "<!-- end .trainingListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		} // end if
		else { // if no results display this
			echo "<p>No Training Data Available</p>";
		} // end else
	} // end searchTraining method
	
	
	// get training completion count to display as a percentage
	public function getTrainingPercentage($trainingId) {
		// query to get total number based on training ID
		$result = $this->db->query("SELECT COUNT(*) FROM training_completion WHERE trainingId='$trainingId'");
		$totalTraining = $result->fetch_row();
		
		// query to get total training completed based on training ID
		$result2 = $this->db->query("SELECT COUNT(*) FROM training_completion WHERE trainingId='$trainingId' AND trainingCompletionDate!='0000-00-00'");
		$completedTraining = $result2->fetch_row();
		
		// divide and multiply to get the percentage of training completed
		$percentcomplete = ($completedTraining[0] / $totalTraining[0]) * 100;
		return round($percentcomplete) . "% Complete";
		
		
	} // end getTrainingPercentage
	

	public function showTrainingGraph() {
		
		
		// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every training
		$result4 = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' ORDER BY trainingId DESC LIMIT 5");
	} // end if
	else {// otherwise compare manager department based on employee department
		$result4 = $this->db->query("SELECT * FROM training WHERE accountId = '$this->accountId' AND trainingDepartment = '$this->managerDepartment' ORDER BY trainingId DESC LIMIT 5");
	} // end else
		
		if ($result4->num_rows > 0) { // if rows exist
		
		echo "
		<div class='training_dashboard_column_header_1'><p>Title</p></div>
    <div class='training_dashboard_column_header_2'><p>% Complete</p></div>
    <div class='clr'></div>
	";
	
		// loop through each training listed in training table
		while($row4 = $result4->fetch_assoc()) {
		
		
		
		// query to get total number based on training ID
		$result = $this->db->query("SELECT COUNT(*) FROM training_completion WHERE trainingId='$row4[trainingId]'");
		$totalTraining = $result->fetch_row();
		
		// query to get total training completed based on training ID
		$result2 = $this->db->query("SELECT COUNT(*) FROM training_completion WHERE trainingId='$row4[trainingId]' AND trainingCompletionDate!='0000-00-00'");
		$completedTraining = $result2->fetch_row();
		
		// divide and multiply to get the percentage of training completed
		$percentcomplete = round(($completedTraining[0] / $totalTraining[0]) * 100);
		
		// display results as bar graph with title and % complete	
		echo "
		<div class='result_title'><img src='images/training.png' alt=''><a href='training_profile.php?trainingId=$row4[trainingId]'>$row4[trainingTitle]</a></div>
		<div class='result_percent'>$percentcomplete % </div>
		<div class='result_bar_container'>
		<div class='result_bar' style='width:$percentcomplete%'>
		";
		// if percent at 100%, display all employees trained completion date inside result_bar
		// date format for all completed date
				$timestamp = strtotime($row4['trainingAllTrainedDate']);
				$fmat_alltrained_date = date('F d, Y', $timestamp);
		if($percentcomplete == '100') {
			echo "<span>Completion Date: " . $fmat_alltrained_date . "</span>";
		}
		echo "
		
		</div>
		 <!-- end .result_bar_container --></div> 
		 <div class='clr'></div><!-- clear each row -->
		 ";
		
		} // end while
		} // end if rows exist
		else {
			echo "
				<p>No training is currently available.</p>
				";
		} // end else
	} // end showTrainingGraph
	
	public function showTrainingRedFlag() {
		// get todays date
		$today = date('Y-m-d');
		// query joins training, training_completion, and employee based on trainingId and employeeId
		if($this->managerDepartment == 'All') {
		$result = $this->db->query("SELECT DISTINCT training.trainingId,training.trainingTitle,  training.trainingDepartment, training_completion.employeeId, training_completion.trainingScheduleDate, employee.employeeFirstName, employee.employeeLastName FROM training INNER JOIN training_completion ON training.trainingId = training_completion.trainingId INNER JOIN employee ON training_completion.employeeId = employee.employeeId WHERE training.trainingScheduleDate < '$today' AND training_completion.trainingCompletionDate = '0000-00-00' AND training.accountId='$this->accountId'");
		} // end if managerDepartment = All
		else {
			$result = $this->db->query("SELECT DISTINCT training.trainingId,training.trainingTitle,  training.trainingDepartment, training_completion.employeeId, training_completion.trainingScheduleDate, employee.employeeFirstName, employee.employeeLastName FROM training INNER JOIN training_completion ON training.trainingId = training_completion.trainingId INNER JOIN employee ON training_completion.employeeId = employee.employeeId WHERE training.trainingScheduleDate < '$today' AND training_completion.trainingCompletionDate = '0000-00-00' AND training.accountId='$this->accountId' AND training.trainingDepartment='$this->managerDepartment'");
		} // end else
		
		if($result->num_rows > 0) { // if there are results
		
		echo "
		<div class='trainingredflag_dashboard'>
    	<h3>Past Due Employee Training</h3>
		<div class='trainingredflag_dashboard_column_header'><p>Training Title</p></div>
		<div class='trainingredflag_dashboard_column_header'><p>Employee Name</p></div>
		<div class='trainingredflag_dashboard_column_header'><p>Employee Department</p></div>
		<div class='trainingredflag_dashboard_column_header'><p>Scheduled Date</p></div>
		";
		
		while($row = $result->fetch_assoc()) {
				// date format for all schedule date
				$timestamp = strtotime($row['trainingScheduleDate']);
				$fmat_schedule_date = date('F d, Y', $timestamp);
			
			echo "<div class='trainingredflag_dashboard_column'><p><a href='training_record_list.php?trainingId=$row[trainingId]'><img src='images/flag_orange.png' alt='' />" . $row['trainingTitle'] . "</a></p></div><div class='trainingredflag_dashboard_column'><p><a href='training_record.php?employeeId=$row[employeeId]'>" . $row['employeeFirstName'] . " " . $row['employeeLastName'] . "</a></p></div><div class='trainingredflag_dashboard_column'><p>" . $row['trainingDepartment'] . "</p></div><div class='trainingredflag_dashboard_column'><p>" . $fmat_schedule_date . "</p></div>";
		} // end while
		echo "<!-- end .trainingredflag_dashboard --></div>";
		} // end if results exist
	} // end showTrainingRedFlag
	
	
	
} // end Training class