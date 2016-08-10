<?php
class PasswordMailer extends DbConnect {
	// define properties
	protected $db;
	
	protected $managerEmail;
	protected $newPassword;
	protected $newEncryptPassword;
	
	public function __construct() {
		//connect to database
		parent::__construct();
	} // end construct
	
	public function sendPassword($managerEmail) {
		
		// get the managers information
		$result = $this->db->prepare("SELECT managerFirstName, managerLastName FROM manager WHERE managerEmail = ?");
		$result->bind_param('s', $this->managerEmail);
		$this->managerEmail = $managerEmail;
        $result->execute();
		
		$result->bind_result($managerFirstName, $managerLastName);
		
		while ($result->fetch()) {
			
		// create new password of 8 characters
		// this is the password sent to the manager
		$this->newPassword = $this->randomPassword(8);
				
		// email manager the password
		$to = $this->managerEmail;
		$from = "admin@managelog.com";
		$headers = "MIME-Version: 1.0" . "\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";
		$headers .= "From: $from" . "\n";
		
		$message = "
		<p>" . $managerFirstName . " " . $managerLastName . ",</p>
		<p>We have been notified that you have forgotten your login password.</p>
		<p>Please use the following login password to login to your account: <strong>" . $this->newPassword . 		"</strong></p>
		<p><a href='http://www.managelog.com' target='_blank'>www.managelog.com</a></p>
		<p>Thank you for using our service!</p>
		<p>Stephen Miller</p>
		";
		mail( $to, "Manage Log - Password Retrieval", $message, $headers );
		} // end while

		
		
		// query to update manager account with encrypted password
		$result = $this->db->prepare("UPDATE manager SET managerPassword = ? WHERE managerEmail = ?");
		$result->bind_param('ss', $this->newEncryptPassword,$this->managerEmail);
		// change plaintext password to encrypted version
		$this->newEncryptPassword = md5($this->newPassword);
		$this->managerEmail = $managerEmail;
        $result->execute();

		header("Location: index.php?password_sent=yes");
	} // end sendPassword
	
	
	
	public function randomPassword($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
	} // end randomPassword
	
} // end PasswordMailer class


?>