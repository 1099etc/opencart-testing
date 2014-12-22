<?php
class ModelReportReorder extends Model {
	public function getOrders($data = array()) {
		$sql = "SELECT MIN(tmp.date_added) AS date_start, MAX(tmp.date_added) AS date_end, COUNT(tmp.order_id) AS `orders`, SUM(tmp.products) AS products, SUM(tmp.tax) AS tax, SUM(tmp.total) AS total FROM (SELECT o.order_id, (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id) AS products, (SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id) AS tax, o.total, o.date_added FROM `" . DB_PREFIX . "order` o"; 

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " GROUP BY o.order_id) tmp";
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY DAY(tmp.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY WEEK(tmp.date_added)";
				break;	
			case 'month':
				$sql .= " GROUP BY MONTH(tmp.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(tmp.date_added)";
				break;									
		}
		
		$sql .= " ORDER BY tmp.date_added DESC";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	
	
	public function getOrderTotals($data = array()) {
    $sql = "select c.customer_id, o.order_id, op.order_product_id, '' as serial, c.fax, c.telephone, c.email, concat(c.firstname, ' ', c.lastname) as cname, concat( a.firstname, ' ', a.lastname) as name, a.company, concat(a.address_1, ' ', a.address_2) as addr,
    concat(a.city, ', ',  z.name, ' ', a.postcode) as csz, op.quantity, '' as price

    from " . DB_PREFIX . "customer as c, " . DB_PREFIX . "address as a, " . DB_PREFIX . "zone as z, 
    `" . DB_PREFIX . "order` as o, " . DB_PREFIX . "order_product as op, " . DB_PREFIX . "product as p

    where 
    c.address_id = a.address_id
    and a.zone_id = z.zone_id
    and c.customer_id = o.customer_id
    and o.order_id = op.order_id
    and op.model = '".$data['filter_ordered_year']."-1099-FormsFiler'
    and op.product_id = p.product_id
    
    ";
				
		if (isset($data['filter_taxcalc_hide']) && $data['filter_taxcalc_hide'] == 'Y') {
			$sql .= " and c.referral_id not in (28,23) ";
		}
		
		if (isset($data['filter_pr_hide']) && $data['filter_pr_hide'] == 'Y') {
			$sql .= " and a.zone_id not in (3664,4033) ";
		}


		if (isset($data['filter_fax']) && $data['filter_fax'] == 'Y') {
			$sql .= " and trim(c.fax) <> ''";
		}
    elseif (isset($data['filter_fax']) && $data['filter_fax'] == 'N') 
    {
      $sql .= " and trim(c.fax) = ''";
    }
		
    if (isset($data['filter_email']) && $data['filter_email'] == 'Y') {
			$sql .= " and trim(c.email) <> '' and c.email not like '%@1099-etc.com'";
		}
    elseif (isset($data['filter_email']) && $data['filter_email'] == 'N') 
    {
      $sql .= " and (trim(c.email) = '' or c.email like '%@1099-etc.com')";
    }

    if (isset($data['filter_multiquantity']) && $data['filter_multiquantity'] == 'Y')
    {
      $sql .= " and op.quantity > 1";
    }
    elseif (isset($data['filter_multiquantity']) && $data['filter_multiquantity'] == 'N')
    {
      $sql .= " and op.quantity = 1";
    }
    else
    {
      $sql .= " and op.quantity > 0";
    }
		
		$sql .= " ";
		//exit($sql);
		$query = $this->db->query($sql);
    
    $reorders = array();
    
    if(isset($data['filter_didnt_order_year']) && is_numeric($data['filter_didnt_order_year']))
    {
    $soft_qty = 0;
    $sql = "select v.price from product p, product_option_value v where p.model = '".$data['filter_didnt_order_year']."-1099-FormsFiler' and p.product_id = v.product_id and v.option_id = 18 and v.option_value_id = 60";
    $query_price = $this->db->query($sql);
    $soft_price = $query_price->row['price'];
          
    $ams_qty = 0;
    $sql = "select v.price from product p, product_option_value v where p.model = '".$data['filter_didnt_order_year']."-1099-FormsFiler' and p.product_id = v.product_id and v.option_id = 18 and v.option_value_id = 59";
    $query_price = $this->db->query($sql);
    $ams_price = $query_price->row['price'];
          
    $forms_qty = 0;
    $sql = "select v.price from product p, product_option_value v where p.model = '".$data['filter_didnt_order_year']."-1099-FormsFiler' and p.product_id = v.product_id and v.option_id = 19 and v.option_value_id = 63";
    $query_price = $this->db->query($sql);
    $forms_price = $query_price->row['price'];
          
    $efile_qty = 0;
    $sql = "select v.price from product p, product_option_value v where p.model = '".$data['filter_didnt_order_year']."-1099-FormsFiler' and p.product_id = v.product_id and v.option_id = 17 and v.option_value_id = 65";
    $query_price = $this->db->query($sql);
    $efile_price = $query_price->row['price'];
    
    $query_price = null;

    $sql = "select price from product where model = '".$data['filter_didnt_order_year']."-1099-FormsFiler'";
    $price_query = $this->db->query($sql);
    $price = $price_query->row['price'];
    
    $price_query = null;
    }
    foreach($query->rows as $row)
    {
      $sql = "select count(1) as didnt from `order` as o, order_product as op 
              where 
              o.order_id = op.order_id 
              and o.customer_id = ".$row['customer_id']."
              and op.model = '".$data['filter_didnt_order_year']."-1099-FormsFiler'";
      $query_count = $this->db->query($sql);
      $didnt_order = $query_count->row['didnt'];
      
      $query_count = null;

      if($didnt_order < 1)
      {
        $skip = false;
       // if(isset($data['filter_software_generated_forms']) || isset($data['filter_ams_payroll']) || isset($data['filter_efile_direct']) || isset($data['filter_forms_filer_plus']))
        //{
          $sql = "select name, value from order_option as oo where 
          oo.order_id = ".$row['order_id']."
          and oo.order_product_id = ".$row['order_product_id']."";
          
          $options_query = $this->db->query($sql);
          $options = $options_query->rows;
          
          $options_query = null;
        //}
        //else
        //{

          $soft_qty = 0;
          $ams_qty = 0;
          $forms_qty = 0;
          $efile_qty = 0;
          foreach ($options as $opt)
          {
            switch($opt['value'])
            {
              case 'AMS Payroll and Software Generated Forms':
                $soft_qty = $row['quantity'];
                $ams_qty = $row['quantity'];
                break;
              case 'Software Generated Forms':
                $soft_qty = $row['quantity'];
                break;
              case 'E-File Direct':
                $efile_qty = $row['quantity'];
                break;
              case 'AMS Payroll':
                $ams_qty = $row['quantity'];
                break;
              case 'Forms Filer Plus':
                $forms_qty = $row['quantity'];
                break;
            }
          }
        //}
        
        $sql = "select `key` from serials_order where oid = ".$row['order_id']." and pid = ".$row['order_product_id']."";
        $serial_query = $this->db->query($sql);
        $serial = $serial_query->row['key'];
        
        $serial_query = null;
        
        if(!$skip)
        {
          $reorders[] = array('serial'=>$serial,
                        'xfax'=>'',
                        'fax'=>$row['fax'],
                        'phone'=>$row['telephone'],
                        'phone2'=>'',
                        'email'=>$row['email'],
                        'cname'=>$row['cname'],
                        'name'=>$row['name'],
                        'company'=>$row['company'],
                        'addr'=>$row['addr'],
                        'csz'=>$row['csz'],
                        'qty1'=>$row['quantity'],
                        'ext1'=>$price*$row['quantity'],
                        'qty2'=>$soft_qty,
                        'ext2'=>$soft_price*$soft_qty,
                        'qty3'=>$ams_qty,
                        'ext3'=>$ams_price*$ams_qty,
                        'qty4'=>$efile_qty,
                        'ext4'=>$efile_price*$efile_qty,
                        'qty5'=>$forms_qty,
                        'ext5'=>$forms_price*$forms_qty,
                        'subtotl'=>(($price*$row['quantity'])+($soft_price*$soft_qty)+($ams_price*$ams_qty)+($efile_price*$efile_qty)+($forms_price*$forms_qty))
                        );
        }
      }
      
    }
    $query = null;

		return $reorders;
	}	
	
}
?>
