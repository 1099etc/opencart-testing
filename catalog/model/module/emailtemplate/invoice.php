<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class ModelModuleEmailTemplateInvoice extends Model {

	public function getInvoice($order_id, $output = false){
		$order_id = intval($order_id);

		$this->load->model('module/emailtemplate');
		$this->load->model('localisation/language');
		$this->load->model('checkout/order');
		$this->load->model('account/order');
		$this->load->model('setting/store');
		$this->load->model('setting/setting');
		$this->load->model('tool/image');

		# Directory
		//$dir = DIR_SYSTEM . '/../../resources/'.date('Y-m-d').'/'; # path outside doc root more secure
		$dir = DIR_CACHE . 'invoices/'.date('Y-m-d').'/';
		if(!is_dir($dir) || !is_writable($dir)){
			mkdir($dir, 0777, true);
		}

		# Order
		$order_info = $this->model_checkout_order->getOrder($order_id);
		if($order_info == false) return false;

		$order_info['language_id'] = ($order_info['language_id']) ? $order_info['language_id'] : 1;
		$order_info['shipping_address'] = EmailTemplate::formatAddress($order_info, 'shipping', $this->data['order']['shipping_address_format']);
		$order_info['payment_address'] = EmailTemplate::formatAddress($order_info, 'payment', $this->data['order']['payment_address_format']);
		$order_info['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
		$order_info['totals'] = $this->model_account_order->getOrderTotals($order_id);

		# Store
		$store_info = array_merge(
			//$this->model_setting_store->getStore($order_info['store_id']),
			$this->model_setting_setting->getSetting("config", $order_info['store_id'])
		);
		if(!isset($store_info['config_url'])) {
			$store_info['config_url'] = HTTP_SERVER;
		}

		# Order - Products
		$order_info['products'] = array();
		$products = $this->model_account_order->getOrderProducts($order_id);
		foreach ($products as $product) {
			$option_data = array();
			$options = $this->model_account_order->getOrderOptions($order_id, $product['order_product_id']);
			foreach ($options as $option) {
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

			//sample, add options as a string
			$str = '';
			if( count($option_data) > 0)
			{
				$str = '<br /><br />';

				foreach ($option_data as $value) {
					$str .= $value['name'] . ' : ' .$value['value'] . '<br />' ;
				}
			}

			$order_info['products'][] = array(
				'name'     => $product['name'],
				'model'    => $product['model'],
				'option'   => $str,
				'quantity' => $product['quantity'],
				'url' 	   => $this->url->link('product/product', 'product_id=' . $product['product_id']), 
				'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
			);
		}

		# Order - Vouchers
		$order_info['vouchers'] = array();
		if(method_exists($this->model_account_order, 'getOrderVouchers')){
			$vouchers = $this->model_account_order->getOrderVouchers($order_id);
			foreach ($vouchers as $voucher) {
				$order_info['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
		}
		
		# Extension settings - load main template
		$config = $this->model_module_emailtemplate->getConfig(array(
			'store_id' 	  => $order_info['store_id'],
			'language_id' => $order_info['language_id']
		), true, true);

		# Language
		$languages = $this->model_localisation_language->getLanguages();
		foreach($languages as $lang){
			if($lang['language_id'] == $order_info['language_id']){
				$oLanguage = new Language($lang['directory']);
				$language = array_merge(
					$oLanguage->load($lang['filename']),
					$oLanguage->load('account/order'),
					$oLanguage->load('account/invoice')
				);
			}
		}

		# Delete old order file
		if(isset($order_info['invoice_filename']) && file_exists($dir.$order_info['invoice_filename'])){
			@unlink($dir.$order_info['invoice_filename']);
		}

		# Filename
		while (true) {
			$filename = uniqid('order_'.$order_id.'_', true).'.pdf';
			if (!file_exists($dir.$filename)) break;
		}

		# Merge all data together
		$data = array();
		$data['config'] = $config;
		$data['order'] = $order_info;
		$data['store'] = $store_info;

		# Create Invoice
		require_once(DIR_SYSTEM . 'library/emailtemplate/invoice.php');
		$pdf = new EmailTemplateInvoice('P', 'mm', 'A4');
		
		$language['a_meta_charset'] = 'UTF-8';
		$pdf->setLanguageArray($language);
		
		$pdf->Build($data);
		$pdf->Draw();

		if($output === true){
			$pdf->Output($dir.$filename, 'I');
		} elseif($pdf->Output($dir.$filename, 'F') !== false){
			$this->db->query("UPDATE `".DB_PREFIX."order` SET `invoice_filename` = '{$filename}' WHERE `order_id` = '{$order_id}'");
		}
		
		return $dir.$filename;
	}
}
