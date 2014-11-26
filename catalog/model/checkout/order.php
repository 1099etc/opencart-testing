<?php
class ModelCheckoutOrder extends Model {	
	public function addOrder($data) {
    if(!isset($data['shipping_description']) || $data['shipping_description'] == 'No Description') { $data['shipping_description'] = ''; }
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_company_id = '" . $this->db->escape($data['payment_company_id']) . "', payment_tax_id = '" . $this->db->escape($data['payment_tax_id']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_description = '" . $this->db->escape($data['shipping_description']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");

		$order_id = $this->db->getLastId();

		foreach ($data['products'] as $product) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");
 
			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}
				
			foreach ($product['download'] as $download) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_download SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', name = '" . $this->db->escape($download['name']) . "', filename = '" . $this->db->escape($download['filename']) . "', mask = '" . $this->db->escape($download['mask']) . "', remaining = '" . (int)($download['remaining'] * $product['quantity']) . "'");
			}	
		}
		
		foreach ($data['vouchers'] as $voucher) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");
		}
			
		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', text = '" . $this->db->escape($total['text']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}	

		return $order_id;
	}

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");
			
		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}			
			
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");
			
			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';				
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}
			
			$this->load->model('localisation/language');
			
			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);
			
			if ($language_info) {
				$language_code = $language_info['code'];
				$language_filename = $language_info['filename'];
				$language_directory = $language_info['directory'];
			} else {
				$language_code = '';
				$language_filename = '';
				$language_directory = '';
			}
		 			
			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],				
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],				
				'payment_company'         => $order_query->row['payment_company'],
				'payment_company_id'      => $order_query->row['payment_company_id'],
				'payment_tax_id'          => $order_query->row['payment_tax_id'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],	
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],				
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],	
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_description'    => $order_query->row['shipping_description'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'language_filename'       => $language_filename,
				'language_directory'      => $language_directory,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'], 
				'user_agent'              => $order_query->row['user_agent'],	
				'accept_language'         => $order_query->row['accept_language'],				
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
        'order_paid'              => $order_query->row['order_paid']
			);
		} else {
			return false;	
		}
	}	

	public function confirm($order_id, $order_status_id, $comment = '', $notify = false) {
    
    $FC[] = array();
 
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['order_status_id']) {
			// Fraud Detection
			if ($this->config->get('config_fraud_detection')) {
				$this->load->model('checkout/fraud');
				
				$risk_score = $this->model_checkout_fraud->getFraudScore($order_info);
				
				if ($risk_score > $this->config->get('config_fraud_score')) {
					$order_status_id = $this->config->get('config_fraud_status_id');
				}
			}

			// Ban IP
			$status = false;
			
			$this->load->model('account/customer');

			if ($order_info['customer_id']) {
				$results = $this->model_account_customer->getIps($order_info['customer_id']);
				
				foreach ($results as $result) {
					if ($this->model_account_customer->isBanIp($result['ip'])) {
						$status = true;
						
						break;
					}
				}
			} else {
				$status = $this->model_account_customer->isBanIp($order_info['ip']);
			}
			
			if ($status) {
				$order_status_id = $this->config->get('config_order_status_id');
			}		
				
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '1', comment = '" . $this->db->escape(($comment && $notify) ? $comment : '') . "', date_added = NOW()");

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
			
			foreach ($order_product_query->rows as $order_product) {


// ADDED BY JOHN
$X_order_id = $order_product['order_id'];
$X_order_product_id = $order_product['order_product_id'];
$X_product_model = $order_product['model'];
$stockStatusID = $this->db->query("select " . DB_PREFIX . "product.stock_status_id from " . DB_PREFIX . "product, " . DB_PREFIX . "order_product where " . DB_PREFIX . "order_product.product_id = " . DB_PREFIX . "product.product_id and " . DB_PREFIX . "order_product.order_id = '" . $X_order_id . "'");
foreach($stockStatusID->rows as $ssID) {
  // Check if the item is preordered
  if($ssID['stock_status_id'] == 8) {
    // Here, we need to check to see if it's already been paid, or if it's a check order
    if($order_status_id == '5') {
      $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '24', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
    }
    else {
      $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '25', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
    }

  }
}

				$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");
				
				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");
			
        // Added by John
        // This section is for processing upgraded orders.
        if(substr($order_product['model'],0,4) === "upg-") {

        // Set some constants 
        $sn = '';
        $fc[] = '';

	        foreach ($order_option_query->rows as $opt) {
            // Snag the submitted serial number with feature codes
            if($opt['name'] == 'Serial Number') {
              $sn = strtoupper($opt['value']);
              $sn = substr($sn, 0, -3); // Removing the old featurecodes.
            }

$Q = "SELECT featurecodeOrder, featurecode FROM `" . DB_PREFIX . "option`, `" . DB_PREFIX . "option_value`, " . DB_PREFIX . "product_option_value WHERE `" . DB_PREFIX . "option_value`.option_value_id = " . DB_PREFIX . "product_option_value.option_value_id AND `" . DB_PREFIX . "option`.option_id = " . DB_PREFIX . "product_option_value.option_id AND " . DB_PREFIX . "product_option_value.product_option_value_id = '" . $opt['product_option_value_id'] . "'";

            $FCO = $this->db->query($Q);
            // Grabs each featurecodeOrder 
            foreach($FCO->rows as $k ) {
              // here we need to get each of the new featurecodes and put them in the order they belong in.
              $fc[$k['featurecodeOrder']] = $k['featurecode'];
            }
          }

          // Next, we need to drop the serial from the database, then re-add it with the new FeatureCodes
          // UPDATE - We are going to leave the original serial number alone and add a copy of the serial with new featurecodes to the new upgrade order.
          $insertQuery = "INSERT INTO " . DB_PREFIX . "serials_order (`key`, `oid`, `pid`, `featurecode`) VALUES ('" . $sn . "', '" . $X_order_id . "', '" . $X_order_product_id . "', \"" . strtoupper($fc[0] . $fc[1] . $fc[2]) . "\")";
          $this->db->query($insertQuery);
          
        } // End if upgrade product.
        elseif(substr($order_product['model'],0,7) === 'repl-cd') {
          // Replacement CD Serial NumbersA
          foreach ($order_option_query->rows as $opt) {
            if($opt['name'] == 'Replacement CD Serial') {
              if(strlen($opt['value']) == 8) {
                $sn = strtoupper(trim($opt['value']));    // get the serial and featurecodes
                $sn = substr($sn, 0, -3);           // Remove the featurecodes
                $fc = substr(trim($opt['value']), -3, 3); // Get the featurecodes
              }
            }
          }
          if(isset($sn) && strlen($sn) == 5 && strlen($fc) == 3) {
            $insertQuery = "INSERT INTO " . DB_PREFIX . "serials_order (`key`, `oid`, `pid`, `featurecode`) VALUES ('" . strtoupper($sn) . "', '" . $X_order_id . "', '" . $X_order_product_id . "', \"" . strtoupper($fc) . "\")";
            $this->db->query($insertQuery);
          }
        }

				foreach ($order_option_query->rows as $option) {
					$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
				}
			}

			
			$this->cache->delete('product');
			
			// Downloads
			$order_download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
			
			// Gift Voucher
			$this->load->model('checkout/voucher');
			
			$order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");
			
			foreach ($order_voucher_query->rows as $order_voucher) {
				$voucher_id = $this->model_checkout_voucher->addVoucher($order_id, $order_voucher);
				
				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher['order_voucher_id'] . "'");
			}			
			
			// Send out any gift voucher mails
			if ($this->config->get('config_complete_status_id') == $order_status_id) {
				$this->model_checkout_voucher->confirm($order_id);
			}
					
			// Order Totals			
			$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
			
			foreach ($order_total_query->rows as $order_total) {
				$this->load->model('total/' . $order_total['code']);
				
				if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
					$this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
				}
			}
			
			// Send out order confirmation mail
			$language = new Language($order_info['language_directory']);
			$language->load($order_info['language_filename']);
			$language->load('mail/order');
		 
			$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
			
			if ($order_status_query->num_rows) {
				$order_status = $order_status_query->row['name'];	
			} else {
				$order_status = '';
			}
			
			$subject = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);
		
			// HTML Mail
			$template = new Template();
			
			$template->data['title'] = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
			
			$template->data['text_greeting'] = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
			$template->data['text_link'] = $language->get('text_new_link');
			$template->data['text_download'] = $language->get('text_new_download');
			$template->data['text_order_detail'] = $language->get('text_new_order_detail');
			$template->data['text_instruction'] = $language->get('text_new_instruction');
			$template->data['text_order_id'] = $language->get('text_new_order_id');
			$template->data['text_date_added'] = $language->get('text_new_date_added');
			$template->data['text_payment_method'] = $language->get('text_new_payment_method');	
			$template->data['text_shipping_method'] = $language->get('text_new_shipping_method');
			$template->data['text_email'] = $language->get('text_new_email');
			$template->data['text_telephone'] = $language->get('text_new_telephone');
			$template->data['text_ip'] = $language->get('text_new_ip');
			$template->data['text_payment_address'] = $language->get('text_new_payment_address');
			$template->data['text_shipping_address'] = $language->get('text_new_shipping_address');
			$template->data['text_product'] = $language->get('text_new_product');
			$template->data['text_model'] = $language->get('text_new_model');
			$template->data['text_quantity'] = $language->get('text_new_quantity');
			$template->data['text_price'] = $language->get('text_new_price');
			$template->data['text_total'] = $language->get('text_new_total');
			$template->data['text_footer'] = $language->get('text_new_footer');
			$template->data['text_powered'] = $language->get('text_new_powered');
			
			$template->data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');		
			$template->data['store_name'] = $order_info['store_name'];
			$template->data['store_url'] = $order_info['store_url'];
			$template->data['customer_id'] = $order_info['customer_id'];
			$template->data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;
			
			if ($order_download_query->num_rows) {
				$template->data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
			} else {
				$template->data['download'] = '';
			}
			
			$template->data['order_id'] = $order_id;
			$template->data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));    	
			$template->data['payment_method'] = $order_info['payment_method'];
			$template->data['shipping_method'] = $order_info['shipping_method'].'<br>'.html_entity_decode($order_info['shipping_description']);
			$template->data['email'] = $order_info['email'];
			$template->data['telephone'] = $order_info['telephone'];
			$template->data['ip'] = $order_info['ip'];
      /*foreach ($this->getSetting('data') as $row_num => $row) {
        if( html_entity_decode($row['title'][$this->session->data['language']], ENT_QUOTES, 'UTF-8') == $order_info['shipping_method'])
        {
          $template->data['shipping_method'] .= '<br>'.html_entity_decode($row['description'], ENT_NOQUOTES, 'UTF-8');
        }
      }*/
			
      if ($order_info['order_paid'] != 0)
      {
       // $template->data['text_download'] = 'You can click on the link below to access your downloadable products:';
        $template->data['text_greeting'] = "Thank you for your interest in ". html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')." products. Your order has been received and processed.";
      }
      else
      {
        //$template->data['text_total'] = 'Amount Due:';
      }
			if ($comment && $notify) {
				$template->data['comment'] = nl2br($comment);
			} else {
				$template->data['comment'] = '';
			}
						
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			
			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);
		
			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']  
			);
		
			$template->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));						
									
			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
			
			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);
		
			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']  
			);
		
			$template->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
			
			// Products
			$template->data['products'] = array();
		  $preorder_message = false;		
			foreach ($order_product_query->rows as $product) {
				$option_data = array();
				if(!$preorder_message)
        {
          $product_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product['product_id'] . "'");

          if(strpos($product['model'],'1099-FormsFiler') && $product_status_query->row['stock_status_id'] == 8)
          {
            $preorder_message = true;
            $template->data['comment'] .= "<br>You have ordered the ".$product['name'].", which will be released by early January.  You will receive an email notification when the software is available.";
          }
        }

				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
				
				foreach ($order_option_query->rows as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
					}
					
					$option_data[] = array(
						'name'  => $option['name'],
						//'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					  'value' => $value
          );					
				}
			  
				$template->data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
				);
			}
	
			// Vouchers
			$template->data['vouchers'] = array();
			
			foreach ($order_voucher_query->rows as $voucher) {
				$template->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}
	
			$template->data['totals'] = $order_total_query->rows;
		  foreach ($template->data['totals'] as $key=>$total) {
        if(($total['title'] == 'Total' && $order_info['order_paid'] == 0) && ($order_info['payment_code'] == 'pending' || $order_info['payment_code'] == 'invoiced' || $order_info['payment_code'] == 'cheque'))
        {  
          $template->data['totals'][$key]['title'] = 'Unpaid Balance ';
        }
        elseif ($total['title'] == 'Total') {
          $template->data['totals'][$key]['title'] = 'Total Paid';
        }
      }
	
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/mail/order.tpl')) {
				$html = $template->fetch($this->config->get('config_template') . '/template/mail/order.tpl');
			} else {
				$html = $template->fetch('default/template/mail/order.tpl');
			}
			
			// Text Mail
			$text  = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
			$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
			$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
			
			if ($comment && $notify) {
				$text .= $language->get('text_new_instruction') . "\n\n";
				$text .= $comment . "\n\n";
			}
			
			// Products
			$text .= $language->get('text_new_products') . "\n";
			
			foreach ($order_product_query->rows as $product) {
				$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
				
				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
				
				foreach ($order_option_query->rows as $option) {
					$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($option['value']) > 20 ? utf8_substr($option['value'], 0, 20) . '..' : $option['value']) . "\n";
				}
			}
			
			foreach ($order_voucher_query->rows as $voucher) {
				$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
			}
						
			$text .= "\n";
			
			$text .= $language->get('text_new_order_total') . "\n";
			
			foreach ($order_total_query->rows as $total) {
        if(strpos($total['title'],'Total') !== false && $order_info['order_paid'] == 0)
        {
				  $text .= 'Amount Due: ' . html_entity_decode($total['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
        }
        else
        {
          if($total['title'] == 'Total')
          {
            $text .= 'Total Paid: ' . html_entity_decode($total['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
          }
          else
          {
				    $text .= $total['title'] . ': ' . html_entity_decode($total['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
			    } 
        }
      }			
			
			$text .= "\n";
			
			if ($order_info['customer_id']) {
				$text .= $language->get('text_new_link') . "\n";
				$text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
			}
		
			if ($order_download_query->num_rows) {
				$text .= $language->get('text_new_download') . "\n";
				$text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
			}
			
			// Comment
			if ($order_info['comment']) {
				$text .= $language->get('text_new_comment') . "\n\n";
				$text .= $order_info['comment'] . "\n\n";
			}

			$text .= $language->get('text_new_footer') . "\n\n";
		
			$mail = new Mail(); 
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');			
			$mail->setTo($order_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($order_info['store_name']);
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($html);
			$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			// Admin Alert Mail
			if ($this->config->get('config_alert_mail')) {
				$subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_id);
				
				// Text 
				$text  = $language->get('text_new_received') . "\n\n";
				$text .= $language->get('text_new_order_id') . ' ' . $order_id . "\n";
				$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
				$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
				$text .= $language->get('text_new_products') . "\n";
				
				foreach ($order_product_query->rows as $product) {
					$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
					
					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
					
					foreach ($order_option_query->rows as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}
											
						$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
					}
				}
				
				foreach ($order_voucher_query->rows as $voucher) {
					$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
				}
							
				$text .= "\n";

				$text .= $language->get('text_new_order_total') . "\n";
				
				foreach ($order_total_query->rows as $total) {
					$text .= $total['title'] . ': ' . html_entity_decode($total['text'], ENT_NOQUOTES, 'UTF-8') . "\n";
				}			
				
				$text .= "\n";
				
				if ($order_info['comment']) {
					$text .= $language->get('text_new_comment') . "\n\n";
					$text .= $order_info['comment'] . "\n\n";
				}
			
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
				$mail->setSender($order_info['store_name']);
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
				$mail->send();
				
				// Send to additional alert emails
				$emails = explode(',', $this->config->get('config_alert_emails'));
				
				foreach ($emails as $email) {
					if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						$mail->setTo($email);
						$mail->send();
					}
				}				
			}		
		}
	}
	
	public function update($order_id, $order_status_id, $comment = '', $notify = false) {
		$order_info = $this->getOrder($order_id);

		if ($order_info && $order_info['order_status_id']) {
			// Fraud Detection
			if ($this->config->get('config_fraud_detection')) {
				$this->load->model('checkout/fraud');
				
				$risk_score = $this->model_checkout_fraud->getFraudScore($order_info);
				
				if ($risk_score > $this->config->get('config_fraud_score')) {
					$order_status_id = $this->config->get('config_fraud_status_id');
				}
			}			

			// Ban IP
			$status = false;
			
			$this->load->model('account/customer');
			
			if ($order_info['customer_id']) {
								
				$results = $this->model_account_customer->getIps($order_info['customer_id']);
				
				foreach ($results as $result) {
					if ($this->model_account_customer->isBanIp($result['ip'])) {
						$status = true;
						
						break;
					}
				}
			} else {
				$status = $this->model_account_customer->isBanIp($order_info['ip']);
			}
			
			if ($status) {
				$order_status_id = $this->config->get('config_order_status_id');
			}		
						
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
		
      // Added by John
      $stockStatusID = $this->db->query("select " . DB_PREFIX . "product.stock_status_id from " . DB_PREFIX . "product, " . DB_PREFIX . "order_product where " . DB_PREFIX . "order_product.product_id = " . DB_PREFIX . "product.product_id and " . DB_PREFIX . "order_product.order_id = '" . $order_id . "'");
      foreach($stockStatusID->rows as $ssID) {
        // Check if the item is preordered
        if($ssID['stock_status_id'] == 8) {
          // Here, we need to check to see if it's already been paid, or if it's a check order
            if($order_status_id == '5') {
              $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '24', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
            }
            else {
              $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '25', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
            }
          }
        }


			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

      $AlertMessage = $comment;	

			// Send out any gift voucher mails
			if ($this->config->get('config_complete_status_id') == $order_status_id) {
				$this->load->model('checkout/voucher');
	
				$this->model_checkout_voucher->confirm($order_id);
			}	
	
			if ($notify) {

				$language = new Language($order_info['language_directory']);
				$language->load($order_info['language_filename']);
				$language->load('mail/order');
			
				$subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

// Start the template stuff.
//$message  = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">';
//$message .= "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><title>Order Update</title></head>";
//$message .= '<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">';
$message = "<div style='width:590px;'>";
//$message .= "<a href='$store_url' title='$store_name'><img src='$logo' alt='$store_name' style='margin-bottom: 20px; border: none;' /></a>";

        $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
        $preorder_message = false;
        $preorder_comment = '';
        foreach ($order_product_query->rows as $product) {
          $option_data = array();
          
          if(!$preorder_message)
          {
            $product_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product['product_id'] . "'");

            if(strpos($product['model'],'1099-FormsFiler') && $product_status_query->row['stock_status_id'] == 8)
            {
              $preorder_message = true;
              $preorder_comment = "<br>You have ordered the ".$product['name'].", which will be released by early January.  You will receive an email notification when the software is available.";            
            }
          }
                                                                          
          $serials = array();
          if($order_status_id == $this->config->get('config_complete_status_id')) {
            $sns          = $this->model_catalog_serial->getSerialsByProduct($product['order_product_id']);
            $featurecodes = $this->model_catalog_serial->getFeaturecodesByProduct($product['order_product_id']);
            if(!empty($sns)) {
              $message .= "<table style='border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;'>\n";
              $message .= "<thead>\n";
              $message .= "<tr>\n";
              $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;'>Serials and Keycodes for the following product</td>\n";
              $message .= "</tr>\n";
              $message .= "</thead>\n";
              $message .= "<tbody>\n";
              $message .= "<tr>\n";
              $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;'>\n";
              $message .= "<ul>\n";

              if(!empty($sns)) {
                foreach ($sns as $sn) {
                  $message .= "<li style='font-size: 14px;'>Serial Number: <b>" . $sn . $featurecodes[0] . "</b> | Keycode: <b>" . $this->model_catalog_serial->generate_keycode($sn . $featurecodes[0]) . "</b> | <a href='http://shop.1099-etc.com/index.php?route=account/amsupdate/submit&serialSearch=".$sn.$featurecodes[0]."'>Download</a></li>";
                }
              }
              $message .= "</ul></td></tr></tbody></table>\n";
            }


            $message .= "<table style='border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;'>";
            $message .= "<thead>";
            $message .= "<tr>";
            $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;'>Product</td>";
            $message .= "</tr>";
            $message .= "</thead>";
            $message .= "<tbody>";
            $message .= "<tr>";
            $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;'>";

            $message .= "<ul>";
            $message .= "<li style='font-weight: bold;'>" . $product['name'] . "<ul>";

            if((strpos($product['model'], "1099-FormsFiler") !== false) && (strpos($product['model'], "upg-") === false)) {
              $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
              $tmp_option_data = array();
              $tmp_option_data[0]['value'] = "W-2 / 1099 Forms Filer";
              $tmp_option_data[0]['name'] = '';

              foreach ($order_option_query->rows as $option) {
                if($option['value'] != "No Thank You")
                {
                  if(stripos($option['value'], "Soft") !== false)  {
                    $tmp_option_data[1]['value'] = "Software Generated Forms";
                    $tmp_option_data[1]['name'] = '';
                  }
                  if(stripos($option['value'], "AMS Payroll") !== false) {
                    $tmp_option_data[2]['value'] = "AMS Payroll";
                    $tmp_option_data[2]['name'] = '';
                  }
                  if(stripos($option['value'], "E-File Direct") !== false) {
                    $tmp_option_data[3]['value'] = "E-File Direct";
                    $tmp_option_data[3]['name'] = '';
                  }
                  if(stripos($option['value'], "Forms Filer Plus") !== false) {
                    $tmp_option_data[4]['value'] = "Forms Filer Plus";
                    $tmp_option_data[4]['name'] = '';
                  }

                  /*if ($option['type'] != 'file') {
                    $value = $option['value'];
                  } else {
                    $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
                  }

                  $option_data[] = array(
                    'name'  => $option['name'],
                    'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                  );*/
                }
              }
              ksort($tmp_option_data);
              foreach($tmp_option_data as $option){
                  $message .= "<li>" . $option['value'] . "</li>";
              }
              
            }
            
      elseif(strpos($product['model'], "upg") !== false) {
        $tmp_option_data = array();
              $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
        foreach($order_option_query->rows as $X => $O) {
          if($O['value'] == 'No Thank You') {
            //unset($product['option'][$X]);
          }
          if(stripos($O['value'], "Soft") !== false)  {
            $tmp_option_data[0]['value'] = "Software Generated Forms";
            $tmp_option_data[0]['name'] = '';
          }
          if(stripos($O['value'], "AMS Payroll") !== false) {
            $tmp_option_data[1]['value'] = "AMS Payroll";
            $tmp_option_data[1]['name'] = '';
          }
          if(stripos($O['value'], "E-File Direct") !== false) {
            $tmp_option_data[2]['value'] = "E-File Direct";
            $tmp_option_data[2]['name'] = '';
          }
          if(stripos($O['value'], "Forms Filer Plus") !== false) {
            $tmp_option_data[3]['value'] = "Forms Filer Plus";
            $tmp_option_data[3]['name'] = '';
          }
          if(stripos($O['name'], "Serial") !== false) {
            //$tmp_option_data[4]['value'] = "Original Serial Number: " . $O['value'] ;
            //$tmp_option_data[4]['name'] = '';
          }

        }
        //$product['option'] = $tmp_option_data;
        ksort($tmp_option_data);
              foreach($tmp_option_data as $option){
                  $message .= "<li>" . $option['value'] . "</li>";
              }

      }
            $message .= "</ul></li></ul></td></tr></tbody></table>\n";

              //$message .= "</body></html>";
            //}
          }
        }

//				$message .= $language->get('text_update_footer');
 $message .= "<table style='border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;'>";
        $message .= "<thead>";
        $message .= "<tr>\n";
        $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;'>Order Update</td>\n";
        $message .= "</tr>";
        $message .= "</thead>";
        $message .= "<tbody>";
        $message .= "<tr>";
        $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;'>\n";

        $message .= "This message is being sent because there was an update made to your order. ";
        $message .= "Please review the entire message as there may be important information such as serial numbers and keycodes contained in this message.<br /><br />\n";

        $message .= $language->get('text_update_order') . ' ' . $order_id . "<br />";
        $message .= $language->get('text_update_date_added') . ' ' . date("d M Y", strtotime($order_info['date_added'])) . "<br />";

        $message .= "</td></tr></tbody></table>\n";


        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

        if ($order_status_query->num_rows) {
          $message .= "<table style='border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;'>\n";
          $message .= "<thead>\n";
          $message .= "<tr>\n";
          $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;'>" . $language->get('text_update_order_status') . "</td>\n";
          $message .= "</tr>\n";
          $message .= "</thead>\n";
          $message .= "<tbody>\n";
          $message .= "<tr>\n";
          $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;'>\n";
//          $message .= $language->get('text_update_order_status') . "\n\n";
          $message .= $order_status_query->row['name'] . "<br />";
          $message .= "</td></tr></tbody></table>\n";
        }

        if ($order_info['customer_id']) {
          $message .= "<table style='border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;'>\n";
          $message .= "<thead>\n";
          $message .= "<tr>\n";
          $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;'>" . $language->get('text_update_link') . "</td>\n";
          $message .= "</tr>\n";
          $message .= "</thead>\n";
          $message .= "<tbody>\n";
          $message .= "<tr>\n";
          $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;'>\n";
//          $message .= $language->get('text_update_link') . "\n";
          $message .= "<a href='" . $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "'>" . $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "</a><br />";
          $message .= "</td></tr></tbody></table>\n";
        }
 if (($comment && strpos($comment,"Authorization Code") === false) || $preorder_comment) {
          $message .= "<table style='border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;'>\n";
          $message .= "<thead>\n";
          $message .= "<tr>\n";
          $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;'>" . $language->get('text_update_comment') . "</td>\n";
          $message .= "</tr>\n";
          $message .= "</thead>\n";
          $message .= "<tbody>\n";
          $message .= "<tr>\n";
          $message .= "<td style='font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;'>\n";
//          $message .= $language->get('text_update_comment') . "\n\n";
          if ($comment && strpos($comment,"Authorization Code") === false) {
            $message .= nl2br($comment) . "<br />";
          }
          if ($preorder_comment) {
            $message .= $preorder_comment . "<br>";
          }
          $message .= "</td></tr></tbody></table>\n";
        }
        $message .= "</div>";




				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');				
				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($order_info['store_name']);
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
			}
		}
	}
 /* private function getSetting($setting) {
    $value = $this->config->get('multiflatrate_' . $setting);
    return (is_string($value) && strpos($value, 'a:') === 0) ? unserialize($value) : $value;
  }*/

}
?>
