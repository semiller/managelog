<?php
	// connect to DB
$config = array(
	'host'		=> '',
	'username'	=> '',
	'password'	=> '',
	'dbname' 	=> ''
);
// set up mysqli connection
$conn = new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);

?>
