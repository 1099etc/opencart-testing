<?php
// This script is for obtaining tracking data for users who are downloading the software. 
// This script should log all the available information for the individual downloading, it does not require serial number.


// Include the config file.
require_once("config.php");

// Start with no errors 
$errorMSG[] = array();
$error      = 0;

// $serialNumber = '30004plx';
$customer_id  = $_REQUEST['customer_id'];
$order_id     = $_REQUEST['order_id'];
$download_id  = $_REQUEST['download_id'];
$from         = $_REQUEST['from'];

// Empty variables 
$maskName = '';
$fileName = '';

// Create our connection, because we'll need it.
$link = ams_connect();

// Lets make sure that "from" has something in it... well, and everything else too
if($from == '' || $order_id == '' || $customer_id == '' || $download_id == '') {
  header("location: https://www.1099-etc.com\n\n");
}

// First thing we need to do is check the customer_id, order_id, and download_id to ensure that they are correct, filled in, and all 
// go together... IE, has customer_id actually purchased $order_id, and is $download_id actually available as a download currently.

$query = "select distinct customer_id from `order` where order_id='" . (int)$order_id . "'";
if($cid = mysqli_query($link, $query)) {
  // Here we should have a customer_id returned and it should be equal to the one submitted by the calling script.
  
  // check to see if a single customer_id was returned.... or not...
  if(mysqli_num_rows($cid) != 1) {
    $errorMSG[] .= 'Downloader Script - A01 - There was more than one customer ID returned during the query.';
    $error = 1;
  }
  else {  
    // Does it match what the referring script submitted?
    $cid_num = $cid->fetch_array();
    if($cid_num['customer_id'] != $customer_id) {
      $errorMSG[] .= 'Downloader Script - A01 - There was more than one customer ID returned during the query.';
      $error = 1;
    }
  }
  
}

// At this point, if $error = 0 then we have a matching customer_id and order_id... next we make sure that the download_id is valid

$q = "select distinct download.filename as filename, download.mask as mask from download where download.download_id = '" . (int)$download_id . "'";
$maskName = '';
$fileName = '';
if($result = mysqli_query($link, $q)) {
  $row = $result->fetch_array();
  $maskName = $row['mask'];
  $fileName = $row['filename'];
}

// At this point, we should hopefully have an authenicated serial number and a file to send to the user, or an error message to display.

// Let's log the visit....
require_once('rb.php');

//Second, we need to setup the database
R::setup('mysql:host=localhost;dbname=opencart','opencartuser','opencartpass');

// Create a redbean...
$log = R::dispense('logger');

// Process the data being submitted for sanitization
foreach ($_SERVER as $key => $value){
  $log->$key = $value;
  R::store($log);
}
foreach ($_REQUEST as $key => $value){
  $log->$key = $value;
  R::store($log);
}
foreach ($_POST as $key => $value){
  $log->$key = $value;
  R::store($log);
}
foreach ($_GET as $key => $value){
  $log->$key = $value;
  R::store($log);
}
foreach ($_ENV as $key => $value){
  $log->$key = $value;
  R::store($log);
}

$localVariables = array();
$localVariables['maskName'] = $maskName;
$localVariables['fileName'] = $fileName;
$localVariables['dateTime'] = date('Y-m-d H:i:s');

foreach ($localVariables as $key => $value){
  $log->$key = $value;
  R::store($log);
}

// Output time!
if(!empty(array_filter($errorMSG))) {
  header("location: https://www.1099-etc.com\n\n");
}
else {
  $fakeFile = $maskName . ".exe";
  $realFile = $fileName;
  $file     = "../download/" . $realFile;
  $fp       = fopen($file,'rb');
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=$fakeFile");
  header("Content-Length: " . filesize($file));
  fpassthru($fp);
}




?>
