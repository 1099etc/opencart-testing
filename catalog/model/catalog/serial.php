<?php
class ModelCatalogSerial extends Model {
    
    public function addOrderSerials($product_id, $order_id, $order_product_id, $quantity){
        
        // Get serials for product
        $serials = $this->getSerial($product_id, $quantity);
        if(!$serials) return false;
        if(!count($serials)) return false;
        
        $values = array();
        $todelete = array();
        
        $order_id = (int) $order_id;
        $order_product_id = (int) $order_product_id;
        
        foreach($serials as $s) {
        	$key = $this->db->escape($s['key']);
            $featurecode = $this->generateFeatureCode($order_product_id);
            $values[] = "('$order_id', '$key', '$order_product_id', '$featurecode')";
            $todelete[] = (int) $s['id'];
        }
        $vals = implode(',', $values);
        $query = sprintf('
        INSERT INTO
            `%1$sserials_order` (`oid`, `key`, `pid`,`featurecode`)
        VALUES
            %2$s
        ',
        DB_PREFIX,
        $vals);
        $this->deleteSerialsByID($todelete);
        $this->db->query($query);
        
        if($this->config->get('config_serial_email_admin') == 1) {
			$count = $this->getTotalSerials($product_id);
			if($count <= $this->config->get('config_serial_threshold')) {
				$this->load->model('catalog/product');
				
				$product = $this->model_catalog_product->getProduct($product_id);
				
				if(!$product) {
					return;
				}
				
				$this->load->language('product/serial');
				$text = $this->language->get('text_low_serial');
				$subject = $this->language->get('text_subject');
				
				$text = str_replace('{count}', $count, $text);
				$text = str_replace('{name}', $product['name'], $text);
				
				$mail = new Mail(); 
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');			
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
				$mail->send();
			}
        }
    }
    
    public function deleteSerialsByID($keys) {
    	foreach($keys as $k => $key) {
    		$keys[$k] = (int) $key;
    	}
    	
        $keystr = implode(',', $keys);
        $query = sprintf('
            DELETE FROM
                `%1$sserials`
            WHERE
                `id` IN (%2$s)
            ',
            DB_PREFIX,
            $keystr
        );
        $this->db->query($query);
    }
    
    /**
     * ModelCatalogSerial::getSerial()
     * Gets the specified number of serial keys for a product
     * @param integer $product_id
     * @param integer $keys
     * @return mixed
     */
    public function getSerial($product_id, $keys = 1) {
        $query = sprintf('
            SELECT
                `s`.*
            FROM
                `%1$sserials` `s`
            WHERE
                `s`.`pid` = %2$s
            ORDER BY
                `s`.`id`
            LIMIT %3$s',
            DB_PREFIX,
            (int) $product_id,
            (int) $keys
        );
        $result = $this->db->query($query);
        if($result->num_rows) {
            return $result->rows;
        }
        return false;        
    }
    
    public function getOrderSerials($order_download_id) {
        $query = sprintf('
            SELECT
                `so`.`key`
            FROM
                `%1$sserials_order` `so`
            LEFT JOIN
                `%1$sorder_download` `o`
            ON
                `o`.`order_product_id` = `so`.`pid`
            WHERE
                `o`.`order_download_id` = %2$s
            ORDER BY
                `so`.`id`',
            DB_PREFIX,
            (int) $order_download_id
        );
        $result = $this->db->query($query);
        if($result->num_rows) {
            $res = array();
            foreach($result->rows as $row) {
                $res[] = $row['key'];
            }
            return $res;
        }
        return false;

    }
    
    public function getSerialsByProduct($order_product_id) {
        $query = sprintf('
            SELECT
                `so`.`key`
            FROM
                `%1$sserials_order` `so`
            WHERE
                `so`.`pid` = %2$s
            ORDER BY
                `so`.`id`',
            DB_PREFIX,
            (int) $order_product_id
        );
        $result = $this->db->query($query);
        if($result->num_rows) {
            $res = array();
            foreach($result->rows as $row) {
                $res[] = $row['key'];
            }
            return $res;
        }
        return false;

    }

