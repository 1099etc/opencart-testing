<?php

class ModelSaleAlert extends Model {

  // Returns alerts saved to a customer_id
  public function getCustomerAlerts($customer_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "alerts WHERE customer_id='" . $customer_id . "' ORDER BY date_added DESC");
    return $query->rows;
  } // end getCustomerAlerts

  // returns alerts saved to an order_id
  public function getOrderAlerts($order_id) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "alerts WHERE order_id='" . $order_id . "' ORDER BY date_added DESC");
    return $query->rows;
  } // end getOrderAlerts

  // inserts a new alert on a customer_id
  public function createCustomerAlert($customer_id, $message, $severity, $title, $user_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "alerts SET customer_id = '" . $customer_id . "', message = '" . $message . "', severity = '" . $severity . "', title='" . $title . "', user_id='" . $user_id . "'");
  } // end createCustomerAlerts

  // inserts a new alert on an order_id
  public function createOrderAlert($order_id, $message, $severity, $title, $user_id) {
    $this->db->query("INSERT INTO " . DB_PREFIX . "alerts SET order_id = '" . $order_id . "', message = '" . $message . "', severity = '" . $severity . "', title='" . $title . "', user_id='" . $user_id . "'");
  } // end createOrderAlerts

  // deletes an alert on an alert_id
  public function deleteAlert($alert_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "alerts WHERE alert_id='" . $alert_id . "'");
  } // end of deleteAlert

  // Modifies the severity of an alert
  public function changeSeverity($alert_id, $severity) {
    $this->db->query("UPDATE " . DB_PREFIX . "alerts SET severity = '" . $severity . "' WHERE alert_id = '" . $alert_id . "'");
  } // end of changeSeverity

  // Modifies an alert message
  public function updateAlert($alert_id, $title, $message, $severity) {
    $this->db->query("UPDATE " . DB_PREFIX . "alerts SET title = '" . $title . "', message = '" . $message . "', severity = '" . $severity . "' WHERE alert_id = '" . $alert_id . "'");
  } // end of updateMessage

}

?>
