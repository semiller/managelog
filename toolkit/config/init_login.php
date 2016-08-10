<?php
// this solves the header issue not passing properly
ob_start();
// Include this page on top of all pages
// start the session
session_start();

// Autoload necessary classes
  function __autoload($class_name) {
      require_once 'classes/' . $class_name . '.php';
  } // end function __autoload

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

?>