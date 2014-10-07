<?php

// Heartbeat server connection.
function heartbeat_connect() {
  $username = "heartbeatuser";
  $password = "heartbeatpass";
  $database = "heartbeat";
  $link = mysqli_connect("u16845242.onlinehome-server.com", $username, $password, $database);
  /* check connection */
  if (!$link) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  return $link;
}

// Fetch the timestamp from the database.
function getTimestamp($link,$id) {
  $result = mysqli_query($link, sprintf("SELECT `timestamp` from `check` where id=%s", mysqli_real_escape_string($link,$id)));
  while($row = mysqli_fetch_assoc($result)) {
    $timestamp = $row['timestamp'];
  }
  return $timestamp;
}





while(1) {
  // Make the connection
  $conn = heartbeat_connect();

  // get the timestamps
  $currentTimestamp = date('Y-m-d H:i:s');
  $heartbeatTimestamp = getTimestamp($conn, 1);

  // display timestamps
  echo "\n\n##########################################################################################################\n\n";

  $a = strtotime($currentTimestamp);
  $b = strtotime($heartbeatTimestamp);

  echo "Current Timestamp   : " . $currentTimestamp . " : " . $a . "\n";
  echo "Heartbeat Timestamp : " . $heartbeatTimestamp . " : " . $b . "\n";

  $c = $a - $b;

  echo "Seconds Difference  : " . $c . "\n";
  echo "Minutes Difference  : " . ($c / 60) . "\n";
  echo "Hours Difference    : " . (($c / 60) / 60) . "\n";

  if((($c / 60) / 60) > 1) {
//    error_log("The CDB Server Timestamp has not been updated in over an hour. Please check the server.",1,"jlevan@gmail.com","From:john.levan@1099-etc.com");
  }

  echo "\n\n##########################################################################################################\n\n";

  // Close the connection
  mysqli_close($conn);

  sleep(300);


}

?>
