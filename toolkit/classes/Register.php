<?php
class Register extends DbConnect {
	// declare variables
	protected $db;
	
	private $_lastManagerId;
	private $_lastAccountId;
	
	private $_managerNumber;
	private $_managerUsername;
	private $_managerPassword;
	private $_managerFirstName;
	private $_managerLastName;
	private $_managerEmail;
	private $_managerPhone;
	private $_managerRole;
	private $_managerDepartment;
	
	private $_accountId;
	private $_accountName;
	
	private $_packageType;
	
	
	private $_managerCoupon;

	
	public function __construct() {
		parent::__construct();
	}
	
	public function registerManager($managerNumber,$managerUsername,$managerPassword,$managerFirstName,$managerLastName,$managerEmail,$managerPhone,$accountName,$managerCoupon,$packageType) {
		
		$this->_managerNumber = $managerNumber;
		$this->_managerUsername = $managerUsername;
		// store as password hash
		$this->_managerPassword = md5($managerPassword);
		$this->_managerFirstName = $managerFirstName;
		$this->_managerLastName = $managerLastName;
		$this->_managerEmail = $managerEmail;
		$this->_managerPhone = $managerPhone;	
		$this->_managerRole = '1';
		$this->_managerDepartment = 'All';	
		
		$this->_packageType = $packageType;
		
		$this->_accountName = $accountName;
		
		// set coupon codes in array
		$couponCode = array("aramark","grand2015","carolinasls","grand2016");
		$this->_managerCoupon = $managerCoupon;
		
		// This is if the form is submitted too quickly.  Uses the hidden field on form.  Gets current time when form is loaded, then subtract seconds for how long it takes to submit form  Number in If is # of seconds
$loadtime = $_POST['loadtime'];
$totaltime = time() - $loadtime;
if($totaltime < 10)
{
   header("Location:http://www.google.com");
   exit();
}
		
		// check if email exists before attempting to add new manager and account
		$this->checkEmailExists($this->_managerEmail);
		// check if username exists before attempting to add new manager and account
		$this->checkUsernameExists($this->_managerUsername);
		
		// add the account name to db
		$this->addAccount($this->_accountName);
		
		$today = date('Y-m-d');
		
		// prepare the statement to subtitute the $_POST elements from the form
		$result = $this->db->prepare("INSERT INTO manager (managerNumber,managerUsername,managerPassword,managerCreateDate,managerFirstName,managerLastName,managerEmail,managerPhone,managerRole,managerDepartment) VALUES (?,?,?,?,?,?,?,?,?,?)");
		$result->bind_param('ssssssssss',$this->_managerNumber,$this->_managerUsername,$this->_managerPassword,$today,$this->_managerFirstName,$this->_managerLastName,$this->_managerEmail,$this->_managerPhone,$this->_managerRole,$this->_managerDepartment);
		$result->execute();
		
		$this->_lastManagerId = $this->db->insert_id;
		// get last inserted account id to place in manager table
		$this->updateAccountId($this->_lastManagerId);
		
		// Insert the package type for registered member
		$this->insertPackageType();
	
		// check if coupon code exist in array - if it does, grant free access
			if (in_array($this->_managerCoupon, $couponCode)) {
				
				// this will copy over insert if member doesn't change to Gold status
				$result = $this->db->query("UPDATE package SET packageType='Gold',packageDepartment='10000',packageManager='10000' WHERE accountId = '$this->_accountId'");
				
				// if successful, mark new registration with paid status and redirect to bypass payment page
				$this->updateManagerCouponFree();
				header("Location:index.php?coupon_success=yes");
				exit();
			} // end if
		
		// if no coupon code has been entered or is not correct - proceed with normal payment transaction
		header("Location:register_payment.php?register_success=yes&packageType=$this->_packageType");
		exit();
	} // end registerMember function
	
	
	public function addAccount($accountName) {
		// prepare the statement to subtitute the $_POST elements from the form
		$result = $this->db->prepare("INSERT INTO account(accountName) VALUES (?)");
		$result->bind_param('s',$this->_accountName);
		$this->_accountName = $accountName;
		$result->execute();
	} // end addAccount
	
