<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<!--
<pre>
<?php // echo print_r(get_defined_vars()); ?>
</pre>
-->
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div class="product-info">
    <?php if ($thumb || $images) { ?>
    <div class="left">
      <?php if ($thumb) { ?>
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
      <?php } ?><!--
      <?php if ($images) { ?>
      <div class="image-additional">
        <?php foreach ($images as $image) { ?>
        <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
        <?php } ?>
      </div> -->
      <?php } ?>
    </div>
    <?php } ?>
    <div class="right">
<!--      <div class="description">
        <?php if ($manufacturer) { ?>
        <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
        <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
        <span><?php echo $text_stock; ?></span> <?php echo $stock; ?>
     </div> -->

      <?php if ($options) { ?>
<?php if(substr($model,0,1) === '2') { ?>
<!-- CONTROL BOARD -->

<div id='controlBoard'>

<div id='baseSoftwareBlock' style='background-color: #cccccc;border: 1px solid #820024; padding: 10px; margin:10px;width: auto; display: block;'>
<b><?php echo $jan; ?></b>
<div class='priceTag' style='font-weight: bold; font-size: 16px; display: inline-block; float:right; text-align: right;'><?php echo $price; ?></div>
<div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#w2-forms-filer'>Click here for more information</a></div>
</div>

<div style='display: block; border: 0px solid lightgrey; padding: 10px 10px 0px 10px; width:auto;'>
  <div style='display: inline-block;'><h2>Available Options</h2></div>
</div>


  <div id='laserGenerationBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectLaser' id='selectLaser' value='1' />
    <label for='selectLaser' style='font-weight: bold;'>Software Generated Forms</label>
    <div class='priceTag' style='font-weight: bold; font-size: 16px; display: inline-block; float:right; text-align: right;'>+ $75.00</div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#software-generated-forms'>Click here for more information</a></div>
  </div>
    
<div id='amsPayrollBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectAMSpayroll' id='selectAMSpayroll' value='1'  /> 
    <label for='selectAMSpayroll' style='font-weight: bold;'>AMS Payroll</label>
    <div class='priceTag' style='font-weight: bold; font-size: 16px; display: inline-block; float:right; text-align: right;'>+ $105.00</div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#ams-payroll'>Click here for more information</a></div>
  </div>

<div id='eFileBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectEfile' id='selectEfile' value='1' />
    <label for='selectEfile' style='font-weight: bold;'>E-File Direct</label>
    <div class='priceTag' style='font-weight: bold; font-size: 16px; display: inline-block; float:right; text-align: right;'>+ $105.00</div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#e-file'>Click here for more information</a></div>
  </div>

<div id='formsFilerBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectFormsFiler' id='selectFormsFiler' value='1' />
    <label for='selectFormsFiler' style='font-weight: bold;'>Forms Filer Plus</label>
    <div class='priceTag' style='font-weight: bold; font-size: 16px; display: inline-block; float:right; text-align: right;'>+ $45.00</div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#forms-filer-plus'>Click here for more information</a></div>
  </div>


</div>
<br />



<!-- CONTROL BOARD -->
<?php } ?>


      <div class="options" style='<?php if(substr($model,0,1) === '2') { ?>display: none;<?php } ?>'>
        <h2><?php echo $text_option; ?></h2>
        <br />
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>





        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="cart">
        <div><?php echo $text_qty; ?>
          <input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
          &nbsp;
          <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" />
<!--           <span>&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;</span>
          <span class="links"><a onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a><br />
            <a onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></span> -->

      <?php if ($price) { ?><input type='hidden' name='baseprice' id='baseprice' value='<?php echo $price; ?>' />
      <div class="price" id='priceBlock' style='float: right;'><?php echo $text_price; ?>
        <?php if (!$special) { ?>
        <?php echo $price; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
        <?php } ?>
        <br />
        <?php if ($tax) { ?>
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
        <?php } ?>
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
        <?php } ?>
        <?php if ($discounts) { ?>
        <br />
        <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>




        </div>
        <?php if ($minimum > 1) { ?>
        <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
      <?php if ($review_status) { ?>
      <div class="review">
        <div><img src="catalog/view/theme/amsTheme/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $text_write; ?></a></div>
        <div class="share"><!-- AddThis Button BEGIN -->
          <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
          <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
          <!-- AddThis Button END --> 
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
  <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
    <?php if ($attribute_groups) { ?>
    <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
    <?php } ?>
    <?php if ($review_status) { ?>
    <a href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
    <?php if ($products) { ?>
    <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    <?php } ?>
  </div>
  <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
  <?php if ($attribute_groups) { ?>
  <div id="tab-attribute" class="tab-content">
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td style='text-align: left;'><?php echo nl2br($attribute['text']); ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <?php } ?>
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content">
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 16px;"><?php echo $text_note; ?></span><br />
    <br />
    <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
    <input type="radio" name="rating" value="1" />
    &nbsp;
    <input type="radio" name="rating" value="2" />
    &nbsp;
    <input type="radio" name="rating" value="3" />
    &nbsp;
    <input type="radio" name="rating" value="4" />
    &nbsp;
    <input type="radio" name="rating" value="5" />
    &nbsp;<span><?php echo $entry_good; ?></span><br />
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="" />
    <br />
    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
    <br />
    <div class="buttons">
      <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
    </div>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  <div id="tab-related" class="tab-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/amsTheme/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a></div>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
  <?php if ($tags) { ?>
  <div class="tags"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/amsTheme/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/amsTheme/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/amsTheme/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//--></script> 








<script>


  $(function(){
    // Make the options radio buttons invisible
    $(".options").hide();

    // Create the 'Easy to use' interface
    var eFileDirectContainerID  = document.getElementsByClassName("option")[0].id;
    var payrollLaserContainerID = document.getElementsByClassName("option")[1].id;
    var formsFilerContainerID   = document.getElementsByClassName("option")[2].id;

    var eFileRadioIDarray = new Array();
    var payrollLaserRadioIDarray = new Array();
    var formsFilerRadioIDarray = new Array();

    $("#" + eFileDirectContainerID + " input:radio").each(function (index) {
      eFileRadioIDarray[index] = $(this)[0].id;
    });

    $("#" + payrollLaserContainerID + " input:radio").each(function (index) {
      payrollLaserRadioIDarray[index] = $(this)[0].id;
    });

    $("#" + formsFilerContainerID + " input:radio").each(function (index) {
      formsFilerRadioIDarray[index] = $(this)[0].id;
    });
    
    // Set up the defaults
    document.getElementById(eFileRadioIDarray[eFileRadioIDarray.length - 1]).checked = true;
    document.getElementById(payrollLaserRadioIDarray[payrollLaserRadioIDarray.length - 1]).checked = true;
    document.getElementById(formsFilerRadioIDarray[formsFilerRadioIDarray.length - 1]).checked = true;

    priceUpdate();

//    alert(eFileRadioIDarray[eFileRadioIDarray.length - 1]);
    $("#button-cart").click(function() {
      this.reset();
    });

    $("input").change(function() {

      if($('#selectEfile').attr("checked")) {      
        document.getElementById(eFileRadioIDarray[0]).checked = true;
      }
      else {
        document.getElementById(eFileRadioIDarray[1]).checked = true;
      }

      if($('#selectAMSpayroll').attr("checked") && $('#selectLaser').attr('checked')) {
        document.getElementById(payrollLaserRadioIDarray[2]).checked = true;
      }
      if(! $('#selectAMSpayroll').attr("checked") && ! $('#selectLaser').attr('checked')) {
        document.getElementById(payrollLaserRadioIDarray[3]).checked = true;
      }
      if($('#selectAMSpayroll').attr("checked") && ! $('#selectLaser').attr('checked')) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = true;
      }
      if(! $('#selectAMSpayroll').attr("checked") && $('#selectLaser').attr('checked')) {
        document.getElementById(payrollLaserRadioIDarray[1]).checked = true;
      }

      if($('#selectFormsFiler').attr("checked")) {      
        document.getElementById(formsFilerRadioIDarray[0]).checked = true;
      }
      else {
        document.getElementById(formsFilerRadioIDarray[1]).checked = true;
      }

      // Colorations of the divs
      
      // Laser Generation Block
      if($('#selectLaser').attr('checked')) {
        $('#laserGenerationBlock').css("background-color","#cccccc");
        $('#laserGenerationBlock').css("border","1px solid #820024");
      }
      else {
        $('#laserGenerationBlock').css("background-color","transparent");
        $('#laserGenerationBlock').css("border","1px solid lightgray");
      }

// Laser Generation Block
      if($('#selectEfile').attr('checked')) {
        $('#eFileBlock').css("background-color","#cccccc");
        $('#eFileBlock').css("border","1px solid #820024");
      }
      else {
        $('#eFileBlock').css("background-color","transparent");
        $('#eFileBlock').css("border","1px solid lightgray");
      }

      // Laser Generation Block
      if($('#selectAMSpayroll').attr('checked')) {
        $('#amsPayrollBlock').css("background-color","#cccccc");
        $('#amsPayrollBlock').css("border","1px solid #820024");
      }
      else {
        $('#amsPayrollBlock').css("background-color","transparent");
        $('#amsPayrollBlock').css("border","1px solid lightgray");
      }

      // Forms Filer Plus Block
      if($('#selectFormsFiler').attr('checked')) {
        $('#formsFilerBlock').css("background-color","#cccccc");
        $('#formsFilerBlock').css("border","1px solid #820024");
      }
      else {
        $('#formsFilerBlock').css("background-color","transparent");
        $('#formsFilerBlock').css("border","1px solid lightgray");
      }

    priceUpdate();
    });

    $('#button-cart').click(function() {
      $('#selectLaser').prop("checked", false);
      $('#laserGenerationBlock').css("background-color","transparent");
      $('#laserGenerationBlock').css("border","1px solid lightgray");

      $('#selectEfile').prop("checked", false);
      $('#eFileBlock').css("background-color","transparent");
      $('#eFileBlock').css("border","1px solid lightgray");

      $('#selectAMSpayroll').prop("checked", false);
      $('#amsPayrollBlock').css("background-color","transparent");
      $('#amsPayrollBlock').css("border","1px solid lightgray");

      $('#selectFormsFiler').prop("checked", false);
      $('#formsFilerBlock').css("background-color","transparent");
      $('#formsFilerBlock').css("border","1px solid lightgray");
    });

  });

/*
<div id='controlBoard'>
  <input type='checkbox' name='selectEfile'      id='selectEfile'      value='1'  /> : Efile Direct<br />
  <input type='checkbox' name='selectAMSpayroll' id='selectAMSpayroll' value='1'  /> : AMS Payroll<br />
  <input type='checkbox' name='selectLaser'      id='selectLaser' value='1'  /> : Laser Generation<br />
  <input type='checkbox' name='selectFormsFiler' id='selectFormsFiler' value='1'  /> : Forms Filer Plus<br />
</div>
<br />
*/




// Calculate the price of the purchase and modify the #priceBlock information. This is for display only.
function priceUpdate() {

  var eFileRadioIDarray = new Array();
  var payrollLaserRadioIDarray = new Array();
  var formsFilerRadioIDarray = new Array();

  var eFileDirectContainerID  = document.getElementsByClassName("option")[0].id;
  var payrollLaserContainerID = document.getElementsByClassName("option")[1].id;
  var formsFilerContainerID   = document.getElementsByClassName("option")[2].id;

  $("#" + eFileDirectContainerID + " input:radio").each(function (index) {
    eFileRadioIDarray[index] = $(this)[0].id;
  });

  $("#" + payrollLaserContainerID + " input:radio").each(function (index) {
    payrollLaserRadioIDarray[index] = $(this)[0].id;
  });

  $("#" + formsFilerContainerID + " input:radio").each(function (index) {
    formsFilerRadioIDarray[index] = $(this)[0].id;
  });

  // We will need to extract the price information from each radio button label. It is currently formatted as (+$XXX.XX)

//  var price = 75.00;

  var price0 = $('#baseprice').val();
  var price = Number(price0.replace(/[^0-9\.]+/g,""));

  var regExp = /\$([^)]+)\)/;

  // E-File - Upgrade E-File + 0 / 0 / 105
  var eFileUpgradePrice0 = $("label[for=" + eFileRadioIDarray[0] + "]").text();
  eFileUpgradePrice0 = regExp.exec(eFileUpgradePrice0);

  if($("#" + eFileRadioIDarray[0]).is(":checked")) {
    price = parseFloat(price) + parseFloat(eFileUpgradePrice0[1]);
  }

  $('#eFileBlock .priceTag').html('+ $' + eFileUpgradePrice0[1]);

  // Payroll and Laser 0 / 0 / 0 / 0 / 75 / 105 / 180 / 75 / 105
  var payrollLaser0 = $("label[for=" + payrollLaserRadioIDarray[0] + "]").text();
  payrollLaser0 = regExp.exec(payrollLaser0);

  if($("#" + payrollLaserRadioIDarray[0]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser0[1]);
  }

  var payrollLaser1 = $("label[for=" + payrollLaserRadioIDarray[1] + "]").text();
  payrollLaser1 = regExp.exec(payrollLaser1);

  if($("#" + payrollLaserRadioIDarray[1]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser1[1]);
  }

  var payrollLaser2 = $("label[for=" + payrollLaserRadioIDarray[2] + "]").text();
  payrollLaser2 = regExp.exec(payrollLaser2);

  if($("#" + payrollLaserRadioIDarray[2]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser2[1]);
  }

//  var payrollLaser3 = $("label[for=" + payrollLaserRadioIDarray[3]).text();
//  payrollLaser3 = regExp.exec(payrollLaser3);

//  if($("#" + payrollLaserRadioIDarray[3]).is(":checked")) {
//    price = parseFloat(price) + parseFloat(payrollLaser3[1]);
//  }

  $('#laserGenerationBlock .priceTag').html('+ $' + payrollLaser1[1]);
  $('#amsPayrollBlock .priceTag').html('+ $' + payrollLaser0[1]);
  // Forms Filer 0 / 0 / 45

  var formsFiler0 = $("label[for=" + formsFilerRadioIDarray[0] + "]").text();
  formsFiler0 = regExp.exec(formsFiler0);

  if($("#" + formsFilerRadioIDarray[0]).is(":checked")) {
    price = parseFloat(price) + parseFloat(formsFiler0[1]);
  }

  $('#formsFilerBlock .priceTag').html('+ $' + formsFiler0[1]);

  price = parseFloat(price);
  $("#priceBlock").html("Total: $" + price.toFixed(2));


  // Check priceTag labels
  ///////////////////////////////////////////////////////////////////////////////
  if($('#selectFormsFiler').attr('checked')) {  
//    $('#formsFilerBlock .priceTag').html('Selected!');
  }
  else {
    $('#formsFilerBlock .priceTag').html('+ $' + formsFiler0[1]);
  }
  
  if($('#selectAMSpayroll').attr('checked')) {
 //   $('#amsPayrollBlock .priceTag').html('Selected!');
  }
  else {
    $('#amsPayrollBlock .priceTag').html('+ $' + payrollLaser0[1]);
  }

  if($('#selectEfile').attr('checked')) {
//    $('#eFileBlock .priceTag').html('Selected!');
  }
  else {
    $('#eFileBlock .priceTag').html('+ $' + eFileUpgradePrice0[1]);
  }

  if($('#selectLaser').attr('checked')) {
//    $('#laserGenerationBlock .priceTag').html('Selected!');
  }
  else {
    $('#laserGenerationBlock .priceTag').html('+ $' + payrollLaser1[1]);
  }

}


</script>



<?php echo $footer; ?>
