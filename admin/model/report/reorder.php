<?php

Class ModelReportReorder extends Model {

  public function getReorderReport($hasYear = '', $hasEmail = 1, $hasFax = '', $quantity = '') {
 
  $Q = "SELECT 
          DISTINCT " . DB_PREFIX . "`order`.customer_id,
          " . DB_PREFIX . "`order`.order_id

        FROM

          " . DB_PREFIX . "`order`
          " . DB_PREFIX . "`order_product`

        WHERE

          " . DB_PREFIX . "`order_product`.model LIKE '%';


        ";



  } // end getReorderReport

} // end class

?>


