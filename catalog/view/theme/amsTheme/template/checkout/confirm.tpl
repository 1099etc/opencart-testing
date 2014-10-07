<?php if (!isset($redirect)) { ?>
<div class="checkout-product">
  <table>
    <thead>
      <tr>
        <td class="name"><?php echo $column_name; ?></td>
<!--         <td class="model"><?php echo $column_model; ?></td> -->
         <td class="model">&nbsp;</td> 
        <td class="quantity"><?php echo $column_quantity; ?></td>
        <td class="price"><?php echo $column_price; ?></td>
        <td class="total"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="name"><!-- <a href="<?php echo $product['href']; ?>"> --><?php echo $product['name']; ?><!-- </a> -->
<?php
      if((strpos($product['model'], "1099-FormsFiler") !== false) && (strpos($product['model'], "upg-") === false)) {        $tmp_option_data = array();
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
        //  if(stripos($O['name'], "Serial") !== false) {
        //    $tmp_option_data[4]['value'] = "Original Serial Number: " . $O['value'] ;
        //    $tmp_option_data[4]['name'] = '';
        //  }

        }
        $product['option'] = $tmp_option_data;
        ksort($product['option']);
      }

?>

          <?php foreach ($product['option'] as $option) { ?>
          <br />
<!--          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small> -->
          &nbsp;<small> - <?php echo $option['value']; ?></small>
          <?php } ?></td>
<!--        <td class="model"><?php echo $product['model']; ?></td> -->
        <td class="model">&nbsp;</td> 
        <td class="quantity"><?php echo $product['quantity']; ?></td>
        <td class="price"><?php echo $product['price']; ?></td>
        <td class="total"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="name"><?php echo $voucher['description']; ?></td>
         <td class="model"></td> 
        <td class="quantity">1</td>
        <td class="price"><?php echo $voucher['amount']; ?></td>
        <td class="total"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="4" class="price"><b><?php echo $total['title']; ?>:</b></td>
        <td class="total"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<div class="payment"><?php echo $payment; ?></div>
<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script> 
<?php } ?>
