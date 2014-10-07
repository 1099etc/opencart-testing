<?php echo $header; ?>

<link href="view/stylesheet/module/emailtemplate.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/codemirror/codemirror.css" type="text/css" rel="stylesheet" />

<div id="content">
	<div class="breadcrumb">
 	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
  		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  	<?php } ?>
	</div>

	<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
	<?php if ($error_attention) { ?><div class="attention"><?php echo $error_attention; ?></div><?php } ?>
	<?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>

	<div class="box" id="emailtemplate">		
		<div class="heading">
			<h1><img src="view/image/mail.png" alt="" /><?php echo $heading_template .  ($emailtemplate['label'] ? (': '.  $emailtemplate['label']) : ''); ?></h1>
			
			<div class="buttons">
				<?php if(isset($insertMode)){ ?>
					<a id="submitButton" href="javascript:void(0)" onclick="$('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><span><?php echo $button_create; ?></span></a>
					<span style="width:1px; height:24px; background:#e2e2e2; border-right:1px solid #fff; border-left:1px solid #fff; display:inline-block; *display:inline; zoom:1; line-height:0; vertical-align:top; margin: 0 1px 0 2px;"></span>
				<?php } else { ?>
					<a id="submitButton" href="javascript:void(0)" onclick="$('#form').attr('action', '<?php echo $action; ?>'); $('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a>
					<?php if(isset($action_delete)){ ?><a href="javascript:void(0)" onclick="$('#form').attr('action', '<?php echo $action_delete; ?>'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a><?php } ?>
					<span style="width:1px; height:24px; background:#e2e2e2; border-right:1px solid #fff; border-left:1px solid #fff; display:inline-block; *display:inline; zoom:1; line-height:0; vertical-align:top; margin: 0 1px 0 2px;"></span>	
					<a href="<?php echo $new_template; ?>" class="button button-secondary"><span><?php echo $button_insert_template; ?></span></a>
				<?php }?>
				<a href="<?php echo $cancel; ?>" class="button button-secondary"><span><?php echo $button_back; ?></span></a>
			</div>
			
			<div style="font-size: 11px; float: right; margin: 12px 10px 0 0;">
				<?php if($emailtemplate['modified']){ ?>
					<?php echo $text_modified . ': <i>' . $emailtemplate['modified'].'</i>'; ?>
				<?php } ?>
			</div>
		</div>
	
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" style="position:relative">				
				<?php if(isset($vqmod_xml)): ?>
					<p class="error"><?php echo $error_vqmod_xml; ?></p>
					<textarea style="width:100%; height: 150px;"><?php echo $vqmod_xml; ?></textarea>				
				<?php endif;?>
				
				<div class="tabsHolder">
	    			<div class="vtabs tabs-nav" id="settings-tab">
	    				<a href="#tab-setting"><?php echo $heading_settings; ?></a>
	    				<a href="#tab-mail"><?php echo $heading_mail; ?></a>
	    				<?php if (!empty($shortcodes)) { ?><a href="#tab-shortcodes"><?php echo $heading_shortcodes; ?></a><?php } ?>
	    				<?php if($emailtemplate['default'] == 1){ ?><a href="#tab-vqmod"><?php echo $heading_vqmod; ?></a><?php } ?>
	    			</div>
	    		
	    			<div id="tab-setting" class="vtabs-content">
	    				<table class="form">
	    					<tr>
								<td>
									<label for="emailtemplate_type"><span class="required">*</span> <?php echo $entry_type; ?></label>
								</td>
								<td>
									<select name="emailtemplate_type" id="emailtemplate_type">
										<?php foreach($emailtemplate_types as $value => $label): ?>
										<option value="<?php echo $value; ?>"<?php echo ($emailtemplate['type'] == $value) ? 'selected="selected"' : ''; ?>><?php echo $label; ?></option>
										<?php endforeach; ?>
									</select>
									<?php if(isset($error_emailtemplate_type)) { ?><span class="error"><?php echo $error_emailtemplate_type; ?></span><?php } ?>
								</td>
							</tr>
	    					<tr data-field="key" style="display:none">
								<td>
									<label for="emailtemplate_key"><span class="required">*</span> <?php echo $entry_key; ?></label>
								</td>
								<td>
									<?php if(!empty($emailtemplate_keys)): ?>
									<select class="large" name="emailtemplate_key_select" id="emailtemplate_key_select">
										<option value="">- - - <?php echo $text_custom; ?> - - -</option>
										<?php foreach($emailtemplate_keys as $row): ?>
											<option value="<?php echo $row['value']; ?>"<?php if($emailtemplate['key'] == $row['value'] || $emailtemplate['key_select'] == $row['value']) echo ' selected="selected"'; ?>><?php echo $row['label']; ?></option>
										<?php endforeach; ?>
									</select>
									<?php endif; ?>
									
									<input class="large" type="text" name="emailtemplate_key" value="<?php echo $emailtemplate['key']; ?>" id="emailtemplate_key" />
									<?php if(isset($error_emailtemplate_key)) { ?><span class="error"><?php echo $error_emailtemplate_key; ?></span><?php } ?>
								</td>
							</tr>
																												
							<?php if(isset($emailtemplate['template'])){ ?>
	    					<tr data-field="template" style="display:none">
								<td>
									<label for="emailtemplate_template"><?php echo $entry_template; ?></label>
								</td>
								<td>
									<select name="emailtemplate_template" id="emailtemplate_template" class="large">
										<option value="">- - - <?php echo $text_none; ?> - - -</option>
										<?php if(!empty($emailtemplate_files['catalog'])): ?>
										<optgroup label="<?php echo $emailtemplate_files['dirs']['catalog']; ?>" data-type="catalog">
											<?php foreach($emailtemplate_files['catalog'] as $file): ?>
												<option value="<?php echo $file; ?>" <?php echo ($emailtemplate['template'] == $file) ? 'selected="selected"' : ''; ?>><?php echo $file; ?></option>
											<?php endforeach; ?>
										</optgroup>
										<?php endif; ?>
										
										<?php if(!empty($emailtemplate_files['catalog_default'])): ?>
										<optgroup label="<?php echo $emailtemplate_files['dirs']['catalog_default']; ?>" data-type="catalog">
											<?php foreach($emailtemplate_files['catalog_default'] as $file): ?>
												<option value="<?php echo $file; ?>" <?php echo ($emailtemplate['template'] == $file) ? 'selected="selected"' : ''; ?>><?php echo str_replace($emailtemplate_files['dirs']['catalog_default'], '', $file); ?></option>
											<?php endforeach; ?>
										</optgroup>
										<?php endif; ?>
										
										<?php if(!empty($emailtemplate_files['admin'])): ?>
										<optgroup label="<?php echo $emailtemplate_files['dirs']['admin']; ?>" data-type="admin">
											<?php foreach($emailtemplate_files['admin'] as $file): ?>
												<option value="<?php echo $file; ?>" <?php echo ($emailtemplate['template'] == $file) ? 'selected="selected"' : ''; ?>><?php echo str_replace($emailtemplate_files['dirs']['admin'], '', $file); ?></option>
											<?php endforeach; ?>
										</optgroup>
										<?php endif; ?>
									</select>
									<?php if(isset($error_emailtemplate_template)) { ?><span class="error"><?php echo $error_emailtemplate_template; ?></span><?php } ?>
								</td>
							</tr>
							<?php } ?>
							
							<?php if(!empty($emailtemplate_configs)){ ?>
							<tr>
								<td>
									<label for="emailtemplate_config_id"><?php echo $entry_email_config; ?></label>
								</td>
								<td>
									<select name="emailtemplate_config_id" id="emailtemplate_config_id">
										<option value="0"><?php echo $text_select; ?></option>
										<?php foreach($emailtemplate_configs as $row): ?>
										<option value="<?php echo $row['emailtemplate_config_id']; ?>"<?php echo ($emailtemplate['emailtemplate_config_id'] == $row['emailtemplate_config_id']) ? 'selected="selected"' : ''; ?>><?php echo $row['name']; ?></option>
										<?php endforeach; ?>
									</select>
									<?php if(isset($error_emailtemplate_config_id)) { ?><span class="error"><?php echo $error_emailtemplate_config_id; ?></span><?php } ?>
								</td>
							</tr>
							<?php } ?>
							
							<tr data-field="language_files" style="display:none">
								<td>
									<label for="emailtemplate_language_files"><?php echo $entry_language_files; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_language_files" value="<?php echo $emailtemplate['language_files']; ?>" id="emailtemplate_language_files" />
									<?php if(isset($error_emailtemplate_language_files)) { ?><span class="error"><?php echo $error_emailtemplate_language_files; ?></span><?php } ?>
								</td>
							</tr>
							
							<tr>
								<td>
									<label for="emailtemplate_label"><?php echo $entry_label; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_label" value="<?php echo $emailtemplate['label']; ?>" id="emailtemplate_label" />
									<?php if(isset($error_emailtemplate_label)) { ?><span class="error"><?php echo $error_emailtemplate_label; ?></span><?php } ?>
								</td>
							</tr>
														
							<tr>
								<td>
									<label for="emailtemplate_status"><span class="required">*</span> <?php echo $entry_status; ?></label>
								</td>
								<td>
									<label class="radio">
										<input type="radio" name="emailtemplate_status" value="ENABLED" <?php echo ($emailtemplate['status'] == '' || $emailtemplate['status'] == 'ENABLED') ? 'checked="checked"' : ''; ?>/>
										<?php echo $text_enabled; ?>
									</label>
									<label class="radio">
										<input type="radio" name="emailtemplate_status" value="DISABLED" <?php echo ($emailtemplate['status'] == 'DISABLED') ? 'checked="checked"' : ''; ?>/>
										<?php echo $text_disabled; ?>
									</label>
									
									<?php if(isset($error_emailtemplate_status)) { ?><span class="error"><?php echo $error_emailtemplate_status; ?></span><?php } ?>
								</td>
							</tr>
														
							<tr>
								<td>
									<label for="emailtemplate_shortcodes"> <?php echo $entry_shortcodes; ?></label>
								</td>
								<td>
									<label class="radio">
										<input type="radio" name="emailtemplate_shortcodes" value="1" <?php echo ($emailtemplate['shortcodes'] == 1) ? 'checked="checked"' : ''; ?>/>
										<?php echo $text_complete; ?>
									</label>
									<label class="radio">
										<input type="radio" name="emailtemplate_shortcodes" value="0" <?php echo ($emailtemplate['shortcodes'] == 0) ? 'checked="checked"' : ''; ?>/>
										<?php echo $text_pending; ?>
									</label>
																		
									<?php if(isset($error_emailtemplate_shortcodes)) { ?><span class="error"><?php echo $error_emailtemplate_shortcodes; ?></span><?php } ?>
								</td>
							</tr>
						</table>
						
						<?php if($emailtemplate['default'] == 0 && (isset($insertMode) || $emailtemplate['type'] == 'standard')): ?>
						<div id="table-options">
							<h2><?php echo $heading_conditions; ?></h2>
							<table class="form">
								<?php if(!empty($stores)){ ?>
								<tr>
									<td><label for="store_id"><?php echo $entry_store; ?></label></td>
									<td>
										<select name="store_id" id="store_id">
											<option value="NULL">--- <?php echo $text_all; ?> ---</option>
											<?php foreach($stores as $store){ ?>
											<option value="<?php echo $store['store_id']; ?>"<?php if($emailtemplate['store_id'] == $store['store_id'] && is_numeric($emailtemplate['store_id'])) echo ' selected="selected"'; ?>><?php echo $store['store_name']; ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
								
								<?php if(!empty($customer_groups)){ ?>
								<tr>
									<td><label for="customer_group_id"><?php echo $entry_customer_group; ?></label></td>
									<td>
										<select name="customer_group_id" id="customer_group_id">
											<option value="">--- <?php echo $text_all; ?> ---</option>
											<?php foreach($customer_groups as $customer_group){ ?>
											<option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if($emailtemplate['customer_group_id'] == $customer_group['customer_group_id']) echo ' selected="selected"'; ?>><?php echo $customer_group['name']; ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
								
								<?php if(!empty($emailtemplate_shortcodes)){ ?>
									<tr>
										<td><label><?php echo $entry_condition; ?></label></td>
										<td>
											<select id="condition_add_select">
												<option value=""><?php echo $text_select; ?></option>
												<?php foreach($emailtemplate_shortcodes as $item){ ?>
													<?php if(substr($item['code'], 0, 5) == 'text_' ||
															 substr($item['code'], 0, 7) == 'button_' || 
															 substr($item['code'], 0, 6) == 'error_' || 
															 substr($item['code'], 0, 6) == 'entry_') continue; ?>
													<option><?php echo $item['code']; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
											<table id="emailtemplate_conditions">
												<tbody>
													<?php if(!empty($emailtemplate['condition'])){ ?>
													<?php foreach($emailtemplate['condition'] as $i => $condition){ ?>
													<tr data-count="<?php echo $i; ?>">
														<td><input type="text" name="emailtemplate_condition[<?php echo $i; ?>][key]" value="<?php echo $condition['key']; ?>" /></td>										
														<td>
															<select name="emailtemplate_condition[<?php echo $i; ?>][operator]">
																<option value="=="<?php if($condition['operator'] == '==') echo ' selected="selected"'; ?>>(==) Equal</option>
																<option value="!="<?php if($condition['operator'] == '!=') echo ' selected="selected"'; ?>>(!=) &nbsp;Not Equal</option>
																<option value="&gt;"<?php if($condition['operator'] == '&gt;') echo ' selected="selected"'; ?>>(&gt;) &nbsp;&nbsp;Greater than</option>
																<option value="&lt;"<?php if($condition['operator'] == '&lt;') echo ' selected="selected"'; ?>>(&lt;) &nbsp;&nbsp;Less than</option>
																<option value="&gt;="<?php if($condition['operator'] == '&gt;=') echo ' selected="selected"'; ?>>(&gt;=) Greater than or equal to </option>
																<option value="&lt;="<?php if($condition['operator'] == '&lt;=') echo ' selected="selected"'; ?>>(&lt;=) Less than or equal to </option>
																<option value="IN"<?php if($condition['operator'] == 'IN') echo ' selected="selected"'; ?>>(IN) Checks if a value exists in comma-delimited string </option>
																<option value="NOTIN"<?php if($condition['operator'] == 'NOTIN') echo ' selected="selected"'; ?>>(NOTIN) Checks if a value does not exist in comma-delimited string </option>
															</select>
														</td>
														<td><input type="text" name="emailtemplate_condition[<?php echo $i; ?>][value]" value="<?php echo $condition['value']; ?>" placeholder="Value" /></td>
														<td><a class="button" onclick="$(this).parents('tr').eq(0).remove()"><?php echo $button_delete; ?></a></td>
													</tr>
													<?php } ?>
													<?php } ?>
												</tbody>
											</table>
										</td>								
									</tr>
								<?php } ?>
							</table>
						</div>
						<?php endif; ?>
					</div>
					
					<div id="tab-mail" class="vtabs-content">
						<table class="form">
	    					<tr>
								<td>
									<label for="emailtemplate_mail_to"><?php echo $entry_mail_to; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_to" value="<?php echo $emailtemplate['mail_to']; ?>" id="emailtemplate_mail_to" />
									<?php if(isset($error_emailtemplate_mail_to)) { ?><span class="error"><?php echo $error_emailtemplate_mail_to; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_from"><?php echo $entry_mail_from; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_from" value="<?php echo $emailtemplate['mail_from']; ?>" id="emailtemplate_mail_from" />
									<?php if(isset($error_emailtemplate_mail_from)) { ?><span class="error"><?php echo $error_emailtemplate_mail_from; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_sender"><?php echo $entry_mail_sender; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_sender" value="<?php echo $emailtemplate['mail_sender']; ?>" id="emailtemplate_mail_sender" />
									<?php if(isset($error_emailtemplate_mail_sender)) { ?><span class="error"><?php echo $error_emailtemplate_mail_sender; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_replyto"><?php echo $entry_mail_replyto; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_replyto" value="<?php echo $emailtemplate['mail_replyto']; ?>" id="emailtemplate_mail_replyto" />
									<?php if(isset($error_emailtemplate_mail_replyto)) { ?><span class="error"><?php echo $error_emailtemplate_mail_replyto; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_replyto_name"><?php echo $entry_mail_replyto_name; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_replyto_name" value="<?php echo $emailtemplate['mail_replyto_name']; ?>" id="emailtemplate_mail_replyto_name" />
									<?php if(isset($error_emailtemplate_mail_replyto_name)) { ?><span class="error"><?php echo $error_emailtemplate_mail_replyto_name; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_cc"><?php echo $entry_mail_cc; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_cc" value="<?php echo $emailtemplate['mail_cc']; ?>" id="emailtemplate_mail_cc" />
									<?php if(isset($error_emailtemplate_mail_cc)) { ?><span class="error"><?php echo $error_emailtemplate_mail_cc; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_bcc"><?php echo $entry_mail_bcc; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_bcc" value="<?php echo $emailtemplate['mail_bcc']; ?>" id="emailtemplate_mail_bcc" />
									<?php if(isset($error_emailtemplate_mail_bcc)) { ?><span class="error"><?php echo $error_emailtemplate_mail_bcc; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_mail_attachment"><?php echo $entry_mail_attachment; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_mail_attachment" value="<?php echo $emailtemplate['mail_attachment']; ?>" id="emailtemplate_mail_attachment" />
									<?php if(isset($error_emailtemplate_mail_attachment)) { ?><span class="error"><?php echo $error_emailtemplate_mail_attachment; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_plain_text"><?php echo $entry_plain_text; ?></label>
								</td>
								<td>
									<input type="radio" name="emailtemplate_plain_text" value="1" id="emailtemplate_plain_text" <?php echo ($emailtemplate['plain_text'] == 1) ? ' checked="checked"' : ''; ?>/><?php echo $text_yes; ?>
									<input type="radio" name="emailtemplate_plain_text" value="0" id="emailtemplate_plain_text" <?php echo ($emailtemplate['plain_text'] == 0) ? ' checked="checked"' : ''; ?>/><?php echo $text_no; ?>
									<?php if(isset($error_emailtemplate_plain_text)) { ?><span class="error"><?php echo $error_emailtemplate_plain_text; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_tracking_campaign_source"><?php echo $entry_tracking_campaign_source; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_tracking_campaign_source" value="<?php echo $emailtemplate['tracking_campaign_source']; ?>" id="emailtemplate_tracking_campaign_source" />
									<?php if(isset($error_emailtemplate_tracking_campaign_source)) { ?><span class="error"><?php echo $error_emailtemplate_tracking_campaign_source; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_showcase"><?php echo $entry_showcase; ?></label>
								</td>
								<td>
									<input type="radio" name="emailtemplate_showcase" value="1" id="emailtemplate_showcase" <?php echo ($emailtemplate['showcase'] == 1) ? ' checked="checked"' : ''; ?>/><?php echo $text_yes; ?>
									<input type="radio" name="emailtemplate_showcase" value="0" id="emailtemplate_showcase" <?php echo ($emailtemplate['showcase'] == 0) ? ' checked="checked"' : ''; ?>/><?php echo $text_no; ?>
									<?php if(isset($error_emailtemplate_showcase)) { ?><span class="error"><?php echo $error_emailtemplate_showcase; ?></span><?php } ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="emailtemplate_wrapper_tpl"><?php echo $entry_template_wrapper; ?></label>
								</td>
								<td>
									<input class="large" type="text" name="emailtemplate_wrapper_tpl" value="<?php echo $emailtemplate['wrapper_tpl']; ?>" id="emailtemplate_wrapper_tpl" />
									<?php if(isset($error_emailtemplate_wrapper_tpl)) { ?><span class="error"><?php echo $error_emailtemplate_wrapper_tpl; ?></span><?php } ?>
								</td>
							</tr>
						</table>
					</div>
					
					<?php if (!empty($shortcodes)) { ?>
					<div id="tab-shortcodes" class="vtabs-content">
						<table class="list" id="shortcodes_list">
							<thead>
								<tr>
									<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'shortcode_selected\']').attr('checked', this.checked);" /></td>
									<td class="left" width="200"><a href="<?php echo $sort_code; ?>" class="<?php if ($sort == 'code') echo strtolower($order); ?>"><?php echo $column_code; ?></a></td>
									<td class="left"><a href="<?php echo $sort_example; ?>" class="<?php if ($sort == 'example') echo strtolower($order); ?>"><?php echo $column_example; ?></a></td>
				            	</tr>
				          	</thead>
				          	<tbody>
				            <?php foreach ($shortcodes as $shortcode) { ?>
				            	<tr>
				              		<td style="text-align: center;"><input type="checkbox" name="shortcode_selected[]" value="<?php echo $shortcode['id']; ?>" /></td>
                					<td class="left">
                						<a href="javascript:void(0)" class="insertHander">{$<?php echo $shortcode['code']; ?>}</a>
                					</td>
				              		<td class="left"><?php echo $shortcode['example']; ?></td>
				            	</tr>
				            <?php } ?>
				          </tbody>
				          <tfoot>
				          	<tr>
				          		<td colspan="0" bgcolor="#F2F2F2" style="padding:10px">
				          			<a href="javascript:void(0)" onclick="$('#form').attr('action', '<?php echo $shortcodes_delete; ?>'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a>
				          		</td>
				          	</tr>
				          </tfoot>
				        </table>
					</div>
					<?php } ?>
					
					<?php if($emailtemplate['default'] == 1){ ?>
					<div id="tab-vqmod" class="vtabs-content tab-content-editor">						
						<table class="form">
							<tr>
								<td style="text-align: left">
									<textarea name="emailtemplate_vqmod" id="emailtemplate_vqmod" style="width: 100%; height: 450px;"><?php echo $emailtemplate['vqmod']; ?></textarea>
									<?php if(isset($error_emailtemplate_vqmod)) { ?><span class="error" style="margin-top:10px;"><?php echo $error_emailtemplate_vqmod; ?></span><?php } ?>
								</td>
							</tr>
						</table>
						
						<?php if(!empty($vqmod_files)): ?>
						<div class="vqmod_cache">							
							<div class="vtabs tabs-nav" id="vqmod-tabs">
								<?php $i = 1; foreach($vqmod_files as $vqmod_file){ ?>
				    				<a href="#tab-vqmodfile-<?php echo $i; ?>" title="<?php echo $vqmod_file['file']; ?>"><?php echo $vqmod_file['name']; ?></a>
			    				<?php $i++; } ?>
			    			</div>
			    			
			    			<?php $i = 1; foreach($vqmod_files as $vqmod_file){ ?>
			    			<div id="tab-vqmodfile-<?php echo $i; ?>" class="vtabs-content">
	    						<textarea style="height: 200px; width: 100%;" id="vqmodfile-<?php echo $i; ?>"><?php echo $vqmod_file['contents']; ?></textarea>
		    				</div>
		    				<?php $i++; } ?>						
						</div>
						<?php endif; ?>
					</div>
					<?php } ?>
					
					<hr style="clear:both" />					
				</div>
											
				<div id="language-body" class="htabs">
					<?php foreach ($languages as $language) { ?>
						<a href="#tab-language-<?php echo $language['language_id']; ?>">
							<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> 
							<?php echo $language['name']; ?>
							<?php if($language['default'] == 1){ echo ' - ' . $text_default; } ?>
						</a>
					<?php } ?>
				</div>
				
				<?php foreach ($emailtemplate_description as $langId => $description) { ?>
				<div id="tab-language-<?php echo $langId; ?>" class="tabHolder tabLangHolder" style="display:none">
					<div class="buttons" style="float: right; margin-top: -33px; margin-right: 8px;">
						<button type="button" data-frame="preview-<?php echo $langId; ?>" data-lang="<?php echo $langId; ?>" class="button preview-template"><?php echo $button_preview; ?></button>
					</div>
					
					<table class="form">
						<tr>			          
							<td>
								<label for="emailtemplate_description_subject_<?php echo $langId; ?>"><b><?php echo $entry_subject; ?></b></label>
							</td>
							<td>
								<input type="text" class="large" name="emailtemplate_description_subject[<?php echo $langId; ?>]" id="emailtemplate_description_subject_<?php echo $langId; ?>" value="<?php echo $description['subject']; ?>" />							
								<?php if (isset($error_emailtemplate_description_subject[$langId])) {?><span class="error"><?php echo $error_emailtemplate_description_subject[$langId]; ?></span><?php } ?>	 							
							</td>
						</tr> 
						<?php for ($i = 1; $i <= EmailTemplateDescriptionDAO::$content_count; $i++) {   
							if($i != 1 && empty($description['content'.$i])) break; ?>				
						<tr>			          
							<td style="vertical-align: top; padding-top: 20px; border-bottom: none">
								<label for="emailtemplate_description_subject_<?php echo $langId; ?>">
									<b><?php echo $entry_content; ?></b>								
									<span class="help">{$emailtemplate.content<?php echo $i; ?>}</span>
								</label>						
							</td>
							<td rowspan="2" style="border-bottom: none">
								<textarea class="content<?php echo $i; ?>" name="emailtemplate_description_content<?php echo $i; ?>[<?php echo $langId; ?>]" id="emailtemplate_description_content<?php echo $i; ?>_<?php echo $langId; ?>"><?php echo $description['content'.$i]; ?></textarea>
								<?php if (isset(${"error_emailtemplate_description_content".$i}[$langId])) {?><span class="error"><?php echo ${"error_emailtemplate_description_content".$i}[$langId]; ?></span><?php } ?>	 							
							</td>
						</tr>
						<tr>			          
							<td style="vertical-align: bottom; border-top: none; padding-bottom: 20px;">
								<?php if($i < EmailTemplateDescriptionDAO::$content_count && empty($description['content'.($i+1)])){ ?><a href="javascript:void(0)" class="addContentEditorButton" data-count="<?php echo $i + 1; ?>" data-lang="<?php echo $langId; ?>">Add Editor <?php echo $i + 1; ?></a><?php } ?>							
							</td>
						</tr>
						<?php } ?>
					</table>
					
					<div class="preview-email" style="display: none;">
						<div class="preview content-heading">
							<span class="heading"><?php echo $heading_preview; ?></span>
							
							<div class="mediaIcons buttons">
								<span class="desktop selected"></span>
								<span class="tablet"></span>
								<span class="mobile"></span>
							</div>		
						</div>
						
						<iframe id="preview-<?php echo $langId; ?>" name="preview-<?php echo $langId; ?>" style="width:100%; height:500px; border:none; margin:0 auto; float:none; display:block"></iframe>
					</div>
				</div>
				<?php } ?>
												
			</form>	
		</div>	
	</div>
</div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
CKEDITOR.stylesSet.add('ckeditor_custom_style', [
	{ name: 'Default', element: 'p', attributes: {'class': 'standard'} },
	//{ name: 'Table', element: 'table', attributes: {'class': 'table1'} },
	{ name: 'Link', element: 'p', attributes: {'class': 'link'} },
	{ name: 'Heading 1', element: 'h1', attributes: {'class': 'heading1'} },
	{ name: 'Heading 2', element: 'h2', attributes: {'class': 'heading2'} },
	{ name: 'Heading 3', element: 'h3', attributes: {'class': 'heading3'} },
	{ name: 'Heading 4', element: 'h4', attributes: {'class': 'heading4'} },
	{ name: 'Heading 5', element: 'h5', attributes: {'class': 'heading5'} },
	{ name: 'Heading 6', element: 'h6', attributes: {'class': 'heading6'} }
]);


function addContentEditor(key){
	if($('#'+key).length){
		CKEDITOR.replace(key, {
			extraPlugins: '', //codemirror plugin conflicts with real codemirror
		    contentsCss : '<?php echo str_replace('&amp;', '&', $css_url); ?>',
			filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			stylesSet: 'ckeditor_custom_style',
			toolbar: [
		        ['Source'],
				['Maximize'],
				['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
				['NumberedList','BulletedList','-','Outdent','Indent'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
				['SpecialChar'],
				'/',
				['Undo','Redo'],
				['Styles'],
				['Font','FontSize'],
				['TextColor','BGColor'],
				['Link','Unlink','Anchor'],
				['Image','Table','HorizontalRule']
			],
			bodyId : 'emailTemplate'
		});
	}
}

<?php 
foreach ($emailtemplate_description as $langId => $description) { 
	for ($i = 1; $i <= EmailTemplateDescriptionDAO::$content_count; $i++) {  
		if($i != 1 && empty($description['content'.$i])) break; ?>
		addContentEditor('emailtemplate_description_content<?php echo $i; ?>_<?php echo $langId; ?>');		
<?php } } ?>
//--></script>

<script src="view/javascript/codemirror/codemirror-compressed.js"></script>
<script type="text/javascript"><!--
<?php if($emailtemplate['default'] == 1){ ?>
var el = document.getElementById("emailtemplate_vqmod");
if(el){
	var editor = CodeMirror.fromTextArea(el, {
		mode: { name: "xml", htmlMode: true },
		integer: 4,
		lineNumbers: true,
		alignCDATA: true,
		lineWrapping: true,
		indentWithTabs: true,
		indentUnit: 4,
		styleActiveLine: true,
		autoCloseTags: true,
	    extraKeys: {
	        "'<'": completeAfter,
	        "'/'": completeIfAfterLt,
	        "' '": completeIfInTag,
	        "'='": completeIfInTag,
	        "Ctrl-Space": function(cm) {
	            CodeMirror.showHint(cm, CodeMirror.xmlHint, {schemaInfo: vqmodTags});
	        }
	    }
	});
	editor.setSize("100%", 400);
}

<?php if(!empty($vqmod_files)){ ?>
	<?php $i = 1; foreach($vqmod_files as $vqmod_file){ ?>
		var el = document.getElementById("vqmodfile-<?php echo $i; ?>");
		if(el){
			
			var editor_vqmodfile_<?php echo $i; ?> = CodeMirror(function(elt) {
				el.parentNode.replaceChild(elt, el);
			}, {
				mode: "<?php echo $vqmod_file['mode']; ?>",
				value: el.value,
				readOnly: true,
				lineNumbers: true
			});
		}
	<?php $i++; } ?>
<?php } ?>
<?php } ?>
	
(function($){	
	function onChangeType($type){	
		var $rows = $('#tab-setting tr[data-field], #table-options'), field;
		$rows.hide();		
		switch($type.val()){
			case 'standard':
				$rows.filter(function(){
					field = $(this).data('field');
					if(field){
						return (field == 'key' || field == 'template' || field == 'language_files')
					} else {
						return true;
					}
				}).show();
			break;
		}	
	}

	function addCondition(key){
		var $table = $('#emailtemplate_conditions > tbody');
		var i = $table.find('tr:last').data('count');
		if(i >= 1){
			i++;
		} else {
			i = 1;
		}		
		var html = '<tr data-count="' + i + '">';
		    html += '	<td><input type="text" name="emailtemplate_condition[' + i + '][key]" value=" ' + key + '" /></td>';										
		    html += '	<td><select name="emailtemplate_condition[' + i + '][operator]">';
		    html += '		<option value="==">(==) Equal</option>';
			html += '		<option value="!=">(!=) &nbsp;Not Equal</option>';
			html += '		<option value="&gt;">(&gt;) &nbsp;&nbsp;Greater than</option>';
			html += '		<option value="&lt;">(&lt;) &nbsp;&nbsp;Less than</option>';
			html += '		<option value="&gt;=">(&gt;=) Greater than or equal to </option>';
			html += '		<option value="&lt;=">(&lt;=) Less than or equal to </option>';
			html += '		<option value="IN">(IN) Checks if a value exists in comma-delimited string </option>';
			html += '		<option value="NOTIN">(NOTIN) Checks if a value does not exist in comma-delimited string </option>';
			html += '	</select></td>';
			html += '	<td><input type="text" name="emailtemplate_condition[' + i + '][value]" value="" placeholder="Value" /></td>';
			html += '	<td><a class="button" onclick="$(this).parents(\'tr\').eq(0).remove();"><?php echo $button_delete; ?></a></td>';
			html += '</tr>';				
		$table.append(html);
	}
		
	$(document).ready(function(){
		$('#settings-tab > a').tabs();
		$('#language-body > a').tabs();
		$('#vqmod-tabs > a').tabs();
						
		$('#emailtemplate_type').change(function(){
			onChangeType($(this));			
		}).change();
						
		$('#condition_add_select').change(function(){
			addCondition($(this).find(":selected").text());
			$(this).find('option:selected').removeAttr("selected");	
		});
			
		$('.addContentEditorButton').click(function(){
			var lang = $(this).data('lang'); 
			var count = $(this).data('count');
			var html = '<tr>' +					          
			    		'<td style="vertical-align: top; padding-top: 20px; border-bottom: none"><label for="emailtemplate_description_subject_' + lang + '"><b><?php echo $entry_content; ?></b><span class="help">{$emailtemplate.content' + count + '}</span></label></td>' +
			    		'<td rowspan="2" style="border-bottom: none"><textarea class="content' + count + '" name="emailtemplate_description_content' + count + '[' + lang + ']" id="emailtemplate_description_content' + count + '_' + lang + '"></textarea></td>' +
					   '</tr>';

			$(this).parents('tr').after(html);

			addContentEditor('emailtemplate_description_content' + count + '_' + lang);
			
			$(this).remove();
		});

		//Media Icons
		var $mediaIcons = $(".mediaIcons").children("span");
		$mediaIcons.on('click', function(){
			var $previewArea = $(this).parents('.preview-email').find('iframe').eq(0);			
			$mediaIcons.removeClass('selected');
			$(this).addClass('selected');
			
			if($(this).hasClass('desktop')){
				$previewArea.css('width', '100%');
			} else if($(this).hasClass('tablet')){
				$previewArea.css('width', '768px');
			} else if($(this).hasClass('mobile')){
				$previewArea.css('width', '320px');
			}			
		});	
		
		$('.preview-template').click(function(){
			var $self = $(this);
			$.ajax({
				url: 'index.php?route=module/emailtemplate/preview_email&token=<?php echo $token; ?>&emailtemplate_id=<?php echo $emailtemplate['emailtemplate_id']; ?>',
				dataType: 'text',
				data: 'language_id=' + $self.data('lang'),
				success: function(data) {
					if(data){
						var iframe = document.getElementById($self.data('frame'));
						iframe.parentNode.style.display = "block";						
						iframe = (iframe.contentWindow) ? iframe.contentWindow : (iframe.contentDocument.document) ? iframe.contentDocument.document : iframe.contentDocument;
						iframe.document.open();
						iframe.document.write(data);
						iframe.document.close();
					}
				}
			});	
			$self.remove();				
		});//.filter(':visible').click();
		
		$(".insertHander").click(function(e){
    	    e.preventDefault();
    	    var editorId = $('.tabLangHolder:visible textarea.content1').eq(0).attr('id');
	    	CKEDITOR.instances[editorId].insertText($(this).html());
	    });

		// Select tab if errors are hidden
		var $hidden_error = $('.tabsHolder .error').eq(0);
		if($hidden_error.length > 0){
			// tabs editor
		    $('.tabs-nav a[href=#'+$hidden_error.parents(".vtabs-content").eq(0).attr('id')+']').click();
		}

		//Save Form [ctrl+s]
		$(window).keypress(function(event) {
			if((event.which == 115 && (event.ctrlKey||event.metaKey)) || (event.which == 19)){
			    var $button = $("#submitButton").eq(0);
			    if($button.length){
				    $button.click();
				    event.preventDefault();
			    }
			    return false;
			}
		});
	});		
})(jQuery);
//--></script>

<?php echo $footer; ?>