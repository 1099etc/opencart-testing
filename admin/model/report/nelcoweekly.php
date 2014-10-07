<?php

Class ModelReportNelcoweekly extends Model {

  public function getNelcoWeekly($startDate = '', $endDate = '') {

    if($startDate == '') { $startDate = date('Y-m-d', strtotime("-1 week")); }
    if($endDate == '') { $endDate = date('Y-m-d'); }

    $result = $this->db->query("SELECT " . DB_PREFIX . "serials_order.`key`, " . DB_PREFIX . "serials_order.featurecode, year(str_to_date((select " . DB_PREFIX . "`order`.date_added from " . DB_PREFIX . "`order` where " . DB_PREFIX . "`order`.customer_id = " . DB_PREFIX . "customer.customer_id ORDER BY " . DB_PREFIX . "`order`.date_added ASC LIMIT 1), '%Y-%m-%d')) as firstYear, " . DB_PREFIX . "customer.lastname, " . DB_PREFIX . "customer.firstname, " . DB_PREFIX . "`order`.payment_company, concat( " . DB_PREFIX . "`order`.payment_address_1, ' ', " . DB_PREFIX . "`order`.payment_address_2) as payment_address, " . DB_PREFIX . "`order`.payment_city, " . DB_PREFIX . "`order`.payment_zone, " . DB_PREFIX . "`order`.payment_postcode, " . DB_PREFIX . "`order`.telephone, '' as telephone2, " . DB_PREFIX . "`order`.fax, " . DB_PREFIX . "`order`.email, " . DB_PREFIX . "`order`.date_added FROM " . DB_PREFIX . "customer, " . DB_PREFIX . "serials_order, " . DB_PREFIX . "`order` WHERE " . DB_PREFIX . "customer.private = 0 and " . DB_PREFIX . "customer.customer_id = " . DB_PREFIX . "`order`.customer_id and " . DB_PREFIX . "serials_order.oid = " . DB_PREFIX . "`order`.order_id and " . DB_PREFIX . "`order`.date_added >= '" . $startDate . "' and " . DB_PREFIX . "`order`.date_added <= '" . $endDate . "'");

    return $result;

  }

} // end class

?>


