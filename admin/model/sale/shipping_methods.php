<?php 
class ModelSaleShippingMethods extends Model {
		
	public function getOrderShippingMethods($data) {
      $sql = "select distinct(shipping_method) from " DB_PREFIX ."`order` order by shipping_method asc";
			$query = $this->db->query($sql);
			return $query->rows;
	}
}
?>
