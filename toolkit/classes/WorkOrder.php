<?php
class WorkOrder extends DbConnect {
	// declare properties
	protected $db;
	
	protected $accountId;
	protected $managerDepartment;
	protected $managerFirstName;
	protected $managerLastName;
	protected $managerId;
	
	protected $workorderId;
    protected $workorderTitle;
	protected $workorderCategory;
	protected $workorderDepartment;
    protected $workorderDescription;
	protected $workorderPriority;
	protected $workorderLocation;
    protected $workorderCreateDate;
    protected $workorderCompletionDate;
    protected $workorderSubmittedBy;
	
	protected $sortWorkOrder;
	
	protected $workorderUpdateComments;
		  
		  protected $viewAuth = true; // determines whether get has been changed to unauthorized view
	
	public function __construct() {
		parent::__construct();
		$this->accountId = $_SESSION['accountId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
		$this->managerId = $_SESSION['managerId'];
		$this->managerFirstName = $_SESSION['managerFirstName'];
		$this->managerLastName = $_SESSION['managerLastName'];
	} // end construct
	
	public function addWorkOrder() {
		$result = $this->db->prepare("INSERT INTO workorder(accountId,workorderTitle,workorderCategory,workorderDepartment,workorderCreateDate,workorderSubmittedBy,workorderDescription,workorderPriority,workorderLocation) VALUES (?,?,?,?,?,?,?,?,?)");

$result->bind_param('sssssssss', $this->accountId, $workorderTitle, $workorderCategory, $workorderDepartment, $workorderCreateDate, $workorderSubmittedBy, $workorderDescription, $workorderPriority, $workorderLocation);

// get values entered from form
$workorderTitle = $_POST['workorderTitle'];
$workorderCategory = $_POST['workorderCategory'];
$workorderDepartment = $_POST['workorderDepartment'];
$workorderCreateDate = date('Y-m-d');
$workorderSubmittedBy = $this->managerFirstName . " " . $this->managerLastName;
$workorderDescription = $_POST['workorderDescription'];
$workorderPriority = $_POST['workorderPriority'];
$workorderLocation = $_POST['workorderLocation'];
$workorderCompletionDate = '';

$result->execute();

header("Location: add_workorders.php?workorderAdded=yes");

	} // end addWorkOrder method

          
		  
		  // ************************READ WORK ORDERS************************** //
		  
		  public function workorderSelectDisplay($link) { // $link is href to carry GET
		  
	// Sort Work Order Selection - store value
	// stores initial value
	$this->sortWorkOrder = $_POST['sortWorkOrder'];
	// this is used for paging.  if sort value is set, get the value to keep the sortWorkOrder property loaded
	if (isset($_GET['sort'])) {
	$this->sortWorkOrder = $_GET['sort'];
	} // end if get page is set
		  
		  // START PAGING AND DISPLAYING OF WORK ORDERS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL WORK ORDERS
		// QUERY WORK ORDER DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every work order
			$result = $this->db->query("SELECT COUNT(workorderId) FROM workorder WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(workorderId) FROM workorder WHERE accountId='$this->accountId' AND workorderDepartment = '$this->managerDepartment'");
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
		if ($this->sortWorkOrder == 'workorderTitle') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort for workorder title
		
		// IF SORT BY CATEGORY
		if ($this->sortWorkOrder == 'workorderCategory') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderCategory ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderCategory ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort for workorder category
		
		// IF SORT BY DEPARTMENT
		if ($this->sortWorkOrder == 'workorderDepartment') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderDepartment ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderDepartment ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort for workorder department
		
		// IF SORT BY SUBMITTED BY
		if ($this->sortWorkOrder == 'workorderSubmittedBy') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort for workorder submitted by
		
		// IF SORT BY CREATE DATE
		if ($this->sortWorkOrder == 'workorderCreateDate') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderCreateDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderCreateDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort for workorder create date
		
		// IF SORT BY TITLE
		if ($this->sortWorkOrder == 'workorderCompletionDate') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderCompletionDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderCompletionDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end if sort for workorder completion date
		  
		  
if ($this->sortWorkOrder == '' || !isset($this->sortWorkOrder)) {
//******* THIS IS THE DEFAULT IF NO SORTING SELECTION IS MADE - SORT BY TITLE *********//  		
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderTitle ASC LIMIT $offset,$recordsperpage");
		} // end if
		else {// otherwise compare manager department based on workorderDepartment
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderTitle ASC LIMIT $offset,$recordsperpage");
		} // end else
} // end else if sort work order is blank or empty
	
	
	
	
	
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each workorderId to property for later use
			$this->workorderId = $row['workorderId'];
			
			// date format for project create date
			$timestamp = strtotime($row['workorderCreateDate']);
			$fmat_workorder_createdate = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set project values
			$this->setWorkOrderValues($this->workorderId);
			
			// Display for work order list
			echo "<div class='workorderListContent'>".
				 "<p><a href='$link?workorderId=$this->workorderId'>".$row['workorderTitle']."</a></p>".
				 "<p>".$row['workorderCategory']."</p>".
				 "<p>".$row['workorderDepartment']."</p>".
				 "<p>".$row['workorderSubmittedBy']."</p>".
				 "<p>".$fmat_workorder_createdate."</p>".
				 "<p>".$this->getWorkOrderCompletionDate()."</p>".
				 "<!-- end .workorderListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='workorders.php?page=$page&sort=$this->sortWorkOrder'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='workorders.php?page=$page&sort=$this->sortWorkOrder'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='workorders.php?page=$page&sort=$this->sortWorkOrder'>Next</a>";  // LINK FOR NEXT PAGE
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
		} // END INITAL IF
		// END PAGING
		
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Work Order Data Available</p>";
		} // end else
	} // end workorderSelectDisplay method
	
	
	public function getViewAuth() {
			return $this->viewAuth;
		} // end getViewAuth method
		  
          
          public function setWorkOrderValues($workorderId) {
			  
			  // workorder id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM workorder WHERE workorderId = '$workorderId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of workorder information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected work order details.</p></div>";
		} //end if
		else {
			  
			  
                    $result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderId = '$workorderId'");
                    while ($row = $result->fetch_assoc()) {
							  $this->workorderId = $row['workorderId'];
                              $this->workorderTitle = $row['workorderTitle'];
							  $this->workorderCategory = $row['workorderCategory'];
							  $this->workorderDepartment = $row['workorderDepartment'];
                              $this->workorderDescription = $row['workorderDescription'];
							  $this->workorderPriority = $row['workorderPriority'];
							  $this->workorderLocation = $row['workorderLocation'];
                              $this->workorderCreateDate = $row['workorderCreateDate'];
                              $this->workorderCompletionDate = $row['workorderCompletionDate'];
                              $this->workorderSubmittedBy = $row['workorderSubmittedBy'];
							  $this->workorderUpdateComments = $row['workorderUpdateComments'];
                    } // end while
		} // end else - for display storing values
          } // end setWorkOrderValues
          
          public function getWorkOrderId() {
                    return $this->workorderId;
          } // end getWorkOrderId;
          
          public function getWorkOrderTitle() {
                    return $this->workorderTitle;
          } // end getWorkOrderTitle
		  
		  public function getWorkOrderCategory() {
			  		return $this->workorderCategory;
		  } // end getWorkOrderCategory
		  
		  public function getWorkOrderDepartment() {
			  		return $this->workorderDepartment;
		  } // end getWorkOrderDepartment
          
          public function getWorkOrderDescription() {
                    return $this->workorderDescription;
          } // end getWorkOrderDescription
		  
		   public function getWorkOrderPriority() {
                    return $this->workorderPriority;
          } // end getWorkOrderPriority
		  
		   public function getWorkOrderLocation() {
                    return $this->workorderLocation;
          } // end getWorkOrderLocation
          
		  public function getWorkOrderCreateDateEdit() {
		// edit version is so date loads in 0000-00-00 format
		return $this->workorderCreateDate;
	} // end getWorkOrderCreateDate method
		  
          public function getWorkOrderCreateDate() {
			  // date format for create date
			$timestamp = strtotime($this->workorderCreateDate);
			$this->workorderCreateDate = date('F d, Y', $timestamp);
                    return $this->workorderCreateDate;
          } // end getWorkOrderCreateDate
          
		  // this one is used to check whether to display on right menu
		  public function getWorkOrderCompletionDateMenu() {
			  return $this->workorderCompletionDate;
		  } // end work order complete date
		  
          public function getWorkOrderCompletionDate() {
                    // if workorder is not complete, don't show 0's, show n/a
		if($this->workorderCompletionDate != '0000-00-00') {
			// date format for completion date
			$timestamp = strtotime($this->workorderCompletionDate);
			$this->workorderCompletionDate = date('F d, Y', $timestamp);
			return $this->workorderCompletionDate;
		} // end if
		else { // this return creates link to mark workorder complete.  it passes back to the workorders.php page and then performs the markComplete function
			return "<a href='workorders.php?markWorkOrderComplete=yes&workorderId=$this->workorderId' onClick='return confirm('Are you sure you want to mark this work order complete?')'><img src='images/accept.png' alt='Mark Complete' class='float_img' />Mark Complete</a>";
		} // end else
          } // end getWorkOrderCompletionDate   
		  
		   public function getWorkOrderProfileCompletionDate() {
                    // if workorder is not complete, don't show 0's, show n/a
		if($this->workorderCompletionDate != '0000-00-00') {
			// date format for completion date
			$timestamp = strtotime($this->workorderCompletionDate);
			$this->workorderCompletionDate = date('F d, Y', $timestamp);
			return $this->workorderCompletionDate;
		} // end if
		else { 
			return "Not Complete";
		} // end else
          } // end getWorkOrderProfileCompletionDate   
          
          public function getWorkOrderSubmittedBy() {
                    $result = $this->db->query("SELECT * FROM manager WHERE managerId = '$this->managerId'");
                    $row = $result->fetch_assoc();
                    $this->projectSubmittedBy = $row['managerFirstName'] . " " . $row['managerLastName'];
                    return $this->workorderSubmittedBy;
          } // end getWorkOrderSubmittedBy
		  
		  public function getWorkOrderUpdateComments() {
			  if ($this->workorderUpdateComments != '') {
				return $this->workorderUpdateComments;
			  } // end if not blank
			  else { echo "n/a"; }
		  } // end getWorkOrderUpdateComments method
          
		  
		public function displayWorkOrderCategorySelect() {
			// gets all work order categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' ORDER BY workorderCategoryName ASC");
			} // end if managerDepartment = All
			else {
			$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' AND (workorderCategoryDepartment = '$this->managerDepartment' OR workorderCategoryDepartment = 'All') ORDER BY workorderCategoryName ASC");
			} // end else
		echo "
		<select name='workorderCategory'>
		<option value=''></option>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['workorderCategoryName'] . "'>". $row['workorderCategoryName'];
			if ($this->managerDepartment == 'All') {
				echo "- (" . $row['workorderCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayWorkOrderCategorySelect  
	
	public function displayWorkOrderCategoryEditSelect() {
			// gets all work order categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' ORDER BY workorderCategoryName ASC");
			} // end if
			else {
			$result = $this->db->query("SELECT * FROM workorder_category WHERE accountId='$this->accountId' AND workorderCategoryDepartment = '$this->managerDepartment'  OR workorderCategoryDepartment = 'All' ORDER BY workorderCategoryName ASC");
			} // end else
		echo "
		<select name='workorderCategory'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
				<option value='" . $row['workorderCategoryName'] . "'"; 
				$result2 = $this->db->query("SELECT * FROM workorder WHERE accountId='$this->accountId' and workorderId = '$this->workorderId'");
				$row2  = $result2->fetch_assoc();
				if ($row2['workorderCategory'] == $row['workorderCategoryName']) echo "selected"; 
				
				echo ">". $row['workorderCategoryName'];
				if ($this->managerDepartment == 'All') {
				echo "- (" . $row['workorderCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				 </option>
				";
			
		} // end while
		echo "
		</select>
		";
	} // end displayWorkOrderCategoryEditSelect
	
	// this is for the display of departments on the edit_workorder page
	public function displayManagerDepartmentEditWorkOrderSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId = '$this->accountId' AND departmentName = '$this->managerDepartment'");
		} // end else
		
		
			echo "
				<select name='workorderDepartment'>
			";
			// get all manager departments
			while ($row = $result->fetch_assoc()) {
				
				$result2 = $this->db->query("SELECT * FROM workorder WHERE accountId='$this->accountId'");
				$row2=$result2->fetch_assoc();
				
			// display select form for available department selection
				echo " 
				<option value='" . $row['departmentName'] . "'"; 
				// if the property workorderDepartment is equal the department name from loop make default selection
				if ($this->workorderDepartment == $row['departmentName']) echo "selected"; 
				
				echo ">". $row['departmentName'] . "</option>
				";
				
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditWorkOrderSelect method
		
		
		public function updateWorkOrderComplete($workorderId) { 
		$today = date('Y-m-d');
		// updates the workorder completion date
		$result = $this->db->query("UPDATE workorder SET workorderCompletionDate='$today' WHERE workorderId='$workorderId'");	
		} // end updateWorkOrderComplete
		
		public function updateWorkOrder($workorderId) {
		$result = $this->db->prepare("UPDATE workorder SET workorderTitle=?,workorderCategory=?,workorderDepartment=?,workorderCreateDate=?,workorderDescription=?,workorderPriority=?,workorderLocation=?,workorderUpdateComments=? WHERE workorderId = '$workorderId'");

$result->bind_param('ssssssss', $workorderTitle,$workorderCategory,$workorderDepartment,$workorderCreateDate,$workorderDescription,$workorderPriority,$workorderLocation,$workorderUpdateComments);


$workorderTitle = $_POST['workorderTitle'];
$workorderCategory = $_POST['workorderCategory'];
$workorderDepartment = $_POST['workorderDepartment'];
$workorderCreateDate = $_POST['workorderCreateDate'];
$workorderDescription = $_POST['workorderDescription'];
$workorderPriority = $_POST['workorderPriority'];
$workorderLocation = $_POST['workorderLocation'];
$workorderUpdateComments= $_POST['workorderUpdateComments'];


$result->execute();

header("Location: edit_selected_workorder.php?workorderUpdated=yes&workorderId=$workorderId");
	} // end updateWorkOrder method
		
		
		//********************DELETE WORK ORDERS********************//

public function deleteWorkOrderList() {
	
	// START PAGING AND DISPLAYING OF WORK ORDERS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL WORK ORDERS
		// QUERY WORK ORDER DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every work order
			$result = $this->db->query("SELECT COUNT(workorderId) FROM workorder WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(workorderId) FROM workorder WHERE accountId='$this->accountId' AND workorderDepartment = '$this->managerDepartment'");
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
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every work order
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderTitle ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on workorder department
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderTitle ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
		
			// stores each workorderId to property for later use
			$this->workorderId = $row['workorderId'];
		
			// date format for create date
			$timestamp = strtotime($row['workorderCreateDate']);
			$fmat_workorder_createdate = date('F d, Y', $timestamp);
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set project values
			$this->setWorkOrderValues($this->workorderId); // primarily for the return of completion date
			
			// Display for project list
			echo "<div class='workorderListContent'>".
				 "<p><a href='delete_workorders.php?workorderId=$this->workorderId&workorderDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this work order?\")'>"
				 .$row['workorderTitle']."</a></p>".
				 "<p>".$row['workorderCategory']."</p>".
				 "<p>".$row['workorderDepartment']."</p>".
				 "<p>".$row['workorderSubmittedBy']."</p>".
				 "<p>".$fmat_workorder_createdate."</p>".
				 "<p>".$this->getWorkOrderCompletionDate()."</p>".
				 "<!-- end .workorderListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_workorders.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='delete_workorders.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_workorders.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
		} // END INITAL IF
		// END PAGING
		
		} // end if for displaying content
		else { // if no results display this
			echo "<p>No Work Order Data Available</p>";
		} // end else	
		
	} // end deleteWorkOrderList method
	
	public function deleteWorkOrder($workorderId) {
		$result = $this->db->query("DELETE FROM workorder WHERE `workorderId` = '$workorderId'");
		
	} // end deleteWorkOrder method

