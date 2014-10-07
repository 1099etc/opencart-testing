<?php
/**
 * HTML Email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */
class EmailTemplate {

	static $version = '0.14';
	public $data = array();
		
	private $registry;
	private $request;
	private $config;
	private $db;
	private $model;
	private $model_tool_image;
	
	private $server;
	private $server_image;
	
	private $html = null;
	private $css = null;
	private $wrapper_tpl = '_main.tpl';
	
	private $language_id;
	private $store_id;
	private $customer_group_id;
	
	private $emailtemplate;
	private $emailtemplate_id;
	private $emailtemplate_config;
	private $emailtemplate_config_id;
		
	/** 
	 * @param Request $request
	 */
	public function __construct(Request $request, Registry $registry) {
		$this->registry = $registry;
		$this->request = $request;
		$this->config = $registry->get('config');
		$this->language = $registry->get('language');
		$this->load = $registry->get('load');
		$this->db = $registry->get('db');
		
		$this->customer_group_id = $this->config->get('config_customer_group_id');
		$this->language_id = $this->config->get("config_language_id");
		$this->store_id = $this->config->get("config_store_id");
		
		# Load models
		$this->load->model('tool/image');
		$this->model_tool_image = new ModelToolImage($this->registry);
		
		$this->load->model('module/emailtemplate');
		$this->model = new ModelModuleEmailTemplate($this->registry); 
		
		if (isset($request->server['HTTPS']) && (($request->server['HTTPS'] == 'on') || ($request->server['HTTPS'] == '1'))) {
			$this->data['server'] = defined('HTTPS_CATALOG') ? HTTPS_CATALOG : HTTPS_SERVER;
		} else {
			$this->data['server'] = defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER;
		}
		$this->data['server_admin'] = defined("HTTP_ADMIN") ? HTTP_ADMIN : ($this->data['server'].'admin/');
		$this->data['server_image'] = defined("HTTP_IMAGE") ? HTTP_IMAGE : ($this->data['server'].'image/');
	}

