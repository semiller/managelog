<?php
class Journal extends DbConnect {
          // define properties     
		  protected $db;
		       
          protected $accountId;
          protected $managerId; // saved as session? check Log class
		  protected $managerDepartment;
          protected $managerFirstName;
		  protected $managerLastName;
		  
          protected $journalId;
          protected $journalTitle;
		  protected $journalCategory;
		  protected $journalDepartment;
          protected $journalNotes;
          protected $journalDate;
          protected $journalSubmittedBy;
		  
		  protected $sortJournal;
		  
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
          
          public function addJournal() {
		$result = $this->db->prepare("INSERT INTO journal(accountId,journalDate,journalDepartment,journalSubmittedBy,journalCategory,journalTitle,journalNotes) VALUES (?,?,?,?,?,?,?)");

$result->bind_param('sssssss', $this->accountId, $journalDate, $journalDepartment, $journalSubmittedBy, $journalCategory, $journalTitle, $journalNotes);

// get values entered from form
$journalDate = date("Y-m-d");
$journalDepartment = $_POST['journalDepartment'];
$journalSubmittedBy = $this->managerFirstName . " " . $this->managerLastName;
$journalCategory = $_POST['journalCategory'];
$journalTitle = $_POST['journalTitle'];
$journalNotes = $_POST['journalNotes'];

$result->execute();

header("Location: add_journal.php?journalAdded=yes");

	} // end addJournal method

          
		  
		  // ************************READ JOURNAL************************** //
		  
		  public function journalSelectDisplay($link) { // $link is href to carry GET
		  
		 	 // Sort Journal Selection - store value
			// stores initial value
			$this->sortJournal = $_POST['sortJournal'];
			// this is used for paging.  if sort value is set, get the value to keep the sortJournal property loaded
			if (isset($_GET['sort'])) {
			$this->sortJournal = $_GET['sort'];
			} // end if get page is set
		  
		  
		  // START PAGING AND DISPLAYING OF JOURNAL  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL JOURNAL
		// QUERY PROJECTS DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every journal
			$result = $this->db->query("SELECT COUNT(journalId) FROM journal WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(journalId) FROM journal WHERE accountId='$this->accountId' AND journalDepartment = '$this->managerDepartment'");
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
		if ($this->sortJournal == 'journalTitle') {  
		  if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all journal for account		
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalTitle ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on journalDepartment
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalTitle ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort journal title
		
		// IF SORT BY CATEGORY
		if ($this->sortJournal == 'journalCategory') {  
		  if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all journal for account		
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalCategory ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on journalDepartment
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalCategory ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort journal category
		
		// IF SORT BY DEPARTMENT
		if ($this->sortJournal == 'journalDepartment') {  
		  if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all journal for account		
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalDepartment ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on journalDepartment
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalDepartment ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort journal department
		
		// IF SORT BY SUBMITTED BY
		if ($this->sortJournal == 'journalSubmittedBy') {  
		  if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all journal for account		
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on journalDepartment
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalSubmittedBy ASC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort journal submitted by
		
		// IF SORT BY CREATE DATE
		if ($this->sortJournal == 'journalDate') {  
		  if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all journal for account		
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalDate DESC LIMIT $offset,$recordsperpage");
			} // end if
			else {// otherwise compare manager department based on journalDepartment
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalDate DESC LIMIT $offset,$recordsperpage");
			} // end else
		} // end else for sort journal date
		
		
	if ($this->sortJournal == '' || !isset($this->sortJournal)) {
	//******* THIS IS THE DEFAULT IF NO SORTING SELECTION IS MADE - SORT BY TITLE *********//  
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all journal for account		
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalTitle ASC LIMIT $offset,$recordsperpage");
		} // end if
		else {// otherwise compare manager department based on journalDepartment
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalTitle ASC LIMIT $offset,$recordsperpage");
		} // end else
	} // end else if sort journal is not set or blank
	
	
	
	
	
		if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each projectId to property for later use
			$this->journalId = $row['journalId'];
			
			// date format for project create date
			$timestamp = strtotime($row['journalDate']);
			$fmat_journal_date = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set journal values
			$this->setJournalValues($this->journalId);
			
			// Display for journal list
			echo "<div class='journalListContent'>".
				 "<p><a href='$link?journalId=$this->journalId'>".$row['journalTitle']."</a></p>".
				 "<p>".$row['journalCategory']."</p>".
				 "<p>".$row['journalDepartment']."</p>".
				 "<p>".$row['journalSubmittedBy']."</p>".
				 "<p>".$fmat_journal_date."</p>".
				 "<p>".$row['journalNotes']."</p>".
				 "<!-- end .journalListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='journal.php?page=$page&sort=$this->sortJournal'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='journal.php?page=$page&sort=$this->sortJournal'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='journal.php?page=$page&sort=$this->sortJournal'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Journal Data Available</p>";
		} // end else
		  
	} // end journalSelectDisplay method
	
	
	public function getViewAuth() {
			return $this->viewAuth;
		} // end getViewAuth method
		  
          
          public function setJournalValues($journalId) {
			  
			  // journal id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM journal WHERE journalId = '$journalId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of project information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected journal details.</p></div>";
		} //end if
		else {
			  
			  
                    $result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalId = '$journalId'");
                    while ($row = $result->fetch_assoc()) {
							  $this->journalId = $row['journalId'];
                              $this->journalTitle = $row['journalTitle'];
							  $this->journalCategory = $row['journalCategory'];
							  $this->journalDepartment = $row['journalDepartment'];
                              $this->journalNotes = $row['journalNotes'];
                              $this->journalDate = $row['journalDate'];
                              $this->journalSubmittedBy = $row['journalSubmittedBy'];
                    } // end while
		} // end else - for display storing values
          } // end setJournalValues
          