//********************END DELETE WORK ORDERS********************//
		
		
		
		  
		 public function workorderDashboardDisplay() {
			 if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all workorders for account		
			 	// display a list of the 5 most recent work orders submitted
			 	$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' ORDER BY workorderId DESC LIMIT 5");
			 } // end if managerDepartment = All
			 else {
				 $result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' ORDER BY workorderId DESC LIMIT 5");
			 } // end else
			 
			 if ($result->num_rows > 0) { // if there are results display them
			 
			 echo "
			 <div class='workorder_dashboard_column_header_title'><p>Title</p></div>
    		<div class='workorder_dashboard_column_header'><p>Category</p></div>
    		<div class='workorder_dashboard_column_header'><p>Priority</p></div>
    		<div class='workorder_dashboard_column_header'><p>Created</p></div>
    		<div class='clr'></div>
			";
			 
			 
			 // loop to display list
			 
			 
			 while($row = $result->fetch_assoc()) {
			
				// date format for create date
			$timestamp = strtotime($row['workorderCreateDate']);
			$fmat_workorder_createdate = date('m/d/Y', $timestamp);
								 
			 	echo "<div class='workorder_dashboard_column_title'><p><img src='images/workorder.png' alt=''><a href='workorder_profile.php?workorderId=$row[workorderId]'>" . $row['workorderTitle'] . "</a></p></div><div class='workorder_dashboard_column'><p>" . $row['workorderCategory'] . "</p></div><div class='workorder_dashboard_column'><p>" . $row['workorderPriority'] . "</p></div><div class='workorder_dashboard_column'><p>$fmat_workorder_createdate</p></div><div class='clr'></div>";
				
			 } // end while
			 } // end if exist display list
			 else {
				 echo "
				 <p>No Work Order Data Available.</p>
				 ";
			 } // end else
		 } // end workorderDashboardDisplay


		 public function searchWorkOrders($searchWorkOrders) {
			// SEARCH RESULTS
			$foundWorkOrders = $searchWorkOrders;
			$words = explode(" ", $foundWorkOrders);
			$phrase = implode("%' AND workorderTitle LIKE '%", $words);

			// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every workorder
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderTitle LIKE '%$phrase%' ORDER BY workorderTitle ASC");
	} // end if
	else {// otherwise compare manager department based on workorder department
		$result = $this->db->query("SELECT * FROM workorder WHERE accountId = '$this->accountId' AND workorderDepartment = '$this->managerDepartment' AND workorderTitle LIKE '%$phrase%' ORDER BY workorderTitle ASC");
	}
    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			
			// stores each workorderId to property for later use
			$this->workorderId = $row['workorderId'];
			
			// date format for project create date
			$timestamp = strtotime($row['workorderCreateDate']);
			$fmat_workorder_createdate = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set work order values
			$this->setWorkOrderValues($this->workorderId);
			
			// Display for work order list
			echo "<div class='workorderListContent'>".
				 "<p><a href='workorder_profile.php?workorderId=$this->workorderId'>".$row['workorderTitle']."</a></p>".
				 "<p>".$row['workorderCategory']."</p>".
				 "<p>".$row['workorderDepartment']."</p>".
				 "<p>".$row['workorderSubmittedBy']."</p>".
				 "<p>".$fmat_workorder_createdate."</p>".
				 "<p>".$this->getWorkOrderCompletionDate()."</p>".
				 "<!-- end .workorderListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		} // end if
		else { // if no results display this
			echo "<p>No Work Order Data Available</p>";
		} // end else
	} // end searchWorkOrders method
	
	
} // end WorkOrder class
?>