	/**
	 * Load Template + Config + Set all store data
	 * 
	 * @param $keys 
	 * @param $data - pass data which overwrites config, used in admin preview system
	 */
	public function load($data)
	{		
		if(is_array($data)){										
			if(isset($data['language_id']) && $data['language_id'] >= 1){
				$this->language_id = intval($data['language_id']);
			}
							
			if(isset($data['store_id']) && $data['store_id'] >= 0){
				$this->store_id = intval($data['store_id']);
			}	
								
			if(isset($data['customer_group_id']) && $data['customer_group_id'] >= 1){
				$this->customer_group_id = intval($data['customer_group_id']);
			} 
								
			if(isset($data['emailtemplate_config_id']) && $data['emailtemplate_config_id']){
				$this->emailtemplate_config_id = intval($data['emailtemplate_config_id']);
			} 
						
			$filter = array();
									
			if(isset($data['type'])){
				$filter['emailtemplate_type'] = $data['type'];
			}

			if(isset($data['emailtemplate_id'])){
				$filter['emailtemplate_id'] = intval($data['emailtemplate_id']);
			}
			
			if(isset($data['key'])){
				if(is_numeric($data['key'])){
					$filter['emailtemplate_id'] = $data['key'];
				} else {
					$filter['emailtemplate_key'] = $data['key'];
				}
			}			
		} else {
			if(is_numeric($data)){
				$filter = array('emailtemplate_id' => $data);
			} else {
				$filter = array('emailtemplate_key' => $data);
			}
		}
				
		$templates = $this->model->getTemplates($filter);
		
		if(empty($templates)){	
			trigger_error('Could not load email template: ' . key($filter) . '=' . current($filter));		
			return false;
		}
		
		$keys = array(
			'language_id' => $this->language_id,
			'customer_group_id' => $this->customer_group_id,
			'store_id' => $this->store_id
		);
		
		foreach ($templates as &$template) {			
			$template['power'] = 0;
			
			foreach ($keys as $_key => $_value) {
				$template['power'] = $template['power'] << 1;
				if (isset($template[$_key]) && $template[$_key] == $_value) {
					$template['power'] |= 1;
				}
			}
			
			if(!empty($template['emailtemplate_condition'])){
				foreach($template['emailtemplate_condition'] as $condition){
					$template['power'] = $template['power'] << 1;
					$key = trim($condition['key']);	
											
					if(isset($this->data[$key])){
						switch(html_entity_decode($condition['operator'], ENT_COMPAT, "UTF-8")){
							case '==':
								if($this->data[$key] == $condition['value'])
									$template['power'] |= 1;
								break;						
							case '!=':
								if($this->data[$key] != $condition['value'])
									$template['power'] |= 1;
								break;						
							case '>':
								if($this->data[$key] > $condition['value'])
									$template['power'] |= 1;
								break;						
							case '<':
								if($this->data[$key] < $condition['value'])
									$template['power'] |= 1;
								break;						
							case '>=':
								if($this->data[$key] >= $condition['value'])
									$template['power'] |= 1;
								break;						
							case '<=':
								if($this->data[$key] <= $condition['value'])
									$template['power'] |= 1;
								break;						
							case 'IN':
								$haystack = explode(',', $condition['value']);
								if(is_array($haystack) && in_array($this->data[$key], $haystack))
									$template['power'] |= 1;
								break;
							case 'NOTIN':
								$haystack = explode(',', $condition['value']);
								if(is_array($haystack) && !in_array($this->data[$key], $haystack))
									$template['power'] |= 1;
								break;
						}
					}
				}
			}
		}
		unset($template);		
		$this->emailtemplate = $templates[0];
		
		foreach ($templates as $template) {
			if ($this->emailtemplate['power'] < $template['power']) {
				$this->emailtemplate = $template;
			}
		}
						
		foreach($this->emailtemplate as $key => $val){
			if (strpos($key, 'emailtemplate_') === 0 && substr($key, -3) != '_id') {
				unset($this->emailtemplate[$key]);
				$this->emailtemplate[substr($key, strlen('emailtemplate_'))] = $val;
			} else {
				$this->emailtemplate[$key] = $val;
			}
		}
		
		$this->emailtemplate_id = $this->emailtemplate['emailtemplate_id'];
		
		if($this->emailtemplate['emailtemplate_config_id']){
			$this->emailtemplate_config_id = $this->emailtemplate['emailtemplate_config_id'];
		}
				
		$descriptions = $this->model->getTemplateDescription(array(
			'emailtemplate_id' => $this->emailtemplate_id,
			'language_id' => $this->language_id
		));
		
		if(!empty($descriptions)){
			$description = $descriptions[0];
			foreach($description as $key => $val){
				if(!isset($this->emailtemplate[$key])){
					if (strpos($key, 'emailtemplate_description_') === 0 && substr($key, -3) != '_id') {
						$this->emailtemplate[substr($key, strlen('emailtemplate_description_'))] = $val;
					} else {
						$this->emailtemplate[$key] = $val;
					}
				}
			}
		}
			
		if($this->emailtemplate_config_id){
			$this->emailtemplate_config = $this->model->getConfigs(array('emailtemplate_config_id' => $this->emailtemplate['emailtemplate_config_id']));
		} else {
			$configs = $this->model->getConfigs(array('store_id' => $this->store_id));	
			
			if(count($configs) > 1){				
				foreach ($configs as &$config) {
					$config['power'] = 0;
					foreach ($keys as $_key => $_value) {
						$config['power'] = $config['power'] << 1; 
						if (!empty($config[$_key]) && $config[$_key] == $_value) {
							$config['power'] |= 1; 
						}
					}
				}
				unset($config);
				$this->emailtemplate_config = $configs[0];
				
				foreach ($configs as $config) {
					if ($this->emailtemplate_config['power'] < $config['power']) { 
						$this->emailtemplate_config = $config;
					}
				}
			}
		}	
				
		# fail-safe load main config
		if(empty($this->emailtemplate_config)){
			$this->emailtemplate_config = $this->model->getConfig(1);
		}
		
		$this->emailtemplate_config = $this->model->formatConfig($this->emailtemplate_config);
		
		$this->emailtemplate_config_id = $this->emailtemplate_config['emailtemplate_config_id'];
		
		foreach($this->emailtemplate_config as $key => $val){
			if (strpos($key, 'emailtemplate_config_') === 0 && substr($key, -3) != '_id') {
				unset($this->emailtemplate_config[$key]);
				$this->emailtemplate_config[substr($key, strlen('emailtemplate_config_'))] = $val;
			} else {
				$this->emailtemplate_config[$key] = $val;
			}
		}
		
		$config_keys = array('title', 'name', 'url', 'owner', 'address', 'email', 'telephone', 'fax');
		
		if($this->config->get('config_store_id') == $this->store_id){
			foreach($config_keys as $_key){
				$this->data['store_'.$_key] = $this->config->get('config_'.$_key);
			}
		} else {
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
		
			$this->model_setting_store = new ModelSettingStore($this->registry);
			$this->model_setting_setting = new ModelSettingSetting($this->registry);
		
			$store_info = array_merge(
				$this->model_setting_setting->getSetting("config", $this->store_id),
				$this->model_setting_store->getStore($this->store_id)
			);
		
			foreach($config_keys as $_key){
				if(isset($store_info[$_key])){
					$this->data['store_'.$_key] =  $store_info[$_key];
				} elseif(isset($store_info['config_'.$_key])){
					$this->data['store_'.$_key] =  $store_info['config_'.$_key];
				} else {
					$this->data['store_'.$_key] =  '';
				}
			}
		}
		
		if(!$this->data['store_url']){
			$this->data['store_url'] = $this->data['server']; 
		}
								
		$this->data['title'] = $this->data['store_name'];
				
		if($this->emailtemplate['wrapper_tpl']){
			$this->wrapper_tpl = $this->emailtemplate['wrapper_tpl'];
		}
		
		$this->html = null;
						
		return true;
	}
	
	/**
     * Check if template loaded
     * @return boolean
     */
    public function isLoaded()
    {
    	return (!empty($this->emailtemplate));
    }
	
