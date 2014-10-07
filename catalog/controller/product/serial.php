<?php

class Controllerproductserial extends Controller {



  // Return true if serial is valid, false if it is not.
  function validSerial() {
    $json = array();

    $json['success'] = 'true';
    $json['error'] = '';

    if(isset($this->request->get['serialNumber']))  { $serialNumber = $this->request->get['serialNumber']; }
    if(isset($this->request->post['serialNumber'])) { $serialNumber = $this->request->post['serialNumber']; }
    if(isset($this->request->get['modelNumber']))  { $modelNumber = $this->request->get['modelNumber']; }
    if(isset($this->request->post['modelNumber'])) { $modelNumber = $this->request->post['modelNumber']; }
    
//    $json['sn'] = $serialNumber;
//    $json['mn'] = $modelNumber;

    $errorThrownFC = 0;

    // Most important check. If sn or model is empty, then why go any further?
    if(strlen($serialNumber) == 0 || empty($serialNumber)) {
      $json['success'] = 'false';
      $json['error'][] = 'Please enter your complete serial number in the above box and press enter.';
      $this->response->setOutput(json_encode($json));
      return 0;
    }

    // First we need to break down the serial. The first 5 characters are the serial number, the last 3 are the featurecodes
    if(strlen($serialNumber) != 8) {
      $json['success'] = 'false';
      $json['error'][] = 'The format for the complete serial number is - <b>XXXXXXXX</b> - 8 characters. (E01)';
    }

    // The first character must be a number.
    if(!is_numeric(substr($serialNumber, 0, 1))) {
      $json['success'] = 'false';
      $json['error'][] = 'You have entered an invalid serial number. (E02)';
    }

    // Submitted serial number cannot contain anything but letters and numbers.
    if(!preg_match('/[A-Z0-9]/i',$serialNumber)) {
      $json['success'] = 'false';
      $json['error'][] = 'You have entered an invalid serial number. (E03)';
    
    }

    // Third from the last character must be M or P
    if(!preg_match('/[MP]/i', substr($serialNumber, -3, 1))) {
      $json['success'] = 'false';
      $errorThrownFC = 1;
    }

    // Second to last character must be A, B, L, or X
    if(!preg_match('/[ABLX]/i', substr($serialNumber, -2, 1))) {
      $json['success'] = 'false';
      $errorThrownFC = 1;
    }

    // Last character must be F or X
    if(!preg_match('/[FX]/i', substr($serialNumber, -1))) {
      $json['success'] = 'false';
      $errorThrownFC = 1;
    }

    if($errorThrownFC != 0) {
      $json['success'] = 'false';
      $json['error'][] = 'You did not enter a valid serial number. Please try again. (FC01)';
    }

    if(!isset($modelNumber)) {
      $json['success'] = 'false';
      $json['error'][] = 'Model number was empty. (MN01)';
    }

    if($modelNumber[7] != $serialNumber[0]) {
      $json['success'] = 'false';
      $json['error'][] = 'The serial number you entered was not for this product. (ERX1)';
    }

    // Get featurecodes and serial (without featurecodes) so we can query the database
    $featurecodes = strtoupper(substr($serialNumber, -3, 1) . substr($serialNumber, -2, 1) . substr($serialNumber, -1, 1));
    $serial = strtoupper(substr($serialNumber, 0, -3));

//    $snQuery = $this->db->query("select * from " . DB_PREFIX . "serials_order where `key`=UPPER('" . $serial . "') and featurecode=UPPER('" . $featurecodes . "') limit 1");
    $snQuery = $this->db->query("select * from " . DB_PREFIX . "serials_order where `key`=UPPER('" . $serial . "') order by id desc limit 1");
    // Here we need to make sure we find the serial and featurecodes in the database. 

    if($upgradeThis = $snQuery->rows) {
      // Inside this IF statement, the serial number should be valid.
      // This does not mean that the serial number the user is trying to upgrade is allowed though. We need to make sure that it hasn't already been upgraded before.
      // The user should only be able to upgrade the newest version of the serial.
      if(strtoupper($upgradeThis[0]['featurecode']) != strtoupper($featurecodes)) {
        $json['success'] = 'false';
        $json['error'][] = 'The serial number you are attempting to upgrade is not available for this service. (ERX3)';
      }
    }
    else {
      $json['success'] = 'false';
      $json['error'][] = 'You did not enter a valid serial number. Please try again. (ERX2)';
    }

    if($json['success'] != 'false') { $json['success'] = 'true'; }
    if(isset($json['success']) && $json['success'] == 'true') {
      $json['FC1'] = substr($serialNumber, -3, 1);
      $json['FC2'] = substr($serialNumber, -2, 1);
      $json['FC3'] = substr($serialNumber, -1, 1);

      if(isset($serialNumber)) { $json['sn'] = (string)'"' . $serialNumber . '"'; }
      if(isset($modelNumber))  { $json['mn'] = (string)'"' . $modelNumber  . '"'; }
    }

    $this->response->setOutput(json_encode($json));
  }


}
?>
