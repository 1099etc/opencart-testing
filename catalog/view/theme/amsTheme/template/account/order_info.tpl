<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <div style='margin-bottom:10px; padding: 0; float: left; width: 100%;'>
    <h1 style='display: inline-block; margin: 0; padding: 0; vertical-align: middle; float: left;'><?php echo $heading_title; ?></h1>
    <a style="display: inline-block; float: right; margin-top:10px;vertical-align:middle;" href="javascript:window.location=window.location.href.replace('info','resend');" class="button"><span>Resend Order Confirmation Email</span></a>
  </div>

  <table class="list">
    <thead>
      <tr>
        <td class="left" colspan="2"><?php echo $text_order_detail; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left" style="width: 50%;"><?php if ($invoice_no) { ?>
          <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
          <?php } ?>
          <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b> <?php echo date('d M Y', strtotime(str_replace('/','-',$date_added))); ?></td>
        <td class="left" style="width: 50%;"><?php if ($payment_method) { ?>
          <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          <?php } ?>
          <?php if ($shipping_method) { ?>
          <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $text_shipping_address; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $shipping_address; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_name; ?></td>
        <td class="right"><?php echo $column_quantity; ?></td>
        <td class="right"><?php echo $column_price; ?></td>
        <td class="right"><?php echo $column_total; ?></td>
        <?php if ($products) { ?>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="left"><?php echo $product['name']; ?>
<?php
      if((strpos($product['model'], "1099-FormsFiler") !== false) && (strpos($product['model'], "upg-") === false)) {
        $tmp_option_data = array();
        foreach($product['option'] as $X => $O) {
          if($O['value'] == 'No Thank You') {
            unset($product['option'][$X]);
          }
          $tmp_option_data[0]['value'] = "W-2 / 1099 Forms Filer";
          $tmp_option_data[0]['name'] = '';

          if(stripos($O['value'], "Software Generated Forms") !== false)  {
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
        foreach($product['option'] as $X => $O) {
          if($O['value'] == 'No Thank You') {
            unset($product['option'][$X]);
          }
          if(stripos($O['value'], "Soft") !== false)  {
            $tmp_option_data[0]['value'] = "Software Generated Forms";
            $tmp_option_data[0]['name'] = '';
          }
          if(stripos($O['value'], "AMS Payroll") !== false) {
            $tmp_option_data[1]['value'] = "AMS Payroll";
            $tmp_option_data[1]['name'] = '';
          }
          if(stripos($O['value'], "E-File Direct") !== false) {
            $tmp_option_data[2]['value'] = "E-File Direct";
            $tmp_option_data[2]['name'] = '';
          }
          if(stripos($O['value'], "Forms Filer Plus") !== false) {
            $tmp_option_data[3]['value'] = "Forms Filer Plus";
            $tmp_option_data[3]['name'] = '';
          }
//          if(stripos($O['name'], "Serial") !== false) {
//            $tmp_option_data[4]['value'] = "Original Serial Number: " . $O['value'] ;
//            $tmp_option_data[4]['name'] = '';
//          }

        }
        $product['option'] = $tmp_option_data;
        ksort($product['option']);
      }

?>



          <?php foreach ($product['option'] as $option) { ?>
          <br />
<!--           &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small> -->
          &nbsp;<small> - <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td class="right"><?php echo $product['quantity']; ?></td>
        <td class="right"><?php echo $product['price']; ?></td>
        <td class="right"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="left"><?php echo $voucher['description']; ?></td>
        <td class="right">1</td>
        <td class="right"><?php echo $voucher['amount']; ?></td>
        <td class="right"><?php echo $voucher['amount']; ?></td>
        <?php if ($products) { ?>
        <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="2"></td>
        <td class="right"><b><?php echo $total['title']; ?>:</b></td>
        <td class="right"><?php echo $total['text']; ?></td>
        <?php if ($products) { ?>
        <?php } ?>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
  <?php if ($comment) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>

    <?php if(isset($downloads) && $order_status_id == 5) { ?>

    <h2>Available Downloads</h2>
    <table class='list'>
      <thead>
        <tr>
          <td class='left'>File</td>
          <td class='left'>Version</td>
          <td class='left'>Release Notes</td>
          <td class='left'>Release Date</td>
          <td class='left'>Size</td>
          <td class='left'>Action</td>
        </tr>
      </thead>
      
      <?php foreach ($downloads as $download) { ?>
      <tr>
        <td class="left"><?php echo $download['mask']; ?></td>
        <td class="left"><?php echo $download['version']; ?></td>
        <td class="left"><a class='inline' href='#hidden-<?php echo $download["download_id"]; ?>' title='<?php echo $download["name"] . " - " . $download["version"]; ?>' >Click to View</a></td>
        <td class="left"><?php echo date('d M Y', strtotime(str_replace('/','-',$download['date_added']))); ?></td>
        <td class="left"><?php echo $download['filesize']; ?></td>
        <td class="left"><a href="index.php?route=account/amsupdate/download&serial=<?php echo $product['serials'][0]; ?>&download_id=<?php echo $download['download_id']; ?>">Download Link</a></td>
      </tr>
        <?php
          $fileYear = substr($download['mask'], -8, 4);
        ?>

        <?php if(stripos($download['mask'], "upd")) { ?>
          <tr>
            <td colspan='6' style='font-size: .8em; font-style: italic;'>Select this file if you are updating an already installed <?php echo $fileYear; ?> program.</td>
          </tr>
        <?php } ?>
        <?php if(stripos($download['mask'], "full")) { ?>
          <tr>
            <td colspan='6' style='font-size: .8em; font-style: italic;'>Select this file if you are installing the <?php echo $fileYear; ?> program for the first time.</td>
          </tr>
        <?php } ?>


      <?php } ?>
    </table>

    <?php foreach ($downloads as $download) { ?>
      <div style='display: none;'>
        <div id='hidden-<?php echo $download["download_id"]; ?>' style='padding: 10px; background:#FFF;'>
        <?php echo htmlspecialchars_decode($download['notes']); ?>
        </div>
      </div>
    <?php } ?>
    <?php } ?>

  <?php if ($histories) { ?>
  <h2><?php echo $text_history; ?></h2>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added; ?></td>
        <td class="left"><?php echo $column_status; ?></td>
        <td class="left"><?php echo $column_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td class="left"><?php echo date('d M Y', strtotime(str_replace('/','-',$history['date_added']))); ?></td>
        <td class="left"><?php echo $history['status']; ?></td>
        <td class="left"><?php echo $history['comment']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 
