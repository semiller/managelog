<?php
class SafeTrack extends DbConnect {
	// declare properties
	protected $accountId;
	protected $managerDepartment;
	protected $managerRole;
	protected $managerFirstName;
	protected $managerLastName;
	
	protected $safetrackId;
	protected $safetrackDepartment;
	protected $safetrackTitle;
	protected $safetrackCategory;
	protected $safetrackDescription;
	protected $safetrackAction;
	protected $safetrackCreateDate;
	protected $safetrackSubmittedBy;
	protected $safetrackBeforePic;
	protected $safetrackAfterPic;
	protected $safetrackCompletionDate;
	
	protected $sortSafeTrack;
	
	protected $allEmployees;
	protected $employeeId;
	
	protected $viewAuth = true; // determines whether get has been changed to unauthorized view
	
	public function __construct() {
		parent::__construct();
		$this->accountId = $_SESSION['accountId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
		$this->managerFirstName = $_SESSION['managerFirstName'];
		$this->managerLastName = $_SESSION['managerLastName'];
	} // end construct
	
	public function addSafeTrack() {
		
		// IF THE FILE UPLOAD IS EMPTY INSERT INTO DATABASE WITHOUT IMAGE.  MUST CHECK TMP_NAME AS EMPTY TO DETERMINE

if ($_FILES['safetrackBeforePic']['tmp_name'] == '') {
		
		$result = $this->db->prepare("INSERT INTO safetrack(accountId,safetrackDepartment,safetrackTitle,safetrackCategory,safetrackDescription,safetrackAction,safetrackCreateDate,safetrackSubmittedBy,safetrackCompletionDate) VALUES (?,?,?,?,?,?,?,?,?)");
		
$result->bind_param('sssssssss', $this->accountId, $safetrackDepartment, $safetrackTitle, $safetrackCategory, $safetrackDescription, $safetrackAction, $safetrackCreateDate, $safetrackSubmittedBy, $safetrackCompletionDate);

// get values entered from form
$safetrackDepartment = $_POST['safetrackDepartment'];
$safetrackTitle = $_POST['safetrackTitle'];
$safetrackCategory = $_POST['safetrackCategory'];
$safetrackDescription = $_POST['safetrackDescription'];
$safetrackAction = $_POST['safetrackAction'];
$safetrackCreateDate = date("Y-m-d");
$safetrackSubmittedBy = $this->managerFirstName . " " . $this->managerLastName;
$safetrackCompletionDate = '';

$result->execute();
	
} // END IF STATEMENT
else {
	// IF IMAGEIS UPLOADED PERFORM FILE CHECKS BELOW AND INSERT INTO DATABASE
	$target_path = "safetrack_images/";
	// VARIABLE TO CREATE RANDOM NUMBER TO ADD TO FILE NAME
	$ran = rand(0000,9999);
	// TARGET PATH PLUS RANDOM NUMBER PLUS FILENAME
	$target_path = $target_path . $ran . basename($_FILES['safetrackBeforePic']['name']);
	// CHECK TO MAKE SURE ITS A JPEG AND CERTAIN SIZE
	$ext = substr($target_path, strrpos($target_path, '.') + 1);
	// FOR FILE TYPE ADD IMAGE/PJPEG FOR IE UPLOADS OR IMAGE/JPEG FOR ALL OTHER BROWSERS
	if (($ext =='jpg' || $ext =='JPG' || $ext =='jpeg' || $ext =='JPEG') && ($_FILES['safetrackBeforePic']['type'] == 'image/jpeg' || $_FILES['safetrackBeforePic']['type'] == 'image/pjpeg') && ($_FILES['safetrackBeforePic']['size'] < 5242880)) {
		
		if(move_uploaded_file($_FILES['safetrackBeforePic']['tmp_name'], $target_path)) {
		// INSERT INTO DATABASE WITH IMAGE
			$result = $this->db->prepare("INSERT INTO safetrack(accountId,safetrackDepartment,safetrackTitle,safetrackCategory,safetrackDescription,safetrackAction,safetrackCreateDate,safetrackSubmittedBy,safetrackBeforePic,safetrackCompletionDate) VALUES (?,?,?,?,?,?,?,?,?,?)");
		
$result->bind_param('ssssssssss', $this->accountId, $safetrackDepartment, $safetrackTitle, $safetrackCategory, $safetrackDescription, $safetrackAction, $safetrackCreateDate, $safetrackSubmittedBy, $safetrackBeforePic, $safetrackCompletionDate);

// get values entered from form
$safetrackDepartment = $_POST['safetrackDepartment'];
$safetrackTitle = $_POST['safetrackTitle'];
$safetrackCategory = $_POST['safetrackCategory'];
$safetrackDescription = $_POST['safetrackDescription'];
$safetrackAction = $_POST['safetrackAction'];
$safetrackCreateDate = date("Y-m-d");
$safetrackSubmittedBy = $this->managerFirstName . " " . $this->managerLastName;
// set before pic to equal target path
$safetrackBeforePic = $target_path;
$safetrackCompletionDate = '';

$result->execute();

} // END IF STATEMENT TO MOVE IMAGE TO DATABASE
	} // END IF TO CHECK AS JPG
} // END ELSE STATEMENT HOLDING ALL CODE TO MOVE FILE

/* If Training option is choosen, add the safetrack to a training session for the listed employees */
if(isset($_POST['allEmployees']) || isset($_POST['employeeId'])) {
$result = $this->db->prepare("INSERT INTO training(accountId,trainingTitle,trainingCategory,trainingDepartment,trainingConductedBy,trainingDescription) VALUES (?,?,?,?,?,?)");
		
$result->bind_param('ssssss', $this->accountId, $trainingTitle, $trainingCategory, $trainingDepartment, $trainingConductedBy, $trainingDescription);

// get values entered from form
$trainingTitle = $_POST['safetrackTitle'];
$trainingCategory = $_POST['safetrackCategory'];
$trainingDepartment = $_POST['safetrackDepartment'];
$trainingConductedBy = $this->managerFirstName . " " . $this->managerLastName;
$trainingScheduleDate = date ('Y-m-d');
$trainingDescription = $_POST['safetrackDescription'];
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


// if training is conducted add the safetrack category to the training category for future use
	$result9 = $this->db->query("SELECT * FROM training_category WHERE trainingCategoryName = '$trainingCategory' && trainingCategoryDepartment = '$trainingDepartment'");
	// if there are no records of the category name and department together add to training category
		if ($result9->num_rows == 0) {

	$result = $this->db->prepare("INSERT INTO training_category (accountId,trainingCategoryName,trainingCategoryDepartment) VALUES (?,?,?)");	
	$result->bind_param('sss', $this->accountId, $trainingCategoryName, $trainingCategoryDepartment);
	$trainingCategoryName= $_POST['safetrackCategory'];
	$trainingCategoryDepartment = $_POST['safetrackDepartment'];
	$result->execute();
		} // end if
	
	// end add to training category




// END IF TRAINING IS BEIGN CONDUCTED
} // end if statement if employees are selected

// go here when complete
header("Location: add_safetrack.php?safetrackAdded=yes");
	} // end addSafeTrack method
	
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

	public function safetrackSelectDisplay($link) { // $link is href to carry GET
	
	// Sort SafeTrack Selection - store value
	// stores initial value
	$this->sortSafeTrack = $_POST['sortSafeTrack'];
	// this is used for paging.  if sort value is set, get the value to keep the sortSafeTrack property loaded
	if (isset($_GET['sort'])) {
	$this->sortSafeTrack = $_GET['sort'];
	} // end if get page is set
	
	
	// START PAGING AND DISPLAYING OF TRAINING  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL FIFI
		// QUERY safetrack DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
			$result = $this->db->query("SELECT COUNT(safetrackId) FROM safetrack WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(safetrackId) FROM safetrack WHERE accountId='$this->accountId' AND safetrackDepartment = '$this->managerDepartment'");
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
		
		
		// IF SORT BY TITLE
		if ($this->sortSafeTrack == 'safetrackTitle') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by safetrack title
		
		// IF SORT BY CATEGORY
		if ($this->sortSafeTrack == 'safetrackCategory') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackCategory ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackCategory ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by safetrack category
		
		// IF SORT BY DEPARTMENT
		if ($this->sortSafeTrack == 'safetrackDepartment') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackDepartment ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackDepartment ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by safetrack department
		
		// IF SORT BY SUBMITTED BY
		if ($this->sortSafeTrack == 'safetrackSubmittedBy') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by safetrack submitted by
		
		// IF SORT BY CREATE DATE
		if ($this->sortSafeTrack == 'safetrackCreateDate') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackCreateDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackCreateDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by safetrack create date
		
		// IF SORT BY COMPLETION DATE
		if ($this->sortSafeTrack == 'safetrackCompletionDate') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackCompletionDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackCompletionDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort by safetrack completion date
		
		
if ($this->sortSafeTrack == '' || !isset($this->sortSafeTrack)) {
//******* THIS IS THE DEFAULT IF NO SORTING SELECTION IS MADE - SORT BY TITLE *********// 
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackTitle ASC LIMIT $offset,$recordsperpage");
		} // end if
		else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackTitle ASC LIMIT $offset,$recordsperpage");
		} // end else
} // end if sort safetrack is not set or blank
		
		
		
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each safetrackId to property for later use
			$this->safetrackId = $row['safetrackId'];
			
