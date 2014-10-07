<?php
class ModelCatalogSerial extends Model {
    /**
     * ModelCatalogSerial::tableCheck()
     * Creates the serial key tables if they don't exist
     * @return void
     */
    public function tableCheck() {

        // Create `serials` table
        $query = sprintf('
            CREATE TABLE IF NOT EXISTS `%sserials` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(128) NOT NULL,
            `pid` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin',
            DB_PREFIX
        );
        $this->db->query($query);

        // Create `serials_order` table
        $query = sprintf('
            CREATE TABLE IF NOT EXISTS `%sserials_order` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(128) NOT NULL,
            `oid` int(11) NOT NULL,
            `pid` int(11) NOT NULL,
            `featurecode` varchar(3),
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin',
            DB_PREFIX
        );
        $this->db->query($query);
    }

    /**
     * ModelCatalogSerial::getSerialList()
     * Gets a list of serial key product names and the number of keys it has
     * @return array
     */
    public function getSerialList() {
        $query = sprintf('
            SELECT
                `pd`.`product_id` as `id`,
                COUNT(`pd`.`name`) AS `count`,
                `pd`.`name`
            FROM
                `%1$sserials` `s`
            LEFT JOIN
                `%1$sproduct_description` `pd` ON `pd`.`product_id` = `s`.`pid`
            WHERE
            	pd.language_id = \'%2$s\'
            GROUP BY
                `s`.`pid`
            ORDER BY
                `count`
            ASC',
            DB_PREFIX,
            (int) $this->config->get('config_language_id')
        );
        $result = $this->db->query($query);
        return $result->rows;
    }

    public function getSerials($product_id) {
        $query = sprintf('
            SELECT
                `s`.*
            FROM
                `%1$sserials` `s`
            WHERE
                `s`.`pid` = %2$s
            ORDER BY
                `s`.`id`',
            DB_PREFIX,
            (int) $product_id
        );
        $result = $this->db->query($query);
        return $result->rows;
    }

    public function deleteSerials($keys) {
    	foreach($keys as $k => $key) {
    		$keys[$k] = (int) $key;
    	}
    	
        $keystr = implode(',', $keys);
        $query = sprintf('
            DELETE FROM
                `%1$sserials`
            WHERE
                `pid` IN (%2$s)
            ',
            DB_PREFIX,
            $keystr
        );
        $this->db->query($query);
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

    public function addSerials($serials, $product_id){
        $values = array();
        $product_id = (int) $product_id;
        
        foreach($serials as $s) {
        	$s = $this->db->escape($s);
            $values[] = "('$s', '$product_id')";
        }
        
        $vals = implode(',', $values);
        
        $query = sprintf('
        INSERT INTO
            `%1$sserials` (`key`, `pid`)
        VALUES
            %2$s
        ',
        DB_PREFIX,
        $vals);
        
        $this->db->query($query);

    }

    public function getSerialsByProduct($order_product_id) {
        $query = sprintf('
            SELECT
            	`so`.`id`,
              `so`.key
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
                $res[$row['id']] = $row['key'];
            }
            return $res;
        }
        return false;

    }

