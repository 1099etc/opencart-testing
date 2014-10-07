<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>

<?php

//$this->load->model("catalog/serial");


//if(! $this->model_catalog_serial->validSerial("abc123")) {
//  echo "NO SIR<br />";
//}

//if(! $this->model_catalog_serial->validSerial("3D1234PXX")) {
//  echo "YES SIR<br />";
//}

?>




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
      <?php } ?>
      <?php if ($images) { ?>
      <div class="image-additional">
        <?php foreach ($images as $image) { ?>
        <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="right">
      <div class="description">
        <?php if ($manufacturer) { ?>
        <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><input type='hidden' id='model' name='model' value='<?php echo $model; ?>' /><br />
        <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
        </div>
      <?php if ($price) { ?>
      <div class="price" id="priceBlock"><?php echo $text_price; ?>
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

      <?php if ($options) { ?>
      <div class="options" style='<?php if(substr($model,0,1) === '2') { ?>display: none;<?php } ?>'>
        <h2><?php echo $text_option; ?></h2>
        <br />

<!-- CONTROL BOARD -->
<div id='controlBoard'>
  <div id='laserGenerationBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectLaser' id='selectLaser' value='1' />
    <label id='selectLaserLabel' for='selectLaser' style='font-weight: bold;'>Software Generated Forms <span style='font-weight:normal;font-size:.75em;'>(previously known as Laser Generation)</span></label>
    <div class='priceTag' id='laserPrice' style='font-weight: bold; font-size: 14px; display: inline-block; float:right; text-align: right;'></div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#software-generated-forms'>Click here for more information on the Software Generated Forms Module</a></div>
  </div>
    
  <div id='amsPayrollBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectAMSpayroll' id='selectAMSpayroll' value='1'  /> 
    <label id='selectAMSpayrollLabel' for='selectAMSpayroll' style='font-weight: bold;'>AMS Payroll (Formerly A-T-F Payroll Option)</label>
    <div class='priceTag' id='payrollPrice' style='font-weight: bold; font-size: 14px; display: inline-block; float:right; text-align: right;'></div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#ams-payroll'>Click here for more information on the AMS Payroll Module</a></div>
  </div>

  <div id='eFileBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectEfile' id='selectEfile' value='1' />
    <label id='selectEfileLabel' for='selectEfile' style='font-weight: bold;'>E-File Direct</label>
    <div class='priceTag' id='efilePrice' style='font-weight: bold; font-size: 14px; display: inline-block; float:right; text-align: right;'></div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#e-file'>Click here for more information on the E-File Module</a></div>
  </div>

  <div id='formsFilerBlock' style='display: block; border: 1px solid lightgrey; padding: 10px; margin: 10px; width:auto;'>
    <input type='checkbox' name='selectFormsFiler' id='selectFormsFiler' value='1' />
    <label id='selectFormsFilerLabel' for='selectFormsFiler' style='font-weight: bold;'>Forms Filer Plus</label>
    <div class='priceTag' id='formsfilerPrice' style='font-weight: bold; font-size: 14px; display: inline-block; float:right; text-align: right;'></div>
    <div class='descriptiveText' style='padding-top: 10px;'><a href='<?php echo $_SERVER['REQUEST_URI'];?>#forms-filer-plus'>Click here for more information on the Forms Filer Plus Module</a></div>
  </div>

 <input type='hidden' name='FC1' id='FC1' value='' />
 <input type='hidden' name='FC2' id='FC2' value='' />
 <input type='hidden' name='FC3' id='FC3' value='' />
</div>
<br />
<!-- CONTROL BOARD -->
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
          <b><?php echo $option['name']; ?>: </b><br />
          
          <?php if($option['option_value'] == 'serialEntry') {?>
            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" id="<?php echo $option['option_value']; ?>" value="<?php echo isset($_REQUEST['serial']) ? $_REQUEST['serial'] : ''; ?>" />
          <?php } else { ?>
            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
          <?php } ?>
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
          <span>&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;</span>
          <span class="links"><a onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a><br />
            <a onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></span>
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
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
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
  
  totalPrice = returnPrice();
  if(totalPrice > 0) {

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
  } // End If
  else {
    alert("You have not selected any upgrades yet.");
  }

});

function returnPrice() {

  var eFileRadioIDarray = new Array();
  var payrollLaserRadioIDarray = new Array();
  var formsFilerRadioIDarray = new Array();

  var eFileDirectContainerID  = document.getElementsByClassName("option")[1].id;
  var payrollLaserContainerID = document.getElementsByClassName("option")[2].id;
  var formsFilerContainerID   = document.getElementsByClassName("option")[3].id;

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

  var price = 0.00 ;
  var regExp = /\$([^)]+)\)/;

  // E-File - Upgrade E-File + 0 / 0 / 105
  var eFileUpgradePrice2 = $("label[for=" + eFileRadioIDarray[2] + "]").text();
  eFileUpgradePrice2 = regExp.exec(eFileUpgradePrice2);

  if($("#" + eFileRadioIDarray[2]).is(":checked")) {
    price = parseFloat(price) + parseFloat(eFileUpgradePrice2[1]);
  }

  // Payroll and Laser 0 / 0 / 0 / 0 / 75 / 105 / 180 / 75 / 105
  var payrollLaser4 = $("label[for=" + payrollLaserRadioIDarray[4] + "]").text();
  payrollLaser4 = regExp.exec(payrollLaser4);

  if($("#" + payrollLaserRadioIDarray[4]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser4[1]);
  }

  var payrollLaser5 = $("label[for=" + payrollLaserRadioIDarray[5] + "]").text();
  payrollLaser5 = regExp.exec(payrollLaser5);

  if($("#" + payrollLaserRadioIDarray[5]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser5[1]);
  }

  var payrollLaser6 = $("label[for=" + payrollLaserRadioIDarray[6] + "]").text();
  payrollLaser6 = regExp.exec(payrollLaser6);

  if($("#" + payrollLaserRadioIDarray[6]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser6[1]);
  }

  var payrollLaser7 = $("label[for=" + payrollLaserRadioIDarray[7] + "]").text();
  payrollLaser7 = regExp.exec(payrollLaser7);

  if($("#" + payrollLaserRadioIDarray[7]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser7[1]);
  }

  var payrollLaser8 = $("label[for=" + payrollLaserRadioIDarray[8] + "]").text();
  payrollLaser8 = regExp.exec(payrollLaser8);

  if($("#" + payrollLaserRadioIDarray[8]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser8[1]);
  }

  // Forms Filer 0 / 0 / 45

  var formsFiler2 = $("label[for=" + formsFilerRadioIDarray[2] + "]").text();
  formsFiler2 = regExp.exec(formsFiler2);

  if($("#" + formsFilerRadioIDarray[2]).is(":checked")) {
    price = parseFloat(price) + parseFloat(formsFiler2[1]);
  }

  price = parseFloat(price);
  return price;
}

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





<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->


<script>

$(function(){

  var FC1 = $('#FC1').val();
  var FC2 = $('#FC2').val();
  var FC3 = $('#FC3').val();

  var eFileRadioIDarray = new Array();
  var payrollLaserRadioIDarray = new Array();
  var formsFilerRadioIDarray = new Array();

  var eFileDirectContainerID  = document.getElementsByClassName("option")[1].id;
  var payrollLaserContainerID = document.getElementsByClassName("option")[2].id;
  var formsFilerContainerID   = document.getElementsByClassName("option")[3].id;

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
  document.getElementById(eFileRadioIDarray[0]).checked = false;
  document.getElementById(eFileRadioIDarray[1]).checked = false;
  document.getElementById(eFileRadioIDarray[2]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
  document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
  document.getElementById(formsFilerRadioIDarray[0]).checked = false;
  document.getElementById(formsFilerRadioIDarray[1]).checked = false;
  document.getElementById(formsFilerRadioIDarray[2]).checked = false;

  $("label[for=" + eFileRadioIDarray[0] + "],#" + eFileRadioIDarray[0]).hide();
  $("label[for=" + eFileRadioIDarray[1] + "],#" + eFileRadioIDarray[1]).hide();
  $("label[for=" + eFileRadioIDarray[2] + "],#" + eFileRadioIDarray[2]).hide();

  $("label[for=" + payrollLaserRadioIDarray[0] + "],#" + payrollLaserRadioIDarray[0]).hide();
  $("label[for=" + payrollLaserRadioIDarray[1] + "],#" + payrollLaserRadioIDarray[1]).hide();
  $("label[for=" + payrollLaserRadioIDarray[2] + "],#" + payrollLaserRadioIDarray[2]).hide();
  $("label[for=" + payrollLaserRadioIDarray[3] + "],#" + payrollLaserRadioIDarray[3]).hide();
  $("label[for=" + payrollLaserRadioIDarray[4] + "],#" + payrollLaserRadioIDarray[4]).hide();
  $("label[for=" + payrollLaserRadioIDarray[5] + "],#" + payrollLaserRadioIDarray[5]).hide();
  $("label[for=" + payrollLaserRadioIDarray[6] + "],#" + payrollLaserRadioIDarray[6]).hide();
  $("label[for=" + payrollLaserRadioIDarray[7] + "],#" + payrollLaserRadioIDarray[7]).hide();
  $("label[for=" + payrollLaserRadioIDarray[8] + "],#" + payrollLaserRadioIDarray[8]).hide();

  $("label[for=" + formsFilerRadioIDarray[0] + "],#" + formsFilerRadioIDarray[0]).hide();
  $("label[for=" + formsFilerRadioIDarray[1] + "],#" + formsFilerRadioIDarray[1]).hide();
  $("label[for=" + formsFilerRadioIDarray[2] + "],#" + formsFilerRadioIDarray[2]).hide();

  $("#" + eFileDirectContainerID).hide();
  $("#" + payrollLaserContainerID).hide();
  $("#" + formsFilerContainerID).hide();

  $("#controlBoard").hide();

  $(".options br").remove();

  $('#serialEntry').prop('title','Please enter a valid serial number.');

});

// Calculate the price of the purchase and modify the #priceBlock information. This is for display only.
function priceUpdate() {

  var eFileRadioIDarray = new Array();
  var payrollLaserRadioIDarray = new Array();
  var formsFilerRadioIDarray = new Array();

  var eFileDirectContainerID  = document.getElementsByClassName("option")[1].id;
  var payrollLaserContainerID = document.getElementsByClassName("option")[2].id;
  var formsFilerContainerID   = document.getElementsByClassName("option")[3].id;

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
  
  var price = 0.00 ;
  var regExp = /\$([^)]+)\)/;

  // E-File - Upgrade E-File + 0 / 0 / 105  
  var eFileUpgradePrice2 = $("label[for=" + eFileRadioIDarray[2] + "]").text();
  eFileUpgradePrice2 = regExp.exec(eFileUpgradePrice2);

  if($("#" + eFileRadioIDarray[2]).is(":checked")) { 
    price = parseFloat(price) + parseFloat(eFileUpgradePrice2[1]);
  }

  // Payroll and Laser 0 / 0 / 0 / 0 / 75 / 105 / 180 / 75 / 105
  var payrollLaser4 = $("label[for=" + payrollLaserRadioIDarray[4] + "]").text();
  payrollLaser4 = regExp.exec(payrollLaser4);

  if($("#" + payrollLaserRadioIDarray[4]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser4[1]);
  }

  var payrollLaser5 = $("label[for=" + payrollLaserRadioIDarray[5] + "]").text();
  payrollLaser5 = regExp.exec(payrollLaser5);

  if($("#" + payrollLaserRadioIDarray[5]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser5[1]);
  }

  var payrollLaser6 = $("label[for=" + payrollLaserRadioIDarray[6] + "]").text();
  payrollLaser6 = regExp.exec(payrollLaser6);

  if($("#" + payrollLaserRadioIDarray[6]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser6[1]);
  }

  var payrollLaser7 = $("label[for=" + payrollLaserRadioIDarray[7] + "]").text();
  payrollLaser7 = regExp.exec(payrollLaser7);

  if($("#" + payrollLaserRadioIDarray[7]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser7[1]);
  }

  var payrollLaser8 = $("label[for=" + payrollLaserRadioIDarray[8] + "]").text();
  payrollLaser8 = regExp.exec(payrollLaser8);

  if($("#" + payrollLaserRadioIDarray[8]).is(":checked")) {
    price = parseFloat(price) + parseFloat(payrollLaser8[1]);
  }

  // Forms Filer 0 / 0 / 45

  var formsFiler2 = $("label[for=" + formsFilerRadioIDarray[2] + "]").text();
  formsFiler2 = regExp.exec(formsFiler2);

  if($("#" + formsFilerRadioIDarray[2]).is(":checked")) {
    price = parseFloat(price) + parseFloat(formsFiler2[1]);
  }

  price = parseFloat(price);
  $("#priceBlock").html("Price: $" + price.toFixed(2));
}

