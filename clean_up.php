<?php
/*
 * Delete all files/folders for professional HTMl email template.
 * 
 * Move this file into your store root
 *
 */
set_time_limit (0);
error_reporting(E_ALL ^ E_NOTICE ^E_WARNING);
ini_set("display_errors" , 1);

if(isset($_POST['confirm'])){
	$files = array(
		"admin/controller/module/emailtemplate.php",
		
		"admin/language/english/mail/customer_.php",
		"admin/language/english/mail/order_.php",
		"admin/language/english/mail/return_.php",
		"admin/language/english/module/emailtemplate.php",
		"admin/language/english/sale/contact_.php",
		"admin/language/english/sale/customer_.php",
		"admin/language/english/sale/invoice.php",
		"admin/language/english/sale/order_.php",
		"admin/language/english/sale/return_.php",
		"admin/language/english/setting/store_.php",
		
		"admin/model/module/emailtemplate.php",
		"admin/model/module/emailtemplate/install.sql",
		"admin/model/module/emailtemplate/invoice.php",
		
		/* "admin/view/image/colorpicker/blank.gif",
		"admin/view/image/colorpicker/colorpicker_background.png",
		"admin/view/image/colorpicker/colorpicker_hex.png",
		"admin/view/image/colorpicker/colorpicker_hsb_b.png",
		"admin/view/image/colorpicker/colorpicker_hsb_h.png",
		"admin/view/image/colorpicker/colorpicker_hsb_s.png",
		"admin/view/image/colorpicker/colorpicker_indic.gif",
		"admin/view/image/colorpicker/colorpicker_overlay.png",
		"admin/view/image/colorpicker/colorpicker_rgb_b.png",
		"admin/view/image/colorpicker/colorpicker_rgb_g.png",
		"admin/view/image/colorpicker/colorpicker_rgb_r.png",
		"admin/view/image/colorpicker/colorpicker_select.gif",
		"admin/view/image/colorpicker/colorpicker_submit.png",
		"admin/view/image/colorpicker/custom_background.png",
		"admin/view/image/colorpicker/custom_hex.png",
		"admin/view/image/colorpicker/custom_hsb_b.png",
		"admin/view/image/colorpicker/custom_hsb_h.png",
		"admin/view/image/colorpicker/custom_hsb_s.png",
		"admin/view/image/colorpicker/custom_indic.gif",
		"admin/view/image/colorpicker/custom_rgb_b.png",
		"admin/view/image/colorpicker/custom_rgb_g.png",
		"admin/view/image/colorpicker/custom_rgb_r.png",
		"admin/view/image/colorpicker/custom_submit.png",
		"admin/view/image/colorpicker/select.png",
		"admin/view/image/colorpicker/select2.png",
		"admin/view/image/colorpicker/slider.png", */
		
		"admin/view/image/emailtemplate-sprite.png",
		"admin/view/image/mediaIcons.png",
		"admin/view/image/vQmod_Icon.png",
		
		"admin/view/javascript/codemirror/LICENSE",
		"admin/view/javascript/codemirror/codemirror-compressed.js",
		"admin/view/javascript/codemirror/codemirror.css",
		"admin/view/javascript/highlight/prettify.js",
		"admin/view/javascript/jquery/colorpicker.js",
		
		"admin/view/stylesheet/colorpicker.css",
		"admin/view/stylesheet/module/emailtemplate.css",
		
		"admin/view/template/mail/customer_insert.tpl",
		"admin/view/template/mail/order_update.tpl",
		"admin/view/template/mail/return_history.tpl",
		"admin/view/template/module/emailtemplate/config.tpl",
		"admin/view/template/module/emailtemplate/docs.tpl",
		"admin/view/template/module/emailtemplate/extension.tpl",
		"admin/view/template/module/emailtemplate/language_file_form.tpl",
		"admin/view/template/module/emailtemplate/language_files.tpl",
		"admin/view/template/module/emailtemplate/template_form.tpl",
		
		"catalog/language/english/account/address_.php",
		"catalog/language/english/account/newsletter_.php",
		"catalog/language/english/account/password_.php",
		"catalog/language/english/account/return_.php",
		"catalog/language/english/english.php",
		"catalog/language/english/information/contact_.php",
		"catalog/language/english/mail/affiliate_.php",
		"catalog/language/english/mail/customer_.php",
		"catalog/language/english/mail/forgotten_.php",
		"catalog/language/english/mail/order_.php",
		"catalog/language/english/mail/review.php",
		
		"catalog/model/module/emailtemplate.php",
		
		"catalog/view/theme/default/template/mail/_main.tpl",
		"catalog/view/theme/default/template/mail/contact_admin.tpl",
		"catalog/view/theme/default/template/mail/customer_register_admin.tpl",
		"catalog/view/theme/default/template/mail/order_admin.tpl",
		"catalog/view/theme/default/template/mail/order_customer.tpl",
		"catalog/view/theme/default/template/mail/order_update.tpl",
		"catalog/view/theme/default/template/mail/return_admin.tpl",
		
		"image/data/emailtemplate/gray/bottom_left.png",
		"image/data/emailtemplate/gray/bottom_right.png",
		"image/data/emailtemplate/gray/top_left.png",
		"image/data/emailtemplate/gray/top_right.png",
		"image/data/emailtemplate/head-bg.jpg",
		"image/data/emailtemplate/white/bottom_left.png",
		"image/data/emailtemplate/white/bottom_right.png",
		"image/data/emailtemplate/white/top_left.png",
		"image/data/emailtemplate/white/top_right.png",
		
		"system/library/emailtemplate/email_template.php",
		"system/library/emailtemplate/emailtemplate.css",
		
		"system/library/shared/CssToInlineStyles/CHANGELOG.md",
		"system/library/shared/CssToInlineStyles/CssToInlineStyles.php",
		"system/library/shared/CssToInlineStyles/Exception.php",
		"system/library/shared/CssToInlineStyles/LICENSE.md",
		"system/library/shared/CssToInlineStyles/README.md",
		
		"system/library/shared/html2text.php",
		
		"system/library/shared/tcpdf/CHANGELOG.TXT",
		"system/library/shared/tcpdf/LICENSE.TXT",
		"system/library/shared/tcpdf/README.TXT",
		"system/library/shared/tcpdf/config/tcpdf_config.php",
		"system/library/shared/tcpdf/fonts/helvetica.php",
		"system/library/shared/tcpdf/fonts/helveticab.php",
		"system/library/shared/tcpdf/fonts/helveticabi.php",
		"system/library/shared/tcpdf/fonts/helveticai.php",
		"system/library/shared/tcpdf/include/tcpdf.EasyTable.php",
		"system/library/shared/tcpdf/include/tcpdf.PDFImage.php",
		"system/library/shared/tcpdf/include/tcpdf_colors.php",
		"system/library/shared/tcpdf/include/tcpdf_filters.php",
		"system/library/shared/tcpdf/include/tcpdf_font_data.php",
		"system/library/shared/tcpdf/include/tcpdf_fonts.php",
		"system/library/shared/tcpdf/include/tcpdf_images.php",
		"system/library/shared/tcpdf/include/tcpdf_static.php",
		"system/library/shared/tcpdf/tcpdf.php",
		"system/library/shared/tcpdf/tcpdf_autoconfig.php",
		
		"vqmod/xml/0pencart_emailtemplate.xml",	
		'\vqmod\xml\emailtemplate.xml',
		'\vqmod\xml\emailtemplate_admin.xml',
		'\vqmod\xml\emailtemplate_languages.xml',
		'\vqmod\vqcache',
		'\vqmod\mods.cache'
	);
	
	/**
     * Delete a file or recursively delete a directory
     *
     * @param string $str Path to file or directory
     */
    function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
	
	foreach($files as $file){
		recursiveDelete(dirname(__FILE__) . $file);		
	}
	
	echo 'Done!';		
	exit;
}
?>

<form action="" method="post">
	<fieldset>		
		<label>
			<input type="checkbox" name="confirm" value="1" />
			Confirm delete all extension files
		</label>
		<br />
		<input type="submit" value="Yes" />
	</fieldset>
</form>