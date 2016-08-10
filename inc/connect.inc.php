<?php
	// connect to DB
$config = array(
	'host'		=> '23.229.156.96',
	'username'	=> 'smilljr',
	'password'	=> 'optimus1',
	'dbname' 	=> 'managelog'
);
// set up mysqli connection
$conn = new mysqli($config['host'],$config['username'],$config['password'],$config['dbname']);

?>
