<?php
class DbConnect {
	// declare variables
	protected $db;
 
 	public function __construct() {
	// connect to DB
$config = array(
	'host'		=> '23.229.156.96',
	'username'	=> 'smilljr',
	'password'	=> 'optimus1',
	'dbname' 	=> 'managelog'
);
// set up mysqli connection
$this->db = new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);

// check for connection errors
	if($this->db->connect_errno > 0){
    	die('Unable to connect to database [' . $db->connect_error . ']');
	} // end if 
	
	} // end construct
	
	
} // end DbConnect class