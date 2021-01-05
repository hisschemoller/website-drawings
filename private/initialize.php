<?php

  // turn on output buffering
  ob_start();

  // assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define('PRIVATE_PATH', dirname(__FILE__));
  define('PROJECT_PATH', dirname(PRIVATE_PATH));
  define('PUBLIC_PATH', PROJECT_PATH . '/public');
  define('SHARED_PATH', PRIVATE_PATH . '/shared');

  require_once('db_functions.php');
  require_once('functions.php');
  require_once('query_functions.php');

  $db = db_connect();
?>