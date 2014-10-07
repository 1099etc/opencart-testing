<?php

// Include the config file.
require_once("config.php");

// Start with no errors 
$errorMSG[] = array();

// Get the serial number and parse it.


// $serialNumber = '30004plx';

$serialNumber = $_REQUEST['sn'];
$customer_id  = $_REQUEST['customer_id'];
$order_id     = $_REQUEST['order_id'];
$download_id  = $_REQUEST['download_id'];
$from         = $_REQUEST['from'];

$dlFile = $_REQUEST['f'];



// Empty variables 
$maskName = '';
$fileName = '';

$serialNumber = strtoupper($serialNumber);

// Start checking for invalid serial numbers.
if(strlen($serialNumber) == 0) { 
  $errorMSG['blank'] = "Please enter your serial number in the box below.";
}

if(strlen($serialNumber) < 8 && strlen($serialNumber) > 0) { 
  $errorMSG[] = "ERROR SN01 - The serial number you entered was invalid. Please enter the complete serial number.";
}

// Create our connection, because we'll need it.
$link = ams_connect();

// Check feature codes
$FC = mysqli_real_escape_string($link, $serialNumber[strlen($serialNumber) - 3] . $serialNumber[strlen($serialNumber) - 2] . $serialNumber[strlen($serialNumber) - 1]);
if(!preg_match('/[A-Z]*/', $FC)) {
  $errorMSG[] = "ERROR SN02 - The serial number you entered was invalid. Please enter the correct serial number.";
}

// Check the serial portion.
$SN = mysqli_real_escape_string($link,substr($serialNumber, 0, -3));
if(!preg_match('/[A-Z0-9]*/', $SN)) {
  $errorMSG[] = "ERROR SN03 - The serial number you entered was invalid. Please enter the correct serial number.";
}

$query  = " select download.filename, download.mask from download, product_to_download, order_product, serials_order ";
$query .= " where serials_order.pid = order_product.order_product_id and order_product.product_id = product_to_download.product_id ";
$query .= " and product_to_download.download_id = download.download_id and serials_order.key = '" . $SN . "' and serials_order.featurecode = '" . $FC . "'";

if($result = mysqli_query($link, $query)) {
  if(mysqli_num_rows($result) <= 0 ) {
    $errorMSG[] = "ERROR SN04 - The serial number you entered was not found in our database. Please try again.";
    $errorMSG[] = "ASDF " . mysqli_num_rows($result);
  }
  else {

    // THE PROBLEM BEGINS HERE - THERE CAN POTENTIALLY BE MORE THAN ONE FILE AVAILABLE FOR DOWNLOAD! THIS NEEDS TO BE FIXED SO THAT INSTEAD OF AUTOMATICALLY PIPING
    // THE USER TO THE DOWNLOAD, WE NEED TO LIST THE FILES FOR DOWNLOAD SO THE USER CAN CHOOSE WHICH THEY WANT.

    // Let's log the visit....
    require_once('rb.php');
      
    // Second, we need to setup the database
    R::setup('mysql:host=localhost;dbname=opencart','opencartuser','opencartpass');
      
    // Create a redbean...
    $log = R::dispense('logger');
            
    foreach ($_SERVER as $key => $value){
      $log->$key = $value;
      R::store($log);
    }

    foreach ($_REQUEST as $key => $value){
      $log->$key = $value;
      R::store($log);
    }
  /*    
    foreach ($_GLOBALS as $key => $value){
      $log->$key = $value;
      R::store($log);
    }
*/
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
/*      
    foreach ($_SESSION as $key => $value){
      $log->$key = $value;
      R::store($log);
    }
      
    foreach ($_errorMSG as $key => $value){
      $log->$key = $value;
      R::store($log);
    }
*/
    $localVariables = array();    
    while($row = $result->fetch_array()) {
        $localVariables[]['maskName'] = $row['mask'];
        $localVariables[]['fileName'] = $row['filename'];
        $localVariables[]['dateTime'] = date('Y-m-d H:i:s');
    }

    foreach ($localVariables as $key => $value){
      $log->$key = $value;
      //R::store($log);
    }
  }
}

// If there is no error then -
//    if there is a download chosen - send file to browser
//    no download chosen - if there is a serial present - show files
//                         no serial present - print form
//
// If there is an error - 
//    print the error and the form

if(empty($errorMSG)) {
//if(empty(array_filter($errorMSG))) { // This means there is no error 
  // if errorMSG['blank'] is empty then the user submitted a serial number.

  if($dlFile != '') { // the user has selected a file. This should equal a maskName 

    foreach($localVariables as $downloads) {
      if($dlFile == $downloads['maskName']) {
        $fakeFile = $downloads['maskName'];
        $realFile = $downloads['fileName'];
        $file = "../download/" . $realFile;
        $fp = fopen($file,'rb');
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$fakeFile");
        header("Content-Length: " . filesize($file));
        fpassthru($fp);
echo "<pre>";
echo $dlFile + "\n";
echo $fakeFile+ "\n";
echo $realFile+ "\n";
echo "</pre>";
      }
    }
  }
  else { // The user has successfully entered a serial number but not chosen a file yet. So here we need to send a file list
      echo "<ul>";
      foreach($localVariables as $downloads) {
          /*
          $serialNumber = $_REQUEST['sn'];
          $customer_id  = $_REQUEST['customer_id'];
          $order_id     = $_REQUEST['order_id'];
          $download_id  = $_REQUEST['download_id'];
          $from         = $_REQUEST['from'];
          $dlFile       = $_REQUEST['f'];
          */

          $outString  = "&sn=" . $serialNumber;
          $outString .= "&customer_id=" . $customer_id;
          $outString .= "&order_id=" . $order_id;
          $outString .= "&download_id=" . $download_id;
          $outString .= "&from=" . $from;
          $outString .= "&f=" . $dlFile;
        
          echo "<li><a href='?" . $outString . "'>" . $downloads['maskName'] . "</a></li>";
      }
      echo "</ul>";
  }


}
else { // This means there IS an error
  if($errorMSG['blank'] != '') { // The user has not entered a serial number yet.
    echo $errorMSG['blank'];
  }
  else { // User has entered a serial number, but there is an error otherwise.
    echo "<ul>";
    unset($errorMSG['blank']);
    foreach (array_filter($errorMSG) as $key => $value) { // Print out all of the error messages
      echo "<li>" . $value . "</li>";
    }
    echo "</ul>";
  }
  // All the error messages have been printed, here we print out the form.
  echo "<form action='' method='get'>";
  echo "<input type='text' name='sn' value='" . $_REQUEST['sn'] . "' />";
  echo "<input type='submit' value='Submit' />";
  echo "</form>";

echo print_r($errorMSG);

}

?>
