<?php
class Projects extends DbConnect {
          // define properties     
		  protected $db;
		       
          protected $accountId;
          protected $managerId; // saved as session? check Log class
		  protected $managerDepartment;
          protected $managerFirstName;
		  protected $managerLastName;
		  
          protected $projectId;
          protected $projectTitle;
		  protected $projectCategory;
		  protected $projectDepartment;
          protected $projectDescription;
          protected $projectCreateDate;
          protected $projectCompletionDate;
          protected $projectSubmittedBy;
		  
		  protected $sortProject;
		  
		  protected $viewAuth = true; // determines whether get has been changed to unauthorized view

          
          public function __construct() {
			  // call parent construct to connect to database
			  parent::__construct();
                    $this->accountId = $_SESSION['accountId'];
                    $this->managerId = $_SESSION['managerId'];
					$this->managerDepartment = $_SESSION['managerDepartment'];
					$this->managerFirstName = $_SESSION['managerFirstName'];
					$this->managerLastName = $_SESSION['managerLastName'];
          } // end construct
          
          public function addProject() {
		$result = $this->db->prepare("INSERT INTO project(accountId,projectTitle,projectCategory,projectDepartment,projectCreateDate,projectSubmittedBy,projectDescription) VALUES (?,?,?,?,?,?,?)");

$result->bind_param('sssssss', $this->accountId, $projectTitle, $projectCategory, $projectDepartment, $projectCreateDate, $projectSubmittedBy, $projectDescription);

// get values entered from form
$projectTitle = $_POST['projectTitle'];
$projectCategory = $_POST['projectCategory'];
$projectDepartment = $_POST['projectDepartment'];
$projectCreateDate = date('Y-m-d');
$projectSubmittedBy = $this->managerFirstName . " " . $this->managerLastName;
$projectDescription = $_POST['projectDescription'];
$projectCompletionDate = '';

$result->execute();

header("Location: add_projects.php?projectAdded=yes");

	} // end addTraining method

          
		  
		  // ************************READ PROJECTS************************** //
		  
		  public function projectSelectDisplay($link) { // $link is href to carry GET
		  
		  
	// Sort Project Selection - store value
	// stores initial value
	$this->sortProject = $_POST['sortProject'];
	// this is used for paging.  if sort value is set, get the value to keep the sortProject property loaded
	if (isset($_GET['sort'])) {
	$this->sortProject = $_GET['sort'];
	} // end if get page is set
		  
		  
		  // START PAGING AND DISPLAYING OF PROJECTS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL PROJECTS
		// QUERY PROJECTS DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every projects
			$result = $this->db->query("SELECT COUNT(projectId) FROM project WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(projectId) FROM project WHERE accountId='$this->accountId' AND projectDepartment = '$this->managerDepartment'");
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
		if ($this->sortProject == 'projectTitle') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort by projectTitle
		
		// IF SORT BY CATEGORY
		if ($this->sortProject == 'projectCategory') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectCategory ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectCategory ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort by projectCategory
		
		// IF SORT BY DEPARTMENT
		if ($this->sortProject == 'projectDepartment') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectDepartment ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectDepartment ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort by projectDepartment
		
		// IF SORT BY SUBMITTED BY
		if ($this->sortProject == 'projectSubmittedBy') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort by projectSubmittedBy
		
		// IF SORT BY CREATE DATE
		if ($this->sortProject == 'projectCreateDate') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectCreateDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectCreateDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort by projectCreateDate
		
		// IF SORT BY COMPLETION DATE
		if ($this->sortProject == 'projectCompletionDate') { 
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectCompletionDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectCompletionDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort by projectCompletionDate
		  
		
		
		if ($this->sortProject == '' || !isset($this->sortProject)) {
			//******* THIS IS THE DEFAULT IF NO SORTING SELECTION IS MADE - SORT BY TITLE *********//  
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on projectDepartment
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else if sort project is blank or empty
		
		
		
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each projectId to property for later use
			$this->projectId = $row['projectId'];
			
			// date format for project create date
			$timestamp = strtotime($row['projectCreateDate']);
			$fmat_project_createdate = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set project values
			$this->setProjectValues($this->projectId);
			
			// Display for employee list
			echo "<div class='projectListContent'>".
				 "<p><a href='$link?projectId=$this->projectId'>".$row['projectTitle']."</a></p>".
				 "<p>".$row['projectCategory']."</p>".
				 "<p>".$row['projectDepartment']."</p>".
				 "<p>".$row['projectSubmittedBy']."</p>".
				 "<p>".$fmat_project_createdate."</p>".
				 "<p>".$this->getProjectCompletionDate()."</p>".
				 "<!-- end .projectListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='projects.php?page=$page&sort=$this->sortProject'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='projects.php?page=$page&sort=$this->sortProject'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='projects.php?page=$page&sort=$this->sortProject'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Project Data Available</p>";
		} // end else
		  
	} // end projectSelectDisplay method
	
	
	public function getViewAuth() {
			return $this->viewAuth;
		} // end getViewAuth method
		  
          
          public function setProjectValues($projectId) {
			  
			  // project id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM project WHERE projectId = '$projectId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of project information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected project details.</p></div>";
		} //end if
		else {
			  
			  
                    $result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectId = '$projectId'");
                    while ($row = $result->fetch_assoc()) {
							  $this->projectId = $row['projectId'];
                              $this->projectTitle = $row['projectTitle'];
							  $this->projectCategory = $row['projectCategory'];
							  $this->projectDepartment = $row['projectDepartment'];
                              $this->projectDescription = $row['projectDescription'];
                              $this->projectCreateDate = $row['projectCreateDate'];
                              $this->projectCompletionDate = $row['projectCompletionDate'];
                              $this->projectSubmittedBy = $row['projectSubmittedBy'];
                    } // end while
		} // end else - for display storing values
          } // end setProjectValues
          
