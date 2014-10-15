<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<table class="radio">
  <?php foreach ($payment_methods as $payment_method) { ?>
  <tr class="highlight" style='border-bottom: 1px dotted #d3d3d3'>
    <td style='vertical-align: top; padding-top: 10px;'><?php if ($payment_method['code'] == $code || !$code) { ?>
      <?php $code = $payment_method['code']; ?>
      <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" checked="checked" />
      <?php } else { ?>
      <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="<?php echo $payment_method['code']; ?>" />
      <?php } ?></td>
    <td><label for="<?php echo $payment_method['code']; ?>"><?php echo $payment_method['title']; ?></label>
      <?php if($payment_method['code'] == "authorizenet_aim") { ?>
        <img src='images/ccards.jpg' title='We accept AMEX, MasterCard, Visa, and Discover. ' />
      <?php } ?>
    </td>
  </tr>
  <?php } ?>
</table>
<br />
<?php } ?>
<b style='visibility: hidden; display: none;'><?php echo $text_comments; ?></b>
<textarea name="comment" rows="8" style="width: 98%;visibility: hidden; display: none;"><?php echo $comment; ?></textarea>
<br style='visibility: hidden; display: none;' />
<br />
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="right"><?php echo $text_agree; ?>
    <?php if ($agree) { ?>
    <input type="checkbox" name="agree" value="1" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="agree" value="1" />
    <?php } ?>
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" class="button" />
  </div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script> 