    public function getFeatureCodesByProduct($order_product_id) {
        $query = sprintf('
            SELECT
                `so`.`featurecode`
            FROM
                `%1$sserials_order` `so`
            WHERE
                `so`.`pid` = %2$s
            ORDER BY
                `so`.`id`',
            DB_PREFIX,
            (int) $order_product_id
        );
        $result = $this->db->query($query);
        if($result->num_rows) {
            $res = array();
            foreach($result->rows as $row) {
                $res[] = $row['featurecode'];
            }
            return $res;
        }
        return false;

    }    

    public function getTotalSerials($product_id) {
    	$query = sprintf('
            SELECT
                COUNT(`pid`) as `ttl`
            FROM
                `%1$sserials`
            WHERE
                `pid` = %2$s
            GROUP BY
                `pid`',
            DB_PREFIX,
            (int) $product_id
        );
        
        $result = $this->db->query($query);
        return empty($result->row['ttl']) ? 0 : $result->row['ttl'];
    }

        // This should generate the featurecodes for a single serial number based on an orders product id
    public function generateFeatureCode($order_product_id) {
      $query = sprintf('select option_value.featurecode as FC from order_option, product_option_value, option_value, `option`
                       where order_option.product_option_value_id = product_option_value.product_option_value_id
                       and product_option_value.option_value_id = option_value.option_value_id
                       and option_value.option_id = `option`.option_id
                       and order_product_id = %1$s order by option.featurecodeOrder',
                       (int)$order_product_id
                     );
      $result = $this->db->query($query);
      $FC = '';
      if($result->num_rows) {
        foreach($result->rows as $row) {
          $FC .= $row['FC'];
        }
      }
      return trim($FC);
    }


    // Return true if serial is valid, false if it is not.
    public function validSerial($serialNumber) {
      $json = array();

      // First we need to break down the serial. The first 5 characters are the serial number, the last 3 are the featurecodes
      if(strlen($serialNumber) != 8) {
        $json['success'] = 'false';
      }

      // The first character must be a number.
      if(!is_numeric(substr($serialNumber, 0, 1))) {
        $json['success'] = 'false';
      }
     
      // Submitted serial number cannot contain anything but letters and numbers.
      if(!preg_match('/[^A-Za-z0-9]/',$serialNumber)) {
        $json['success'] = 'false';
      }

      // The last 3 characters must be letters - featurecodes
      if(!preg_match('/[^A-Za-z]/', substr($serialNumber, -3, 3))) {
        $json['success'] = 'false';
      }

      // Third from the last character must be M or P
      if(!preg_match('/[^MPmp]/', substr($serialNumber, -3, 0))) { 
        $json['success'] = 'false';
      }

      // Second to last character must be A, B, L, or X
      if(!preg_match('/[^ABLXablx]/', substr($serialNumber, -2, 0))) {
        $json['success'] = 'false';
      }
      
      // Last character must be F or X
      if(!preg_match('/[^FXfx]/', substr($serialNumber, -1, 0))) {
        $json['success'] = 'false';
      }
      
      $json['success'] = 'true';
      $this->response->setOutput(json_encode($json));
    }

    public function validSerialNOJSON($serialNumber) {
      $X = 'true';

      // First we need to break down the serial. The first 5 characters are the serial number, the last 3 are the featurecodes
      if(strlen($serialNumber) != 8) {
        $X = 'Error R01 - You have submitted an invalid serial number.';
      }

      // The first character must be a number.
      if(!is_numeric(substr($serialNumber, 0, 1))) {
        $X = 'Error R02 - You have submitted an invalid serial number.';
      }

      // Submitted serial number cannot contain anything but letters and numbers.
      if(preg_match('/[^A-Za-z0-9]/',$serialNumber)) {
        $X = 'Error R03 - You have submitted an invalid serial number.';
      }

      // The last 3 characters must be letters - featurecodes
      if(preg_match('/[^A-Za-z]/', substr($serialNumber, -3, 3))) {
        $X = 'Error R04 - You have submitted an invalid serial number.';
      }

      // Third from the last character must be M or P
      if(preg_match('/[^MPmp]/', substr($serialNumber, -3, 1))) {
        $X = 'Error R05 - You have submitted an invalid serial number.';
      }

      // Second to last character must be A, B, L, or X
      if(preg_match('/[^ABLXablx]/', substr($serialNumber, -2, 1))) {
        $X = 'Error R06 - You have submitted an invalid serial number.';
      }

      // Last character must be F or X
      if(preg_match('/[^FXfx]/', substr($serialNumber, -1, 1))) {
        $X = 'Error R07 - You have submitted an invalid serial number.';
      }
      
      return $X;
    }
///////////////////////////////////////////////////////////////////
// Keygen Code
//////////////////////////////////////////////////////////////////
    public function change_pol($integer) {
        if(!is_numeric($integer)){ return false; }
        return (0 - $integer);
    }