	/**
     * Build template
     *
     * @return object
     */
    public function build()
    {
        if(!$this->isLoaded()) return false;
    	
    	$this->load->model('localisation/language');
        $this->model_language = new ModelLocalisationLanguage($this->registry);
        $language = $this->model_language->getLanguage($this->language_id);
        
        $oLang = new Language($language['directory']); 

        // In Admin Area
        if(defined('DIR_CATALOG')){
        	if(substr($this->emailtemplate['key'], 0, 6) == 'admin.'){
        		$dir =  DIR_LANGUAGE;
        	} else {
        		$dir = DIR_CATALOG . 'language/';
        	}
        } else {
        	if(substr($this->emailtemplate['key'], 0, 6) == 'admin.'){
        		$dir =  defined('HTTP_ADMIN') ? HTTP_ADMIN . 'language/' : substr(DIR_SYSTEM, 0, -7) . 'admin/language/';
        	} else {
        		$dir = DIR_LANGUAGE;
        	}
        }   
        $oLang->setPath($dir);
        
        $language_files = explode(',', $this->emailtemplate['language_files']);
        
        foreach($language_files as $language_file){
        	if($language_file){
        		$langData = $oLang->load(trim($language_file));
        		if(!empty($langData)){
        			$this->data = array_merge($langData, $this->data);
        		}
        	}
        }
        
        if($this->emailtemplate['shortcodes'] == 0){
        	$this->model->insertTemplateShortCodes($this->emailtemplate_id, $this->data);
        }
        
        $this->data['emailtemplate'] = $this->emailtemplate;
        $this->data['config'] = $this->emailtemplate_config;
        
        $this->data['store_id'] = $this->store_id;
        $this->data['language_id'] = $this->language_id;
        $this->data['customer_group_id'] = $this->customer_group_id;
        
        $this->data = array_merge($oLang->load($language['filename']), $this->data);
                
        $this->data['config']['theme_dir'] = $this->emailtemplate_config['theme'] . '/template/mail/';
        
        foreach(array('top','bottom','left','right') as $var){
        	$cells = '';
        	if($this->emailtemplate_config['shadow_'.$var]['start'] && $this->emailtemplate_config['shadow_'.$var]['end'] &&  $this->emailtemplate_config['shadow_'.$var]['length'] > 0){
        		$gradient = $this->_generateGradientArray($this->emailtemplate_config['shadow_'.$var]['start'], $this->emailtemplate_config['shadow_'.$var]['end'], $this->emailtemplate_config['shadow_'.$var]['length']);
        		foreach($gradient as $hex => $width){
        			switch($var){
        				case 'top':
        				case 'bottom':
        					$cells .= " <tr class='emailShadow'><td bgcolor='#{$hex}' style='background:#{$hex}; height:1px; font-size:1px; line-height:0; mso-margin-top-alt:1px' height='1'>&nbsp;</td></tr>\n";
        					break;
        				default:
        					$cells .= " <td class='emailShadow' bgcolor='#{$hex}' style='background:#{$hex}; width:{$width}px !important; font-size:1px; line-height:0; mso-margin-top-alt:1px' width='{$width}'>&nbsp;</td>\n";
        					break;
        			}
        
        			$this->data['config']['shadow_'.$var]['bg'] = $cells;
        		}
        	}
        }
                
        $this->data['config']['head_text'] = html_entity_decode($this->emailtemplate_config['head_text'], ENT_QUOTES, 'UTF-8');
        $this->data['config']['page_footer_text'] = html_entity_decode($this->emailtemplate_config['page_footer_text'], ENT_QUOTES, 'UTF-8');
        $this->data['config']['footer_text'] = html_entity_decode($this->emailtemplate_config['footer_text'], ENT_QUOTES, 'UTF-8');
        
        for($i=1; $i <= EmailTemplateDescriptionDAO::$content_count; $i++) {
        	if(!empty($this->data['emailtemplate']['content'.$i])){
        		$this->data['emailtemplate']['content'.$i] = html_entity_decode($this->data['emailtemplate']['content'.$i], ENT_QUOTES, 'UTF-8');
        	}
        }
        
        $this->data['config']['header_bg_image'] = ($this->emailtemplate_config['header_bg_image']) ? $this->model_tool_image->get($this->emailtemplate_config['header_bg_image']) : '';
        
        $this->data['config']['email_full_width'] = $this->emailtemplate_config['email_width'] + ($this->emailtemplate_config['shadow_left']['length'] + $this->emailtemplate_config['shadow_right']['length']);
        
        $this->data['config']['shadow_top']['left_img'] = ($this->emailtemplate_config['shadow_top']['left_img']) ? $this->model_tool_image->get($this->emailtemplate_config['shadow_top']['left_img']) : '';
        $this->data['config']['shadow_top']['left_img_height'] = $this->emailtemplate_config['shadow_top']['length'] + $this->emailtemplate_config['shadow_top']['overlap'];
        $this->data['config']['shadow_top']['right_img'] = ($this->emailtemplate_config['shadow_top']['right_img']) ? $this->model_tool_image->get($this->emailtemplate_config['shadow_top']['right_img']) : '';
        $this->data['config']['shadow_top']['right_img_height'] = $this->emailtemplate_config['shadow_top']['length'] + $this->emailtemplate_config['shadow_top']['overlap'];
        $this->data['config']['shadow_bottom']['left_img'] = ($this->emailtemplate_config['shadow_bottom']['left_img']) ? $this->model_tool_image->get($this->emailtemplate_config['shadow_bottom']['left_img']) : '';
        $this->data['config']['shadow_bottom']['left_img_height'] = $this->emailtemplate_config['shadow_bottom']['length'] + $this->emailtemplate_config['shadow_bottom']['overlap'];
        $this->data['config']['shadow_bottom']['right_img'] = ($this->emailtemplate_config['shadow_bottom']['right_img']) ? $this->model_tool_image->get($this->emailtemplate_config['shadow_bottom']['right_img']) : '';
        $this->data['config']['shadow_bottom']['right_img_height'] = $this->emailtemplate_config['shadow_bottom']['length'] + $this->emailtemplate_config['shadow_bottom']['overlap'];
        
        $this->data['config']['shadow_top']['left_img_width'] = $this->emailtemplate_config['shadow_left']['length'] + $this->emailtemplate_config['shadow_left']['overlap'];
        $this->data['config']['shadow_top']['right_img_width'] = $this->emailtemplate_config['shadow_right']['length'] + $this->emailtemplate_config['shadow_right']['overlap'];
        $this->data['config']['shadow_bottom']['left_img_width'] = $this->emailtemplate_config['shadow_left']['length'] + $this->emailtemplate_config['shadow_left']['overlap'];
        $this->data['config']['shadow_bottom']['right_img_width'] = $this->emailtemplate_config['shadow_right']['length'] + $this->emailtemplate_config['shadow_right']['overlap'];
        
        if($this->emailtemplate_config['logo']){
	        if($this->emailtemplate_config['logo_width'] > 0 && $this->emailtemplate_config['logo_height'] > 0){
	        	$this->data['logo'] = $this->model_tool_image->resize($this->emailtemplate_config['logo'], $this->emailtemplate_config['logo_width'], $this->emailtemplate_config['logo_height']);
	        } else {
	        	$this->data['logo'] = $this->model_tool_image->get($this->emailtemplate_config['logo']);
	        }
        } else {
        	$this->data['logo'] = $this->model_tool_image->get($this->emailtemplate_config['logo']);
        }
        
        $this->data['tracking'] = $this->getTracking();
        $this->data['store_url_tracking'] = $this->getTracking($this->data['store_url']);
                        
        if($this->emailtemplate['showcase']){
	        $this->data['showcase_selection'] = $this->model->getShowcase($this->emailtemplate_config, $this->store_id, $this->language_id);
	        if(!empty($this->data['showcase_selection'])){
	        	foreach($this->data['showcase_selection'] as &$showcase){
	        		if($showcase['url']){
	        			$showcase['url_tracking'] = $this->getTracking($showcase['url']);
	        		}
	        	}
	        	unset($showcase);
	        }
        } 
                        
        $replace = $this->_fetchShortCodes();	

        foreach($this->data as $key => $val){
        	if(is_string($val) && strpos($val, '{$') !== false){
        		$this->data[$key] = str_replace($replace['find'], $replace['replace'], $val);
        	}
        }
        foreach($this->data['emailtemplate'] as $key => $val){
        	if(is_string($val) && strpos($val, '{$') !== false){
        		$this->data['emailtemplate'][$key] = str_replace($replace['find'], $replace['replace'], $val);
        	}
        }
        foreach($this->data['config'] as $key => $val){
        	if(is_string($val) && strpos($val, '{$') !== false){
        		$this->data['config'][$key] = str_replace($replace['find'], $replace['replace'], $val);
        	}
        }
        
        return $this; 
    }
    