	public function updateAccountId($lastManagerId) {
		// gets the last inserted account id
		$result2 = $this->db->query("SELECT accountId FROM account ORDER BY accountId DESC LIMIT 1");
		$row = $result2->fetch_assoc();
		$this->_accountId = $row['accountId'];
		
		// put account id under manager
		$result3 = $this->db->query("UPDATE manager SET accountId = '$this->_accountId' WHERE managerId = '$lastManagerId'");
		
	} // end updateAccountId
	
	// update paid status if manager paid for registration
	public function updateManagerPaid() {
		// this will get the last id entered and then update that id to managerPaid = 1
			$result = $this->db->query("SELECT * FROM manager ORDER BY managerId DESC LIMIT 1");
			$row = $result->fetch_assoc();
			$this->_lastManagerId = $row['managerId'];
			$result2 = $this->db->query("UPDATE manager SET managerPaid ='1' WHERE managerId = '$this->_lastManagerId'");
			
			// email new registration details to the member
			//EMAIL TO MEMBER
			$to = $row['managerEmail']; 
			$from = "semillerjr@managelog.com";
			$headers = "MIME-Version: 1.0" . "\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
			$headers .= "From: $from" . "\n";
			
			$emailmessage = "
			<p>Thank you for registering to the Manage Log Service Toolkit.  Your payment was successfully completed.<br>  Listed below are the registration details for your new account.</p>
			
			<p>To get started, simply login to your new account.  As the administrator of your account/facility, you can begin by adding the necessary departments and managers for your location.</p>
			
			<p><strong>Registration Details</strong></p>
			
			<p>
			<strong>Name:</strong> $row[managerFirstName] &nbsp; $row[managerLastName] <br />
			
			<strong>Email:</strong> $row[managerEmail] <br />
			
			<strong>Phone Number:</strong> $row[managerPhone] <br />
			
			<strong>Username:</strong> $row[managerUsername]
			</p>
			
			<p>If you have any questions, comments, or concerns regarding your registration, please reach out by contacting us at <a href='http://www.managelog.com/contact.php'>Our Contact Page</a> or 410-952-9748.</p>
			
			<p>Thanks again for using our service.<br>
			Stephen Miller</p>
			";
			mail( $to, "Manage Log New Registration", $emailmessage, $headers );
			
			
			// email new registration details to self
			//EMAIL TO MEMBER
			$to = "semillerjr@managelog.com"; 
			$from = "semillerjr@managelog.com";
			$headers = "MIME-Version: 1.0" . "\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
			$headers .= "From: $from" . "\n";
			
			$emailmessage = "
			<p>New paid member registration completed.  Details are listed below:</p>
			
			
			<p><strong>Registration Details</strong></p>
			
			<p>
			<strong>Name:</strong> $row[managerFirstName] &nbsp; $row[managerLastName] <br />
			
			<strong>Email:</strong> $row[managerEmail] <br />
			
			<strong>Phone Number:</strong> $row[managerPhone] <br />
			
			<strong>Username:</strong> $row[managerUsername]
			</p>
		
			";
			mail( $to, "Manage Log New Paid Registration Details", $emailmessage, $headers );
			
	} // end updateManagerPaid
	
	
	// update paid status if manager paid for registration
	public function updateManagerCouponFree() {
		// this will get the last id entered and then update that id to managerPaid = 1
			$result = $this->db->query("SELECT * FROM manager ORDER BY managerId DESC LIMIT 1");
			$row = $result->fetch_assoc();
			$this->_lastManagerId = $row['managerId'];
			$result2 = $this->db->query("UPDATE manager SET managerPaid ='1' WHERE managerId = '$this->_lastManagerId'");
			
			// email new registration details to the member
			//EMAIL TO SELF
			$to = $row['managerEmail']; 
			$from = "semillerjr@managelog.com";
			$headers = "MIME-Version: 1.0" . "\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
			$headers .= "From: $from" . "\n";
			
			$emailmessage = "
			<p>Thank you for registering to the Manage Log Service Toolkit.  Your entered coupon code has granted you free access to the service toolkit.<br>  Listed below are the registration details for your new account.</p>
			
			<p>To get started, simply login to your new account.  As the administrator of your account/facility, you can begin by adding the necessary departments and managers for your location.</p>
			
			<p><strong>Registration Details</strong></p>
			
			<p>
			<strong>Name:</strong> $row[managerFirstName] &nbsp; $row[managerLastName] <br />
			
			<strong>Email:</strong> $row[managerEmail] <br />
			
			<strong>Phone Number:</strong> $row[managerPhone] <br />
			
			<strong>Username:</strong> $row[managerUsername]
			</p>
			
			<p>If you have any questions, comments, or concerns regarding your registration, please reach out by contacting us at <a href='http://www.managelog.com/contact.php'>Our Contact Page</a> or 410-952-9748.</p>
			
			<p>Thanks again for using our service.<br>
			Stephen Miller</p>
			";
			mail( $to, "Manage Log New Registration", $emailmessage, $headers );
			
			
			// email new registration details to self
			//EMAIL TO MEMBER
			$to = "semillerjr@managelog.com"; 
			$from = "semillerjr@managelog.com";
			$headers = "MIME-Version: 1.0" . "\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
			$headers .= "From: $from" . "\n";
			
			$emailmessage = "
			<p>New free coupon code member registration completed.  Details are listed below:</p>
			
			
			<p><strong>Registration Details</strong></p>
			
			<p>
			<strong>Name:</strong> $row[managerFirstName] &nbsp; $row[managerLastName] <br />
			
			<strong>Email:</strong> $row[managerEmail] <br />
			
			<strong>Phone Number:</strong> $row[managerPhone] <br />
			
			<strong>Username:</strong> $row[managerUsername]
			</p>
		
			";
			mail( $to, "Manage Log New Coupon Code Registration Details", $emailmessage, $headers );
			
			
	} // end updateManagerCouponFree
	
	
	