          public function getJournalId() {
                    return $this->journalId;
          } // end getJournalId;
          
          public function getJournalTitle() {
                    return $this->journalTitle;
          } // end getJournalTitle
		  
		  public function getJournalCategory() {
			  		return $this->journalCategory;
		  } // end getJournalCategory
		  
		  public function getJournalDepartment() {
			  		return $this->journalDepartment;
		  } // end getJournalDepartment
          
          public function getJournalNotes() {
                    return $this->journalNotes;
          } // end getJournalDescription
          
		  public function getJournalDateEdit() {
		// edit version is so date loads in 0000-00-00 format
		return $this->journalDate;
	} // end getJournalDate method
		  
          public function getJournalDate() {
			  // date format for create date
			$timestamp = strtotime($this->journalDate);
			$this->journalDate = date('F d, Y', $timestamp);
                    return $this->journalDate;
          } // end getJournalCreateDate
          
          public function getJournalSubmittedBy() {
                    $result = $this->db->query("SELECT * FROM manager WHERE managerId = '$this->managerId'");
                    $row = $result->fetch_assoc();
                    $this->journalSubmittedBy = $row['managerFirstName'] . " " . $row['managerLastName'];
                    return $this->journalSubmittedBy;
          } // end getJournalSubmittedBy
          
		  
		public function displayJournalCategorySelect() {
			// gets all journal categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' ORDER BY journalCategoryName ASC");
			} // end if managerDepartment = All
			else {
			$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' AND (journalCategoryDepartment = '$this->managerDepartment' OR journalCategoryDepartment = 'All') ORDER BY journalCategoryName ASC");
			} // end else
		echo "
		<select name='journalCategory'>
		<option value=''></option>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['journalCategoryName'] . "'>". $row['journalCategoryName'];
			 if ($this->managerDepartment == 'All') {
				echo "- (" . $row['journalCategoryDepartment'] . ")";
			} // end if managerDepartment = All
			echo "
				</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayJournalCategorySelect  
	
