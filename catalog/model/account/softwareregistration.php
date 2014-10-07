<?php
class ModelAccountSoftwareRegistration extends Model {
  
  public function getStates() {
    $states_query = $this->db->query("SELECT " . DB_PREFIX . "zone.zone_id, " . DB_PREFIX . "zone.`name`, " . DB_PREFIX . "zone.code from " . DB_PREFIX . "zone, " . DB_PREFIX . "country where " . DB_PREFIX . "zone.country_id=" . DB_PREFIX . "country.country_id and " . DB_PREFIX . "country.`name` = 'United States'");
  
    if($states_query->num_rows) {
      foreach ($states_query->rows as $result) {
        $states_data[] = array(
          'zone_id' => $result['zone_id'],
          'name'    => $result['name'],
          'code'    => $result['code']
        );
      }
      return $states_data;
    }
    else { 
      return false; 
    }
  }

  public function addRegistration($serial, $featurecodes, $states = array(), $comments = '') {
    $query = "INSERT INTO " . DB_PREFIX . "software_registration (serial, featurecodes, filing_states, comments) VALUES (upper('" . $serial . "'), upper('" . $featurecodes . "'), upper('" . implode(',',$states) . "'), '" . $this->db->escape($comments) . "')";
    $this->db->query($query);

    $message  = "Serial - " . $serial . $featurecodes . "\n";
    $message .= "States - " . implode(',',$states) . "\n";
    $message .= "Comments - \n" . $comments . "\n";

    // Need to send Michelle and Dawn an email
    $mail = new Mail();
    $mail->protocol = $this->config->get('config_mail_protocol');
    $mail->parameter = $this->config->get('config_mail_parameter');
    $mail->hostname = $this->config->get('config_smtp_host');
    $mail->username = $this->config->get('config_smtp_username');
    $mail->password = $this->config->get('config_smtp_password');
    $mail->port = $this->config->get('config_smtp_port');
    $mail->timeout = $this->config->get('config_smtp_timeout');
    $mail->setTo('webmaster@1099-etc.com');
    $mail->setFrom($this->config->get('config_email'));
    $mail->setSender('Software Registration');
    $mail->setSubject(html_entity_decode('Software Registration', ENT_QUOTES, 'UTF-8'));
    $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
    $mail->send();


  }

  public function serialPurchased($serial, $featurecode) {
    $exists = $this->db->query("SELECT * FROM " . DB_PREFIX . "serials_order WHERE lower(`key`) = lower('" . $serial . "') and lower(featurecode) = lower('" . $featurecode . "')");
    if($exists->num_rows) {
      return true;
    } else {
      return false;
    }
  }

  public function isRegistered($serial, $featurecode) {
    $exists = $this->db->query("SELECT * FROM " . DB_PREFIX . "software_registration WHERE lower(serial) = lower('" . $serial . "') and lower(featurecodes) = lower('" . $featurecode . "')");
    if($exists->num_rows) {
      return true;
    } else {
      return false;
    }
  }

  public function showRegistration($serial, $featurecode) {
    $this->load->model('catalog/serial');
    $validSerials = trim($this->model_catalog_serial->validSerialNOJSON($serial . $featurecode));
    $registration = $this->db->query("SELECT * FROM " . DB_PREFIX . "software_registration WHERE lower(serial) = lower('" . $serial . "') and lower(featurecodes) = lower('" . $featurecode . "') limit 1");
    
    $returnReg = array();

    if($registration->num_rows) {
      foreach ($registration->rows as $reg) {
        $returnReg[] = array(
          'registration_id'      => $reg['registration_id'],
          'serial'               => $reg['serial'],
          'featurecodes'         => $reg['featurecodes'],
          'filing_states'        => $reg['filing_states'],
          'comments'             => $reg['comments'],
          'registered_timestamp' => $reg['registered_timestamp']
        );
      }
      return $returnReg[0];
    }
    else {
      return false;
    }
  }

  public function getCustomerIDfromSerial($serial, $featurecode) {
    $cid = $this->db->query("select " . DB_PREFIX . "`order`.customer_id from " . DB_PREFIX . "`order`, " . DB_PREFIX . "serials_order where lower(" . DB_PREFIX . "serials_order.`key`) = lower('" . $serial . "') and lower(" . DB_PREFIX . "serials_order.featurecode) = lower('" . $featurecode . "') and " . DB_PREFIX . "serials_order.oid=" . DB_PREFIX . "`order`.order_id");

    foreach ($cid->rows as $result) {
      if(isset($result['customer_id']) && $result['customer_id'] > 0) {
        $customer_id = $result['customer_id'];
      }
    }
    
    if(!isset($customer_id)) { $customer_id = 0; }

    return $customer_id;

  }

  public function editCustomerPayrollStates($customer_id, $payroll_states) {
    if(count($payroll_states) > 1) {
      $payroll_states = implode(',',$payroll_states);
    }
    $this->db->query("UPDATE " . DB_PREFIX . "customer SET payroll_states = CONCAT(payroll_states, '," . $payroll_states . "') WHERE customer_id = '" . (int)$customer_id . "'");
  }




}
?>