          public function getProjectId() {
                    return $this->projectId;
          } // end getProjectId;
          
          public function getProjectTitle() {
                    return $this->projectTitle;
          } // end getProjectTitle
		  
		  public function getProjectCategory() {
			  		return $this->projectCategory;
		  } // end getProjectCategory
		  
		  public function getProjectDepartment() {
			  		return $this->projectDepartment;
		  } // end getProjectDepartment
          
          public function getProjectDescription() {
                    return $this->projectDescription;
          } // end getProjectDescription
          
		  public function getProjectCreateDateEdit() {
		// edit version is so date loads in 0000-00-00 format
		return $this->projectCreateDate;
	} // end getProjectCreateDate method
		  
          public function getProjectCreateDate() {
			  // date format for create date
			$timestamp = strtotime($this->projectCreateDate);
			$this->projectCreateDate = date('F d, Y', $timestamp);
                    return $this->projectCreateDate;
          } // end getProjectCreateDate
          
		  // this one is used to check whether to display on right menu
		  public function getProjectCompletionDateMenu() {
			  return $this->projectCompletionDate;
		  } // end project complete date menu
		  
          public function getProjectCompletionDate() {
                    // if project is not complete, don't show 0's, show n/a
		if($this->projectCompletionDate != '0000-00-00') {
			// date format for completion date
			$timestamp = strtotime($this->projectCompletionDate);
			$this->projectCompletionDate = date('F d, Y', $timestamp);
			return $this->projectCompletionDate;
		} // end if
		else { // this return creates link to mark project complete.  it passes back to the projects.php page and then performs the markComplete function
			return "<a href='projects.php?markProjectComplete=yes&projectId=$this->projectId' onClick='return confirm('Are you sure you want to mark this project complete?')'><img src='images/accept.png' alt='Mark Complete' class='float_img' />Mark Complete</a>";
		} // end else
          } // end getProjectCompletionDate   
		  
		   public function getProjectProfileCompletionDate() {
                    // if project is not complete, don't show 0's, show n/a
		if($this->projectCompletionDate != '0000-00-00') {
			// date format for completion date
			$timestamp = strtotime($this->projectCompletionDate);
			$this->projectCompletionDate = date('F d, Y', $timestamp);
			return $this->projectCompletionDate;
		} // end if
		else { 
			return "Not Complete";
		} // end else
          } // end getProjectProfileCompletionDate   
          
