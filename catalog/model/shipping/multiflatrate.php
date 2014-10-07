<?php
//==============================================================================
// Multi Flat Rate Shipping v155.1
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
//==============================================================================

class ModelShippingMultiflatrate extends Model {
	private $type = 'shipping';
	private $name = 'multiflatrate';
	
	private function getSetting($setting) {
		$value = $this->config->get($this->name . '_' . $setting);
		return (is_string($value) && strpos($value, 'a:') === 0) ? unserialize($value) : $value;
	}
	
	public function getQuote($address) {
		if (!$this->getSetting('status') || !$this->getSetting('data')) {
			return;
		}
		
		$version = (!defined('VERSION')) ? 140 : (int)substr(str_replace('.', '', VERSION), 0, 3);
		
		$default_currency = $this->config->get('config_currency');
		$currency = $this->session->data['currency'];
		$language = $this->session->data['language'];
		
		// Type-specific
		$keycode = ($version < 150) ? 'key' : 'code';
		$total_data = array();
		$order_total = 0;
		$taxes = $this->cart->getTaxes();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'total'");
		$order_totals = $query->rows;
		$sort_order = array();
		foreach ($order_totals as $key => $value) $sort_order[$key] = $this->config->get($value[$keycode] . '_sort_order');
		array_multisort($sort_order, SORT_ASC, $order_totals);
		foreach ($order_totals as $ot) {
			if ($ot[$keycode] == $this->type) break;
			if ($this->config->get($ot[$keycode] . '_status')) {
				$this->load->model('total/' . $ot[$keycode]);
				$this->{'model_total_' . $ot[$keycode]}->getTotal($total_data, $order_total, $taxes);
			}
		}
		
		$shipping_geozones = array();
		$geozones = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '0' OR zone_id = '" . (int)$address['zone_id'] . "')");
		foreach ($geozones->rows as $geozone) {
			$shipping_geozones[] = $geozone['geo_zone_id'];
		}
		$shipping_postcode = preg_replace('/[^A-Za-z0-9 ]/', '', $address['postcode']);
		// end
		
		$quote_data = array();
		$this->load->model('catalog/product');
		
		foreach ($this->getSetting('data') as $row_num => $row) {
			// Check Order Criteria
			$geozone_comparison = ($this->type == 'shipping') ? 'shipping' : $row['geozone_comparison'];
			if (empty($row['stores']) ||
				!in_array((int)$this->config->get('config_store_id'), $row['stores']) ||
				empty($row['currencys']) ||
				(!in_array('autoconvert', $row['currencys']) && !in_array($currency, $row['currencys'])) ||
				empty($row['customer_groups']) ||
				!in_array((int)$this->customer->getCustomerGroupId(), $row['customer_groups']) ||
				empty($row['geo_zones']) ||
				(empty(${$geozone_comparison.'_geozones'}) && !in_array(0, $row['geo_zones'])) ||
				(!empty(${$geozone_comparison.'_geozones'}) && !array_intersect($row['geo_zones'], ${$geozone_comparison.'_geozones'}))
			) {
				continue;
			}
			
			// Generate Comparison Values
			$item = 0;
			$prediscounted = 0;
			$subtotal = 0;
			$taxed = 0;
			$total = $order_total;
			
			foreach ($this->cart->getProducts() as $product) {
				if (!$product['shipping'] && $this->type == 'shipping') continue;
				
				$item += $product['quantity'];
				
				$product_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product WHERE product_id = " . (int)$product['product_id']);
				$product_info = $this->model_catalog_product->getProduct($product['product_id']);
				$price = ($product_info['special']) ? $product_info['special'] : $product_info['price'];
				
				$prediscounted += $product['total'] + ($product['quantity'] * ($product_query->row['price'] - $price));
				$subtotal += $product['total'];
				$taxed += $this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax'));
			}
			
			// Check Cart Criteria
			$autoconvert = !in_array($currency, $row['currencys']);
			$conversion_currency = $row['currencys'][0];
			if ($conversion_currency == 'autoconvert') {
				$conversion_currency = (isset($row['currencys'][1])) ? $row['currencys'][1] : $default_currency;
			}
			
			$total_value = ${$row['total_value']};
			if (strpos($this->name, 'totalbased') === 0) {
				$total_value += (strpos($row['adjustment'], '%')) ? $total_value * (float)$row['adjustment'] / 100 : (float)$row['adjustment'];
			}
			$total_value = $this->currency->convert($total_value, $default_currency, $currency);
			$total_value = ($autoconvert) ? $this->currency->convert($total_value, $currency, $conversion_currency) : $total_value;
			
			// Calculate Cost
			$cost = (strpos($row['cost'], '%')) ? $total_value * (float)$row['cost'] / 100 : (float)$row['cost'];
			$cost = ($row['type'] == 'peritem') ? $cost * $item : $cost;
			$cost = ($autoconvert) ? $this->currency->convert($cost, $conversion_currency, $currency) : $cost;
			$cost = $this->currency->convert($cost, $currency, $default_currency);
			
			$quote_data[$this->name . '_' . $row_num] = array(
				'id'			=> $this->name . '.' . $this->name . '_' . $row_num,
				'code'			=> $this->name . '.' . $this->name . '_' . $row_num,
				'title'			=> html_entity_decode($row['title'][$language], ENT_QUOTES, 'UTF-8'),
				'cost'			=> $cost,
				'description'			=> $row['description'],
				'tax_class_id'	=> $row['tax_class_id'],
				'text'			=> $this->currency->format($this->tax->calculate($cost, $row['tax_class_id'], $this->config->get('config_tax')))
			);
		}
		
		$method_data = array();
		if ($quote_data) {
			if ($this->getSetting('sort_rates') == 'cost') {
				$sort_by_cost = array();
				foreach ($quote_data as $key => $value) $sort_by_cost[$key] = $value['cost'];
				array_multisort($sort_by_cost, SORT_ASC, $quote_data);
			}
			
			$heading = $this->getSetting('heading');
			$method_data = array(
				'id'			=> $this->name,
				'code'			=> $this->name,
				'title'			=> html_entity_decode($heading[$language], ENT_QUOTES, 'UTF-8'),
				'quote'			=> $quote_data,
				'sort_order'	=> $this->getSetting('sort_order'),
				'error'			=> false
			);
		}
error_log("<pre>" .  " made it here</pre>", 1, 'jlevan@gmail.com');
		return $method_data;
	}	
}
?>
