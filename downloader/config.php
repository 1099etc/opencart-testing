<?php

function ams_connect() {
  $username = "opencartuser";
  $password = "opencartpass";
  $database = "opencart";
  $link = mysqli_connect("localhost", $username, $password, $database);
  /* check connection */
  if (!$link) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  return $link;
}


?>
