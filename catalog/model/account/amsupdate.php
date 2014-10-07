<?php
class ModelAccountAmsupdate extends Model {

  public function getDownloads($serial, $featurecodes = '') {
    $featurecodes = trim($featurecodes);

    $query  = "SELECT distinct " . DB_PREFIX . "download.*, " . DB_PREFIX . "download_description.name as name from " . DB_PREFIX . "download, " . DB_PREFIX . "download_description, " . DB_PREFIX . "product_to_download, " . DB_PREFIX . "order_product, " . DB_PREFIX . "serials_order ";
    $query .= "WHERE " . DB_PREFIX . "download.download_id = " . DB_PREFIX . "product_to_download.download_id ";
    $query .= "AND " . DB_PREFIX . "order_product.product_id = " . DB_PREFIX . "product_to_download.product_id ";
    $query .= "AND " . DB_PREFIX . "order_product.order_id = " . DB_PREFIX . "serials_order.oid ";
    $query .= "AND " . DB_PREFIX . "serials_order.`key` = '" . $this->db->escape($serial) . "'";

    $query .= "AND " . DB_PREFIX . "serials_order.`featurecode` = '" . $this->db->escape($featurecodes) . "'";
    
    $query .= "AND " . DB_PREFIX . "download.download_id = " . DB_PREFIX . "download_description.download_id";


    $downloads = $this->db->query($query);

    $files = array();

    if($downloads->num_rows) {
      $i = 0;
      foreach($downloads->rows as $dl) {
        $files[$i]['download_id'] = $dl['download_id'];
        $files[$i]['filename']    = $dl['filename'];
        $files[$i]['name']        = $dl['name'];
        $files[$i]['mask']        = $dl['mask'];
        $files[$i]['date_added']  = $dl['date_added'];
        $files[$i]['notes']       = $dl['notes'];
        $files[$i]['version']     = $dl['version'];
        $i = $i + 1;
      }

    } 
    // Assuming there were any files found, this shouldn't be empty.
    return $files;
  }

  public function getDownload($download_id) {
    $download = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download WHERE download_id='" . $download_id ."' LIMIT 1");
    if($download->num_rows) {
     foreach($download->rows as $dl) {
       return array( 'filename' => $dl['filename'], 'mask' => $dl['mask'] );
     }
    }
    else {
      return false;
    }
  }

  public function getSerialOrderStatusID($serial) {
    $q = $this->db->query("select `" . DB_PREFIX . "order`.order_status_id from  `" . DB_PREFIX . "order`, " . DB_PREFIX . "serials_order where " . DB_PREFIX . "serials_order.oid = `" . DB_PREFIX . "order`.order_id and " . DB_PREFIX . "serials_order.`key`='" . $serial . "'");
    if($q->num_rows) {
      foreach($q->rows as $soid) {
        return $soid['order_status_id'];
      }
    }
    return false;
  }

}
?>