// This calls the serial number validation function and returns whether or not a serial number is valid in the database or not.
function serialCheck(strX) {
  var eFileRadioIDarray = new Array();
  var payrollLaserRadioIDarray = new Array();
  var formsFilerRadioIDarray = new Array();

  var eFileDirectContainerID  = document.getElementsByClassName("option")[1].id;
  var payrollLaserContainerID = document.getElementsByClassName("option")[2].id;
  var formsFilerContainerID   = document.getElementsByClassName("option")[3].id;

  $("#" + eFileDirectContainerID + " input:radio").each(function (index) {
    eFileRadioIDarray[index] = $(this)[0].id;
  });

  $("#" + payrollLaserContainerID + " input:radio").each(function (index) {
    payrollLaserRadioIDarray[index] = $(this)[0].id;
  });

  $("#" + formsFilerContainerID + " input:radio").each(function (index) {
    formsFilerRadioIDarray[index] = $(this)[0].id;
  });

  $.ajax({
    type: 'post',
    url: 'index.php?route=product/serial/validSerial&serialNumber=' + $('#serialEntry').val() + '&modelNumber=' + $('#model').val(),
    dataType: 'json',
    success: function(json) {
               if(json['success'] == 'true') {
                 // First, since we have a valid serial number, we should disable the text box so the user cannot change the serial number.
                 $('#serialEntry').attr("disabled", "disabled");
                     
                 // Enable the controlBoard
                 $('#controlBoard').show();
           
                 // Next we should process each of the featurecodes to see what the user has already purchased and allow for certain upgrades.
                 $('#FC1').val(json['FC1'].toUpperCase());
                 $('#FC2').val(json['FC2'].toUpperCase());
                 $('#FC3').val(json['FC3'].toUpperCase());

                 FC1 = $('#FC1').val();
                 FC2 = $('#FC2').val();
                 FC3 = $('#FC3').val();

                 eFileSelector();
                 formsFilerSelector();
                 laserPayrollSelector();
                 priceUpdate();
                 $('#controlBoard').show();
                 $('#serialEntry').parent('div').hide();
                 $('serialEntry').hide();
                 $(".options br").remove();
                 $('.errorBlock').remove();
               }

               if(json['error']) {
                 // This should just mean that the user has not entered a valid serial number into the box yet.
                 // alert(json['error']);
                $('.errorBlock').remove();
                for(i = 0; i < json['error'].length; ++i) {
                  $('#serialEntry').parent('.option').append("<div class='errorBlock' style='background-color: #a44242;color:white; border:1px solid #741b1b;padding:10px; margin:10px;'>" + json['error'][i] + "</div>"); 
                }

               }
             },
    error: function(jqXHR, exception) { 
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
    }
  });

}

