<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<!--<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">-->
<div style="width: 590px;"><!--<a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>"><img src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" style="margin-bottom: 20px; border: none;" /></a>-->
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_greeting; ?></p>
<?php if(isset($AlertMessage) && $AlertMessage) { ?>
    <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
      <thead>
        <tr>
          <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">
            There has been an update to your order.
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
          <?php echo $AlertMessage; ?>
          </td>
        </tr>
      </tbody>
    </table>
  <?php } ?>
  
<?php
  $have_serial = false;
  $upgrade_order = false;
  foreach ($products as $product)
  {
    if($product['serials'])
    {
      $have_serial = true;
    }
    if(strpos($product['model'], "upg") !== false)
    {
      $upgrade_order = true;
    }
  }  

  ?>
  <?php if($have_serial) : ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="1">
          Serial Numbers and Key Codes
        </td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product) { ?>

      <?php if($product['serials']) : ?>
        <tr>
          <td colspan="1" style="font-family: monospace; font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo implode('<br />', $product['serials']); ?> </td>
        </tr>
      <?php endif; ?>
    <?php } ?>
    </tbody>
  </table>
  <?php endif; ?>
  <?php if($upgrade_order) : ?>
    <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
        <thead>
              <tr>
                      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="1">
                               Upgrade Instructions
                                        </td>
                                              </tr>
                                                  </thead>
                                                      <tbody>
                         
          <tr>
      <td colspan="1" style="font-family: monospace; font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><a href='http://www.1099-etc.com/reserialize-program'>Click here</a> for installation instructions on upgrading 1099-Etc. </td>
     </tr>
    
        </tbody>
    </table>
  <?php endif; ?>

  <?php if ($customer_id) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_link; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
  <?php } ?>
 <!-- <?php if ($download) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_download; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $download; ?>"><?php echo $download; ?></a></p>
  <?php } ?>-->
  <p style="margin-top: 0px; margin-bottom: 20px;">Need compatible forms?</p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="http://1099-etc.nelcosolutions.com/">Click Here</a> to order your forms online!</p>

  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2"><?php echo $text_order_detail; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b> <?php echo date("d M Y",strtotime(str_replace("/","-",$date_added))); ?><br />
          <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          <b><?php if (isset($po_number) && strlen(trim($po_number)) > 0) { ?> <?php echo $text_po_number; ?></b> <?php echo $po_number; ?><br /><?php } ?>
          <?php if (strlen(trim($shipping_method)) > 0 && trim($shipping_method) != "<br>") { ?>
          <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
          <?php } ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b><?php echo $text_email; ?></b> <?php echo $email; ?><br />
          <b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?><br />
          <b><?php echo $text_ip; ?></b> <?php echo $ip; ?><br /></td>
      </tr>
    </tbody>
  </table>
  <?php if ($comment) { ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_instruction; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_shipping_address; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $shipping_address; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; width: 40%; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_product; ?></td>
        <td style="font-size: 12px; width: 20%; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_quantity; ?></td>
        <td style="font-size: 12px; width: 20%; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_price; ?></td>
        <td style="font-size: 12px; width: 20%; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['name']; ?>
          <?php
      if((strpos($product['model'], "1099-FormsFiler") !== false) && (strpos($product['model'], "upg-") === false)) {       
         $tmp_option_data = array();
        foreach($product['option'] as $X => $O) {
          if($O['value'] == 'No Thank You') {
           // unset($product['option'][$X]);
          }
          $tmp_option_data[0]['value'] = "W-2 / 1099 Forms Filer";
          $tmp_option_data[0]['name'] = '';

          if(stripos($O['value'], "Soft") !== false)  {
            $tmp_option_data[1]['value'] = "Software Generated Forms";
            $tmp_option_data[1]['name'] = '';
          }
          if(stripos($O['value'], "AMS Payroll") !== false) {
            $tmp_option_data[2]['value'] = "AMS Payroll";
            $tmp_option_data[2]['name'] = '';
          }
          if(stripos($O['value'], "E-File Direct") !== false) {
            $tmp_option_data[3]['value'] = "E-File Direct";
            $tmp_option_data[3]['name'] = '';
          }
          if(stripos($O['value'], "Forms Filer Plus") !== false) {
            $tmp_option_data[4]['value'] = "Forms Filer Plus";
            $tmp_option_data[4]['name'] = '';
          }

        }
        $product['option'] = $tmp_option_data;
        ksort($product['option']);
      }
      elseif(strpos($product['model'], "upg") !== false) {
        $tmp_option_data = array();
       // echo('<pre>');
       // print_r($product['option']);
       // echo('</pre>');
          $tmp_option_data[0]['value'] = "W-2 / 1099 Forms Filer";
          $tmp_option_data[0]['name'] = '';
        foreach($product['option'] as $X => $O) {
          if($O['value'] == 'No Thank You') {
            //unset($product['option'][$X]);
          }
          if(stripos($O['value'], "Soft") !== false)  {
            $tmp_option_data[1]['value'] = "Software Generated Forms";
            $tmp_option_data[1]['name'] = '';
          }
          if(stripos($O['value'], "AMS Payroll") !== false) {
            $tmp_option_data[2]['value'] = "AMS Payroll";
            $tmp_option_data[2]['name'] = '';
          }
          if(stripos($O['value'], "E-File Direct") !== false) {
            $tmp_option_data[3]['value'] = "E-File Direct";
            $tmp_option_data[3]['name'] = '';
          }
          if(stripos($O['value'], "Forms Filer Plus") !== false) {
            $tmp_option_data[4]['value'] = "Forms Filer Plus";
            $tmp_option_data[4]['name'] = '';
          }
          //if(stripos($O['name'], "Serial") !== false) {
            //$tmp_option_data[5]['value'] = "Original Serial Number: " . $O['value'] ;
            //$tmp_option_data[5]['name'] = '';
          //}

        }
        $product['option'] = $tmp_option_data;
        ksort($product['option']);
      }
      elseif(strpos($product['model'], "repl-cd") !== false) {
        $product['option'] = array();
      }
?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['quantity']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['price']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $product['total']; ?></td>
      </tr>
      <?php if($product['serials']) : ?>
        <tr style="background-color: #eeeeee">
          <td colspan="1" style="text-align: right; padding-right: 10px"><strong><?php echo $text_serial_keys; ?></strong></td>
          <td colspan="3" style="font-family: monospace;"><?php echo implode('<br />', $product['serials']); ?> </td>
        </tr>
      <?php endif; ?>
      <tr><td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4">&nbsp;</td></tr>
    <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['description']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">1</td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $voucher['amount']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="3"><b><?php echo $total['title']; ?>:</b></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<!--</body>
</html>-->