    /**
     * Apply email template settings to Mail object
     *
     * @param object - Mail
     * @return object
     */
    public function hook(Mail $mail)
    {
    	if(!$this->isLoaded()) return $mail;
    	
    	if(!isset($this->data['emailtemplate'])){
    		$this->build();
    	}
    	
    	if($this->data['emailtemplate']['subject']){
    		$mail->setSubject($this->data['emailtemplate']['subject']);
    	}
    	
    	if(is_null($this->html)){
    		$this->html = $this->fetch();
    	}
    	if($this->html){
    		$mail->setHtml($this->html);
    		
	    	if($this->data['emailtemplate']['plain_text']){
	    		$mail->setText($this->getPlainText($this->html));
	    	}
    	}
    	    	
    	if($this->data['emailtemplate']['mail_to'] != ""){
    		$mail->setTo($this->data['emailtemplate']['mail_to']);
    	}
    	if($this->data['emailtemplate']['mail_bcc'] != ""){
    		$mail->setBcc($this->data['emailtemplate']['mail_bcc']);
    	}
    	if($this->data['emailtemplate']['mail_cc'] != ""){
    		$mail->setCc($this->data['emailtemplate']['mail_cc']);
    	}
    	if($this->data['emailtemplate']['mail_from'] != ""){
    		$mail->setFrom($this->data['emailtemplate']['mail_from']);
    	}
    	if($this->data['emailtemplate']['mail_sender'] != ""){
    		$mail->setSender($this->data['emailtemplate']['mail_sender']);
    	}
    	if($this->data['emailtemplate']['mail_replyto'] != "" && $this->data['emailtemplate']['mail_replyto'] != $this->data['emailtemplate']['mail_to']){
    		$mail->setReplyTo($this->data['emailtemplate']['mail_replyto'], $this->data['emailtemplate']['mail_replyto_name']);
    	}
    	if($this->data['emailtemplate']['mail_attachment']){
    		$dir = substr(DIR_SYSTEM, 0, -7); // remove '/system'
    		$mail->addAttachment($dir.$this->data['emailtemplate']['mail_attachment']);
    	}
    	 
    	return $mail;
    }

	/**
	 * @param string $filename - same as 1st parameter in Template::fetch()
	 * @param string $content - if $filename is null then the content will be used as the body
	 * @returns string
	 */
	public function fetch($filename = null, $content = null, $parseHtml = true) {
		if(!$this->isLoaded()) return $mail;
		 
		if(!isset($this->data['emailtemplate'])){
			$this->build();
		}
		
		$this->html = '';
				
		if(!is_null($content)){
			$this->html = html_entity_decode($content, ENT_QUOTES, 'UTF-8');			
		} elseif(!is_null($filename)) {
			$this->html = $this->_fetchTemplate($filename);			
		} elseif(isset($this->data['emailtemplate']) && $this->data['emailtemplate']['template']){
			$this->html = $this->_fetchTemplate($this->data['emailtemplate']['template']);			
		}
		
		if(!$this->html){
			$this->html = $this->data['emailtemplate']['content1'];
		}
		
		if ($this->wrapper_tpl) {
			$wrapper = $this->_fetchTemplate($this->wrapper_tpl);			
			$this->html = str_ireplace('{CONTENT}', $this->html, $wrapper);
			
			if($parseHtml){
				$this->html = $this->_parseHtml($this->html, true);
			}
		}
		
		if($parseHtml){
			$this->html = $this->_parseHtml($this->html, ($this->wrapper_tpl));
		}
		
		return $this->html;
	}
			