// EFile Selector
function eFileSelector() {
  FC1 = $('#FC1').val().toUpperCase();
  
  var eFileRadioIDarray = new Array();
  var eFileDirectContainerID  = document.getElementsByClassName("option")[1].id;
  $("#" + eFileDirectContainerID + " input:radio").each(function (index) {
    eFileRadioIDarray[index] = $(this)[0].id;
  });

  var regExp = /\$([^)]+)\)/;

  switch(FC1) {
    case 'P':
      if($('#selectEfile').prop('checked') == true) {
        document.getElementById(eFileRadioIDarray[0]).checked = false;
        document.getElementById(eFileRadioIDarray[1]).checked = false;
        document.getElementById(eFileRadioIDarray[2]).checked = true;
      }
      else {
        document.getElementById(eFileRadioIDarray[0]).checked = true;
        document.getElementById(eFileRadioIDarray[1]).checked = false;
        document.getElementById(eFileRadioIDarray[2]).checked = false;
      }
      // Figure the price for the control panel
      var efprice = $("label[for=" + eFileRadioIDarray[2]).text();
      efprice2 = regExp.exec(efprice);
      $('#efilePrice').html('+ $' + String(efprice2[1]));


      // Change the CSS of the DIV
      if($('#selectEfile').prop('checked') == true) {
        $('#eFileBlock').css('background-color','lightyellow');
        $('#eFileBlock').css('border','1px solid green');
        $('#eFileBlock .priceTag').html('Added!');
      }
      else {
        $('#eFileBlock').css('background-color','white');
        $('#eFileBlock').css('border','1px solid #d3d3d3');
        $('#efilePrice').html('+ $' + String(efprice2[1]));
      }
      break;

    case 'M':
      $('#selectEfile').prop('checked', true);
      $('#selectEfile').prop('disabled','disabled');
      document.getElementById(eFileRadioIDarray[0]).checked = false;
      document.getElementById(eFileRadioIDarray[1]).checked = true;
      document.getElementById(eFileRadioIDarray[2]).checked = false;
      // Update the price field      
      $('#efilePrice').html("You've already purchased this module.");

      // Change the CSS of the DIV
      $('#eFileBlock').css('background-color','#d3d3d3');
      $('#eFileBlock').css('border','1px solid #8a8a8a');
      $('#eFileBlock').css('color','#8a8a8a');

      break;

    default:
      document.getElementById(eFileRadioIDarray[0]).checked = false;
      document.getElementById(eFileRadioIDarray[1]).checked = false;
      document.getElementById(eFileRadioIDarray[2]).checked = false;
  }
  priceUpdate();
}

