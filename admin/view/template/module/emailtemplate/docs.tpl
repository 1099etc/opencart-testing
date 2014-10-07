<?php echo $header; ?>
<link type="text/css" href="view/stylesheet/module/emailtemplate.css" rel="stylesheet" media="screen" />

<div id="content">
	<div class="breadcrumb">
 	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
  		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  	<?php } ?>
	</div>

	<div class="box" id="emailtemplate-docs">
		<div class="heading">
			<h1><img src="view/image/mail.png" alt="<?php echo $heading_title; ?>" /><?php echo $heading_docs; ?></h1>
		</div>

		<div class="content">
			<div class="vtabs">
				<a href="#tab-overview">Overview</a> 
				<a href="#tab-emails">Emails</a> 
				<a href="#tab-install">Install</a> 
				<a href="#tab-remove">Uninstall</a>
				<a href="#tab-upgrade">Upgrading</a> 
				<a href="#tab-vqmod">vQmod</a>
				<a href="#tab-faq">FAQ/Common Errors</a>
				<a href="#tab-faq-pdf">PDF related Errors</a>
				<a href="#tab-changelog">Changelog</a>
				<a href="#tab-terms">Terms of Use</a> 
				<a href="#tab-support">Support</a>
				<a href="#tab-compatible">Other Extensions</a>
			</div>

			<div class="vtabs-content">
				<div id="tab-overview" style="min-height: 330px">
					<p style='margin-top: 35px;'>Thanks for purchasing Email Template for Opencart. If you have any questions that are beyond the scope of this help file, you've found a bug, need new feature, please open a support ticket at: <a href="<?php echo $support_url; ?>" target="_blank">support.opencart-templates.co.uk</a>.</p>

					<h3>What's <a href="#tab-emails" class="open-tab">included</a> by default?</h3>
					<p>This module will send all emails sent from your Opencart store in HTML email format.</p>
					<p>If you have installed any additional modules to your store that send extra emails, you will need to modify the module for these to work together. Check out the <a href="#faq">FAQ</a> for more details.</p>
					
					<p>We recommend that you throughly test your store after installing any extension, especially if you have another extension which modifies the same area/files. Check for any vqmod errors or system logs</p>
					
					<h3>Open Source libraries included:</h3>
					<ul>
						<li>
							<h4>TCPDF PHP library used to generate the Invoice PDF</h4>
							<p>Code located in /library/shared/tcpdf</p>
							<p>By Nicola Asuni - Tecnick.com <a href="http://www.tcpdf.org" target="_blank">www.tcpdf.org</a></p>
		    				<p>If you like it please feel free to <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40tecnick%2ecom&lc=US&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" alt="PayPal - The safer, easier way to pay online!" style="vertical-align: middle;" /></a> a small amount of money to secure the future of this free library.</p>
						</li>
						<li>
							<h4>Simple HTML DOM PHP library used to modify the HTML preview</h4>
							<p>Author: S.C. Chen (me578022@gmail.com)<br />
							    Original idea is from Jose Solorzano's <a href="http://php-html.sourceforge.net/">HTML Parser for PHP 4</a>. <br />
							    Contributions by: Yousuke Kumakura (Attribute Filters) </p>
							<p>More info: <a href="http://sourceforge.net/projects/simplehtmldom/" target="_blank">sourceforge.net/projects/simplehtmldom</a></p>
						</li>
						<li>
							<h4>Color Picker javscript/jQuery library</h4>
							<p>By Stefan Petre <a href="http://www.eyecon.ro" target="_blank">www.eyecon.ro</a></p>
						</li>
						<li>
							<h4>Google Code Prettify javscript library</h4>
							<p>More info: <a href="http://code.google.com/p/google-code-prettify/" target="_blank">code.google.com/p/google-code-prettify/</a></p>
						</li>
						<li>
							<h4>PHP Mailer (optional)</h4>
							<p>A full-featured email creation and transfer class for PHP, we use this to replace the Opencart Mail.php library, mainly because its more robust and fixes bugs with the preview message not getting displayed on some Apple devices.</p>
							<p>More info: <a href="http://phpmailer.worxware.com/" target="_blank">phpmailer.worxware.com/</a> &amp; <a href="https://github.com/Synchro/PHPMailer" taget="_blank">github</a>
						</li>
					</ul>
					
				</div>

				<div id="tab-emails" style="min-height: 353px; display: none">
					<h2>Opencart Emails</h2>
					<h3>Catalog <strong>[<i>catalog/view/theme/*/template/mail/</i>]</strong></h3>

					<p>Main Email template/wrapper: <strong>_main.tpl</strong></p>
										
					<ol>
						<li style="padding:0 0 5px"><a href="<?php echo $customer_register_url; ?>"><b>Customer Register</b></a>
							<ul>
								<li>Customer: <strong>customer_register.tpl</strong></li>
								<li>Admin: <strong>customer_register_admin.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/mail/customer.php</strong> &amp; <b>customer_.php</b></li>
							</ul>
						</li>
						<li style="padding:0 0 5px"><a href="<?php echo $checkout_url; ?>"><b>Order Confirmation</b></a>
							<ul>
								<li>Customer: <strong>order_customer.tpl</strong></li>
								<li>Admin: <strong>order_admin.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/mail/order.php</strong> &amp; <b>order_.php</b></li>
								<li>Also the order update() method called from payment gateway.</li>
							</ul>
						</li>
						<li style="padding:0 0 5px"><b>Openbay - ebay</b>
							<ul>
								<li>Order Confirmation: <strong>ebay_order_confirm.tpl</strong></li>
								<li>Order Update: <strong>ebay_order_update.tpl</strong></li>
							</ul>
						</li>
						<li style="padding:0 0 5px"><b>Openbay - Play</b>
							<ul>
								<li>Order Update: <strong>play_order_update.tpl</strong></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $contact_url; ?>"><b>Contact Us</b></a>
							<ul>
								<li>Customer: <strong>contact.tpl</strong></li>
								<li>Admin: <strong>contact_admin.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/information/contact.php</strong> &amp; <b>contact_.php</b></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $affiliate_register_url; ?>"><b>Affiliate Register</b></a>
							<ul>
								<li>Affiliate: <strong>affiliate_register.tpl</strong></li>
								<li>Admin: <strong>affiliate_register_admin.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/mail/affiliate.php</strong></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><b>Forgotten Password</b>
							<ul>
								<li><a href="<?php echo $affiliate_forgot_url; ?>">Affiliate</a>: <strong>affiliate_forgotten.tpl</strong></li>
								<li><a href="<?php echo $customer_forgot_url; ?>">Customer</a>: <strong>customer_forgotten.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/mail/forgotten.php</strong> &amp; <b>forgotten_.php</b>
								</li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $voucher_url; ?>"><b>Gift Vouchers</b></a>
							<ul>
								<li>Customer: <strong>voucher_customer.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/mail/voucher.php</strong></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $return_url; ?>"><b>Returns</b></a>
							<ul>
								<li>Admin: <strong>return_admin.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/account/return.php</strong>&amp; <b>return_.php</b>
								</li>
							</ul>
						</li>
						<li><b>Product Reviews</b>
							<ul>
								<li>Admin: <strong>product_review.tpl</strong></li>
								<li>Language: <strong>catalog/language/english/product/product.php</strong>&amp; <b>product_.php</b>
							</ul>
						</li>
					</ol>

					<h3>Admin <strong>[<i>admin/view/template/mail/</i>]</strong></h3>

					<p>Email template: <strong>_main.tpl</strong></p>

					<ol>
						<li style="padding-bottom:8px"><a href="<?php echo $order_url; ?>"><b>Order History/Status Update</b></a>: (<i>Sales</i> &raquo; <i>Orders</i> &raquo; <i>View</i> &raquo; <i>Order History</i>)
							<ul>
								<li>Template: <strong>order_update.tpl</strong></li>
								<li>Language: <strong>admin/language/english/mail/order.php</strong></li>
							</ul>
						</li>
						<li style="padding:0 0 5px"><b>Openbay Admin Notification (ebay, Play &amp; Amazon)</b>
							<ul>
								<li>Admin: <strong>openbay_order_admin.tpl</strong></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $newsletter_url; ?>"><b>Newsletter/Mail</b></a>: (<i>Sales</i> &raquo; <i>Mail</i>)
							<ul>
								<li>Template: <strong>newsletter.tpl</strong></li>
								<li>Language: <strong>admin/language/english/sale/contact.php</strong> &amp; <b>contact_.php</b>
								</li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $customer_url; ?>"><b>Customers</b></a>: (<i>Sales</i> &raquo; <i>Customers</i>)
							<ul>
								<li>Language: <strong>admin/language/english/mail/customer.php</strong>
								</li>
								<li>Approve: <strong>customer_approve.tpl</strong></li>
								<li>Transactions: <strong>customer_transaction.tpl</strong></li>
								<li>Reward Points: <strong>customer_reward.tpl</strong></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $affiliate_url; ?>"><b>Affiliates</b></a> (<i>Sales</i> &raquo; <i>Affiliates</i>)
							<ul>
								<li>Language: <strong>admin/language/english/mail/affiliate.php</strong>
								</li>
								<li>Approve: <strong>affiliate_approve.tpl</strong></li>
								<li>Transactions: <strong>affiliate_transaction.tpl</strong></li>
							</ul>
						</li>
						<li style="padding-bottom:8px"><a href="<?php echo $voucher_url; ?>"><b>Gift Vouchers</b></a>: (<i>Sales</i> &raquo; <i>Gift Vouchers</i>)
							<ul>
								<li>Template: <strong>customer_voucher.tpl</strong></li>
								<li>Language: <strong>admin/language/english/mail/voucher.php</strong></li>
							</ul>
						</li>
						<li><a href="<?php echo $return_url; ?>"><b>Returns</b></a>: (<i>Sales</i> &raquo; <i>Returns</i>)
							<ul>
								<li>Template: <strong>return_history.tpl</strong></li>
								<li>Language: <strong>admin/language/english/mail/return.php</strong></li>
							</ul>
						</li>
					</ol>

					<!--
    	- Single layout template eg: admin/view/template/emailtemplate/_main.tpl so you only have to edit one file. 
		- Email Preview (with/without images)
		- Easily Upload logo/background header image
		- Footer Text Editor: This allow you to easily edit the html to the footer and you could even add social media icons into the footer of all your emails.
		- Multi store: completely change the look of the email for each store. 
		- Multi language: for each store above you can translate the text/change logo etc. This took me a while to figure out and need to tested to ensure its working correctly. 
		- Right to left language support e.g: Arabic, Hebrew
		- Newsletter Unsubscribe link
		-->
				</div>
				<!-- #features -->

				<div class="section clearfix" id="tab-install"
					style="min-height: 353px; display: none">
					<h2>Install</h2>

					<ol>
						<li>Install <a href="#vqmod">vqmod</a> and check that it's
							generating the core cached files in: vqmod/vqcache <br />
						<b>Requires minimum version: 2.2.1</b>
						</li>
						<li>Unzip and upload everything inside the "Upload" folder to the
							root directory of your Opencart store (No files are overwritten)<br />
							<b>If you have a custom theme it is recommended to upload
								everything in "Upload/catalog/view/theme/default" into your
								custom theme.</b>
							<p>If Opencart version 1.5.0 > 1.5.1.2 copy extra .xml file from
								Version folder to your vqmod/xml folder.</p>
						</li>
						<li>Log into the admin area, go to: <b>Extension</b> > <b>Modules</b>,
							click "install".
						</li>
						<li><b>You need to make sure you click "Edit" and "Save" the
								module when you install this</b></li>
						<li>Here you can make changes to the Email Template to customise
							this for your store.</li>
						<li>
							<p>
								If Opencart version <b>&lt; 1.5.0.5</b> edit: <strong>index.php</strong>
								AND <strong>admin/index.php</strong>
							</p>
							<h3>FIND:</h3> <pre class="prettyprint"><code>foreach ($query-&gt;rows as $setting) {
   $config-&gt;set($setting['key'], $setting['value']);
}
</code></pre>
							<h3>REPLACE WITH:</h3> 
							<pre class="prettyprint"><code>foreach ($query-&gt;rows as $setting) {
   if (!empty($setting['serialized'])) {
      $config-&gt;set($setting['key'], unserialize($setting['value']));
   } else {
      $config-&gt;set($setting['key'], $setting['value']);
   }
}</code></pre>
							<p>When you install the extension it will automatically alter your database by adding `serialized` to the settings table.</p>
						</li>
					</ol>
				</div>
				<!-- #install -->

				<div class="section clearfix" id="tab-remove" style="min-height: 353px; display: none">
					<h2>Uninstall</h2>

					<p>If you need to uninstall this extension please log into the admin and "uninstall" the extension in the usual way.</p>

					<p>Also you will need to remove the .xml files form the vqmod directory.</p>
					<p>
						You can do this by either removing the files out of the vqmod/xml
						directory or renaming the .xml part so that vqmod does not read
						these file. <br />Note that moving the .xml files into a subfolder 
						will not work.
					</p>
				</div>

				<div class="section clearfix" id="tab-vqmod" style="min-height: 353px; display: none">
					<h2>vQmod</h2>

					<p>vQmod can be downloaded from: <a href="http://code.google.com/p/vqmod/downloads/list" target="_blank">http://code.google.com/p/vqmod/downloads/list</a> - make sure you select the -opencart.zip version.</p>

					<p>Further information can be found:</p>
					<ol>
						<li><a href="http://forum.opencart.com/viewtopic.php?f=23&t=40987" target="_blank">vQmod 2.0 Offical Thread</a> with all the information you will need to help get you started.</li>
						<li>Further information can also be found on the <a href="http://code.google.com/p/vqmod/wiki/Install_OpenCart">vQmod Wiki</a></li>
					</ol>

					<p>Also not require for this module, although I would recommend also installing a FREE module: <a href="www.opencart.com/index.php?route=extension/extension/info&extension_id=2969" target="_blank">vQmod Manager</a>. This allows you to easily view vqmod errors and much more via the admin area without login via FTP.</p>
					<p><strong>Note:</strong> if you have changed the directory of the admin folder, when installed vQmod you will need to open: vqmod/install/index.php and edit:</p>
										
					<pre class="prettyprint"><code>$u-&gt;addFile('admin/index.php');</code></pre>
				</div>
				<!-- #vqmod -->

				<div class="section clearfix" id="tab-upgrade" style="min-height: 353px; display: none">
					<h2>Upgrading</h2>

					<h3>From the old version?</h3>
					<p>Delete:</p>
					<ol>
						<li>/system/config/html_email.php</li>
						<li>/vqmod/xml/html_email.xml</li>
						<li>/admin/view/template/mail/_main.tpl (this file is no longer
							needed and we use the _main.tpl from your theme/mail)</li>
					</ol>

					<h3>From a recent version (after version: 4)?</h3>
					<p>It's always good practice to edit the extension from the admin and click Save.</p>
				</div>
				<!-- #upgrade -->

				<div class="section clearfix" id="tab-faq" style="min-height: 353px; display: none">
					<h2>FAQ/Common Errors</h2>

					<p>If you installed via vQmod, your first place to check should be:</p>
					<ul>
						<li>Are there any errors in: <b>vqmod/vqmod.log</b> relating to _emailtemplate.xml?</li>
						<li>Are you sure vqmod has the <b>correct permissions</b>?</li>
						<li>Have both <b>index.php</b> and <b>admin/index.php</b> been vqmod correctly?</li>
						<li>Empty the tmp files in <b>vqmod/vqcache/</b>, then refresh your website, check the vqcache folder again. Has this created the cached files correctly?</li>
						<li>Have you deleted the required file: <b>vqmod/xml/vqmod_opencart.xml</b>?</li>
						<li>Error: <b>DOM UNABLE TO LOAD</b>, try:
							<ol>
								<li>Validate the XML file here: <a href="http://www.xmlvalidation.com/" target="_blank">www.xmlvalidation.com</a></li>
								<li>Add &lt;?xml version="1.0" encoding="UTF-8"?&gt; to the top of XML file</li>
								<li>Use a application like Notepad++ which can ensure the file is saved in Encoding UTF-8</li>
								<li>Ensure any non-standard characters (á, é, etc) are wrapped in CDATA</li>
							</ol>
						</li>
					</ul>

					<p class='faq-question'>Error message: <b>"Fatal error: Class 'EmailTemplate' "</b> OR <b>"Fatal error: Call to undefined method ModelToolImage::get()"</b>?</p>
					<p class='faq-answer'>Check vqmod is installed correctly and creating the cached files in <b>vqmod/vqcache/</b>.</p>

					<p class='faq-question'>Error message: <b> EHLO not accepted from server!</b>?</p>
					<p class='faq-answer'>This means that your mail settings are not setup correctly or does not allow remote emails to be sent.</p>

					<p class='faq-question'>Logo incorrect for order email although it works for all other emails?</p>
					<p class='faq-answer'>Make sure you are using the latest version ofthe extension.</p>

					<p class='faq-question'>Error message: <b>"Error: Could not load template *"</b>?</p>
					<p class='faq-answer'>
						Check that you have uploaded all of the email template files
						(inside the "mail" folder). We have added an option into the
						module where you can alter the location to where you have uploaded
						the files.<br /> In older versions (prior to version: 4) this
						would of likely of been because you are using a custom theme but
						have uploaded the files into the default theme. With any module it
						is always recommended to upload the files into your custom theme,
						even if you do not have one create a new theme folder so that the
						changes you make are not overwriting the files in the default
						theme, <a href="http://www.opencart.com/index.php?route=documentation/documentation&path=43_44" target="_blank">further info</a>
					</p>

					<p class='faq-question'>Error message: <b>"Could not resolve path for [catalog/model/account/customer_group.php]"</b>?</p>
					<p class='faq-answer'>Check you are using the latest version of vqmod (higher than: 2.1.6).</p>

					<p class='faq-question'>Images/Logo are not being displayed in my emails?</p>
					<p class='faq-answer'>Most email clients will by default disabled images and you may need to enable them <a href="http://www.benchmarkemail.com/help-FAQ/answer/how-do-i-enable-my-email-client-to-display-images" target="_blank">futher info</a>. This is the reason we have developed this module with a background color fallback solution.</p>
					<p class='faq-answer'>Also there may be a problem if you are testing the module in a local environment because the images are reference by absolute URL.</p>
					<p class='faq-answer'>Also make sure the images you upload to the email template do not contain any spaces or un-recognised characters.</p>
					<p class='faq-answer'>If you are able to check the source of the email, here you can find the URL of the image which isn't working. Try pasting this into your browser address bar checking if this loads correctly.</p>

					<p class='faq-question'>Languages/Translations - I have more than one language, how can I translate to my langauge?</p>
					<p class='faq-answer'> You will need to duplicate the "language" section for each language inside <b>vqmod/xml/emailtemplate_languages.xml</b>.</p>
					
					<ol>
						<li>You can modify the settings for your additional languages inside each tab easily.</li>
						<li>Next open: emailtemplate_languages.xml, by default this contains all of the english changes to the language files.</li>
						<li>Duplicate each of the "english" sections for each of the &lt;file&gt; your languages.
							<ol>
								<li>Update the URL to the file. E.g: name="catalog/language/english would become: name="catalog/language/dutch</li>
								<li>Replace the text inside of &lt;search&gt; with the EXACT text found in: catalog/language/dutch/mail/customer.php<br /> E.g: <pre class="prettyprint"><code>Was						
&lt;file name="catalog/language/english/mail/customer.php"&gt;
  &lt;operation&gt;
    &lt;search position="replace"&gt;&lt;![CDATA[
      $_['text_welcome']  = 'Welcome and thank you for registering at %s!';
	
After	
&lt;file name="catalog/language/dutch/mail/customer.php"&gt;
  &lt;operation&gt;
    &lt;search position="replace"&gt;&lt;![CDATA[
      $_['text_welcome']  = 'Welkom en bedankt voor uw registratie bij %s!';</code></pre>
								</li>
								<li>Translate the text inside of the &lt;add&gt; to your language</li>
							</ol>
						
						<li>Ensure you save the file in character format: UTF-8 (without BOM) so that the foreign characters are displayed correctly.</li>
						<li>Also you can duplicate the file in: cata/language/english/module/emailtemplate.php inyour your language if you have a custom language in the admin area.</li>
						<li>You can see examples of both Dutch and Swedish translations in the "Languages" folder of this extension.</li>
					</ol>
					
					<p class='faq-question'>The login link in the welcome message, contains 'login', twice.</p>
					<p class='faq-answer'>The email extension added the email address into the login link so that its prepopulated for login. This conflicts with extension: Opencart SEO Pack PRO, adding the following should fix this.</p>

					<pre class="prettyprint"><code>&lt;file name="catalog/controller/common/seo_url.php"&gt;
	&lt;operation&gt;
		&lt;search position="replace"&gt;&lt;![CDATA[
			} elseif (isset($data['route']) && $data['route'] == 'account/login') { $url .= '/login';
		]]&gt;&lt;/search&gt;
		&lt;add&gt;&lt;![CDATA[
			} elseif (isset($data['route']) && $data['route'] == 'account/login') { if ($key != 'email') {$url .= '/login';}
		]]&gt;&lt;/add&gt;
	&lt;/operation&gt;
&lt;/file&gt;</code></pre>

					<p class='faq-question'>Model and Quantity columns missing from order email</p>
					<p class='faq-answer'>
						We have move the model into the product and the quantity into
						price column. Otherwise a 5 column table is too wide to displays
						correctly on small screen devices. Although you can easily change
						this back by:<br /> open order_customer.tpl from inside your
						catalog/view/theme/MYTHEME/template/mail
					</p>

					<p><b>FIND:</b></p>
					<pre class="prettyprint"><code>&lt;tr&gt;
	&lt;th width="50%" bgcolor="#ededed" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_product; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
	&lt;th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_price; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
	&lt;th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_total; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
&lt;/tr&gt;</code></pre>

					<p><b>REPLACE:</b></p>
					<pre class="prettyprint"><code>&lt;tr&gt;
	&lt;th width="50%" bgcolor="#ededed" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_product; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
	&lt;th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_model; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
	&lt;th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_quantity; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
	&lt;th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_price; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
	&lt;th width="25%" bgcolor="#ededed" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:14px; word-wrap:break-word;"&gt;
		&lt;b&gt;&lt;?php echo $text_total; ?&gt;&lt;/b&gt;
	&lt;/th&gt;
&lt;/tr&gt;</code></pre>

					<p><b>FIND:</b></p>
					<pre class="prettyprint"><code>&lt;td bgcolor="&lt;?php echo $row_style_background; ?&gt;" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;"&gt;
	&lt;?php if($product['quantity'] &gt; 1) { echo $product['quantity']; ?&gt; &lt;b&gt;x&lt;/b&gt; &lt;?php } echo $product['price']; ?&gt;
&lt;/td&gt;</code></pre>

					<p><b>REPLACE:</b></p>
					<pre class="prettyprint"><code>&lt;td bgcolor="&lt;?php echo $row_style_background; ?&gt;" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;"&gt;
	&lt;?php echo $product['model']; ?&gt;
&lt;/td&gt;
&lt;td bgcolor="&lt;?php echo $row_style_background; ?&gt;" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;"&gt;
	&lt;?php echo $product['quantity']; ?&gt;
&lt;/td&gt;
&lt;td bgcolor="&lt;?php echo $row_style_background; ?&gt;" style="text-align:right; -ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:12px; border-bottom:1px solid #e0e0e0; border-left:1px solid #e0e0e0;"&gt;
	&lt;?php echo $product['price']; ?&gt;
&lt;/td&gt;</code></pre>

					<p><b>REMOVE:</b></p>
					<pre class="prettyprint"><code>&lt;br /&gt;&lt;b&gt;&lt;?php echo $text_model; ?&gt;:&lt;/b&gt; &lt;?php echo $product['model']; ?&gt;:</code></pre>

					<p class='faq-question'>Fatal error: Call to undefined method stdClass :: MsgHTML ()</p>
					<p class='faq-answer'>
						If you have installed phpMailer you need to make sure the settings
						for your store Mail are: SMTP instead of PHP mail(). <br />As an
						example we can use google mail settings: <br />Mail Protocol: SMTP
						<br />SMTP Host: smtp.gmail.com (OR smtp.yourmail.server) <br />SMTP
						Username: myemail@gmail.com <br />SMTP Password: password <br />SMTP
						Port: 465 (465=SSL // 587=TLS // 25=SMTP standard) <br />Note: <br />-
						For SSL you may need to enable extension: php_openssl <br />-
						There is no guarantee this will work with your email hosting
						provider, depending if they allow remote emails to be sent.
					</p>

					<p><b>Store front:</b></p>
					<pre class="prettyprint"><code>
$template = new EmailTemplate($this-&gt;request, $this-&gt;registry);			
$template-&gt;setTitle($this-&gt;config-&gt;get('config_title'));

$mail-&gt;setHtml($template-&gt;fetch('customer_register.tpl', '_main.tpl'));
  		</code></pre>

					<p><b>Admin backend:</b></p>
					<pre class="prettyprint"><code>$template = new EmailTemplate($this-&gt;request, $this-&gt;registry);			

// Overwrite config with store data
$this-&gt;load-&gt;model('setting/setting');
$this-&gt;load-&gt;model('setting/store');
$store_info = $this-&gt;model_setting_store-&gt;getStore($store_id);
$store_settings_config = $this-&gt;model_setting_setting-&gt;getSetting("config", $store_id);
$template-&gt;populateStoreData(array_merge($store_settings_config, $store_info));

// Overwrite config with email data
$et_store = $this-&gt;model_setting_setting-&gt;getSetting("emailtemplate", $store_id);
$template-&gt;populateEmailData($et_store);

$template-&gt;setThemeDir('mail');            

$template-&gt;setTitle($this-&gt;config-&gt;get('config_title'));

$mail-&gt;setHtml($template-&gt;fetch('customer_register.tpl', '_main.tpl'));</code></pre>

					<p class='faq-question'>How do I remove the editor from Order history? Possible it could conflict with another module not compatible with the editor.</p>
					<p class='faq-answer'>Remove the following from vqmod: emailtemplate_admin.xml</p>
					<pre class="prettyprint"><code>&lt;file name="admin/controller/sale/order.php"&gt;
	&lt;operation&gt;
		&lt;search position="replace"&gt;&lt;![CDATA[
		nl2br($result['comment'])
		]]>&lt;/search>
		&lt;add trim="true"&gt;&lt;![CDATA[
			  (strcmp($result['comment'], strip_tags($html_str = html_entity_decode($result['comment'], ENT_QUOTES, 'UTF-8'))) == 0) ? nl2br($result['comment']) : $html_str
		]]>&lt;/add&gt;
	&lt;/operation&gt;
	&lt;operation&gt;
		&lt;search position="replace"&gt;&lt;![CDATA[
		nl2br($order_info['comment'])
		]]>&lt;/search&gt;
		&lt;add trim="true"&gt;&lt;![CDATA[
			  (strcmp($order_info['comment'], strip_tags($html_str = html_entity_decode($order_info['comment'], ENT_QUOTES, 'UTF-8'))) == 0) ? nl2br($order_info['comment']) : $html_str
		]]>&lt;/add&gt;
	&lt;/operation&gt;
&lt;/file&gt;</code></pre>
					
					<pre class="prettyprint"><code>&lt;operation error="skip"&gt;
	&lt;search position="replace"&gt;&lt;![CDATA[
	comment = '" . $this-&gt;db-&gt;escape(strip_tags($data['comment'])) . "'
	]]&gt;&lt;/search&gt;
	&lt;add trim="true"&gt;&lt;![CDATA[
	comment = '" . $this-&gt;db-&gt;escape($data['comment']) . "'
	]]&gt;&lt;/add&gt;
&lt;/operation&gt;</code></pre>
				  
					<pre class="prettyprint"><code>&lt;file name="admin/view/template/sale/order_info.tpl"&gt;
	&lt;operation&gt;
		&lt;search position="replace" index="1"&gt;&lt;![CDATA[
		&lt;script type="text/javascript"&gt;&lt;!--
		]]&gt;&lt;/search&gt;
		&lt;add&gt;&lt;![CDATA[
		&lt;script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"&gt;&lt;/script&gt;
		&lt;script type="text/javascript"&gt;&lt;!--
		CKEDITOR.replace('comment', {
			filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=&lt;?php echo $token; ?&gt;',
			filebrowserUploadUrl: 'index.php?route=common/filemanager&token=&lt;?php echo $token; ?&gt;',
			filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=&lt;?php echo $token; ?&gt;'
		});
		]]&gt;&lt;/add&gt;
	&lt;/operation&gt;
	&lt;operation error="skip"&gt;
		&lt;search position="after"&gt;&lt;![CDATA[
		$('#button-history').live('click', function() {
		]]&gt;&lt;/search&gt;
		&lt;add&gt;&lt;![CDATA[
		// Force CKEDITOR instance in the form to update their respective fields
		CKEDITOR.instances.comment.updateElement();
		]]&gt;&lt;/add&gt;
	&lt;/operation&gt;
	&lt;operation error="skip"&gt;&lt;!-- old versions of OC --&gt;
		&lt;search position="after"&gt;&lt;![CDATA[
		function history() {
		]]&gt;&lt;/search&gt;
		&lt;add&gt;&lt;![CDATA[
		// Force CKEDITOR instance in the form to update their respective fields
		CKEDITOR.instances.comment.updateElement();
		]]&gt;&lt;/add&gt;
	&lt;/operation&gt;
	&lt;operation&gt;
		&lt;search position="before"&gt;&lt;![CDATA[
		$('textarea[name=\'comment\']').val('');
		]]&gt;&lt;/search&gt;
		&lt;add&gt;&lt;![CDATA[
		// Clear CKEDITOR data
		CKEDITOR.instances.comment.setData('');
		]]&gt;&lt;/add&gt;
	&lt;/operation&gt;
&lt;/file&gt;</code></pre>

					<p>Replace:</p>
					<pre class="prettyprint"><code>'comment' =&gt; ($data['comment']) ? html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8') : '',
		
'comment' =&gt; ($data['comment'] != '' ? str_replace(array("\r\n", "\r", "\n"), "&lt;br /&gt;", $data['comment']) : false),</code></pre>

				</div>
				<!-- #faq -->

				<div class="section clearfix" id="tab-faq-pdf" style="min-height: 353px; display: none">
					<h2>PDF/tdpdf Common Errors</h2>
										
					<p class='faq-question'>Warning: <b>"file_exists(): open_basedir restriction in effect. File(/tmp) is not within the allowed path(s): (/var/www/vhosts/www.site.co.uk/httpdocs)"</b>?</p>
					<div class='faq-answer'>
						<p>Your host has disabled the ability to write to the <a href="http://www.php.net/manual/en/function.sys-get-temp-dir.php" target="_blank">system temp path</a>, the most secure way to to write temporary files outside of the document root.</p>
						<p>Firstly ask your host if they offer a different way to write to the system temporary folder? Worst case scenario you will need to write into the system/cache, open system/library/shared/tcpdf/config/tcpdf_config.php.</p>
						
						Replace:
						<pre class="prettyprint"><code>define ('K_PATH_CACHE', sys_get_temp_dir().'/');</code></pre>
						
						With:
						<pre class="prettyprint"><code>define ('K_PATH_CACHE', DIR_CACHE);</code></pre>
					</div>
										
					<p class='faq-question'>Warning: <b>"is_dir(): open_basedir restriction in effect. File(/var/www/vhosts/www.site.co.uk/httpdocs/../resources/2013-11-28/)"</b>?</p>
					<div class='faq-answer'>
						<p>For extra security the PDf invoices are saved outside of the document root, if your host does not allow this you can change the path in: admin/model/module/emailtemplate/invoice.php</p>
						
						Replace:
						<pre class="prettyprint"><code>$dir = str_replace('/system/', '', DIR_SYSTEM) . '/../resources/'.date('Y-m-d').'/'; </code></pre>
						
						With:
						<pre class="prettyprint"><code>$dir = DIR_SYSTEM.'resources/'.date('Y-m-d').'/';</code></pre>
					</div>
					
				</div>
				<!-- #faq -->

				<div class="section clearfix" id="tab-changelog" style="min-height: 353px; display: none">
					<h2>Changelog</h2>

					<h3>Version 4.5</h3>
					<ul>
						<li>Save email templates into database with short codes.</li>
						<li>Complete rewrite of the main email template wrapper so that this is now fluid/responsive.</li>
						<li>Add extra order summary(product, totals, vouchers &amp; downloads) into order status emails.</li>
					</ul>

					<h3>Version 4.4.19</h3>
					<ul>
						<li>Display the contact us message with line breaks</li>
						<li>Force long words onto separate lines such as a long link.</li>
					</ul>

					<h3>Version 4.4.18</h3>
					<ul>
						<li>Fixed bug in contact email from</li>
						<li>Fixed bug in email template admin if only 1 theme</li>
						<li>Fixed php warning for store logo if not exists</li>
						<li>Added Language: Norwegian - from Frode Stordalen</li>
						<li>Improved vqmod selector to order_info.tpl to ensure that ckeditor is loaded below the element</li>
					</ul>

					<h3>Version 4.4.9 AND 4.4.10</h3>
					<ul>
						<li>Removed HTTP_IMAGE, this was causing far too many problems with modifying config file for latest opencart where this has been removed in opencart core now<br /> If you are running a multi-store I would still recommend making this change to config  file <a href="http://forum.opencart.com/viewtopic.php?f=20&t=41737">here</a>.</li>
					</ul>

					<h3>Version 4.4.8</h3>
					<ul>
						<li>Bug fix latest opencart</li>
					</ul>

					<h3>Version 4.4.7</h3>
					<ul>
						<li>Added option to turn off logo resize, been known to cause problems with PNGs</li>
					</ul>

					<h3>Version 4.4.5</h3>
					<ul>
						<li>Added product ID, SKU, quantity remaining into the admin order email</li>
					</ul>

					<h3>Version 4.4.4</h3>
					<ul>
						<li>Added option for really large stores with 10+ languages/stores</li>
					</ul>

					<h3>Version 4.4.3</h3>
					<ul>
						<li>Added customer name to admin order email subject. XML and language changes</li>
						<li>Added option to split email template extension code by store. Turn on with: <pre class="prettyprint"><code>$this->data['multi_store'] = true;</code></pre> in admin/controller/module/emailtemplate.php</li>
					</ul>

					<h3>Version 4.4.2</h3>
					<ul>
						<li>Added auto width/height calculation for Voucher Theme Image (modified: vqmod/xml/emailtemplate_admin.xml &amp; admin/view/template/mail/customer_voucher.tpl)</li>
					</ul>

					<h3>Version 4.4.1</h3>
					<ul>
						<li>Small bug fix to email_template.php</li>
					</ul>

					<h3>Version 4.4</h3>
					<ul>
						<li>Further updates to all email templates after Android and iPad</li>
					</ul>

					<h3>Version 4.3 - Email Template Updates</h3>
					<ul>
						<li>OUTLOOK BACKGROUND IMAGE SUPPORT (apart from the repeating shadow)</li>
						<li>Improve Mobile text display</li>
						<li>Improve layout for CSS compatibility</li>
						<li>Heading/Footer position top with increased browser support</li>
						<li>Added left/right border when images are disabled</li>
					</ul>

					<h3>Version 4.2.3</h3>
					<ul>
						<li><p>Added text_mail_welcome to the customer register email, so this will now not conflict with other extensions using the old welcome text</p></li>
					</ul>

					<h3>Version 4.2.2</h3>
					<ul>
						<li><p>Improved _main.tpl</p></li>
					</ul>

					<h3>Version 4.2.1</h3>
					<ul>
						<li><p>Fixed typos.</p></li>
					</ul>

					<h3>Version 4.2</h3>
					<ul>
						<li><p>Added extra template options: Email Width, Email Padding, Header Border, Footer Position Top, Footer Image/BG Color.</p></li>
						<li><p>Added editor background color change.</p></li>
						<li><p>Added customer groups to admin email.</p></li>
					</ul>

					<h3>Version 4.1.23</h3>
					<ul>
						<li><p>Added customer group name to Admin emails for Customer Register and Order. </p></li>
					</ul>

					<h3>Version 4.1.22</h3>
					<ul>
						<li><p>Added option to send email to customer with login details when manually inserting via admin.</p></li>
					</ul>

					<h3>Version 4.1.21</h3>
					<ul>
						<li><p>Added option to admin to turn off image resize.</p></li>
						<li><p>Account login now able to pass the email in the URL and auto populate the login.</p></li>
					</ul>

					<h3>Version 4.1.20</h3>
					<ul>
						<li><p>Fixed multi-store bug where the store URL was incorrect when sending order history, change to _main.tpl</p></li>
					</ul>

					<h3>Version 4.1.18</h3>
					<ul>
						<li><p>Added ability to add fixed width/height to the logo, this means that Safari(iphone etc) will display the alternate logo text if images are disabled.</p></li>
					</ul>

					<h3>Version 4.1.17</h3>
					<ul>
						<li><p>Fixed OC bug with newsletter and customer groups in old version of OC.</p></li>
						<li><p>Unsubscribe link can now be translated based on the default store language.</p></li>
						<li><p>Fixed bug in older version of opencart in: emailtemplate_backwards_151-1512.xml.</p></li>
					</ul>

					<h3>Version 4.1.16</h3>
					<ul>
						<li><p>Fixed: utf8_ errors and multi-store unsubscribe link.</p></li>
					</ul>

					<h3>Version 4.1.13</h3>
					<ul>
						<li><p>Added: option to display Order picture in Customer Order emails.</p></li>
					</ul>

					<h3>Version 4.1.12</h3>
					<ul>
						<li><p>Added: option to display Order picture in Customer Order emails.</p></li>
						<li><p>Added: header text, for added small text above the header.</p></li>
						<li><p>Fixed bug in Order Status History and Newsletter with a multi-store setup ensure that the email is sent From the correct store email.</p></li>
					</ul>

					<h3>Version 4.1.11</h3>
					<ul>
						<li><p>Fixed bug in mail templates missing body-link-color</p></li>
						<li><p>Fixed bug in order history when comments are saved in both HTML and new line separators - submitted by Package Tracking developer</p></li>
					</ul>

					<h3>Version 4.1.10</h3>
					<ul>
						<li><p>Fixed bug in admin order invoice for Opencart 1.5.1.3</p></li>
					</ul>

					<h3>Version 4.1.9</h3>
					<ul>
						<li><p>Fixed bug in admin order invoice print.</p></li>
					</ul>

					<h3>Version 4.1.8</h3>
					<ul>
						<li><p>Fixed bug in admin order history editor when using "&amp;".</p></li>
						<li><p>Extension uninstall/install rename vqmod files from "*.xml" to "*.xml_".</p></li>
					</ul>

					<h3>Version 4.1.7</h3>
					<ul>
						<li><p>Fixed bug in customer forgotten password. File: customer_forgotten.tpl, Replace: $text_new_password, With: $text_password.</p></li>
					</ul>

					<h3>Version 4.1.6</h3>
					<ul>
						<li><p>Added extra code in the Admin Module to check that vqmod has the correct write permissions.</p></li>
						<li><p>Moved static theme variables(Bg color & Font Color) into editable options in the Body tab. Updated _main.tpl</p></li>
						<li><p>Admin Order History upgrade comment textarea to use CKeditor.</p></li>
						<li><p>Contact Us Admin email added user information.</p></li>
					</ul>

					<h3>Version 4.1.5</h3>
					<ul>
						<li><p>Fixed bug in admin module: emailtemplate.php and emailtemplate.tpl</p></li>
					</ul>

					<h3>Version 4.1.3 + 4.1.4</h3>
					<ul>
						<li><p>Added order link to Admin Order Email.</p></li>
						<li><p>Added ability to have multiple products in Returns.</p></li>
						<li><p>Added product details to Product Review email.</p></li>
						<li><p>Fixed bug with Customer Approval.</p></li>
						<li><p>Fixed bug HTTP_ADMIN is not defined in config.php.</p></li>
					</ul>

					<h3>Version 4.1.2</h3>
					<ul>
						<li><p>Fixed bug Order Update to only show account login if the customer registered during checkout.</p></li>
						<li><p>Fixed bug with email layout when forwarding email.</p></li>
						<li><p>Fixed bug with old PHP versions and admin module.</p></li>
						<li><p>Added code for OC 1.5.1.3 to remove attachment, this was accidently overwritten in recent updates.</p></li>
					</ul>

					<h3>Version 4.1.1</h3>
					<ul>
						<li><p>Fixed bugs in DB with settings and serialized. Error: Notice: unserialize() [function.unserialize]: Error at offset 0 of 1 bytes.</p>
							<p>Check that the index.php and admin/index.php contains:</p> 
							<pre class="prettyprint"><code>foreach ($query-&gt;rows as $setting) {
   if (!empty($setting['serialized'])) {
      $config-&gt;set($setting['key'], unserialize($setting['value']));
   } else {
      $config-&gt;set($setting['key'], $setting['value']);
   }
}

NOT: if (isset($setting['serialized'])) {</code></pre></li>
						<li><p>Fixed bug with Customer Registration and Customer Group Approval.</p></li>
						<li><p>Added language translations to admin Customer Registration.</p></li>
						<li><p>Added link to admin customers if Customer requires approval.</p></li>
					</ul>

					<h3>Version 4.1</h3>
					<ul>
						<li><p>File changes</p>
							<p>
								<strong>Added:</strong>
							</p>
							<ol>
								<li>catalog/view/theme/*/themplate/mail/order_customer.tpl</li>
								<li>catalog/view/theme/*/themplate/mail/voucher_customer.tpl</li>
								<li>catalog/view/theme/*/themplate/mail/product_review.tpl</li>
								<li>catalog/view/theme/*/themplate/mail/return_admin.tpl</li>
							</ol>
							<p><strong>Deleted:</strong></p>
							<ol>
								<li>admin/view/template/mail/_main.tpl - Safe to delete if this is a duplcaite of "_main.tpl" in your theme/*/template/mail directory.</li>
							</ol></li>
						<li>Added new emails for:
							<ol>
								<li>Product Review: notify admins when you have a review awaiting approval.</li>
								<li>Product Returns: notify admins when you have recieved a new return.</li>
							</ol>
						</li>
						<li><p>Updated email_template.php so that you only need 1 _main.tpl in your theme directory.<br /> <strong>If you haven't made any changes you can delete <i>admin/view/template/mail/_main.tpl</i>.</strong></p></li>
						<li><p>Updated Order Email</p>
							<ul>
								<li>Product Options bullet points.</li>
								<li>Product Options admin added options to alter character limit and font size.</li>
								<li>Fixed bug in order comments and payment instructions.</li>
							</ul></li>
						<li><p>Fixed bugs in <b>Hotmail</b> repeating footer background and removing the &lt;body&gt; tab.</p></li>
						<li><p>Clean up code in admin module and bug in opencart if admin has moermission to install/uninstall module.</p></li>
					</ul>

					<h3>Version 4.0.6</h3>
					<ul>
						<li><p>Fixed bug in <b>Admin Newsletter</b> so that the unsubscribe link is only shown for customers (not affiliates).</p></li>
						<li><p>Fixed bug where _main.tpl was using the `store_title` instead of the `store_name`.</p></li>
						<li><p>Fixed bug if payment: Bank Transfer and comment both selected.</p></li>
						<li><p>Fixed bug if <b>Customer Registrater</b> for Newsletters.</p></li>
					</ul>

					<h3>Version 4.0.5</h3>
					<ul>
						<li><p>Fixed bug in admin module and compatible with the preview.</p></li>
						<li><p>Updated _main.tpl</p></li>
					</ul>

					<h3>Version 4.0.1</h3>
					<ul>
						<li>
							<p>Added jquery Color picker @author: Stefan Petre <a href="http://www.eyecon.ro" target="_blank">www.eyecon.ro</a> </p>
						</li>
					</ul>
				</div>
				<!-- #changelog -->

				<div class="section clearfix" id="tab-terms" style="min-height: 353px; display: none">
					<h2>Terms of Use</h2>

					<h3>DISCLAIMER:</h3>
					<p>Under no circumstances can this software be sold, given to
						another person or publically posted.</p>
					<p>The modification is provided on an "AS IS" basis, without
						warranty of any kind, including without limitation the warranties
						of merchantability, fitness for a particular purpose and
						non-infringement. The entire risk as to the quality and
						performance of the Software is borne by you.</p>
					<p>
						Install this mod at your own risk. <br /> Should the modification
						prove defective, you and not the author assume the entire cost of
						any service and repair.
					</p>

					<h3>Restrictions of Use:</h3>
					<p>Your installation of these software mods signifies your agreement to the following:</p>
					
					<ol>
						<li>You will not resell or give these software mods away to others without prior written consent from opencart-templates.co.uk.</li>
						<li>Each software mod will only be installed on the domain for which you purchased a license.</li>
						<li>Title, ownership rights, and intellectual property rights of the software shall remain with opencart-templates.co.uk.</li>
					</ol>
					<p>Copyright laws protect these software mods.</p>
				</div>
				<!-- #terms -->

				<div class="section clearfix" id="tab-support" style="min-height: 353px; display: none">
					<h2>Support</h2>

					<p>Please open a support ticket at: <a href="<?php echo $support_url; ?>">support.opencart-templates.co.uk</a></p>
					<p>The more informaton you can provide will help in getting your issue resolved quicker:</p>
					<ol>
						<li>Opencart version</li>
						<li>vQmod or manual install?
							<ul>
								<li>Do you have any vqmod errors(vqmod/vqmod.log)?</li>
								<li>Is the correct file appearing in the vqmod cache(vqmod/vqcache)?</li>
								<li>Does the vqmod folder have the correct write permissions?</li>
							</ul>
						</li>
						<li>If you are getting an error that points to a file: then send this file in your email. (Notice: Undefined variable: config_theme in /var/www/catalog/view/example.php) then send example.php</li>
						<li>Ideally include a URL or details of which page is causing the problem saying "It isn't working" does not help anybody.</li>
					</ol>
				</div>
				<!-- #support -->

				<div class="section clearfix" id="tab-compatible" style="min-height: 353px; display: none">
					<h2>Other Compatible Extensions:</h2>

					<p>Below is a list of extensions we have already tested/built integration script.</p>
					<p>This extension has been built so that it can be easily integrated
						with other extesions if they are not listed below, see above
						example code from FAQ above or have a look at these vqmods for
						examples. If you require assastance please open a <a href="<?php echo $support_url; ?>">support ticket</a>.
					</p>

					<ul>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=1548" target="_blank">Abandoned Orders</a> - &dollar;25.00</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6246" target="_blank">Contact Us - Adanced</a> - &dollar;15.00</li>
						<li><a href="http://www.e-piksel.com/free-extensions/customer-support-page-oc-free006-15x.html" target="_blank">Customer Support Page</a> - <b>FREE</b></li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=5932" target="_blank">Dutch Post NL & DHL4You Tracking 1.5.1.3</a> - <b>FREE</b></li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=8192" target="_blank">Drop Ship Vendor & One Page Order View w/Email</a> - &dollar;29.00</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=7904" target="_blank">American Style Layaway & Payment System</a> - &dollar;49.00</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6193" target="_blank">Facebook Marketing + FB Connect </a> - &dollar;29.99</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=2860" target="_blank">Multi Vendor / Drop Shipper</a> - &dollar;159.90</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4433" target="_blank">Package Tracking Service</a> - &dollar;25.00</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4348" target="_blank">Tell A Friend Form</a> - <b>FREE</b></li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6625" target="_blank">Resend Order Email</a> - &dollar;19.95</li>
						<li><a href="http://www.opencart.com/index.php?route=extension/extension/info&extension_id=573" target="_blank">Request Reviews</a> - &dollar;13.00</li>
					</ul>

					<p class="small">Note: price accurate at the time of writing.</p>
				</div>
				<!-- #terms -->

				<div class="support">
					<hr style="background: #CCCCCC; border: none; height: 1px; padding: 0; margin: 35px 0 0" />
					<p class='footerThanks'>Designed and developed by <a href="http://www.opencart-templates.co.uk/">Ben Johnson</a>.</p>
				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript" src="view/javascript/highlight/prettify.js"></script>
<script type="text/javascript"><!--
var $tabs = $('.vtabs a');
$tabs.tabs();

(function($){				
	$(document).ready(function() {
		prettyPrint();

		$('.open-tab').click(function(e){
			e.preventDefault();
			$tabs.filter('a[href='+$(this).attr('href')+']').click();
		});
	});	
})(jQuery);
//--></script>
<?php echo $footer; ?>