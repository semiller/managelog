<?php
class TrainingRecord extends Employee {
	
	protected $employeeId;
	protected $trainingCompletionDate;
	
	protected $accountId;
	protected $managerDepartment;
	protected $trainingId;
	
	protected $viewAuth = true;
	
	public function __construct() {
		parent::__construct();
		$this->accountId = $_SESSION['accountId'];
		$this->managerDepartment = $_SESSION['managerDepartment'];
	}
	
	
	public function readTrainingRecord($employeeId) {
		// gets the information from training_completion based on employeeId
		$result = $this->db->query("SELECT * FROM training_completion WHERE employeeId='$employeeId' ORDER BY trainingScheduleDate DESC");
		
		if ($result->num_rows > 0) {
			// for alternating rows
			$n =0;
			
		while($row=$result->fetch_assoc()) {
			
			// set property values
			$this->employeeId = $row['employeeId'];
			$this->trainingCompletionDate = $row['trainingCompletionDate'];
			$this->trainingId = $row['trainingId'];
			
			// gets the training information based on the trainingId from training_completion
			$result2 = $this->db->query("SELECT * FROM training WHERE trainingId='$row[trainingId]'");
			$row2=$result2->fetch_assoc();
			
			// gets the employee information based on the employeeId from training_completion
			$result3 = $this->db->query("SELECT * FROM employee WHERE employeeId='$row[employeeId]'");
			$row3=$result3->fetch_assoc();
			
			
			// date format for schedule date
			$timestamp = strtotime($row['trainingScheduleDate']);
			$fmat_schedule_date = date('F d, Y', $timestamp);
		
			
			// display content
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// Display for employee list
			echo "<div class='employeeListContent'>".
				 "<p>";
				 // to determine if training has been completed
				 if ($row['trainingCompletionDate'] == '0000-00-00') {
					 echo "
				 <a href='training_record.php?trainingCompletionId=$row[trainingCompletionId]&employeeId=$row[employeeId]&trainingId=$row[trainingId]&trainingCompleted=yes'><img src='images/date_edit.png' alt='Mark Complete' class='float_img'>Mark Complete</a>
				 ";
				 } // end if for completion date check
				 else { echo "<img src='images/accept.png' alt='Training Completed' class='float_img'>Completed"; }
				 
				 echo"
				 </p>".
				 "<p>".$row3['employeeLastName']."</p>".
				 "<p>".$row3['employeeFirstName']."</p>".
				 "<p>".$row2['trainingTitle']."</p>".
				 "<p>".$fmat_schedule_date."</p>".
				 "<p>".$this->getTrainingCompletionDate()."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
			
		} // end while
		} // end num_rows check
		else { echo "<p>No Training Data Available</p>"; }
		
	} // end readTrainingRecord method
	
	
	public function setViewAuth($trainingId) {
		// training id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM training WHERE trainingId = '$trainingId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of training information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected training details.</p></div>";
		} //end if
		else { return $this->viewAuth; }
		} // end getViewAuth method
	
	public function setViewAuthEmployee($employeeId) {
		// employee id must have a account id of the current session accountId
		$result = $this->db->query("SELECT accountId FROM employee WHERE employeeId = '$employeeId'");
		$row=$result->fetch_assoc();
		if ($row['accountId'] != $_SESSION['accountId']) {
			
			$this->viewAuth = false; // false will not allow unauthorized view of training information
			echo " <div class='left'><h3>Unauthorized View</h3><p>You are not authorized to view the selected employee training details.</p></div>";
		} //end if
		else { return $this->viewAuth; }
		} // end getViewAuth method
	
	public function readTrainingRecordList($trainingId) {
		
		// gets the information from training_completion based on employeeId
		$result = $this->db->query("SELECT * FROM training_completion WHERE trainingId='$trainingId' ORDER BY employeeId ASC");
		
		
		if ($result->num_rows > 0) {
			// for alternating rows
			$n =0;
			
		while($row=$result->fetch_assoc()) {
			
			// set property values
			$this->employeeId = $row['employeeId'];
			$this->trainingCompletionDate = $row['trainingCompletionDate'];
			$this->trainingId = $row['trainingId'];
			
			// gets the training information based on the trainingId from training_completion
			$result2 = $this->db->query("SELECT * FROM training WHERE trainingId='$row[trainingId]'");
			$row2=$result2->fetch_assoc();
			
			// gets the employee information based on the employeeId from training_completion
			$result3 = $this->db->query("SELECT * FROM employee WHERE employeeId='$row[employeeId]'");
			$row3=$result3->fetch_assoc();
			
			
			// date format for schedule date
			$timestamp = strtotime($row['trainingScheduleDate']);
			$fmat_schedule_date = date('F d, Y', $timestamp);
			
			// display content
			if($n % 2 == 0) { // if statement for alternating backgrounds
				echo "<div class='alt_display'>";
				$n++; // to alternate the color and count
			} // end if
			else {
				echo "<div class='alt_display_2'>";
				$n++; // to alternate the color and count
			} // end else (place ending </div> below all content
			
			// Display for employee list
			echo "<div class='employeeListContent'>".
				 "<p>";
				 // to determine if training has been completed
				 if ($row['trainingCompletionDate'] == '0000-00-00') {
					 echo "
				 <a href='training_record_list.php?trainingCompletionId=$row[trainingCompletionId]&employeeId=$row[employeeId]&trainingId=$row[trainingId]&trainingCompleted=yes'><img src='images/date_edit.png' alt='Mark Complete' class='float_img'>Mark Complete</a>
				 ";
				 } // end if for completion date check
				 else { echo "<img src='images/accept.png' alt='Training Completed' class='float_img'>Completed"; }
				 
				 echo"
				 </p>".
				 "<p>".$row3['employeeLastName']."</p>".
				 "<p>".$row3['employeeFirstName']."</p>".
				 "<p>".$row2['trainingTitle']."</p>".
				 "<p>".$fmat_schedule_date."</p>".
				 "<p>".$this->getTrainingCompletionDate()."</p>".
				 "<!-- end .employeeListContent --></div><div class='clr'></div>";
				 
				 echo "</div>"; // ending </div> for alternating display
			
		} // end while
		} // end num_rows check
		else { echo "<p>No Employee Data Available</p>"; }
		
	} // end readTrainingRecordList method
	
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
	

	public function updateTrainingRecord($trainingCompletionId,$employeeId,$trainingId) {
		// set todays date
		$today = date('Y-m-d');
		// updates the training completion in training_completion database
		$result = $this->db->prepare("UPDATE training_completion SET trainingCompletionDate=? WHERE trainingcompletionId = '$trainingCompletionId'");
		$result->bind_param('s', $today);
		$result->execute();
		
		$this->updateAllTrainedDate($trainingId);
		
		header("Location:training_record.php?updateTrainingRecord=yes&employeeId=$employeeId");
	} // end updateTrainingRecord method
	
	public function updateTrainingRecordList($trainingCompletionId,$employeeId,$trainingId) {
		// set todays date
		$today = date('Y-m-d');
		// updates the training completion in training_completion database
		$result = $this->db->prepare("UPDATE training_completion SET trainingCompletionDate=? WHERE trainingcompletionId = '$trainingCompletionId'");
		$result->bind_param('s', $today);
		$result->execute();
		
		$this->updateAllTrainedDate($trainingId);
		
		header("Location:training_record_list.php?updateTrainingRecord=yes&trainingId=$trainingId&employeeId=$employeeId");
	} // end updateTrainingRecordList method
	
	
	public function updateAllTrainedDate($trainingId) {
		// query to get all alike instances of completed training based on accountId and trainingId
		$result= $this->db->query("SELECT * FROM training_completion WHERE trainingId='$trainingId' AND trainingCompletionDate = '0000-00-00'");
		// todays date for completion
		$today = date('Y-m-d');
		
			if ($result->num_rows == 0) {
				$result2 = $this->db->query("UPDATE training SET trainingAllTrainedDate='$today' WHERE trainingId='$trainingId'");
			} // end if
	} // end updateAllTrainedDate
	
	public function updateMarkAllTrainingComplete($trainingId) {
		$today = date('Y-m-d');
		// updates the finalized training date
		$result = $this->db->query("UPDATE training SET trainingAllTrainedDate='$today' WHERE trainingId='$trainingId'");
		// updates every training_completion where the account number and trainingId match
		$result2 = $this->db->query("UPDATE training_completion SET trainingCompletionDate = '$today' WHERE accountId='$this->accountId' AND trainingId='$trainingId'");
	} // end updateMarkAllTrainingComplete
	
	
	public function displayTrainingEmployeeNameSelect() {
		// select all if manager department equals all
		if ($this->managerDepartment == 'All') {
			$result = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId' ORDER BY employeeLastName ASC");
		} // end if
		else {
			// query will select managers that have same account id, same department, and a role equal or less 	than the logged in manager
			$result = $this->db->query("SELECT * FROM employee WHERE accountId='$this->accountId' AND employeeDepartment = '$this->managerDepartment' ORDER BY employeeLastName ASC");
		} // end else
		echo "
		<select name='employeeId' size='2'>
		";
		while ($row = $result->fetch_assoc()) {
			echo " 
			<option value='" . $row['employeeId'] . "'>". $row['employeeLastName'] . ", " . $row['employeeFirstName'] . "</option>
			";
		} // end while
		echo "
		</select>
		";
	} // end displayTrainingEmployeeNameSelect
	
	
	public function readTrainingSignInSheet($trainingId) {
		// gets the information from training_completion based on employeeId
		$result = $this->db->query("SELECT * FROM training_completion WHERE trainingId='$trainingId'");
		
		if ($result->num_rows > 0) {
			
		while($row=$result->fetch_assoc()) {
			
			// set property values
			$this->employeeId = $row['employeeId'];
			$this->trainingId = $row['trainingId'];
			
			// gets the training information based on the trainingId from training_completion
			$result2 = $this->db->query("SELECT * FROM training WHERE trainingId='$row[trainingId]'");
			$row2=$result2->fetch_assoc();
			
			// gets the employee information based on the employeeId from training_completion
			$result3 = $this->db->query("SELECT * FROM employee WHERE employeeId='$row[employeeId]'");
			$row3=$result3->fetch_assoc();
			
			
			// Display for employee list
				echo "<p><div class='employee_name'>".$row3['employeeLastName'] . ", " . $row3['employeeFirstName']. "</div><div class='sign_off'></div></p>".
				 "<div class='clr'></div>";
				 
			
		} // end while
		} // end num_rows check
		else { echo "<p>No Employee Data Available</p>"; }
		
	} // end readTrainingSignInSheet method
	
	
		
} // end TrainingRecord class