    public function sn_n($s) {
      return $s;
    }

    public function charx($x, $i) {
      $x = $x + $i;
      if ($x < ord('A')) {
        $x = ord('Z') - (ord('A')-$x) + 1;
      }
      elseif ($x > ORD('Z')) {
        $x = ord('A') + ($x - ord('Z')) - 1;
      }
      $char = chr($x);
      return $char;
    }

    public function funcX($sn, $j, $cxxx, $serial) {
      $j = $j - 1;
      if ($j < 0) {
        $x = $cxxx;
        return $x;
        break;
      }
      $ord_0 = ord("0");
      $ord_1 = ord("$serial[$j]");
      $i = $ord_1 - $ord_0;
      $ij_comp = $i + ($j + 1);
      if($ij_comp % 2) {
        $x = $this->charx(ORD('Z'), $this->change_pol($i));
      }
      else {
        $x = $this->charx(ORD('A'), $i);
      }
      return $x;
    }

    public function calc($num, $cxxx, $serial) {
      $s = "";
      $i = 0;
      $l = 0;
      $s = $num;
      for ($i = 0; $i < 6; $i++) {
        $k = ord($s[$i]) - ord('0');
        $s[$i] = $this->funcX($num, $k, $cxxx, $serial);
      }
      return $s;
    }
    public function generate_keycode($serial) {
      // needs a full serial number to operate
      $int = 0;
      if ($serial[5] == "M") { $int = 1; }
      if ($serial[6] == "L") { $int = $int + 2; }
      if ($serial[6] == "A") { $int = $int + 4; }
      if ($serial[6] == "B") { $int = $int + 8; }
      if ($serial[7] == "F") { $int = $int + 16; }
      $int = $int + ord('A');
      $kint = ord($serial[0]) - ord('8');
      if($kint % 2) {
        // kint is odd
        //  echo "$kint is odd<br>";
        $kint_to_charx = $kint * 2;
        $cxxx = $this->charx($int, $kint_to_charx);
      }
      else {
        // kint is even
        // turn kint negative
        $kint = $this->change_pol($kint);
        $kint_to_charx = $kint * 2;
        $cxxx = $this->charx($int, $kint_to_charx);
        //  echo "$kint is even<br>";
      }
      if ($serial[0] == "0") { $sn = $this->calc('402531', $cxxx, $serial); }
      if ($serial[0] == "1") { $sn = $this->calc("153204", $cxxx, $serial); }
      if ($serial[0] == "2") { $sn = $this->calc("304215", $cxxx, $serial); }
      if ($serial[0] == "3") { $sn = $this->calc("240513", $cxxx, $serial); }
      if ($serial[0] == "4") { $sn = $this->calc("152304", $cxxx, $serial); }
      if ($serial[0] == "5") { $sn = $this->calc("403152", $cxxx, $serial); }
      if ($serial[0] == "6") { $sn = $this->calc("245013", $cxxx, $serial); }
      if ($serial[0] == "7") { $sn = $this->calc("413250", $cxxx, $serial); }
      if ($serial[0] == "8") { $sn = $this->calc("031452", $cxxx, $serial); }
      if ($serial[0] == "9") { $sn = $this->calc("342051", $cxxx, $serial); }
      $sn = str_replace("FUCK", "AUCK", $sn);
      return $sn;
    }
///////////////////////////////////////////////////////////////////
// Keygen Code
//////////////////////////////////////////////////////////////////
    

}
