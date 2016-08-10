<?php
// this solves the header issue not passing properly
ob_start();
// Include this page on top of all pages
// start the session
session_start();
if (@$_SESSION['auth'] != "yes")
{
	header("Location: index.php");
	exit();
}

// Autoload necessary classes
  function __autoload($class_name) {
      require_once 'classes/' . $class_name . '.php';
  } // end function __autoload

// Creates default time zone for the Eastern Time/Date
date_default_timezone_set('America/New_York');

?>