    public function getFeatureCodesByProduct($order_product_id) {
        $query = sprintf('
            SELECT
              `so`.`id`,
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
                $res[$row['id']] = $row['featurecode'];
            }
            return $res;
        }
        return false;

    }

    // This function should return all the serial numbers for an order
    public function viewSerialsByOrder($order_id) {
      $query = sprintf('
        SELECT
          `so`.`id`,
          concat(`so`.`key`, `so`.`featurecode`) as `key`
        FROM
          `%1$sserials_order` `so`
        WHERE
          `so`.`oid` = %2$s
        ORDER BY
          `so`.`id`',
        DB_PREFIX,
        (int) $order_id
      );
      $result = $this->db->query($query);
      if($result->num_rows) {
        $res = array();
        foreach($result->rows as $row) {
          $res[$row['id']] = $row['key'];
        }
        return $res;
      }
      return false;
    }

    public function injectHistoryNote($order_id,$comment) {
      $comment = $this->user->getUserName() . " (ID: " . $this->user->getId() . ") " . $comment;
      $today = date("Y-m-d H:i:s");
      $query  = "INSERT INTO " . DB_PREFIX . "order_history (order_id, order_status_id, comment, date_added) VALUES";
      $query .= "(" . $order_id . ", (SELECT " . DB_PREFIX . "`order`.order_status_id FROM " . DB_PREFIX . "`order` where " . DB_PREFIX . "`order`.order_id=" . $order_id . "),";
      $query .= "'" . mysql_real_escape_string($comment) . "',";
      $query .= "NOW())";
      $result = $this->db->query($query);
      return true;
    }

    public function restoreOrderSerials($order_id) {
    	$result = $this->db->query("SELECT `id` FROM `" . DB_PREFIX . "serials_order` WHERE `oid` = '" . (int) $order_id . "' ORDER BY `id` ASC");
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$this->removeOrderSerial($row['id'], $order_id);
    		}
    	}
    }
    
    public function restoreSerialKey($serial_id, $order_id) {
    	if($this->config->get('config_serial_restore_deleted') == 1) {
    		$sql = sprintf("
SELECT
	`so`.`key`,
	`op`.`product_id`
FROM
	`%1\$sserials_order` `so`
LEFT JOIN
	`%1\$sorder_product` `op`
ON
	`so`.`pid` = `op`.`order_product_id`
WHERE
	`so`.`id` = '%2\$s'
AND
	`so`.`oid` = '%3\$s'",
		DB_PREFIX,
		(int) $serial_id,
		(int) $order_id);
    		$result = $this->db->query($sql);
    		if($result->num_rows == 1) {
    			$this->addSerials(array($result->row['key']), $result->row['product_id']);
    			return true;
    		}
    	}
    	return false;
    }

    public function removeOrderSerial($serial_id, $order_id) {
       	$this->restoreSerialKey($serial_id, $order_id);
    	  $serialString = $this->db->query("SELECT `key`,featurecode from " . DB_PREFIX . "serials_order where id=" . $serial_id);
        $query = sprintf('
            DELETE FROM
                `%1$sserials_order`
            WHERE
                `id` = %2$s
		        AND
                `oid` = %3$s',
            DB_PREFIX,
            (int) $serial_id,
            (int) $order_id
        );

        $result = $this->db->query($query);
    
        if($serialString->num_rows) {
          foreach($serialString->rows as $row) {
            $this->injectHistoryNote($order_id, "REMOVED: " . $row['key'] . "" . $row['featurecode']);
          }
        }

        return $this->db->countAffected() ? true : false;

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
 
    public function deleteSerialsByKey($keys) {
      foreach($keys as $k => $key) {
        $keys[$k] = "\"" . $key . "\"";
      }

        $keystr = implode(',', $keys);
        $query = sprintf('
            DELETE FROM
                `%1$sserials`
            WHERE
                `key` IN (%2$s) 
            ',
            DB_PREFIX,
            $keystr
        );
        $this->db->query($query);
    }

    public function addOrderSerial($serial, $order_id, $order_product_id) {
      $this->deleteSerialsByKey(array($serial));

      $FC = $this->generateFeatureCode($order_product_id);

    	$query = sprintf('
	  		INSERT INTO
  				`%1$sserials_order`
				  (`key`, `oid`, `pid`, `featurecode`)
			  VALUES
		  		(\'%2$s\', %3$s, %4$s, "%5$s")',
	  		DB_PREFIX,
  			$this->db->escape(trim($serial)),
			  (int) $order_id,
		  	(int) $order_product_id,
        $FC
  		);
		  $result = $this->db->query($query);
      
      $this->injectHistoryNote($order_id, "ADDED: " . $serial . "" . $FC);

  		return (bool) $result;
    }

    public function updateOrderSerial($serial_id, $serial) {
        $query = sprintf('
            UPDATE
                `%1$sserials_order`
            SET
            	`key` = \'%3$s\'
            WHERE
                `id` = %2$s',
            DB_PREFIX,
            (int) $serial_id,
            $this->db->escape($serial)
        );

        $result = $this->db->query($query);

        return $this->db->countAffected() ? true : false;

    }

    public function updateSerial($serial_id, $serial) {
        $query = sprintf('
            UPDATE
                `%1$sserials`
            SET
            	`key` = \'%3$s\'
            WHERE
                `id` = %2$s',
            DB_PREFIX,
            (int) $serial_id,
            $this->db->escape($serial)
        );

        $result = $this->db->query($query);

        return $this->db->countAffected() ? true : false;

    }
    
    public function duplicateSerials($serials, $pid) {
    	$pid = (int) $pid;
    	if(!is_array($serials) || empty($serials) || $pid < 1) return false;
    	
    	$dupes = array();
    	
    	foreach($serials as $k => $serial) {
    		$serials[$k] = $this->db->escape($serial);
    	}
    	
    	$serials_list = strtolower(implode("','", $serials));
    	
    	$result = $this->db->query("SELECT `key` FROM `" . DB_PREFIX . "serials` WHERE LOWER(`key`) IN ('$serials_list') AND `pid` = '$pid'");
    	
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$dupes[] = $row['key'];
    		}
    	}
    	
    	$result = $this->db->query("SELECT `so`.`key` AS `key` FROM `" . DB_PREFIX . "serials_order` `so` LEFT JOIN `" . DB_PREFIX . "order_product` `op` ON `so`.`pid` = `op`.`order_product_id` WHERE LOWER(`key`) IN ('$serials_list') AND `op`.`product_id` = '$pid'");
    	
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$dupes[] = $row['key'];
    		}
    	}
    	
    	return empty($dupes) ? false : array_unique($dupes);
    }
    
    public function getOrderSerialsTotal() {
    	$result = $this->db->query("SELECT `op`.`product_id` AS `product_id`, COUNT(`op`.`product_id`) as `cnt` FROM `" . DB_PREFIX . "serials_order` `so` LEFT JOIN `" . DB_PREFIX . "order_product` `op` ON `so`.`pid` = `op`.`order_product_id` GROUP BY `op`.`product_id`");
    	
    	$results = array();
    	if($result->num_rows) {
    		foreach($result->rows as $row) {
    			$results[$row['product_id']] = $row['cnt'];
    		}
    	}
    	
    	return $results;
    }
    
    public function findOrderSerials($serial_key) {
    	$result = $this->db->query("SELECT `oid` FROM `" . DB_PREFIX . "serials_order` WHERE LOWER(`key`) LIKE '%" . strtolower($this->db->escape($serial_key)) . "%' ORDER BY `oid` DESC LIMIT 1");
    	
    	return $result->num_rows ? $result->row['oid'] : false;
    }
    
    public function getProducts() {
    	$result = $this->db->query("SELECT `product_id`, `name` FROM `" . DB_PREFIX . "product_description` WHERE `language_id` = '" . (int) $this->config->get('config_language_id') . "' ORDER BY `name`");
    	return $result->rows;
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

?>
