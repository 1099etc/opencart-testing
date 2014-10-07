<?php
 require_once "Mail.php";
 
 $from = "system@1099-etc.com";
 $to = "jlevan@gmail.com";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 
// $host = "208.65.145.13";
$host = "smtp.mxtoolbox.com";
 $username = "casey@1099-etc.com";
 $password = "dhmh19";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);
 
 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
  }
 ?>
