<?php

class Account extends DbConnect {
	
          // define properties
          protected $accountId;
          protected $accountName;
		  
		  
		  public function __construct($accountId) {
			  parent::__construct();
			  $this->accountId = $accountId;
			  
			  $result = $this->db->query("SELECT * FROM account WHERE accountId = '$this->accountId'");
			  $row = $result->fetch_assoc();
			  $this->accountName = $row['accountName'];
			  
		  } // end __construct
		  
		  public function getAccountName() {
			  return $this->accountName;
		  } // end getAccountName
} // end Account class


?>