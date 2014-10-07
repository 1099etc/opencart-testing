<?php

function generate_new_serial($link){
  // need to lock tables here...... ;)
  $available_letters = array( 1 => "A",  2 => "B",  3 => "C",  4 => "D",  5 => "E" , 6 => "F",  7 => "G",  8 => "H",  9 => "I", 10 => "J", 
                             11 => "K", 12 => "L", 13 => "M", 14 => "N", 15 => "O", 16 => "P", 17 => "Q", 18 => "R", 19 => "S", 
                             20 => "T", 21 => "U", 22 => "V", 23 => "W", 24 => "X", 25 => "Y", 26 =>  "Z", 27 => "0", 28 => "1",
                             29 => "2", 30 => "3", 31 => "4", 32 => "5", 33 => "6", 34 => "7", 35 => "8", 36 => "9", 37 => "0");

  //$last_serial_query = mysqli_query($link, "SELECT max(sn) as SN from customer where SN LIKE 'X%'");
  $last_serial_query = mysqli_query($link, "SELECT max(serial) as SN from serials");
  $last_serial_result = mysqli_fetch_array($last_serial_query, MYSQLI_ASSOC);

  // manipulate serial ...
  // X0001

  $last_serial = $last_serial_result['SN'];

  // for testing a rollover and such
  // $last_serial = "XZ999";

  if ($last_serial == "0999"){
//    $last_serial = 'A001';
    echo "This should never happen.....";
    exit(0);
  }

  $last_digits = $last_serial[1] . $last_serial[2] . $last_serial[3];
  $letter = $last_serial[0];

 // foreach ($available_letters as $letter_key => $letter_value) {
   // if ($letter_value == $letter) {
    //  echo "1 CURRENT - " . $current_available . "\n\n\n";
   //   $current_available = $letter_key;
   //   echo "2 CURRENT - " . $current_available . "\n\n\n";
   // }
 // }
  $available_flipped = array_flip($available_letters);
  $current_available = $available_flipped[$letter];

  $last_digits = $last_digits + 1;

  // pad small numbers with extra 0's or else the serial will be wrong	
  if ($last_digits < 10) {
    $print_digits = "00" . $last_digits;
    $last_digits = $print_digits;
    echo "3 - " . $current_available . "\n\n\n";
  }
  if ($last_digits >= 10 && $last_digits < 100) {
    $print_digits = "0" . $last_digits;
    $last_digits = $print_digits;
    echo "4 - " . $current_available . "\n\n\n";
  }		
  if ($last_digits > 999) {
    $last_digits = "001";

    // roll to next letter
    if($current_available > 36) { $current_available = 1; } else { $current_available = $current_available; } 

    $current_available++;
    $letter = $available_letters[$current_available];
  }	
  //$returned_serial = "X" . $letter . $last_digits;
  $returned_serial = $letter . $last_digits;
  return $returned_serial;

}

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

mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A001\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A002\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A003\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A004\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A005\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A006\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A007\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A008\")");
mysqli_query($link, "insert into serials (year, serial) values (\"0\",\"A009\")");

while(1) {
  $s = generate_new_serial($link);


  while($year <= 9) {
    mysqli_query($link, "insert into serials (year, serial) values (\"" . $year . "\",\"" . $s . "\")");
    echo $year . " " . $s . "<br />\n";
    $year++;
  }

  $year = 0;
}





?>
