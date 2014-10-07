<?php
/* This is a logging php script that uses the RedBean framework to automatically generate
   the database schema based on need. The only requirement is that when submitting data
   to be stored in the database the variable
   
   obfuscationPhrase must be set to t3chn0dr0m3
   
   or else the logger will not store the data.
   
   Written by John LeVan. Tada!
   
   FYI, all this logger will store is the information being submitted to it. If you want to 
   know personal information about the user then you'll have to submit it. There is nothing 
   identifying about this logger at all. No IP addresses or anything. Handle it yourself!
   
   You can utilize this app by submitting data to the following base URL - 
   http://www.1099-etc.com/LogFiler/logger.php?obfuscationPhrase=t3chn0dr0m3
   
   To include more data in the logger, you can use an ampersand - & - separated key = value pair.
   IE - http://www.1099-etc.com/LogFiler/logger.php?obfuscationPhrase=t3chn0dr0m3&Crayon=Red
   
   the database will gain an entry for Crayon = Red based on the above URL.
*/

// Require some silly crap to proceed.
if($_REQUEST['obfuscationPhrase'] != 't3chn0dr0m3') { exit; }
else {
  //First, we need to include redbean
  require_once('rb.php');
  //Second, we need to setup the database
  R::setup('mysql:host=198.101.136.228;dbname=344224_logger','344224_logger','Zedmond120');
  // Create a redbean...
  $log = R::dispense('log');
  // Process the data being submitted for sanitization
  foreach ($_REQUEST as $key => $value){
    $log->$key = $value;
    R::store($log);  
  }
}
?>