	public function displayJournalCategoryEditSelect() {
			// gets all journal categories from either the managers department or if manager department is equal to all
			if($this->managerDepartment == 'All') {
				$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' ORDER BY journalCategoryName ASC");
			} // end if
			else {
			$result = $this->db->query("SELECT * FROM journal_category WHERE accountId='$this->accountId' AND journalCategoryDepartment = '$this->managerDepartment' OR journalCategoryDepartment = 'All' ORDER BY journalCategoryName ASC");
			} // end else
		echo "
		<select name='journalCategory'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
				<option value='" . $row['journalCategoryName'] . "'"; 
				$result2 = $this->db->query("SELECT * FROM journal WHERE accountId='$this->accountId' and journalId = '$this->journalId'");
				$row2  = $result2->fetch_assoc();
				if ($row2['journalCategory'] == $row['journalCategoryName']) echo "selected"; 
				
				echo ">". $row['journalCategoryName'];
				if ($this->managerDepartment == 'All') {
				echo "- (" . $row['journalCategoryDepartment'] . ")";
			} // end if managerDepartment = All
				echo "
					</option>
				";
			
		} // end while
		echo "
		</select>
		";
	} // end displayJournalCategoryEditSelect
	
	// this is for the display of departments on the edit_journal page
	public function displayManagerDepartmentEditJournalSelect() {	
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId='$this->accountId'");
		} // end if
		else {
			// query will select managers that have same managerId, and a role equal or less than the logged in manager
			$result = $this->db->query("SELECT DISTINCT departmentName FROM department_category WHERE accountId = '$this->accountId' AND departmentName = '$this->managerDepartment'");
		} // end else
		
		
			echo "
				<select name='journalDepartment'>
			";
			// get all manager departments
			while ($row = $result->fetch_assoc()) {
				
				$result2 = $this->db->query("SELECT * FROM journal WHERE accountId='$this->accountId'");
				$row2=$result2->fetch_assoc();
				
			// display select form for available department selection
				echo " 
				<option value='" . $row['departmentName'] . "'"; 
				// if the property journalDepartment is equal the department name from loop make default selection
				if ($this->journalDepartment == $row['departmentName']) echo "selected"; 
				
				echo ">". $row['departmentName'] . "</option>
				";
				
			} // end while
			echo "
				</select>
			";
	} // end displayManagerDepartmentEditJournalSelect method
		

		
		public function updateJournal($journalId) {
		$result = $this->db->prepare("UPDATE journal SET journalTitle=?,journalCategory=?,journalDepartment=?,journalDate=?,journalNotes=? WHERE journalId = '$journalId'");

$result->bind_param('sssss', $journalTitle,$journalCategory,$journalDepartment,$journalDate,$journalNotes);


$journalTitle = $_POST['journalTitle'];
$journalCategory = $_POST['journalCategory'];
$journalDepartment = $_POST['journalDepartment'];
$journalDate = $_POST['journalDate'];
$journalNotes = $_POST['journalNotes'];


$result->execute();

header("Location: edit_selected_journal.php?journalUpdated=yes&journalId=$journalId");
	} // end updateJournal method
		
		
		//********************DELETE JOURNAL********************//

public function deleteJournalList() {
	
	// START PAGING AND DISPLAYING OF PROJECTS  THIS SET THE LIMITS FOR DISPLAY ON EACH PAGE
		  // START PAGING
		  // GETS COUNT OF TOTAL JOURNAL ENTRIES
		// QUERY PROJECTS DB
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every journal
			$result = $this->db->query("SELECT COUNT(journalId) FROM journal WHERE accountId='$this->accountId'");
		} // end if All
		else {
			$result = $this->db->query("SELECT COUNT(journalId) FROM journal WHERE accountId='$this->accountId' AND journalDepartment = '$this->managerDepartment'");
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
	
	
		if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every journal
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' ORDER BY journalTitle ASC LIMIT $offset,$recordsperpage");
	} // end if
	else {// otherwise compare manager department based on journal department
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' ORDER BY journalTitle ASC LIMIT $offset,$recordsperpage");
	}

    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			// stores each journalId to property for later use
			$this->journalId = $row['journalId'];
			
		
			// date format for create date
			$timestamp = strtotime($row['journalDate']);
			$fmat_journal_date = date('F d, Y', $timestamp);
			
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set journal values
			$this->setJournalValues($this->journalId); 
			
			// Display for journal list
			echo "<div class='journalListContent'>".
				 "<p><a href='delete_journal.php?journalId=$this->journalId&journalDeleted=yes' onClick='return confirm(\"Are you sure you want to delete this journal entry?\")'>"
				 .$row['journalTitle']."</a></p>".
				 "<p>".$row['journalCategory']."</p>".
				 "<p>".$row['journalDepartment']."</p>".
				 "<p>".$row['journalSubmittedBy']."</p>".
				 "<p>".$fmat_journal_date."</p>".
				 "<p>".$row['journalNotes']."</p>".
				 "<!-- end .journalListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		
		// START PAGING
		// MORE PAGING STUFF  THIS SHOWS THE BAR AT THE BOTTOM OF THE SCREEN IF PAGING IS TO BE USED
		if ($thispage > 1) {
			$page = $thispage - 1;
			$prevpage = "<a href='delete_journal.php?page=$page'>Previous</a>";  // LINK FOR PREVIOUS PAGE
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
			$bar .= "<a href='delete_journal.php?page=$page'> $page </a>";  // LINK FOR CURRENT PAGE OR PAGE NUMBER
		} // END ELSE
			} // END FOR
		} // END IF

		if ($thispage < $totpages) {
			$page = $thispage + 1;
			$nextpage = "<a href='delete_journal.php?page=$page'>Next</a>";  // LINK FOR NEXT PAGE
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
			echo "<p>No Journal Data Available</p>";
		} // end else	
		
	} // end deleteJournalList method
	
	public function deleteJournal($journalId) {
		$result = $this->db->query("DELETE FROM journal WHERE `journalId` = '$journalId'");
		
	} // end deleteJournal method

