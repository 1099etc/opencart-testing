<?php

function ams_connect() {
  $username = "serialuser";
  $password = "serialpass";
  $database = "serial";

  $link = mysqli_connect("localhost", $username, $password, $database);

  /* check connection */
  if (!$link) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }

  return $link;
}


$link = ams_connect();

$year = 0;

while($year <= 9) {

  $query = mysqli_query($link, "select * from serials where year='" . $year . "'");
  while($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
    $serial = $result['year'] . $result['serial'];
    $file = './serialsForYear' . $year . '.txt';
    file_put_contents($file, $serial . ',', FILE_APPEND | LOCK_EX);
    echo $serial . ",";
  }
  $year = $year + 1;
}



?>