			// date format for schedule date
			$timestamp = strtotime($row['safetrackCreateDate']);
			$fmat_create_date = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set safetrack values
			$this->setSafeTrackValues($this->safetrackId);
			
			// Display for safetrack list
			echo "".
				 "<div class='safetrackListContent'>".
				 "<p><a href='$link?safetrackId=$this->safetrackId'>".$row['safetrackTitle']."</a></p>".
				 "<p>".$row['safetrackCategory']."</p>".
				 "<p>".$row['safetrackDepartment']."</p>".
				 "<p>".$row['safetrackSubmittedBy']."</p>".
				 "<p>".$fmat_create_date."</p>".
				 "<p>".$this->getSafeTrackCompletionDate()."</p>".
				 "<!-- end .safetrackListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='safetrack.php?page=$page&sort=$this->sortSafeTrack'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='safetrack.php?page=$page&sort=$this->sortSafeTrack'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='safetrack.php?page=$page&sort=$this->sortSafeTrack'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Safety Tracker Data Available</p>";
		} // end else
		
	} // end safetrackSelectDisplay method
	
	
	public function getViewAuth() {
			return $this->viewAuth;
		} // end getViewAuth method
	
	
	public function setSafeTrackValues($safetrackId) {
		
		// safetrack id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM safetrack WHERE safetrackId = '$safetrackId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of training information
			echo " <div class='left'><h2>Unauthorized View</h2><p>You are not authorized to view the selected safety tracker details.</p></div>";
		} //end if
		else {
		
		
		// get all training database values based on ID number
		$result = $this->db->query("SELECT * FROM safetrack WHERE safetrackId = '$safetrackId'");
		$row = $result->fetch_assoc();
	
		// store property values
		$this->safetrackId = $row['safetrackId'];
		$this->safetrackTitle = $row['safetrackTitle'];
		$this->safetrackCategory = $row['safetrackCategory'];
		$this->safetrackDepartment = $row['safetrackDepartment'];
		$this->safetrackCreateDate = $row['safetrackCreateDate'];
		$this->safetrackSubmittedBy = $row['safetrackSubmittedBy'];
		$this->safetrackDescription = $row['safetrackDescription'];
		$this->safetrackAction = $row['safetrackAction'];
		$this->safetrackBeforePic = $row['safetrackBeforePic'];
		$this->safetrackAfterPic = $row['safetrackAfterPic'];
		$this->safetrackCompletionDate = $row['safetrackCompletionDate'];
		
		
		} // end else authorized view
	} // end setSafeTrackValues method
	
	public function getSafeTrackId() {
		return $this->safetrackId;
	} // end getSafeTrackId method
	
	public function getSafeTrackTitle() {
		return $this->safetrackTitle;
	} // end getSafeTrackTitle method
	
	public function getSafeTrackCategory() {
		return $this->safetrackCategory;
	} // end getSafeTrackCategory method
	
	public function getSafeTrackDepartment() {
		return $this->safetrackDepartment;
	} // end getSafeTrackDepartment method
	
	public function getSafeTrackSubmittedBy() {
		return $this->safetrackSubmittedBy;
	} // end getSafeTrackConductedBy method
	
	public function getSafeTrackDescription() {
		return $this->safetrackDescription;
	} // end getSafeTrackDescription method
	
	public function getSafeTrackAction() {
		return $this->safetrackAction;
	} // end getSafeTrackAction method
	
	public function getSafeTrackBeforePic() {
		if ($this->safetrackBeforePic != '') {
		return "<img src='$this->safetrackBeforePic' alt=''>";
		} // end if
		else {
			return "n/a";
		} // end else
	} // end getSafeTrackBeforePic method
	
	public function getSafeTrackAfterPic() {
		if ($this->safetrackAfterPic != '') {
		return "<img src='$this->safetrackAfterPic' alt=''>";
		} // end if
		else {
			return "n/a";
		} // end else
	} // end getSafeTrackAfterPic method
	
	public function getSafeTrackCreateDate() {
		// date format for create date
			$timestamp = strtotime($this->safetrackCreateDate);
			$this->safetrackCreateDate = date('F d, Y', $timestamp);
		return $this->safetrackCreateDate;
	} // end getSafeTrackCreateDate method
	
	
	public function getSafeTrackCompletionDate() {
		// if safetrack is not complete, don't show 0's, show n/a
		if($this->safetrackCompletionDate != '0000-00-00') {
			// date format for completion date
			$timestamp = strtotime($this->safetrackCompletionDate);
			$this->safetrackCompletionDate = date('F d, Y', $timestamp);
			return $this->safetrackCompletionDate;
		} // end if
		else { // this return creates link to mark safetrack complete.  it passes back to the safetracks.php page and then performs the markComplete function
			return "<a href='safetrack.php?markSafeTrackComplete=yes&safetrackId=$this->safetrackId' onClick='return confirm('Are you sure you want to mark this discrepancy complete?')'><img src='images/accept.png' alt='Mark Complete' class='float_img' />Mark Complete</a>";
		} // end else
	} // end getSafeTrackCompletionDate method
	
	// this one is used to check whether to display on right menu
		  public function getSafeTrackCompletionDateMenu() {
			  return $this->safetrackCompletionDate;
		  } // end safetrack complete date menu
	
	public function displaySafeTrackCategorySelect() {
			// gets all safetrack categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' ORDER BY safetrackCategoryName ASC");
			} // end if managerDepartment = all
			else {
			$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' AND (safetrackCategoryDepartment = '$this->managerDepartment' OR safetrackCategoryDepartment = 'All') ORDER BY safetrackCategoryName ASC");
			} // end else
		echo "
		<select name='safetrackCategory'>
		<option value=''></option>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['safetrackCategoryName'] . "'>" . $row['safetrackCategoryName'];
			if ($this->managerDepartment == 'All') {
				echo "- (" . $row['safetrackCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displaySafeTrackCategorySelect
	
	public function displaySafeTrackCategoryEditSelect() {
			// gets all safetrack categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' ORDER BY safetrackCategoryName ASC");
			} // end if
			else {
			$result = $this->db->query("SELECT * FROM safetrack_category WHERE accountId='$this->accountId' AND safetrackCategoryDepartment = '$this->managerDepartment' OR safetrackCategoryDepartment = 'All' ORDER BY safetrackCategoryName ASC");
			} // end else
		echo "
		<select name='safetrackCategory'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
				<option value='" . $row['safetrackCategoryName'] . "'"; 
				$result2 = $this->db->query("SELECT * FROM safetrack WHERE accountId='$this->accountId' and safetrackId = '$this->safetrackId'");
				$row2  = $result2->fetch_assoc();
				if ($row2['safetrackCategory'] == $row['safetrackCategoryName']) echo "selected"; 
				
				echo ">". $row['safetrackCategoryName'];
				if ($this->managerDepartment == 'All') {
				echo "- (" . $row['safetrackCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				 </option>
				 ";
			
		} // end while
		echo "
		</select>
		";
	} // end displaySafeTrackCategoryEditSelect
	
	
	// this is for the display of departments on the edit_training page
	public function displayManagerDepartmentEditSafeTrackSelect() {	
		// select all if manager department equals All
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId = '$this->accountId' AND departmentName = '$this->managerDepartment'");
		} // end else
		
		
			echo "
				<select name='safetrackDepartment'>
			";
			// get all manager departments
			while ($row = $result->fetch_assoc()) {
				
				$result2 = $this->db->query("SELECT * FROM safetrack WHERE accountId='$this->accountId'");
				$row2=$result2->fetch_assoc();
				
			// display select form for available department selection
				echo " 
				<option value='" . $row['departmentName'] . "'"; 
				// if the property safetrackDepartment is equal the department name from loop make default selection
				if ($this->safetrackDepartment == $row['departmentName']) echo "selected"; 
				
				echo ">". $row['departmentName'] . "</option>
				";
				
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditSafeTrackSelect method
	
	public function updateSafeTrackComplete($safetrackId) { 
		$today = date('Y-m-d');
		// updates the safetrack completion date
		$result = $this->db->query("UPDATE safetrack SET safetrackCompletionDate='$today' WHERE safetrackId='$safetrackId'");	
		} // end updateSafeTrackComplete
	
	public function updateSafeTrack($safetrackId) {
		
		// IF THE FILE UPLOAD IS EMPTY INSERT INTO DATABASE WITHOUT IMAGE.  MUST CHECK TMP_NAME AS EMPTY TO DETERMINE
if ($_FILES['safetrackAfterPic']['tmp_name'] == '') {
		
		$result = $this->db->prepare("UPDATE safetrack SET safetrackTitle=?,safetrackCategory=?,safetrackDepartment=?,safetrackDescription=?,safetrackAction=? WHERE safetrackId = '$safetrackId'");

$result->bind_param('sssss', $safetrackTitle,$safetrackCategory,$safetrackDepartment,$safetrackDescription,$safetrackAction);


$safetrackTitle = $_POST['safetrackTitle'];
$safetrackCategory = $_POST['safetrackCategory'];
$safetrackDepartment = $_POST['safetrackDepartment'];
$safetrackDescription = $_POST['safetrackDescription'];
$safetrackAction = $_POST['safetrackAction'];

$result->execute();

} // END IF STATEMENT
else {
	// IF IMAGEIS UPLOADED PERFORM FILE CHECKS BELOW AND INSERT INTO DATABASE
	$target_path = "safetrack_images/";
	// VARIABLE TO CREATE RANDOM NUMBER TO ADD TO FILE NAME
	$ran = rand(0000,9999);
	// TARGET PATH PLUS RANDOM NUMBER PLUS FILENAME
	$target_path = $target_path . $ran . basename($_FILES['safetrackAfterPic']['name']);
	// CHECK TO MAKE SURE ITS A JPEG AND CERTAIN SIZE
	$ext = substr($target_path, strrpos($target_path, '.') + 1);
	// FOR FILE TYPE ADD IMAGE/PJPEG FOR IE UPLOADS OR IMAGE/JPEG FOR ALL OTHER BROWSERS
	if (($ext =='jpg' || $ext =='JPG' || $ext =='jpeg' || $ext =='JPEG') && ($_FILES['safetrackAfterPic']['type'] == 'image/jpeg' || $_FILES['safetrackAfterPic']['type'] == 'image/pjpeg') && ($_FILES['safetrackAfterPic']['size'] < 5242880)) {
		
		if(move_uploaded_file($_FILES['safetrackAfterPic']['tmp_name'], $target_path)) {
$result = $this->db->prepare("UPDATE safetrack SET safetrackTitle=?,safetrackCategory=?,safetrackDepartment=?,safetrackDescription=?,safetrackAction=?,safetrackAfterPic=? WHERE safetrackId = '$safetrackId'");

$result->bind_param('ssssss', $safetrackTitle,$safetrackCategory,$safetrackDepartment,$safetrackDescription,$safetrackAction,$safetrackAfterPic);


$safetrackTitle = $_POST['safetrackTitle'];
$safetrackCategory = $_POST['safetrackCategory'];
$safetrackDepartment = $_POST['safetrackDepartment'];
$safetrackDescription = $_POST['safetrackDescription'];
$safetrackAction = $_POST['safetrackAction'];
$safetrackAfterPic = $target_path;

$result->execute();
} // END IF STATEMENT TO MOVE IMAGE TO DATABASE
	} // END IF TO CHECK AS JPG
} // END ELSE STATEMENT HOLDING ALL CODE TO MOVE FILE
header("Location: edit_selected_safetrack.php?safetrackUpdated=yes&safetrackId=$safetrackId");
	} // end updateSafeTrack method
	
	
//********************DELETE SAFETRACK********************//

	public function deleteSafeTrackList() {
	
	// START PAGING AND DISPLAYING OF SAFETRACK  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL SAFETRACK
		// QUERY SAFETRACK DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
			$result = $this->db->query("SELECT COUNT(safetrackId) FROM safetrack WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(safetrackId) FROM safetrack WHERE accountId='$this->accountId' AND safetrackDepartment = '$this->managerDepartment'");
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
	
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackTitle ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on safetrack department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' ORDER BY safetrackTitle ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each safetrackId to property for later use
			$this->safetrackId = $row['safetrackId'];
			
		
			// date format for create date
			$timestamp = strtotime($row['safetrackCreateDate']);
			$fmat_safetrack_createdate = date('F d, Y', $timestamp);
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set safetrack values
			$this->setSafeTrackValues($this->safetrackId); // primarily for the return of completion date
			
			// Display for safetrack list
			echo "<div class='safetrackListContent'>".
				 "<p><a href='delete_safetrack.php?safetrackId=$this->safetrackId&safetrackDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this safetrack?\")'>"
				 .$row['safetrackTitle']."</a></p>".
				 "<p>".$row['safetrackCategory']."</p>".
				 "<p>".$row['safetrackDepartment']."</p>".
				 "<p>".$row['safetrackSubmittedBy']."</p>".
				 "<p>".$fmat_safetrack_createdate."</p>".
				 "<p>".$this->getSafeTrackCompletionDate()."</p>".
				 "<!-- end .safetrackListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_safetrack.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='delete_safetrack.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_safetrack.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Safety Tracker Data Available</p>";
		} // end else	
		
	} // end deleteSafeTrackList method



	public function deleteSafeTrack($safetrackId) {
		// get picture links from database
		$result = $this->db->query("SELECT safetrackBeforePic,safetrackAfterPic FROM safetrack WHERE `safetrackId` = '$safetrackId'");
		$row = $result->fetch_assoc();
		if ($row['safetrackBeforePic'] != '') {
		// unlink or delete the pictures
		unlink($row['safetrackBeforePic']);
		} // end if
		if ($row['safetrackAfterPic'] != '') {
		unlink($row['safetrackAfterPic']);
		} // end if
		// delete images before deleting the row 
		$result = $this->db->query("DELETE FROM safetrack WHERE `safetrackId` = '$safetrackId'");
		
	} // end deleteSafeTrack method

//********************END DELETE SAFETRACK********************//


public function searchSafeTrack($searchSafeTrack) {
			// SEARCH RESULTS
			$foundSafeTrack = $searchSafeTrack;
			$words = explode(" ", $foundSafeTrack);
			$phrase = implode("%' AND safetrackTitle LIKE '%", $words);

			// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every safetrack
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackTitle LIKE '%$phrase%' ORDER BY safetrackTitle ASC");
	} // end if
	else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' AND safetrackTitle LIKE '%$phrase%' ORDER BY safetrackTitle ASC");
	}
    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			
			// stores each safetrackId to property for later use
			$this->safetrackId = $row['safetrackId'];
			
			// date format for schedule date
			$timestamp = strtotime($row['safetrackCreateDate']);
			$fmat_create_date = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set safetrack values
			$this->setSafeTrackValues($this->safetrackId);
			
			// Display for safetrack list
			echo "<div class='safetrackListContent'>".
				 "<p><a href='safetrack_profile.php?safetrackId=$this->safetrackId'>".$row['safetrackTitle']."</a></p>".
				 "<p>".$row['safetrackCategory']."</p>".
				 "<p>".$row['safetrackDepartment']."</p>".
				 "<p>".$row['safetrackSubmittedBy']."</p>".
				 "<p>".$fmat_create_date."</p>".
				 "<p>".$this->getSafeTrackCompletionDate()."</p>".
				 "<!-- end .safetrackListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		} // end if
		else { // if no results display this
			echo "<p>No Safety Tracker Data Available</p>";
		} // end else
	} // end searchSafeTrack method
	

	public function safetrackDashboardDisplay() {	
		
				
			 if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all safetrack for account		
			 	// display a list of the todays journal entries submitted
			 	$result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' ORDER BY safetrackId DESC");
			 } // end if managerDepartment = All
			 else {
				 $result = $this->db->query("SELECT * FROM safetrack WHERE accountId = '$this->accountId' AND safetrackDepartment = '$this->managerDepartment' OR safetrackDepartment = 'All' ORDER BY safetrackId DESC");
			 } // end else
			 
			 if ($result->num_rows > 0) { // if there are results display them
			 
			 echo "
			 <div class='safetrack_dashboard_column_header'><p>Title</p></div>
    		 <div class='safetrack_dashboard_column_header'><p>Category</p></div>
			 <div class='safetrack_dashboard_column_header'><p>Department</p></div>
			 <div class='safetrack_dashboard_column_header'><p>Submitted By</p></div>
			 <div class='safetrack_dashboard_column_header'><p>Created</p></div>
    		 <div class='clr'></div>
			";
			 
			 // loop to display list
			 while($row = $result->fetch_assoc()) {
				 
				 // date format for schedule date
			$timestamp = strtotime($row['safetrackCreateDate']);
			$fmat_create_date = date('F d, Y', $timestamp);
								 
			 	echo "<div class='safetrack_dashboard_column'><p><img src='images/safetrack.png' alt=''><a href='safetrack_profile.php?safetrackId=$row[safetrackId]'>" . $row['safetrackTitle'] . "</a></p></div>
				<div class='safetrack_dashboard_column'><p>" . $row['safetrackCategory'] . "</p></div>
				<div class='safetrack_dashboard_column'><p>" . $row['safetrackDepartment'] . "</p></div>
				<div class='safetrack_dashboard_column'><p>" . $row['safetrackSubmittedBy'] . "</p></div>
				<div class='safetrack_dashboard_column'><p>" . $fmat_create_date . "</p></div>
				<div class='clr'></div>";
				
			 } // end while
			 } // end if exist display list
			 else {
				 $today = date("F d, Y");
				 echo "
				 <p>No Safety Tracker Data Available.</p>
				 ";
			 } // end else
	} // end safetrackDashboardDisplay
	

} // end SafeTrack class