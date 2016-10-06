<?php 
// Error Reporting
error_reporting(E_ALL);

// Check Version
if (version_compare(phpversion(), '5.1.0', '<') == TRUE) {
 exit('PHP5.1+ Required');
}

ini_set('memory_limit', '128M');
ini_set('magic_quotes_gpc', 'Off');
ini_set('register_globals', 'Off');
ini_set('default_charset', 'UTF-8');
ini_set('max_execution_time', '18000');
ini_set('safe_mode', 'Off');
ini_set('mysql.connect_timeout', '20');
ini_set('session.use_cookies', 'On');
ini_set('session.use_trans_sid', 'Off');
ini_set('session.gc_maxlifetime', '12000000');

ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '20M');


// Register Globals
if (ini_get('register_globals')) {
 ini_set('session.use_cookies', 'On');
 ini_set('session.use_trans_sid', 'Off');
  
 session_set_cookie_params(0, '/');
 session_start();
 
 $globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES);

 foreach ($globals as $global) {
  foreach(array_keys($global) as $key) {
   unset($$key);
  }
 }
}

// Magic Quotes Fix
if (ini_get('magic_quotes_gpc')) {
 function clean($data) {
     if (is_array($data)) {
     foreach ($data as $key => $value) {
       $data[clean($key)] = clean($value);
     }
  } else {
     $data = stripslashes($data);
  }
 
  return $data;
 }   
 
 $_GET = clean($_GET);
 $_POST = clean($_POST);
 $_COOKIE = clean($_COOKIE);
}

// Set default time zone if not set in php.ini
if (!ini_get('date.timezone')) {
 date_default_timezone_set(date('e', $_SERVER['REQUEST_TIME']));
}

// Engine
require_once(DIR_SYSTEM . 'engine/controller.php');
require_once(DIR_SYSTEM . 'engine/front.php');
require_once(DIR_SYSTEM . 'engine/loader.php'); 
require_once(DIR_SYSTEM . 'engine/model.php');
require_once(DIR_SYSTEM . 'engine/registry.php');
require_once(DIR_SYSTEM . 'engine/router.php'); 
require_once(DIR_SYSTEM . 'engine/url.php');

// Common
require_once(DIR_SYSTEM . 'library/cache.php');
require_once(DIR_SYSTEM . 'library/config.php');
require_once(DIR_SYSTEM . 'library/db.php');
require_once(DIR_SYSTEM . 'library/document.php');
require_once(DIR_SYSTEM . 'library/image.php');
require_once(DIR_SYSTEM . 'library/language.php');
require_once(DIR_SYSTEM . 'library/logger.php');
require_once(DIR_SYSTEM . 'library/mail.php');
require_once(DIR_SYSTEM . 'library/pagination.php');
require_once(DIR_SYSTEM . 'library/request.php');
require_once(DIR_SYSTEM . 'library/response.php');
require_once(DIR_SYSTEM . 'library/session.php');
require_once(DIR_SYSTEM . 'library/template.php');

// 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload Begin
require_once(DIR_SYSTEM . 'library/userfunctions.php');
// 100129 ALNAUA Home Page change, add product sorting, translite russian filename upload End

// (+) ALNAUA 091114 (START)
//Swift
require_once(DIR_SYSTEM . 'library/swift/swift_required.php');
// (+) ALNAUA 091114 (FINISH)

// 130424 ET-130424 Begin
require_once(DIR_SYSTEM . 'library/payu/payu.php');
// 130424 ET-130424 End
?>