	/**
	 * Send Email
	 */
	public function send($sendAdditional = false) {	
		$mail = new Mail();		
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail = $this->hook($mail);
		$mail->send();
		
		if($sendAdditional){
			$emails = explode(',', $this->config->get('config_alert_emails'));				
			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
	}
			
	/**
	 * Appends template data
	 *
	 * [code]
	 * $template->addData($my_data_array); // array
	 * $template->addData("my_value", $my_value); // key,value 
	 * $template->addData($my_data_array, 'my_data'); // array,prefix
	 *
	 * @return object
	 */
	public function addData($param1, $param2 = '')
	{
		if(is_array($param1)){
			// $param2 acts as prefix
			if($param2 != ""){
				$param2 = rtrim($param2, "_") . "_";
				foreach ($param1 as $key => $value){
					$param1[$param2.$key] = $value;
					unset($param1[$key]);
				}
			}
			$this->data = array_merge($this->data, $param1);
		} elseif(is_string($param1) && $param2 != "") {
			$this->data[$param1] = $param2;
		}
	
		return $this;
	}
					
	/**
	 * Get var
	 */
	public function getConfig($key)
	{
		if(property_exists($this, $key)){
			return $this->$key;
		} elseif(isset($this->emailtemplate[$key])){
			return $this->emailtemplate[$key];
		} elseif(isset($this->emailtemplate_config[$key])){
			return $this->emailtemplate_config[$key];
		}
		return false;
	}
				
	/**
	 * Set var
	 */
	public function setConfig($key, $val)
	{
		if(property_exists($this, $key)){
			$this->$key = $val;
		} elseif(isset($this->emailtemplate[$key])){
			$this->emailtemplate[$key] = $val;
		} elseif(isset($this->emailtemplate_config[$key])){
			$this->emailtemplate_config[$key] = $val;
		}
	}
		
	/**
	 * Get Tracking
	 */
	public function getTracking($url = null)
	{
		if(!$this->emailtemplate_config['tracking']) return $url;
		
		if(!isset($this->data['tracking'])){
			$tracking = array();
			$tracking['utm_campaign'] = $this->emailtemplate_config['tracking_campaign_name'];
			$tracking['utm_medium'] = 'email';
			if($this->emailtemplate_config['tracking_campaign_term']){
				$tracking['utm_term'] = $this->emailtemplate_config['tracking_campaign_term'];
			}
			if($this->emailtemplate['tracking_campaign_source']){
				$tracking['utm_source'] = $this->emailtemplate['tracking_campaign_source'];
			} else {
				$tracking['utm_source'] = isset($this->request->get['route']) ? $this->request->get['route'] : '';
			}
			$this->data['tracking'] = http_build_query($tracking);
		}
                
        if($url){
        	return $url . (strpos($url, '?') === false ? '?' : '&amp;') . $this->data['tracking'];	
        } else {
        	return $this->data['tracking'];
        }
	}
	
	/******************************************************************************
	 * Copyright (c) 2010 Jevon Wright and others.
	* All rights reserved. This program and the accompanying materials
	* are made available under the terms of the Eclipse Public License v1.0
	* which accompanies this distribution, and is available at
	* http://www.eclipse.org/legal/epl-v10.html
	*
	* Contributors:
	*    Jevon Wright - initial API and implementation
	****************************************************************************/	
	/**
	 * Tries to convert the given HTML into a plain text format - best suited for
	* e-mail display, etc.
	*
	* <p>In particular, it tries to maintain the following features:
	* <ul>
	*   <li>Links are maintained, with the 'href' copied over
	*   <li>Information in the &lt;head&gt; is lost
	* </ul>
	*
	* @param html the input HTML
	* @return the HTML converted, as best as possible, to text
	*/
	public function getPlainText($html = null)
	{
		if(is_null($html)){
			$html = $this->html;
		}

		$html = fix_newlines($html);
		
		$doc = new DOMDocument();
		if (!$doc->loadHTML($html))
			throw new Html2TextException("Could not load HTML - badly formed?", $html);
		
		$output = iterate_over_node($doc->getElementById('emailPage'));
		
		// remove leading and trailing spaces on each line
		$output = preg_replace("/[ \t]*\n[ \t]*/im", "\n", $output);
		
		// remove leading and trailing whitespace
		$output = trim($output);
		
		return $output;
	}
	
	/**
	 * Get CSS File
	 */
	public function fetchCss()
	{		
		if($this->css === null){
			$themePath = (defined('DIR_CATALOG') ? DIR_CATALOG : DIR_APPLICATION) . 'view/theme/';
				
			foreach(array(
				$themePath.$this->emailtemplate_config['theme'].'/stylesheet/module/email_template.php.css',
				$themePath.'default/stylesheet/email_template.php.css',
				DIR_SYSTEM.'library/emailtemplate/email_template.php.css'
			) as $cssPath){
				if(file_exists($cssPath)) {
					
					extract($this->data);
					
					ob_start();
					
					include($cssPath);
					
					$this->css = ob_get_contents();
					
					ob_end_clean();
		
					//preg_replace('#/\*.*?\*/#s', '', $css);
					//preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
					//preg_replace('/\s\s+(.*)/', '$1', $css);
					//str_replace(';}', '}', $css);
		
					break;
				}
			}
		}
	
		return $this->css;
	}
	
	/**
	 * Get Template Path
	 */
	protected function _getTemplatePath($file)
	{
		if(defined('DIR_CATALOG')){
			if(file_exists(DIR_TEMPLATE.'mail/'.$file)){
				$path = DIR_TEMPLATE.'mail/';
			} elseif(file_exists(DIR_CATALOG.'view/theme/'.$this->emailtemplate_config['theme'].'/template/mail/'.$file)) {
				$path = DIR_CATALOG.'view/theme/'.$this->emailtemplate_config['theme'].'/template/mail/';
			} else {
				$path = DIR_CATALOG.'view/theme/default/template/mail/';
			}
		} else {
			if(file_exists(DIR_TEMPLATE.$this->emailtemplate_config['theme'].'/template/mail/'.$file)) {
				$path = DIR_TEMPLATE.$this->emailtemplate_config['theme'].'/template/mail/';
			} else {
				$path = DIR_TEMPLATE.'default/template/mail/';
			}
		}
	
		return $path;
	}
	
	/**
	 * Get Email Wrapper Filename
	 *
	 * @param string - filename
	 * @return object - EmailTemplate
	 */
	private function _fetchTemplate($file)
	{
		$path = $this->_getTemplatePath($file);
	
		if ($file && is_file($path.$file)) {
			extract($this->data);
	
			ob_start();
	
			include(VQMod::modCheck($path.$file));
	
			$content = ob_get_contents();
	
			ob_end_clean();
	
			return $content;
		} else {
			trigger_error('Error: Could not load template: ' .$file . ', in: '. $path);
			exit();
		}
	}
	
	/**
	 * Generate array of hex values for shadow
	 * @param $from - HEX colour from
	 * @param $until - HEX colour from
	 * @param $length - distance of shadow
	 * @return Array(hex=>width)
	 */
	private function _generateGradientArray($from, $until, $length){
	$from = ltrim($from,'#');
		$until = ltrim($until,'#');
		$from = array(hexdec(substr($from,0,2)),hexdec(substr($from,2,2)),hexdec(substr($from,4,2)));
		$until = array(hexdec(substr($until,0,2)),hexdec(substr($until,2,2)),hexdec(substr($until,4,2)));
		
		if($length > 1){
			$red=($until[0]-$from[0])/($length-1);
			$green=($until[1]-$from[1])/($length-1);
			$blue=($until[2]-$from[2])/($length-1);
			$return = array();
	
			for($i=0;$i<$length;$i++){
				$newred=dechex($from[0]+round($i*$red));
				if(strlen($newred)<2) $newred="0".$newred;
	
				$newgreen=dechex($from[1]+round($i*$green));
				if(strlen($newgreen)<2) $newgreen="0".$newgreen;
	
				$newblue=dechex($from[2]+round($i*$blue));
				if(strlen($newblue)<2) $newblue="0".$newblue;
	
				$hex = $newred.$newgreen.$newblue;
				if(isset($return[$hex])){
					$return[$hex] ++;
				} else {
					$return[$hex] = 1;
				}
			}
			return $return;
		} else {
			$red=($until[0]-$from[0]);
			$green=($until[1]-$from[1]);
			$blue=($until[2]-$from[2]);
			
			$newred=dechex($from[0]+round($red));
			if(strlen($newred)<2) $newred="0".$newred;
			
			$newgreen=dechex($from[1]+round($green));
			if(strlen($newgreen)<2) $newgreen="0".$newgreen;
			
			$newblue=dechex($from[2]+round($blue));
			if(strlen($newblue)<2) $newblue="0".$newblue;
			
			return array($newred.$newgreen.$newblue => $length);
		}
		
	}
		
	/**
	 * Method parses add inline CSS styles
	 *
	 * @param string $html
	 * @param bool - does the HTML have a valid doc type?
	 * @return string $html
	 */
	private function _parseHtml($html, $hasDocType = true)
	{	
		if($this->isLoaded()){
			$replace = $this->_fetchShortCodes();							
			$html = str_replace($replace['find'], $replace['replace'], $html);
		}
				
		if($hasDocType === false){
			$html  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Email Template</title></head><body>' . $html . '</body></html>';
		}
		
		$this->fetchCss();
		if($this->css && $html){
			require_once DIR_SYSTEM . 'library/shared/CssToInlineStyles/CssToInlineStyles.php';
			$cssToInlineStyles = new CssToInlineStyles();
			$cssToInlineStyles->setCSS($this->css);
			$cssToInlineStyles->setHTML($html);
			$html = $cssToInlineStyles->convert();
			//$html = str_ireplace('{CSS}', $this->css, $html);
		}
	
		if($hasDocType === false){
			$dom = new DOMDocument('1.0', 'UTF-8');
			$dom->loadHTML($html);
	
			$oWrapper = $dom->getElementsByTagName('body')->item(0);
			$html = '';
			foreach($oWrapper->childNodes as $node) {
				$html .= $dom->saveXml($node);
			}
		}
				
		return $html;
	}
		
	/**
	 *  
	 */
	private function _fetchShortCodes()
	{
		$find = array();
		$replace = array();
			
		foreach($this->data as $key => $var){
			if(is_array($var)){
				foreach($var as $key2 => $var2){
					if(is_string($var2) || is_int($var2)){
						$find[] = '{$'.$key.'.'.$key2.'}';
						$replace[] = $var2;
					}
				}
			} elseif(is_string($var) || is_int($var)){				
				$find[] = '{$'.$key.'}';
				$replace[] = $var;				
			} 			
		}
		
		return array('find' => $find, 'replace' => $replace);
	}
			 
	/**
	  * Format Address
	  */
	public static function formatAddress($address, $address_prefix = '', $format = null)
	{
		$find = array();
		$replace = array();
		if($address_prefix != ""){
	 		$address_prefix = trim($address_prefix, '_') . '_';
		}
	 	if (is_null($format) || $format == '') {
	 		$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
	 	}
	 	$vars = array(
	 		'firstname',
	 		'lastname',
	 		'company',
	 		'address_1',
	 		'address_2',
	 		'city',
	 		'postcode',
	 		'zone',
	 		'zone_code',
	 		'country'
	 	);
	 	foreach($vars as $var){
	 		$find[$var] = '{'.$var.'}';
	 		if(isset($address[$address_prefix.$var])){
	 			$replace[$var] =  $address[$address_prefix.$var];
	 		} elseif(isset($address[$var])){
	 			$replace[$var] =  $address[$var];
	 		} else {
	 			$replace[$var] =  '';
	 		}
	 	}
	 	return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
	}
	 
	public static function truncate_str($str, $length = 100, $breakWords = true, $append = '...') {
		$strLength = mb_strlen($str);
		
		if ($strLength <= $length) {
			return $str;
		}
		
		if (!$breakWords) {
			while ($length < $strLength AND preg_match('/^\pL$/', mb_substr($str, $length, 1))) {
				$length++;
			}
		}
		
		return mb_substr($str, 0, $length) . $append;
	}
}


/**
 * Data Access Object - Abstract
 */
abstract class EmailTemplateAbstract
{
	/**
	 * Data Types
	 */
	const INT = "INT";
	const TEXT = "TEXT";
	const SERIALIZE = "SERIALIZE";
	const CHECKBOX = "CHECKBOX";
	const FLOAT = "FLOAT";
	const DATE_NOW = "DATE_NOW";

