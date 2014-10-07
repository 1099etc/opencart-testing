<?php

class ControllerSaleAlert extends Controller {

  public function index() {

  }

  public function deleteAlert() {
    $this->load->model('sale/alert');
    $extraParams = "";

    if(isset($this->request->get['order_id'])) {
      $extraParams = "order_id=" . $this->request->get['order_id'];
    }
    if(isset($this->request->get['customer_id'])) {
      $extraParams = "customer_id=" . $this->request->get['customer_id'];
    }
    if(isset($this->request->get['alert_id'])) {
      $this->model_sale_alert->deleteAlert($this->request->get['alert_id']);
    }
    header("Location: index.php?route=" . $this->request->get['returnURL'] . "&token=" . $this->request->get['token'] . "&" . $extraParams);
  }

  public function addAlert() {
    $this->load->model('sale/alert');
    $this->load->model('user/user');

    $user_id = $this->user->getId();
 
    $extraParams = "";

    isset($this->request->post['alert_message']) ? $message = $this->request->post['alert_message'] : $message = "";
    isset($this->request->post['alert_title'])   ? $title   = $this->request->post['alert_title']   : $title = "";

    if(isset($this->request->post['order_id'])) {
      $extraParams = "order_id=" . $this->request->post['order_id'];
      $this->model_sale_alert->createOrderAlert($this->request->post['order_id'],$this->db->escape($message),$this->request->post['alert_severity'], $this->db->escape($title), $user_id);
    }

    if(isset($this->request->post['customer_id'])) {
      $extraParams = "customer_id=" . $this->request->post['customer_id'];
      $this->model_sale_alert->createCustomerAlert($this->request->post['customer_id'],$this->db->escape($message),$this->request->post['alert_severity'], $this->db->escape($title), $user_id);
    }

//    header("Location: index.php?route=" . $this->request->post['returnURL'] . "&token=" . $this->request->get['token'] . "&" . $extraParams);
  }

}

?>
