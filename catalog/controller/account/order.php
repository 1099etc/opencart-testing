<?php 
class ControllerAccountOrder extends Controller {
	private $error = array();
		
	public function index() {
    	if (!$this->customer->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		$this->language->load('account/order');
		
		$this->load->model('account/order');
 		
		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_account_order->getOrder($this->request->get['order_id']);
			
			if ($order_info) {
				$order_products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
						
				foreach ($order_products as $order_product) {
					$option_data = array();
							
					$order_options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);
							
					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];	
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}
							
					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->request->get['order_id']);
							
					$this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
				}
									
				$this->redirect($this->url->link('checkout/cart'));
			}
		}

    	$this->document->setTitle($this->language->get('heading_title'));

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/order', $url, 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_reorder'] = $this->language->get('button_reorder');
		$this->data['button_continue'] = $this->language->get('button_continue');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$this->data['orders'] = array();
		
		$order_total = $this->model_account_order->getTotalOrders();
		
		$results = $this->model_account_order->getOrders(($page - 1) * 10, 10);
		
		foreach ($results as $result) {
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);

			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'products'   => ($product_total + $voucher_total),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'href'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'),
				'reorder'    => $this->url->link('account/order', 'order_id=' . $result['order_id'], 'SSL')
			);
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/order', 'page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/order_list.tpl';
		} else {
			$this->template = 'default/template/account/order_list.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
						
		$this->response->setOutput($this->render());				
	}
	



