<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class ModelModuleEmailTemplate extends Model {
		
	/**
	 * Get Templates
	 * 
	 * @return array
	 */
	public function getTemplates($data = array()) 
	{
		$p = DB_PREFIX;	
		$cond = array();
		
		if (isset($data['store_id'])) {
			if(is_numeric($data['store_id'])){
				$cond[] = "e.`store_id` = '".intval($data['store_id'])."'";
			} else {
				$cond[] = "e.`store_id` IS NULL";
			}
		}	
		
		if (isset($data['language_id']) && $data['language_id'] != 0) {
			$cond[] = "ed.`language_id` = '".intval($data['language_id'])."'";
		}
				
		if (isset($data['customer_group_id']) && $data['customer_group_id'] != 0) {
			$cond[] = "e.`customer_group_id` = '".intval($data['customer_group_id'])."'";
		}
		
		if (isset($data['emailtemplate_key']) && $data['emailtemplate_key'] != "") {
			$cond[] = "e.`emailtemplate_key` = '".$this->db->escape($data['emailtemplate_key'])."'";
		}	
		
		if (isset($data['emailtemplate_status']) && $data['emailtemplate_status'] != "") {
			$cond[] = "e.`emailtemplate_status` = '".$this->db->escape($data['emailtemplate_status'])."'";
		} else {
			$cond[] = "e.`emailtemplate_status` = 'ENABLED'";
		}
		
		if (isset($data['emailtemplate_type']) && $data['emailtemplate_type'] != "") {
			$cond[] = "e.`emailtemplate_type` = '".$this->db->escape($data['emailtemplate_type'])."'";
		}	
		
		if (isset($data['emailtemplate_id'])) {
			if(is_array($data['emailtemplate_id'])){
				$ids = array();
				foreach($data['emailtemplate_id'] as $id){ $ids[] = intval($id); }
				$cond[] = "e.`emailtemplate_id` IN('".implode("', '", $ids)."')";
			} else {
				$cond[] = "e.`emailtemplate_id` = '".intval($data['emailtemplate_id'])."'";
			}
		}	
		
		if (isset($data['language_id']) && $data['language_id'] != 0) {
			$query = "SELECT e.*, ed.* FROM `{$p}emailtemplate` e LEFT JOIN `{$p}emailtemplate_description` ed ON(ed.emailtemplate_id = e.emailtemplate_id)";			
		} else {
			$query = "SELECT e.* FROM `{$p}emailtemplate` e";
		}
		
		if(!empty($cond)){
			$query .= ' WHERE ' . implode(' AND ', $cond);
		}
			
		$sort_data = array(
			'label' => 'e.`emailtemplate_label`',
			'key' => 'e.`emailtemplate_key`',
			'template' => 'e.`emailtemplate_template`',
			'modified' => 'e.`emailtemplate_modified`',
			'shortcodes' => 'e.`emailtemplate_shortcodes`',
			'status' => 'e.`emailtemplate_status`',
			'id' => 'e.`emailtemplate_id`',
			'store' => 'e.`store_id`',
			'customer' => 'e.`customer_group_id`',
			'language' => 'ed.`language_id`',
			'type' => 'e.`emailtemplate_type`'
		);	
		if (isset($data['sort']) && in_array($data['sort'], array_keys($sort_data))) {
			$query .= " ORDER BY " . $sort_data[$data['sort']];
		} else {
			$query .= " ORDER BY e.`emailtemplate_label`";
		}
	
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}
			
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}	
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
				
		$result = $this->_fetch($query);	
		return $result->rows;
	}
	
	/**
	 * Get Template
	 * @param int $id
	 * @return array
	 */
	public function getTemplateDescription($data)
	{
		$p = DB_PREFIX;
		$cond = array();
		$query = "SELECT * FROM {$p}emailtemplate_description";
	
		if(isset($data['emailtemplate_id'])){
			$cond[] = "`emailtemplate_id` = '".intval($data['emailtemplate_id'])."'";
		}
	
		if(isset($data['language_id'])){
			$cond[] = "`language_id` = '".intval($data['language_id'])."'";
		}
	
		if(!empty($cond)){
			$query .= ' WHERE ' . implode(' AND ', $cond);
		}
		$result = $this->_fetch($query);
	
		return $result->rows;
	}
		
	/**
	 * Load showcase for store emails
	 * NOTE: duplicate method admin/model/module/emailtemplate.php
	 */
	public function getShowcase($config, $language_id, $store_id = 0){
		$return = array();
			
		switch($config['showcase']){
			case 'products':	
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				
				$result = array();
				$selection = explode(',', $config['showcase_selection']);
				foreach($selection as $product_id){
					if($product_id){
						$result[] = $this->model_catalog_product->getProduct($product_id);
					}
				}
					
				foreach($result as $row){
					if ($row['image']) {
						$image = $this->model_tool_image->resize($row['image'], 100, 100);
						$image_width = 100;
						$image_height = 100;
					} else {
						$image = false;
						$image_width = 0;
						$image_height = 0;
					}
					
					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($row['price'], $row['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
					
					if ((float)$row['special']) {
						$special = $this->currency->format($this->tax->calculate($row['special'], $row['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}
																
					$return[] = array(
						'product_id' => $row['product_id'],
						'image'   	 => $image,
						'image_width' => $image_width,
						'image_height' => $image_height,
						'name'    	 => $row['name'],
						'name_short' => EmailTemplate::truncate_str($row['name'], 28, ''),
						'description' => substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
						'price'       => $price,
						'special'     => $special,
						'url'    	 => $this->url->link('product/product', 'product_id=' . $row['product_id'])
					);
				}
			break;
		}
		
		return $return;
	}
	
	/**
	 * Get Email Template Config
	 * 
	 * @param int||array $identifier
	 * @param bool $outputFormatting
	 * @param bool $keyCleanUp
	 * @return array
	 */
	public function getConfig($data, $outputFormatting = false, $keyCleanUp = false)
	{
		$p = DB_PREFIX;
		$cond = array();
		
		if(is_array($data)){
			if(isset($data['store_id'])) {
				$cond[] = "`store_id` = '".intval($data['store_id'])."'";
			}			
			if(isset($data['language_id'])) {
				$cond[] = "(`language_id` = '".intval($data['language_id'])."' OR `language_id` = 0)";
			}
		} elseif(is_numeric($data)) {
			$cond[] = "`emailtemplate_config_id` = '" . intval($data) . "'";
		} else {
			return false;
		}
		
		$query = "SELECT * FROM `{$p}emailtemplate_config`";		
		if(!empty($cond)){
			$query .= " WHERE " . implode(" AND ", $cond);
		}
		$query .= " ORDER BY `language_id` DESC LIMIT 1";
		
		$result = $this->_fetch($query);
		if(empty($result->row)) return false;
		$row = $result->row;
		
		$cols = EmailTemplateConfigDAO::describe();
		foreach($cols as $col => $type){
			if(isset($row[$col]) && $type == EmailTemplateDAO::SERIALIZE){
				if($row[$col]){
					$row[$col] = unserialize($row[$col]);
				}
			}
		}
			
		if($outputFormatting){
			$row = $this->formatConfig($row);
		}
								
		if($outputFormatting){
			foreach($row as $col => $val){
				$key = (strpos($col, 'emailtemplate_config_') === 0 && substr($col, -3) != '_id') ? substr($col, 21) : $col;
				if(!isset($row[$key])){
					unset($row[$col]);
					$row[$key] = $val;
				}
			}			
		}
		
		return $row;
	}
	
	/**
	 * Return array of configs
	 * @param array - $data
	 */
	public function getConfigs($data = array(), $outputFormatting = false)
	{
		$p = DB_PREFIX;
		$cond = array();
	
		if (isset($data['language_id'])) {
			$cond[] = "AND ec.`language_id` = '".intval($data['language_id'])."'";
		} elseif (isset($data['_language_id'])) {
			$cond[] = "OR ec.`language_id` = '".intval($data['_language_id'])."'";
		}
	
		if (isset($data['store_id'])) {
			$cond[] = "AND ec.`store_id` = '".intval($data['store_id'])."'";
		} elseif (isset($data['_store_id'])) {
			$cond[] = "OR ec.`store_id` = '".intval($data['_store_id'])."'";
		}
	
		if (isset($data['customer_group_id'])) {
			$cond[] = "AND ec.`customer_group_id` = '".intval($data['customer_group_id'])."'";
		} elseif (isset($data['_customer_group_id'])) {
			$cond[] = "OR ec.`customer_group_id` = '".intval($data['_customer_group_id'])."'";
		}
		
		if (isset($data['emailtemplate_config_id'])) {
			if(is_array($data['emailtemplate_config_id'])){
				$ids = array();
				foreach($data['emailtemplate_config_id'] as $id){ $ids[] = intval($id); }
				$cond[] = "AND ec.`emailtemplate_config_id` IN('".implode("', '", $ids)."')";
			} else {
				$cond[] = "AND ec.`emailtemplate_config_id` = '".intval($data['emailtemplate_config_id'])."'";
			}
		}
		
		if (isset($data['status']) && $data['status'] != "") {
			$cond[] = "AND ec.`emailtemplate_config_status` = '".$this->db->escape($data['status'])."'";
		} else {
			$cond[] = "AND ec.`emailtemplate_config_status` = 'ENABLED'";
		}
			
		$query = "SELECT ec.* FROM `{$p}emailtemplate_config` ec";
		if(!empty($cond)){
			$query .= ' WHERE ' . ltrim(implode(' ', $cond), 'AND');
		}
	
		$sort_data = array(
			'ec.emailtemplate_config_id',
			'ec.emailtemplate_config_name',
			'ec.emailtemplate_config_modified',
			'ec.store_id',
			'ec.language_id',
			'ec.customer_group_id'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$query .= " ORDER BY `" . $data['sort'] . "`";
		} else {
			$query .= " ORDER BY ec.`emailtemplate_config_name`";
		}
	
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$query .= " DESC";
		} else {
			$query .= " ASC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$query .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
				
		$result = $this->_fetch($query);		
		if(empty($result->rows)) return array();
		$rows = $result->rows;
		
		$cols = EmailTemplateConfigDAO::describe();
		foreach($rows as $key => $row){
			foreach($cols as $col => $type){
				if(isset($row[$col]) && $type == EmailTemplateDAO::SERIALIZE){
					if($row[$col]){
						$row[$col] = unserialize($row[$col]);
					}
				}
			}							
			$rows[$key] = $row; 
		}
				
		return $rows;
	}
	
	
	/**
	 * Return array of configs
	 * 
	 * @param array - $data
	 */
	public function formatConfig($data = array())
	{
		$this->load->model('tool/image');
			
		$data['emailtemplate_config_head_text_fvalue'] = html_entity_decode($data['emailtemplate_config_head_text'], ENT_QUOTES, 'UTF-8');
		$data['emailtemplate_config_page_footer_text_fvalue'] = html_entity_decode($data['emailtemplate_config_page_footer_text'], ENT_QUOTES, 'UTF-8');
		$data['emailtemplate_config_footer_text_fvalue'] = html_entity_decode($data['emailtemplate_config_footer_text'], ENT_QUOTES, 'UTF-8');
			
		if ($data['emailtemplate_config_logo'] && file_exists(DIR_IMAGE . $data['emailtemplate_config_logo'])) {
			if ($data['emailtemplate_config_logo_width'] > 0 && $data['emailtemplate_config_logo_height'] > 0){
				$data['emailtemplate_config_logo_thumb'] = $this->model_tool_image->resize(
					$data['emailtemplate_config_logo'],
					$data['emailtemplate_config_logo_width'],
					$data['emailtemplate_config_logo_height']
				);
			} else {
				$data['emailtemplate_config_logo_thumb'] = $this->model_tool_image->get($data['emailtemplate_config_logo']);
			}
		} else {
			$data['emailtemplate_config_logo_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
			
		if ($data['emailtemplate_config_header_bg_image'] && file_exists(DIR_IMAGE . $data['emailtemplate_config_header_bg_image'])) {
			$data['emailtemplate_config_header_bg_image_thumb'] = $this->model_tool_image->get($data['emailtemplate_config_header_bg_image']);
		} else {
			$data['emailtemplate_config_header_bg_image_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
	
		if ($data['emailtemplate_config_invoice_logo'] && file_exists(DIR_IMAGE . $data['emailtemplate_config_invoice_logo'])) {
			$data['emailtemplate_config_invoice_logo_thumb'] = $this->model_tool_image->get($data['emailtemplate_config_invoice_logo']);
		} else {
			$data['emailtemplate_config_invoice_logo_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
	
		foreach(array('left', 'right') as $col){
			if (isset($data['emailtemplate_config_shadow_top'][$col.'_img']) && file_exists(DIR_IMAGE . $data['emailtemplate_config_shadow_top'][$col.'_img'])) {
				$data['emailtemplate_config_shadow_top'][$col.'_thumb'] = $this->model_tool_image->get($data['emailtemplate_config_shadow_top'][$col.'_img']);
			} else {
				$data['emailtemplate_config_shadow_top'][$col.'_thumb'] = $this->model_tool_image->resize('no_image.jpg', 50, 50);
			}
	
			if (isset($data['emailtemplate_config_shadow_bottom'][$col.'_img']) && file_exists(DIR_IMAGE . $data['emailtemplate_config_shadow_bottom'][$col.'_img'])) {
				$data['emailtemplate_config_shadow_bottom'][$col.'_thumb'] = $this->model_tool_image->get($data['emailtemplate_config_shadow_bottom'][$col.'_img']);
			} else {
				$data['emailtemplate_config_shadow_bottom'][$col.'_thumb'] = $this->model_tool_image->resize('no_image.jpg', 50, 50);
			}
		}
	
		return $data;
	}

	
	/**
	 * Insert Template Short Codes
	 */
	public function insertTemplateShortCodes($id, $data)
	{
		$id = intval($id);
		$cols = EmailTemplateShortCodesDAO::describe();
		$p = DB_PREFIX;
		$return = 0;
		
		$this->db->query("DELETE FROM {$p}emailtemplate_shortcode WHERE `emailtemplate_id` = '{$id}'");
		
		foreach($data as $code => $example){
			if(is_array($example)) continue;
		
			$inserts = $this->_build_query($cols, array(
				'emailtemplate_id' => $id,
				'emailtemplate_shortcode_type' => 'auto',
				'emailtemplate_shortcode_code' => $code,
				'emailtemplate_shortcode_example' => $example
			));
			if (empty($inserts)) return false;
			
			$this->db->query("INSERT INTO {$p}emailtemplate_shortcode SET ".implode($inserts,", "));
			$return++;
		}
				
		$this->db->query("UPDATE {$p}emailtemplate SET `emailtemplate_shortcodes` = '1' WHERE `emailtemplate_id` = '{$id}'");
		
		$this->_deleteCache();
		
		return $return;
	}

	/**
	 * Fetch query with caching
	 *
	 */
	private function _fetch($query)
	{
		$queryName = 'emailtemplate_sql_'.md5($query);
		$result = $this->cache->get($queryName);
		if(!$result){
			$result = $this->db->query($query);
			$this->cache->set($queryName, $result);
		}
		return $result;
	}
	
	
	/**
	 * Method builds mysql for INSERT/UPDATE
	 *
	 * @param array $cols
	 * @param array $data
	 * @return array
	 */
	private function _build_query($cols, $data, $withoutCols = false)
	{
		if(empty($data)) return $data;
		$return = array();
			
		foreach ($cols as $col => $type) {
			if (!array_key_exists($col, $data)) continue;
	
			switch ($type) {
				case EmailTemplateAbstract::INT:
					$value = intval($data[$col]);
					break;
				case EmailTemplateAbstract::FLOAT:
					$value = floatval($data[$col]);
					break;
				case EmailTemplateAbstract::DATE_NOW:
					$value = 'NOW()';
					break;
				default:
					$value = $this->db->escape($data[$col]);
			}
	
			if($withoutCols){
				$return[] = "'{$value}'";
			} else {
				$return[] = " `{$col}` = '{$value}'";
			}
		}
	
		return empty($return) ? false : $return;
	}
	
	/**
	 * Delete all cache files that begin with emailtemplate_
	 *
	 */
	private function _deleteCache($key = 'emailtemplate_sql_')
	{
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '*');
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					unlink($file);
				}
			}
		}
	}
}