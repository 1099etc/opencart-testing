<?php

// Function to connect to the database
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

// Function to zerofill a number string
function zerofill ($num, $zerofill = 3) {
  return sprintf("%0".$zerofill."s", $num);
}


// Connect to the database.
$link = ams_connect();

// Characters available for our 1st character.
$characters = array ( "A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z" );

// Loop through the years
for($year = 0; $year <= 9; $year++) {

  // Loop through each character in the array
  for($charIndex = 0; $charIndex < count($characters); $charIndex++) {

    // One last loop, for 000 - 999
    for($num = 0; $num <= 999; $num++) {
    
      // Build the actual serial number.
      $number = zerofill($num, 3);
      $serialNumber = $characters[$charIndex] . $number;

      // Do the insert
      mysqli_query($link, "insert into serials (year, serial) values (\"" . $year . "\",\"" . $serialNumber . "\")");
      
      // Give the user some output
      echo $year . " - " . $serialNumber . "\n";

    } // end num loop

  } // end character index loop

} // end of year loop

?>
