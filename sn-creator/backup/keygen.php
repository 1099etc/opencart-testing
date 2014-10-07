<?php

function change_pol($integer) {
    if(!is_numeric($integer)){ return false; }
    return (0 - $integer);
} 

function sn_n($s) {
  return $s;
}

function charx($x, $i) {
  $x = $x + $i;
  if ($x < ord('A')) {
    $x = ord('Z') - (ord('A')-$x) + 1;
  }
  elseif ($x > ORD('Z')) {
    $x = ord('A') + ($x - ord('Z')) - 1;
  }
  $char = chr($x);
  return $char;
}

function funcX($sn, $j, $cxxx, $serial) {
  $j = $j - 1;
  if ($j < 0) {
    $x = $cxxx;
    return $x;
    break;
  }
  $ord_0 = ord("0");
  $ord_1 = ord("$serial[$j]");
  $i = $ord_1 - $ord_0;
  $ij_comp = $i + ($j + 1);
  if($ij_comp % 2) {
    $x = charx(ORD('Z'), change_pol($i));
  }
  else {
    $x = charx(ORD('A'), $i);
  }
  return $x;
}	
	
function calc($num, $cxxx, $serial) {
  $s = "";
  $i = 0;
  $l = 0;
  $s = $num;
  for ($i = 0; $i < 6; $i++) {
    $k = ord($s[$i]) - ord('0');
    $s[$i] = funcX($num, $k, $cxxx, $serial);
  }
  return $s;	
}

function generate_keycode($serial) {
  // needs a full serial number to operate
  $int = 0;
  if ($serial[5] == "M") { $int = 1; }
  if ($serial[6] == "L") { $int = $int + 2; }
  if ($serial[6] == "A") { $int = $int + 4; }
  if ($serial[6] == "B") { $int = $int + 8; }
  if ($serial[7] == "F") { $int = $int + 16; }	
  $int = $int + ord('A');	
  $kint = ord($serial[0]) - ord('8');
  if($kint % 2) {
    // kint is odd
    //  echo "$kint is odd<br>";
    $kint_to_charx = $kint * 2;
    $cxxx = charx($int, $kint_to_charx);
  } 
  else {
    // kint is even
    // turn kint negative
    $kint = change_pol($kint);
    $kint_to_charx = $kint * 2;
    $cxxx = charx($int, $kint_to_charx);
    //  echo "$kint is even<br>";
  }
  if ($serial[0] == "0") { $sn = calc('402531', $cxxx, $serial); }
  if ($serial[0] == "1") { $sn = calc("153204", $cxxx, $serial); }
  if ($serial[0] == "2") { $sn = calc("304215", $cxxx, $serial); }
  if ($serial[0] == "3") { $sn = calc("240513", $cxxx, $serial); }
  if ($serial[0] == "4") { $sn = calc("152304", $cxxx, $serial); }
  if ($serial[0] == "5") { $sn = calc("403152", $cxxx, $serial); }
  if ($serial[0] == "6") { $sn = calc("245013", $cxxx, $serial); }
  if ($serial[0] == "7") { $sn = calc("413250", $cxxx, $serial); }
  if ($serial[0] == "8") { $sn = calc("031452", $cxxx, $serial); }
  if ($serial[0] == "9") { $sn = calc("342051", $cxxx, $serial); }
  $sn = str_replace("FUCK", "AUCK", $sn);
  return $sn;
}
		
		

		


/*
$serial = '3U858PXX';
$keycode = generate_keycode($serial);

echo "Serial: " . $serial . " : Keycode : " . $keycode . " \n";

*/

?>