	/**
	 * Filter from array, by unsetting element(s)
	 * @param string/array $filter - match array key
	 * @param array to be filtered
	 * @return array
	*/
	protected static function filterArray($filter, $array)
	{
		if($filter === null) return $array;

		if(is_array($filter)){
			foreach($filter as $f){
				unset($array[$f]);
			}
		} else {
			unset($array[$filter]);
		}

		return $array;
	}

}

/**
 * Email Templates `emailtemplate`
 */
class EmailTemplateDAO extends EmailTemplateAbstract
{	
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateDAOAbstract::describe()
	 */
	public static function describe()
	{
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_id' => EmailTemplateAbstract::INT,
			'emailtemplate_key' => EmailTemplateAbstract::TEXT,
			'emailtemplate_label' => EmailTemplateAbstract::TEXT,
			'emailtemplate_template' => EmailTemplateAbstract::TEXT,
			'emailtemplate_type' => EmailTemplateAbstract::TEXT,
			'emailtemplate_vqmod' => EmailTemplateAbstract::TEXT,
			'emailtemplate_modified' => EmailTemplateAbstract::DATE_NOW,
			'emailtemplate_mail_attachment' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_to' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_cc' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_bcc' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_from' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_sender' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_replyto' => EmailTemplateAbstract::TEXT,
			'emailtemplate_mail_replyto_name' => EmailTemplateAbstract::TEXT,
			'emailtemplate_language_files' => EmailTemplateAbstract::TEXT,
			'emailtemplate_wrapper_tpl' => EmailTemplateAbstract::TEXT,
			'emailtemplate_tracking_campaign_source' => EmailTemplateAbstract::TEXT,
			'emailtemplate_default' => EmailTemplateAbstract::INT,
			'emailtemplate_status' => EmailTemplateAbstract::TEXT,
			'emailtemplate_shortcodes' => EmailTemplateAbstract::INT,
			'emailtemplate_showcase' => EmailTemplateAbstract::INT,
			'emailtemplate_plain_text' => EmailTemplateAbstract::INT,
			'emailtemplate_condition' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_id' => EmailTemplateAbstract::INT,
			'store_id' => EmailTemplateAbstract::INT,
			'customer_group_id' => EmailTemplateAbstract::INT
		);
		
		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}

/**
 * Email Templates `emailtemplate_description`
 */
class EmailTemplateDescriptionDAO extends EmailTemplateAbstract
{
	public static $content_count = 3;
	
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateDAOAbstract::describe()
	 */
	public static function describe()
	{
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_id' => EmailTemplateAbstract::INT,
			'language_id' => EmailTemplateAbstract::INT,
			'emailtemplate_description_subject' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_preview' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_content1' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_content2' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_content3' => EmailTemplateAbstract::TEXT,
			'emailtemplate_description_modified' => EmailTemplateAbstract::TEXT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}

/**
 * Email Templates `emailtemplate_shortcode`
 */
class EmailTemplateShortCodesDAO extends EmailTemplateAbstract
{
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateDAOAbstract::describe()
	 */
	public static function describe()
	{
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_shortcode_id' => EmailTemplateAbstract::INT,
			'emailtemplate_shortcode_code' => EmailTemplateAbstract::TEXT,
			'emailtemplate_shortcode_type' => EmailTemplateAbstract::TEXT,
			'emailtemplate_shortcode_example' => EmailTemplateAbstract::TEXT,
			'emailtemplate_id' => EmailTemplateAbstract::INT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}

/**
 * Config `emailtemplate_config`
 */
class EmailTemplateConfigDAO extends EmailTemplateAbstract
{
	/**
	 * Columns & Data Types.
	 * @see EmailTemplateAbstract::describe()
	 */
	public static function describe()
	{
		$filter = func_get_args();
		$cols = array(
			'emailtemplate_config_id' => EmailTemplateAbstract::INT,
			'emailtemplate_config_name' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_email_width' => EmailTemplateAbstract::INT,
			'emailtemplate_config_page_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_font_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_link_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_heading_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_body_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_footer_text' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_text' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_valign' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_font_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_footer_height' => EmailTemplateAbstract::INT,
			'emailtemplate_config_footer_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_bg_image' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_height' => EmailTemplateAbstract::INT,
			'emailtemplate_config_header_border_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_header_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_head_text' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_head_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_invoice_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_invoice_download' => EmailTemplateAbstract::INT,
			'emailtemplate_config_invoice_heading_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_invoice_logo' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_invoice_logo_width' => EmailTemplateAbstract::INT,
			'emailtemplate_config_invoice_products_limit' => EmailTemplateAbstract::INT,
			'emailtemplate_config_invoice_text' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_invoice_title' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_font_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_font_size' => EmailTemplateAbstract::INT,
			'emailtemplate_config_logo_height' => EmailTemplateAbstract::INT,
			'emailtemplate_config_logo_valign' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_logo_width' => EmailTemplateAbstract::INT,
			'emailtemplate_config_shadow_top' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_shadow_left' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_shadow_right' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_shadow_bottom' => EmailTemplateAbstract::SERIALIZE,
			'emailtemplate_config_showcase' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_limit' => EmailTemplateAbstract::INT,
			'emailtemplate_config_showcase_selection' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_title' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_showcase_section_bg_color' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_text_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_page_align' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_tracking' => EmailTemplateAbstract::INT,
			'emailtemplate_config_tracking_campaign_name' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_tracking_campaign_term' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_theme' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_style' => EmailTemplateAbstract::TEXT,
			'emailtemplate_config_status' => EmailTemplateAbstract::TEXT,
			'customer_group_id' => EmailTemplateAbstract::INT,
			'language_id' => EmailTemplateAbstract::INT,
			'store_id' => EmailTemplateAbstract::INT
		);

		return (!$filter)? $cols : self::filterArray($filter, $cols);
	}
}


/**
 * Unify newlines; in particular, \r\n becomes \n, and
 * then \r becomes \n. This means that all newlines (Unix, Windows, Mac)
 * all become \ns.
 *
 * @param text text with any number of \r, \r\n and \n combinations
 * @return the fixed text
 */
function fix_newlines($text) {
	// replace \r\n to \n
	$text = str_replace("\r\n", "\n", $text);
	// remove \rs
	$text = str_replace("\r", "\n", $text);

	return $text;
}

function next_child_name($node) {
	// get the next child
	$nextNode = $node->nextSibling;
	while ($nextNode != null) {
		if ($nextNode instanceof DOMElement) {
			break;
		}
		$nextNode = $nextNode->nextSibling;
	}
	$nextName = null;
	if ($nextNode instanceof DOMElement && $nextNode != null) {
		$nextName = strtolower($nextNode->nodeName);
	}

	return $nextName;
}
function prev_child_name($node) {
	// get the previous child
	$nextNode = $node->previousSibling;
	while ($nextNode != null) {
		if ($nextNode instanceof DOMElement) {
			break;
		}
		$nextNode = $nextNode->previousSibling;
	}
	$nextName = null;
	if ($nextNode instanceof DOMElement && $nextNode != null) {
		$nextName = strtolower($nextNode->nodeName);
	}

	return $nextName;
}

function iterate_over_node($node) {
	if ($node instanceof DOMText) {
		return preg_replace("/\\s+/im", " ", $node->wholeText);
	}
	if ($node instanceof DOMDocumentType) {
		// ignore
		return "";
	}

	$nextName = next_child_name($node);
	$prevName = prev_child_name($node);

	$name = strtolower($node->nodeName);

	// start whitespace
	switch ($name) {
		case "hr":
			return "------\n";

		case "style":
		case "head":
		case "title":
		case "meta":
		case "script":
			// ignore these tags
			return "";

		case "h1":
		case "h2":
		case "h3":
		case "h4":
		case "h5":
		case "h6":
			// add two newlines
			$output = "\n";
			break;

		case "p":
		case "div":
			// add one line
			$output = "\n";
			break;

		default:
			// print out contents of unknown tags
			$output = "";
			break;
	}

	// debug $output .= "[$name,$nextName]";

	if($node->childNodes){
		for ($i = 0; $i < $node->childNodes->length; $i++) {
			$n = $node->childNodes->item($i);

			$text = iterate_over_node($n);

			$output .= $text;
		}
	}

	// end whitespace
	switch ($name) {
		case "style":
		case "head":
		case "title":
		case "meta":
		case "script":
			// ignore these tags
			return "";

		case "h1":
		case "h2":
		case "h3":
		case "h4":
		case "h5":
		case "h6":
			$output .= "\n";
			break;

		case "p":
		case "br":
			// add one line
			if ($nextName != "div")
				$output .= "\n";
			break;

		case "div":
			// add one line only if the next child isn't a div
			if ($nextName != "div" && $nextName != null)
				$output .= "\n";
			break;

		case "a":
			// links are returned in [text](link) format
			$href = $node->getAttribute("href");
			if ($href == null) {
				// it doesn't link anywhere
				if ($node->getAttribute("name") != null) {
					$output = "$output";
				}
			} else {
				if ($href == $output) {
					// link to the same address: just use link
					$output;
				} else {
					// replace it
					$output = "$output ($href)";
				}
			}

			// does the next node require additional whitespace?
			switch ($nextName) {
				case "h1": case "h2": case "h3": case "h4": case "h5": case "h6":
					$output .= "\n";
					break;
			}

		default:
			// do nothing
	}

	return $output;
}

class Html2TextException extends Exception {
	var $more_info;

	public function __construct($message = "", $more_info = "") {
		parent::__construct($message);
		$this->more_info = $more_info;
	}
}

?>