          public function getProjectSubmittedBy() {
                    $result = $this->db->query("SELECT * FROM manager WHERE managerId = '$this->managerId'");
                    $row = $result->fetch_assoc();
                    $this->projectSubmittedBy = $row['managerFirstName'] . " " . $row['managerLastName'];
                    return $this->projectSubmittedBy;
          } // end getProjectSubmittedBy
          
		  
		public function displayProjectCategorySelect() {
			// gets all project categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' ORDER BY projectCategoryName ASC");
			} // end if managerDepartment = All
			else {
			$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' AND (projectCategoryDepartment = '$this->managerDepartment' OR projectCategoryDepartment = 'All') ORDER BY projectCategoryName ASC");
			} // end else
		echo "
		<select name='projectCategory'>
		<option value=''></option>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['projectCategoryName'] . "'>". $row['projectCategoryName'];
			 if ($this->managerDepartment == 'All') {
				echo "- (" . $row['projectCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayProjectCategorySelect  
	
	public function displayProjectCategoryEditSelect() {
			// gets all project categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' ORDER BY projectCategoryName ASC");
			} // end if
			else {
			$result = $this->db->query("SELECT * FROM project_category WHERE accountId='$this->accountId' AND projectCategoryDepartment = '$this->managerDepartment' OR projectCategoryDepartment = 'All' ORDER BY projectCategoryName ASC");
			} // end else
		echo "
		<select name='projectCategory'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
				<option value='" . $row['projectCategoryName'] . "'"; 
				$result2 = $this->db->query("SELECT * FROM project WHERE accountId='$this->accountId' and projectId = '$this->projectId'");
				$row2  = $result2->fetch_assoc();
				if ($row2['projectCategory'] == $row['projectCategoryName']) echo "selected"; 
				
				echo ">". $row['projectCategoryName'];
				if ($this->managerDepartment == 'All') {
				echo "- (" . $row['projectCategoryDepartment'] . ")";
			} // end if managerDepartment = All
				echo "
					</option>
				";
			
		} // end while
		echo "
		</select>
		";
	} // end displayProjectCategoryEditSelect
	
	// this is for the display of departments on the edit_project page
	public function displayManagerDepartmentEditProjectSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId = '$this->accountId' AND departmentName = '$this->managerDepartment'");
		} // end else
		
		
			echo "
				<select name='projectDepartment'>
			";
			// get all manager departments
			while ($row = $result->fetch_assoc()) {
				
				$result2 = $this->db->query("SELECT * FROM project WHERE accountId='$this->accountId'");
				$row2=$result2->fetch_assoc();
				
			// display select form for available department selection
				echo " 
				<option value='" . $row['departmentName'] . "'"; 
				// if the property projectDepartment is equal the department name from loop make default selection
				if ($this->projectDepartment == $row['departmentName']) echo "selected"; 
				
				echo ">". $row['departmentName'] . "</option>
				";
				
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditProjectSelect method
		
		
		public function updateProjectComplete($projectId) { 
		$today = date('Y-m-d');
		// updates the project completion date
		$result = $this->db->query("UPDATE project SET projectCompletionDate='$today' WHERE projectId='$projectId'");	
		} // end updateProjectComplete
		
		public function updateProject($projectId) {
		$result = $this->db->prepare("UPDATE project SET projectTitle=?,projectCategory=?,projectDepartment=?,projectCreateDate=?,projectDescription=? WHERE projectId = '$projectId'");

$result->bind_param('sssss', $projectTitle,$projectCategory,$projectDepartment,$projectCreateDate,$projectDescription);


$projectTitle = $_POST['projectTitle'];
$projectCategory = $_POST['projectCategory'];
$projectDepartment = $_POST['projectDepartment'];
$projectCreateDate = $_POST['projectCreateDate'];
$projectDescription = $_POST['projectDescription'];


$result->execute();

header("Location: edit_selected_project.php?projectUpdated=yes&projectId=$projectId");
	} // end updateProject method
		
		
		//********************DELETE PROJECTS********************//

public function deleteProjectList() {
	
	// START PAGING AND DISPLAYING OF PROJECTS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL PROJECTS
		// QUERY PROJECTS DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every projects
			$result = $this->db->query("SELECT COUNT(projectId) FROM project WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(projectId) FROM project WHERE accountId='$this->accountId' AND projectDepartment = '$this->managerDepartment'");
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
	
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every project
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectTitle ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on project department
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectTitle ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each projectId to property for later use
			$this->projectId = $row['projectId'];
			
		
			// date format for create date
			$timestamp = strtotime($row['projectCreateDate']);
			$fmat_project_createdate = date('F d, Y', $timestamp);
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set project values
			$this->setProjectValues($this->projectId); // primarily for the return of completion date
			
			// Display for project list
			echo "<div class='projectListContent'>".
				 "<p><a href='delete_projects.php?projectId=$this->projectId&projectDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this project?\")'>"
				 .$row['projectTitle']."</a></p>".
				 "<p>".$row['projectCategory']."</p>".
				 "<p>".$row['projectDepartment']."</p>".
				 "<p>".$row['projectSubmittedBy']."</p>".
				 "<p>".$fmat_project_createdate."</p>".
				 "<p>".$this->getProjectCompletionDate()."</p>".
				 "<!-- end .projectListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_projects.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='delete_projects.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_projects.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Project Data Available</p>";
		} // end else	
		
	} // end deleteProjectList method
	
	public function deleteProject($projectId) {
		$result = $this->db->query("DELETE FROM project WHERE `projectId` = '$projectId'");
		
	} // end deleteProject method