	// delete registration and account name if payment cancelled
	public function deleteRegistration() {
		// get last entered manager Id for and account Id for deletion
		$result = $this->db->query("SELECT accountId FROM account ORDER BY accountId DESC LIMIT 1");
		$row = $result->fetch_assoc();
		$this->_lastAccountId = $row['accountId'];
		
		$result2 = $this->db->query("DELETE FROM account WHERE accountId = '$this->_lastAccountId'");
		
		$result3 = $this->db->query("SELECT managerId FROM manager ORDER BY managerId DESC LIMIT 1");
		$row3 = $result3->fetch_assoc();
		$this->_lastManagerId = $row3['managerId'];
		
		$result4 = $this->db->query("DELETE FROM manager WHERE managerId = '$this->_lastManagerId'");
		
		// delete package info from manager
		$result5 = $this->db->query("DELETE FROM package WHERE managerId = '$this->_lastManagerId'");
		
		
		// after deletion, redirect to another cancel index page, to prevent refresh and deletion
		header("Location: index.php?payment_cancel_final=yes");
	} // end deleteRegistration
		
	
	
	public function checkEmailExists($managerEmail) {
		$result = $this->db->query("SELECT managerEmail FROM manager WHERE managerEmail = '$managerEmail'");
		if ($result->num_rows > 0) {
			header("Location: register.php?email_exists=yes");
			exit();
		} // end if
	} // end checkEmailExists
	
	public function checkUsernameExists($managerUsername) {
		$result = $this->db->query("SELECT managerUsername FROM manager WHERE managerUsername = '$managerUsername'");
		if ($result->num_rows > 0) {
			header("Location: register.php?username_exists=yes");
			exit();
		} // end if
	} // end checkUsernameExists
	
	
	public function insertPackageType() {
		// if the Bronze Package - do this insert
		if($this->_packageType == 'Bronze') {
		$result = $this->db->query("INSERT INTO package (accountId,managerId,packageType,packageDepartment,packageManager) VALUES ($this->_accountId,$this->_lastManagerId,'Bronze','1','3')");
		} // end if Bronze Package
		elseif ($this->_packageType == 'Silver') {
			$result = $this->db->query("INSERT INTO package (accountId,managerId,packageType,packageDepartment,packageManager) VALUES ($this->_accountId,$this->_lastManagerId,'Silver','5','15')");
		} // end if Silver Package
		elseif ($this->_packageType == 'Gold') {
			$result = $this->db->query("INSERT INTO package (accountId,managerId,packageType,packageDepartment,packageManager) VALUES ($this->_accountId,$this->_lastManagerId,'Gold','10000','10000')");
		} // end if Gold Package
		
	} // end insertPackageType
	
	public function updatePackagePlan() {
		$result = $this->db->query("UPDATE package SET packageType='Gold',packageDepartment='10000',packageManager='10000' WHERE accountId = '$_SESSION[accountId]'");
	} // end updatePackagePlan
	
} // end Register class