// forms filer selector function
function formsFilerSelector() {
  FC3 = $('#FC3').val().toUpperCase();

  var formsFilerRadioIDarray = new Array();
  var formsFilerContainerID   = document.getElementsByClassName("option")[3].id;
  $("#" + formsFilerContainerID + " input:radio").each(function (index) {
    formsFilerRadioIDarray[index] = $(this)[0].id;
  });

  var regExp = /\$([^)]+)\)/;

  switch(FC3) {
    case 'F':
      $('#selectFormsFiler').prop('checked',true);
      $('#selectFormsFiler').prop('disabled','disabled');
      document.getElementById(formsFilerRadioIDarray[0]).checked = false;
      document.getElementById(formsFilerRadioIDarray[1]).checked = true;
      document.getElementById(formsFilerRadioIDarray[2]).checked = false;
      
      // Set the price field
      $('#formsfilerPrice').html("You've already purchased this module.");
      // Change the CSS of the DIV
      $('#formsFilerBlock').css('background-color','#d3d3d3');
      $('#formsFilerBlock').css('border','1px solid #8a8a8a');
      $('#formsFilerBlock').css('color','#8a8a8a');
      break;

    case 'X':
      if($('#selectFormsFiler').prop('checked') == true) {
        document.getElementById(formsFilerRadioIDarray[0]).checked = false;
        document.getElementById(formsFilerRadioIDarray[1]).checked = false;
        document.getElementById(formsFilerRadioIDarray[2]).checked = true;
      }
      else {
        document.getElementById(formsFilerRadioIDarray[0]).checked = true;
        document.getElementById(formsFilerRadioIDarray[1]).checked = false;
        document.getElementById(formsFilerRadioIDarray[2]).checked = false;
      }

      // Figure out the price
      var formsfilerPrice = $("label[for=" + formsFilerRadioIDarray[2]).text();
      var formsfilerPrice2 = regExp.exec(formsfilerPrice);
      $('#formsfilerPrice').html('+ $' + String(formsfilerPrice2[1]));

      // Change the CSS of the DIV
      if($('#selectFormsFiler').prop('checked') == true) {
        $('#formsFilerBlock').css('background-color','lightyellow');
        $('#formsFilerBlock').css('border','1px solid green');
        $('#formsFilerBlock .priceTag').html('Added!');
      }
      else {
        $('#formsFilerBlock').css('background-color','white');
        $('#formsFilerBlock').css('border','1px solid #d3d3d3');
        $('#formsfilerPrice').html('+ $' + String(formsfilerPrice2[1]));
      }

      break;

    default:
      document.getElementById(formsFilerRadioIDarray[0]).checked = false;
      document.getElementById(formsFilerRadioIDarray[1]).checked = false;
      document.getElementById(formsFilerRadioIDarray[2]).checked = false;

  }
  priceUpdate();
}

