<?php
class Log extends DbConnect {
    // declare variables
    protected $db;
    protected $managerUsername;
    protected $managerPassword;
	
	protected $encryptPassword;

    // __construct comes from DbConnect
	public function __construct() {
		parent::__construct();
	}
    public function login($managerUsername, $managerPassword) {

        $this->managerUsername = $managerUsername;
        $this->managerPassword = $managerPassword;
		// get the hash value of the manager entered password and store it in the encryptPassword property
		// when checking against usernmae and password, make sure to check password against encrypte password
		$this->encryptPassword = md5($this->managerPassword);

        // uses getSession to create Session for manager logging in
        $this->getSession();
        // prepare the statement to subtitute the $_POST elements from the form
		// managerPaid must equal 1.  this ensures payment has been completed before manager can log in
        $result = $this->db->prepare("SELECT * FROM manager WHERE managerUsername = ? AND managerPassword = ? AND managerPaid='1'");
        $result->bind_param('ss', $this->managerUsername, $this->encryptPassword);

        $result->execute();

        // fetch the results to see if row is greater than 0
        if ($result->fetch() > 0) {
            // set login session 
            $_SESSION['auth'] = "yes";
            // set session variables for manager
            $_SESSION['managerUsername'] = $managerUsername;

            // redirect to main page
            header("Location: main.php");
            exit();
        } // end if data is correct
        else {
           echo " <p><strong>Incorrect username and/or password</strong></p> ";
        } // end else
    } // end login function



    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    } // end logout()



    public function getSession() {
        // set all session variables
		// check against encrypted password which was previously set to get user session variables
        $result = $this->db->query("SELECT * FROM manager WHERE managerUsername = '{$this->managerUsername}' AND managerPassword = '{$this->encryptPassword}'");
        $row = $result->fetch_assoc();
		$_SESSION['managerId'] = $row['managerId'];
		$_SESSION['managerDepartment'] = $row['managerDepartment'];
		$_SESSION['managerRole'] = $row['managerRole'];
        $_SESSION['managerFirstName'] = $row['managerFirstName'];
        $_SESSION['managerLastName'] = $row['managerLastName'];
		$_SESSION['accountId'] = $row['accountId'];
		
		$result2 = $this->db->query("SELECT * FROM account WHERE accountId = '{$row['accountId']}'");
		$row2 = $result2->fetch_assoc();
		$_SESSION['accountName'] = $row2['accountName'];
    } // end getSession

} // end Log class