//********************END DELETE JOURNAL********************/



 public function journalDashboardDisplay() {
	 			
			 // get todays date to only pull entries from current date
			 $today = date("Y-m-d");
				
			 if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display all projects for account		
			 	// display a list of the todays journal entries submitted
			 	$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDate = '$today' ORDER BY journalId DESC");
			 } // end if managerDepartment = All
			 else {
				 $result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' AND journalDate = '$today' ORDER BY journalId DESC");
			 } // end else
			 
			 if ($result->num_rows > 0) { // if there are results display them
			 
			 echo "
			 <div class='journal_dashboard_column_header'><p>Title</p></div>
    		 <div class='journal_dashboard_column_header'><p>Category</p></div>
			 <div class='journal_dashboard_column_header'><p>Department</p></div>
			 <div class='journal_dashboard_column_header'><p>Submitted By</p></div>
			 <div class='journal_dashboard_column_header'><p>Notes</p></div>
    		 <div class='clr'></div>
			";
			 
			 // loop to display list
			 while($row = $result->fetch_assoc()) {
								 
			 	echo "<div class='journal_dashboard_column'><p><img src='images/journal.png' alt=''><a href='journal_profile.php?journalId=$row[journalId]'>" . $row['journalTitle'] . "</a></p></div>
				<div class='journal_dashboard_column'><p>" . $row['journalCategory'] . "</p></div>
				<div class='journal_dashboard_column'><p>" . $row['journalDepartment'] . "</p></div>
				<div class='journal_dashboard_column'><p>" . $row['journalSubmittedBy'] . "</p></div>
				<div class='journal_dashboard_column'><p>" . $row['journalNotes'] . "</p></div>
				<div class='clr'></div>";
			
			 } // end while
			 } // end if exist display list
			 else {
				 $today = date("F d, Y");
				 echo "
				 <p>No Journal Data Available on $today.</p>
				 ";
			 } // end else
		 } // end journalDashboardDisplay




		 
		 public function searchJournal($searchJournal) {
			// SEARCH RESULTS
			$foundJournal = $searchJournal;
			$words = explode(" ", $foundJournal);
			$phrase = implode("%' AND journalTitle LIKE '%", $words);

			// This prevents managers from searching outside of their account ID and department
			if ($this->managerDepartment == 'All') { // if managerDepartment = 'All' allow to display every journal
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalTitle LIKE '%$phrase%' ORDER BY journalTitle ASC");
	} // end if
	else {// otherwise compare manager department based on manager department
		$result = $this->db->query("SELECT * FROM journal WHERE accountId = '$this->accountId' AND journalDepartment = '$this->managerDepartment' AND journalTitle LIKE '%$phrase%' ORDER BY journalTitle ASC");
	}
    if ($result->num_rows > 0) { // if there are results display them
		
		$n = 0; // variable for changing color background
		while($row = $result->fetch_assoc()) {
			
			
			// stores each journalId to property for later use
			$this->journalId = $row['journalId'];
			
			// date format for project create date
			$timestamp = strtotime($row['journalDate']);
			$fmat_journal_date = date('F d, Y', $timestamp);
			
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// set journal values
			$this->setJournalValues($this->journalId);
			
			// Display for journal list
			echo "<div class='journalListContent'>".
				 "<p><a href='journal_profile.php?journalId=$this->journalId'>".$row['journalTitle']."</a></p>".
				 "<p>".$row['journalCategory']."</p>".
				 "<p>".$row['journalDepartment']."</p>".
				 "<p>".$row['journalSubmittedBy']."</p>".
				 "<p>".$fmat_journal_date."</p>".
				 "<p>".$row['journalNotes']."</p>".
				 "<!-- end .journalListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
		}  // end while
		} // end if
		else { // if no results display this
			echo "<p>No Journal Data Available</p>";
		} // end else
	} // end searchJournal method
          
} // end Journal class

?>