// laser selector function
function laserPayrollSelector() {
  FC2 = $('#FC2').val().toUpperCase();

  var payrollLaserRadioIDarray = new Array();
  var payrollLaserContainerID = document.getElementsByClassName("option")[2].id;
  $("#" + payrollLaserContainerID + " input:radio").each(function (index) {
    payrollLaserRadioIDarray[index] = $(this)[0].id;
  });

  var regExp = /\$([^)]+)\)/; 

  switch(FC2) {
    case 'A':
      $('#selectAMSpayroll').prop('checked', true);
      $('#selectAMSpayroll').prop('disabled','disabled');
      
      if($('#selectLaser').prop('checked') == true) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
      }
      else {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false; 
      }

      // Figure out the price
      var laserPrice = $("label[for=" + payrollLaserRadioIDarray[4]).text();
      var laserPrice2 = regExp.exec(laserPrice);
      $('#laserPrice').html('+ $' + String(laserPrice2[1]));
     
      $('#payrollPrice').html("You've already purchased this module.");

      // Change the CSS of the DIV
      if($('#selectLaser').prop('checked') == true) {
        $('#laserGenerationBlock').css('background-color','lightyellow');
        $('#laserGenerationBlock').css('border','1px solid green');
        $('#laserGenerationBlock .priceTag').html('Added!');
      }
      else {
        $('#laserGenerationBlock').css('background-color','white');
        $('#laserGenerationBlock').css('border','1px solid #d3d3d3');
        $('#laserPrice').html('+ $' + String(laserPrice2[1]));
      }

      $('#amsPayrollBlock').css('background-color','#d3d3d3');
      $('#amsPayrollBlock').css('border','1px solid #8a8a8a');
      $('#amsPayrollBlock').css('color','#8a8a8a');

      break;

    case 'B':
      $('#selectLaser').prop('checked', true);
      $('#selectAMSpayroll').prop('checked', true);

      $('#selectLaser').prop('disabled','disabled');
      $('#selectAMSpayroll').prop('disabled','disabled');
      document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[2]).checked = true;
      document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[8]).checked = false;

      // Set the price field
      $('#laserPrice').html("You've already purchased this module.");
      $('#payrollPrice').html("You've already purchased this module.");

      // Change the CSS of the DIV
      $('#laserGenerationBlock').css('background-color','#d3d3d3');
      $('#laserGenerationBlock').css('border','1px solid #8a8a8a');
      $('#laserGenerationBlock').css('color','#8a8a8a');

      $('#amsPayrollBlock').css('background-color','#d3d3d3');
      $('#amsPayrollBlock').css('border','1px solid #8a8a8a');
      $('#amsPayrollBlock').css('color','#8a8a8a');

      break;

    case 'L':
      $('#selectLaser').prop('checked', true);
      $('#selectLaser').prop('disabled','disabled');

      if($('#selectAMSpayroll').prop('checked') == true) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = true;
      }
      else {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
      }
      
      // Set the price field
      $('#laserPrice').html("You've already purchased this module.");

      var payrollPrice = $("label[for=" + payrollLaserRadioIDarray[5]).text();
      var payrollPrice2 = regExp.exec(payrollPrice);
      $('#payrollPrice').html('+ $' + String(payrollPrice2[1]));

      // Change the CSS of the DIV
      $('#laserGenerationBlock').css('background-color','#d3d3d3');
      $('#laserGenerationBlock').css('border','1px solid #8a8a8a');
      $('#laserGenerationBlock').css('color','#8a8a8a');

      if($('#selectAMSpayroll').prop('checked') == true) {
        $('#amsPayrollBlock').css('background-color','lightyellow');
        $('#amsPayrollBlock').css('border','1px solid green');
        $('#amsPayrollBlock .priceTag').html('Added!');
      }
      else {
        $('#amsPayrollBlock').css('background-color','white');
        $('#amsPayrollBlock').css('border','1px solid #d3d3d3');
        $('#payrollPrice').html('+ $' + String(payrollPrice2[1]));
      }

      break;

    case 'X':
      if($('#selectAMSpayroll').prop('checked') == true && $('#selectLaser').prop('checked') == true) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
      }
      if($('#selectAMSpayroll').prop('checked') == true && $('#selectLaser').prop('checked') == false) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
      }
      if($('#selectAMSpayroll').prop('checked') == false && $('#selectLaser').prop('checked') == true) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
      }
      if($('#selectAMSpayroll').prop('checked') == false && $('#selectLaser').prop('checked') == false) {
        document.getElementById(payrollLaserRadioIDarray[0]).checked = true;
        document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
        document.getElementById(payrollLaserRadioIDarray[8]).checked = false;
      }

      // Figure out the price
      var laserPrice = $("label[for=" + payrollLaserRadioIDarray[4]).text();
      var laserPrice2 = regExp.exec(laserPrice);
      $('#laserPrice').html('+ $' + String(laserPrice2[1]));

      var payrollPrice = $("label[for=" + payrollLaserRadioIDarray[5]).text();
      var payrollPrice2 = regExp.exec(payrollPrice);
      $('#payrollPrice').html('+ $' + String(payrollPrice2[1]));

      // Change the CSS of the DIV
      if($('#selectLaser').prop('checked') == true) {
        $('#laserGenerationBlock').css('background-color','lightyellow');
        $('#laserGenerationBlock').css('border','1px solid green');
        $('#laserGenerationBlock .priceTag').html('Added!');
      }
      else {
        $('#laserGenerationBlock').css('background-color','white');
        $('#laserGenerationBlock').css('border','1px solid #d3d3d3');
        $('#laserPrice').html('+ $' + String(laserPrice2[1]));
      } 

      if($('#selectAMSpayroll').prop('checked') == true) {
        $('#amsPayrollBlock').css('background-color','lightyellow');
        $('#amsPayrollBlock').css('border','1px solid green');
        $('#payrollPrice').html('Added!');
      }
      else {
        $('#amsPayrollBlock').css('background-color','white');
        $('#amsPayrollBlock').css('border','1px solid #d3d3d3');
        $('#payrollPrice').html('+ $' + String(payrollPrice2[1]));
      }

      break;

    default:
      document.getElementById(payrollLaserRadioIDarray[0]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[1]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[2]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[3]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[4]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[5]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[6]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[7]).checked = false;
      document.getElementById(payrollLaserRadioIDarray[8]).checked = false;

  }
  priceUpdate();
}

$(document).ready(function() {
  serialCheck($("#serialEntry").val());
  priceUpdate();
$('#serialEntry').parent('.option').append("<div class='errorBlock' style='background-color: #a44242;color:white; border:1px solid #741b1b;padding:10px; margin:10px;'>Please enter your complete serial number in the above box and press enter.</div>");
});

$('#serialEntry').change(function() {
  serialCheck($("#serialEntry").val());
  priceUpdate();
});

$('#selectEfile').change(function() {
  eFileSelector();
});

$('#selectFormsFiler').change(function() {
  formsFilerSelector();
});

$('#selectLaser').change(function() {
  laserPayrollSelector();
});

$('#selectAMSpayroll').change(function() {
  laserPayrollSelector();
});

























</script>



<?php echo $footer; ?>
