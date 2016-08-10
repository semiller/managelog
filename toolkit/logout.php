<?php
  // require configuration file
  require_once 'config/init.php';
  
	// call logout method
	$log = new Log();
	$log->logout();
?>