public function resend(){

    if (!$this->customer->isLogged()) {
        $this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
        $this->redirect($this->url->link('account/login', '', 'SSL'));
      } 

    $this->load->model('checkout/order'); 
    $order_id   = $this->request->get['order_id'];
    $order_info = $this->model_checkout_order->getOrder($order_id);


    if($this->customer->getEmail() !== $order_info['email']){
      $this->session->data['success'] = "No order was found with that ID for your account!";
      $this->redirect($this->url->link('account/account', '', 'SSL'));
    }

    $template = new Template();
    
    $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
    
    foreach ($order_product_query->rows as $order_product) {
    $this->load->model('catalog/serial');

      if(!empty($order_product)) $product = $order_product;
      //$this->model_catalog_serial->addOrderSerials((int)$product['product_id'], (int)$product['order_id'], (int)$product['order_product_id'], (int)$product['quantity']);

      $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");
      
      $order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");
    
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

    // Order Totals     
    $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
    
    foreach ($order_total_query->rows as $order_total) {
      $this->load->model('total/' . $order_total['code']);
      
      if (method_exists($this->{'model_total_' . $order_total['code']}, 'confirm')) {
        $this->{'model_total_' . $order_total['code']}->confirm($order_info, $order_total);
      }
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

    
    // HTML Mail
    $template = new Template();
    $subject = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_id);
    
    $template->data['title'] = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);
    $template->data['text_greeting'] = "";
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
    $template->data['text_footer'] = "";
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

    // Vouchers
    $template->data['vouchers'] = array();
    
    foreach ($order_voucher_query->rows as $voucher) {
      $template->data['vouchers'][] = array(
        'description' => $voucher['description'],
        'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
      );
    }

    $template->data['order_id'] = $order_id;
    $template->data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));      
    $template->data['payment_method'] = $order_info['payment_method'];
    $template->data['shipping_method'] = $order_info['shipping_method']."<br>".html_entity_decode($order_info['shipping_description']);
    $template->data['email'] = $order_info['email'];
    $template->data['telephone'] = $order_info['telephone'];
    $template->data['ip'] = $order_info['ip'];
    $template->data['comment'] = '';

          
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

    if($order_info['order_status_id'] == 20)
    {
       $this->language->load('oentrypayment/cheque');
       $template->data['comment']  = "<b>".$this->language->get('text_payable') . "</b><br><br>";
       $template->data['comment'] .= $this->config->get('cheque_payable') . "<br><br>";
       $template->data['comment'] .= $this->language->get('text_address') . "<br>";
       if (isset($this->session->data['store_id'])) {
          $template->data['comment'] .= str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim($this->session->data['store_config']['config_address'] ))). "<br><br>";
       } else {
          $template->data['comment'] .= str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim($this->config->get('config_address') ))) . "<br><br>";
       }
       $template->data['comment'] .= "<b>".$this->language->get('text_payment') . "</b>";
    }

    $this->load->model('catalog/serial');
    $template->data['text_serial_keys'] = $language->get('text_serial_keys');
      
    // Products
    $template->data['products'] = array();
    $preorder_message = false;  
    foreach ($order_product_query->rows as $product) {
      $option_data = array();
      
      $serials = array();
      if($order_info['order_status_id'] == $this->config->get('config_complete_status_id')) {
        $sns          = $this->model_catalog_serial->getSerialsByProduct($product['order_product_id']);
        $featurecodes = $this->model_catalog_serial->getFeaturecodesByProduct($product['order_product_id']);
        if(isset($sns) && is_array($sns)) {
          foreach ($sns as $sn) {
            $serials[] = "Serial Number: " . $sn . $featurecodes[0] . " | Keycode: " . $this->model_catalog_serial->generate_keycode($sn . $featurecodes[0]);
          }
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
      if(!$preorder_message)
      {
        $product_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product['product_id'] . "'");
  
        if(strpos($product['model'],'1099-FormsFiler') && $product_status_query->row['stock_status_id'] == 8)
        {
          $preorder_message = true;
          $template->data['comment'] .= "<br>You have ordered the ".$product['name'].", which will be released by early January.  You will receive an email notification when the software is available.";
        }
      }

    }
    $template->data['totals'] = $order_total_query->rows;
    foreach ($template->data['totals'] as $key=>$total) {
      if($total['title'] == 'Total' && $order_info['order_paid'] == 0 && ($order_info['payment_code'] == 'pending' || $order_info['payment_code'] == 'invoiced' || $order_info['payment_code'] == 'cheque'))
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
    $mail->send();

    $this->session->data['success'] = "Order receipt was emailed to: ".$this->customer->getEmail()."!";

    $this->redirect($this->url->link('account/account', '', 'SSL'));

  }
















	public function info() { 
		$this->language->load('account/order');
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}	

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');
			
			$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
						
		$this->load->model('account/order');
			
		$order_info = $this->model_account_order->getOrder($order_id);
		
		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));
			
			$this->data['breadcrumbs'] = array();
		
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),        	
				'separator' => false
			); 
		
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),        	
				'separator' => $this->language->get('text_separator')
			);
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', $url, 'SSL'),      	
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
					
      		$this->data['heading_title'] = $this->language->get('text_order');
			
			$this->data['text_order_detail'] = $this->language->get('text_order_detail');
			$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
    		$this->data['text_order_id'] = $this->language->get('text_order_id');
			$this->data['text_date_added'] = $this->language->get('text_date_added');
      		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
      		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
      		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
      		$this->data['text_history'] = $this->language->get('text_history');
			$this->data['text_comment'] = $this->language->get('text_comment');

      		$this->data['column_name'] = $this->language->get('column_name');
      		$this->data['column_model'] = $this->language->get('column_model');
      		$this->data['column_quantity'] = $this->language->get('column_quantity');
      		$this->data['column_price'] = $this->language->get('column_price');
      		$this->data['column_total'] = $this->language->get('column_total');
			$this->data['column_action'] = $this->language->get('column_action');
			$this->data['column_date_added'] = $this->language->get('column_date_added');
      		$this->data['column_status'] = $this->language->get('column_status');
      		$this->data['column_comment'] = $this->language->get('column_comment');
			
			$this->data['button_return'] = $this->language->get('button_return');
      		$this->data['button_continue'] = $this->language->get('button_continue');
		
			if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}
			
			$this->data['order_id'] = $this->request->get['order_id'];
			$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
			
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
			
			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

      		$this->data['payment_method'] = $order_info['payment_method'];
			
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

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];
			
			$this->data['products'] = array();

      $this->data['order_status_id'] = $order_info['order_status_id'];
			
			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

      		foreach ($products as $product) {
				$option_data = array();
				
				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

         		foreach ($options as $option) {
          			if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
					}
					
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => $value //(utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);					
        		}

        		$this->data['products'][] = array(
          			'name'     => $product['name'],
          			'model'    => $product['model'],
          			'option'   => $option_data,
          			'quantity' => $product['quantity'],
          			'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'return'   => $this->url->link('account/return/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
        		);
      		}

			// Voucher
			$this->data['vouchers'] = array();
			
			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);
			
			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
			
      		$this->data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
			
			$this->data['comment'] = nl2br($order_info['comment']);
			
			$this->data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

      		foreach ($results as $result) {
        		$this->data['histories'][] = array(
          			'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
          			'status'     => $result['status'],
          			'comment'    => nl2br($result['comment'])
        		);
      		}

      		$this->data['continue'] = $this->url->link('account/order', '', 'SSL');
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_info.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/order_info.tpl';
			} else {
				$this->template = 'default/template/account/order_info.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'	
			);
								
			$this->response->setOutput($this->render());		
    	} else {
			$this->document->setTitle($this->language->get('text_order'));
			
      		$this->data['heading_title'] = $this->language->get('text_order');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home'),
				'separator' => false
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
												
      		$this->data['continue'] = $this->url->link('account/order', '', 'SSL');
			 			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'	
			);
								
			$this->response->setOutput($this->render());				
    	}
  	}
}
?>
