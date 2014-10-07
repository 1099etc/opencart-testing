<?php

Class ModelReportUpsworldship extends Model {

  public function getUPSOrders($startDate = '', $endDate = '', $save = 0) {
    if($startDate == '') { $startDate = date('Y-m-d', strtotime("-1 week")); }
    if($endDate == '') { $endDate = date('Y-m-d 24:59:59'); }

    $newOrders = $this->db->query("SELECT " . DB_PREFIX . "`order`.order_id as order_id, concat(" . DB_PREFIX . "serials_order.`key`, " . DB_PREFIX . "serials_order.featurecode) AS SERIAL, 'N' as COD, '0.00' as CODAMT, 'N' as SATDEL, concat(" . DB_PREFIX . "`order`.firstname, ' ', " . DB_PREFIX . "`order`.lastname) as NAME, " . DB_PREFIX . "`order`.shipping_company as FIRM, concat(" . DB_PREFIX . "`order`.shipping_address_1,' '," . DB_PREFIX . "`order`.shipping_address_2) as ADDRESS, " . DB_PREFIX . "`order`.shipping_city as CITY, " . DB_PREFIX . "`zone`.code as STATE, " . DB_PREFIX . "`order`.shipping_postcode as ZIP, " . DB_PREFIX . "`order`.telephone as PHONE, 'Y' as NOTIFY1_OPTION, 'Email' as NOTIFY1_TYPE, " . DB_PREFIX . "`order`.email as EMAIL, 'Next Day Air' as SERVICE, 'UPS Letter' as PKGTYPE, 'Prepaid' as BILLOPT, 'Advanced Micro Solutions' as FROM_COMPANY FROM " . DB_PREFIX . "`order`, " . DB_PREFIX . "zone, " . DB_PREFIX . "serials_order WHERE lower(" . DB_PREFIX . "`order`.shipping_method) LIKE lower('%overnight%') and " . DB_PREFIX . "`order`.shipping_zone_id = " . DB_PREFIX . "`zone`.zone_id and " . DB_PREFIX . "`order`.order_id = " . DB_PREFIX . "serials_order.oid and " . DB_PREFIX . "`order`.date_added >= '" . $startDate . "' and " . DB_PREFIX . "`order`.date_added <= '" . $endDate ."' union all SELECT " . DB_PREFIX . "`order`.order_id as order_id, '' AS SERIAL, 'N' as COD, '0.00' as CODAMT, 'N' as SATDEL, concat(" . DB_PREFIX . "`order`.firstname, ' ', " . DB_PREFIX . "`order`.lastname) as NAME, " . DB_PREFIX . "`order`.shipping_company as FIRM, concat(" . DB_PREFIX . "`order`.shipping_address_1,' '," . DB_PREFIX . "`order`.shipping_address_2) as ADDRESS, " . DB_PREFIX . "`order`.shipping_city as CITY, " . DB_PREFIX . "`zone`.code as STATE, " . DB_PREFIX . "`order`.shipping_postcode as ZIP, " . DB_PREFIX . "`order`.telephone as PHONE, 'Y' as NOTIFY1_OPTION, 'Email' as NOTIFY1_TYPE, " . DB_PREFIX . "`order`.email as EMAIL, 'Next Day Air' as SERVICE, 'UPS Letter' as PKGTYPE, 'Prepaid' as BILLOPT, 'Advanced Micro Solutions' as FROM_COMPANY FROM " . DB_PREFIX . "`order`, " . DB_PREFIX . "zone WHERE lower(" . DB_PREFIX . "`order`.shipping_method) LIKE lower('%overnight%') and " . DB_PREFIX . "`order`.shipping_zone_id = " . DB_PREFIX . "`zone`.zone_id  and " . DB_PREFIX . "`order`.date_added >= '" . $startDate . "' and " . DB_PREFIX . "`order`.date_added <= '" . $endDate ."'");

    // set up a few variables for later.
    $oids = '';
    $x = $newOrders->num_rows; // Get a count of orders returned.
    $i = 0;
    $returnArray = array();

    // Make a comma separated list of the order_id's being used in the report.
    foreach($newOrders->rows as $order) {
      $oids .= $order['order_id'];
      $i = $i + 1;
      if($i < $x) { $oids .= ","; }

      // setup the return array
      $returnArray[] = array(
        'SN'         => $order['SERIAL'],
        'COD'            => $order['COD'],
        'CODAMT'         => $order['CODAMT'],
        'SATDEL'         => $order['SATDEL'],
        'NAME'           => '"' . $order['NAME'] . '"',
        'FIRM'           => '"' . $order['FIRM'] . '"',
        'ADDRESS'        => '"' . $order['ADDRESS'] . '"',
        'CITY'           => '"' . $order['CITY'] . '"',
        'STATE'          => '"' . $order['STATE'] . '"',
        'ZIP'            => '"' . $order['ZIP'] . '"',
        'PHONE'          => '"' . $order['PHONE'] . '"',
        'NOTIFY1_OPTION' => '"' . $order['NOTIFY1_OPTION'] . '"',
        'NOTIFY1_TYPE'   => $order['NOTIFY1_TYPE'],
        'EMAIL'          => $order['EMAIL'],
        'SERVICE'        => $order['SERVICE'],
        'PKGTYPE'        => $order['PKGTYPE'],
        'BILLOPT'        => $order['BILLOPT'],
        'FROM_COMPANY'   => '"' . $order['FROM_COMPANY']. '"'
      );

    } // end foreach
  
    if($oids != '' && $save > 0) {
      $oids = trim($oids, ",");
      $this->db->query("INSERT INTO " . DB_PREFIX . "ups_worldship (startDate, endDate, order_ids) VALUES ('" . $startDate . "', '" . $endDate . "', '" . $oids . "')");
    }

    return $returnArray;
  }

  public function deleteReport($ups_worldship_id) {
    $this->db->query("DELETE FROM " . DB_PREFIX . "ups_worldship WHERE ups_worldship_id = '" . $ups_worldship_id . "'");
  }

  public function listPreviousReports() {
    $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "ups_worldship ORDER BY " . DB_PREFIX . "ups_worldship.ups_worldship_id DESC");
    return $result;    
  }

  public function getLastStartDate() {
    $result = $this->db->query("SELECT startDate from " . DB_PREFIX . "ups_worldship ORDER BY ups_worldship_id DESC LIMIT 1");
    if(isset($result->row['startDate'])) {
      return $result->row['startDate'];
    }
    else {
      return 0;
    }
  }
 
  public function getLastEndDate() {
    $result = $this->db->query("SELECT endDate from " . DB_PREFIX . "ups_worldship ORDER BY ups_worldship_id DESC LIMIT 1");
    if(isset($result->row['endDate'])) {
      return $result->row['endDate'];
    }
    else {
      return 0;
    }
  }

} // end class

?>