//********************END DELETE PROJECT********************//
		
		
		
		  
		 public function projectDashboardDisplay() {
			 if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
			 	// display a list of the 5 most recent projects submitted
			 	$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' ORDER BY projectId DESC LIMIT 5");
			 } // end if managerDepartment = All
			 else {
				 $result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' ORDER BY projectId DESC LIMIT 5");
			 } // end else
			 
			 if ($result->num_rows > 0) { // if there are results display them
			 
			 echo "
			 <div class='project_dashboard_column_header_1'><p>Title</p></div>
    <div class='project_dashboard_column_header_2'><p>Created</p></div>
    <div class='clr'></div>
			";
	
			 // loop to display list
			 while($row = $result->fetch_assoc()) {
			
				// date format for create date
			$timestamp = strtotime($row['projectCreateDate']);
			$fmat_project_createdate = date('m/d/Y', $timestamp);
								 
			 	echo "<div class='project_dashboard_column_1'><p><img src='images/project.png' alt=''><a href='project_profile.php?projectId=$row[projectId]'>" . $row['projectTitle'] . "</a></p></div><div class='project_dashboard_column_2'><p>$fmat_project_createdate</p></div><div class='clr'></div>";
			
			 } // end while
			 } // end if exist display list
			 else {
				 echo "
				 <p>No Project Data Available.</p>
				 ";
			 } // end else
		 } // end projectDashboardDisplay
		 
		 
		 public function searchProjects($searchProjects) {
			// SEARCH RESULTS
			$foundProjects = $searchProjects;
			$words = explode(" ", $foundProjects);
			$phrase = implode("%' AND projectTitle LIKE '%", $words);

			// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every training
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectTitle LIKE '%$phrase%' ORDER BY projectTitle ASC");
	} // end if
	else {// otherwise compare manager department based on employee department
		$result = $this->db->query("SELECT * FROM project WHERE accountId = '$this->accountId' AND projectDepartment = '$this->managerDepartment' AND projectTitle LIKE '%$phrase%' ORDER BY projectTitle ASC");
	}
    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			
			// stores each projectId to property for later use
			$this->projectId = $row['projectId'];
			
			// date format for project create date
			$timestamp = strtotime($row['projectCreateDate']);
			$fmat_project_createdate = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set project values
			$this->setProjectValues($this->projectId);
			
			// Display for employee list
			echo "<div class='projectListContent'>".
				 "<p><a href='project_profile.php?projectId=$this->projectId'>".$row['projectTitle']."</a></p>".
				 "<p>".$row['projectCategory']."</p>".
				 "<p>".$row['projectDepartment']."</p>".
				 "<p>".$row['projectSubmittedBy']."</p>".
				 "<p>".$fmat_project_createdate."</p>".
				 "<p>".$this->getProjectCompletionDate()."</p>".
				 "<!-- end .projectListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		} // end if
		else { // if no results display this
			echo "<p>No Project Data Available</p>";
		} // end else
	} // end searchTraining method
          
} // end Projects class

?>