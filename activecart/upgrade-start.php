<?php
  $serialNumber = $_GET['sn'];

  if(isset($serialNumber) && $serialNumber != '') {
    echo $serialNumber[0];
    if($serialNumber[0] == '4') {
      ?>
      <META http-equiv="refresh" content="0;URL=https://shop.1099-etc.com/upg-2014-1099-etc?serial=<?php echo $serialNumber; ?>">
      <?php
    }
    elseif($serialNumber[0] == '3') {
      ?>
      <META http-equiv="refresh" content="0;URL=https://shop.1099-etc.com/upg-2013-1099-etc?serial=<?php echo $serialNumber; ?>">
      <?php
    }
    else {
      ?>
      <META http-equiv="refresh" content="0;URL=https://shop.1099-etc.com/index.php?route=product/category&path=63">
      <?php
    }
  }
  else {
    ?>
    <META http-equiv="refresh" content="0;URL=https://shop.1099-etc.com/index.php?route=product/category&path=63">
    <?php
  }



?>
