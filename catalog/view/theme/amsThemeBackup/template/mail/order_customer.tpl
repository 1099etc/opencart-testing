{$emailtemplate.content1}

<?php if(!empty($customer_id)){ ?>
<p class="link">
	<b><?php echo $text_new_link; ?></b><br />
	<span>&raquo;</span>
	<a href="<?php echo $link_tracking; ?>" target="_blank">
		<b><?php echo $link; ?></b>
	</a>
</p>
<?php } ?>

<?php if(!empty($download)){ ?>
<p class="link">
	<b><?php echo $text_new_download; ?></b><br />
	<span class="icon">&raquo;</span>
	<a href="<?php echo $download_tracking; ?>" target="_blank">
		<b><?php echo $download; ?></b>
	</a>
</p>
<?php } ?>

<?php if(!empty($comment)){ ?>
<p class="standard">
	<b><?php echo $text_new_comment; ?></b><br />
	<?php echo $comment; ?>
</p>
<?php } ?>

<?php if(!empty($products)){ ?>
<table cellpadding="5" cellspacing="0" width="100%" class="table1">
<thead>
	<tr>
    	<th bgcolor="#ededed" colspan="2"><?php echo $text_new_order_detail; ?></th>
   	</tr>
</thead>
<tbody>
	<tr>
    	<td bgcolor="#fafafa">
          	<b><?php echo $text_new_order_id; ?></b> <?php echo $order_id; ?><br />
    		<?php if(!empty($invoice_no)){?><b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br /><?php } ?>
          	<b><?php echo $text_new_date_added; ?></b> <?php echo $date_added; ?><br />
          	<b><?php echo $text_new_order_status; ?></b> <?php echo $new_order_status; ?><br />
			<b><?php echo $text_new_payment_method; ?></b> <?php echo $payment_method; ?><br />
          	<?php if ($shipping_method) { ?><b><?php echo $text_new_shipping_method; ?></b> <?php echo $shipping_method; ?><?php } ?>
        </td>
        <td bgcolor="#fafafa">
        	<b><?php echo $text_new_email; ?></b> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a><br />
          	<b><?php echo $text_new_telephone; ?></b> <?php echo $telephone; ?>
        </td>
	</tr>
	<tr>
    	<td bgcolor="#f6f6f6">
    		<p class="address">
    			<strong><?php echo $text_new_payment_address; ?></strong><br />
    			<?php echo $payment_address; ?>
    		</p>
    	</td>
        <td bgcolor="#f6f6f6">
        	<?php if ($shipping_address) { ?>
        	<p class="address">
        		<strong><?php echo $text_new_shipping_address; ?></strong><br />
        		<?php echo $shipping_address; ?>
        	</p>
        	<?php } else { echo "&nbsp;"; }?>
        </td>
	</tr>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>

<table cellpadding="5" cellspacing="0" width="100%" class="table1">
<thead>
	<tr>
        <th width="50%" bgcolor="#ededed"><?php echo $text_new_product; ?></th>
        <th width="25%" bgcolor="#ededed" align="right" class="textRight"><?php echo $text_new_price; ?></th>
        <th width="25%" bgcolor="#ededed" align="right" class="textRight"><?php echo $text_new_total; ?></th>
	</tr>
</thead>
<tbody>
	<?php $i = 0;
	foreach ($products as $product) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
    <tr>
		<td bgcolor="<?php echo $row_style_background; ?>">
			<?php if($product['image']){ ?>
				<a href="<?php echo $product['url_tracking']; ?>">
					<img src="<?php echo $product['image']; ?>" width="50" height="50" alt="" style="float: left; margin-right: 5px;" />
				</a>
			<?php } ?>
			<a href="<?php echo $product['url_tracking']; ?>"><?php echo $product['name']; ?></a>
			
			<br /><b><?php echo $text_new_model; ?>:</b> <?php echo $product['model']; ?>

			<?php if(!empty($product['option'])){ ?>
				<br style="clear:both" />
				<p class="list-product-options">
				<?php foreach ($product['option'] as $option) { ?>
					&raquo; <strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?><br />
				<?php } ?>
				</p>
			<?php } ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price">
			<?php if($product['quantity'] > 1) { echo $product['quantity']; ?> <b>x</b> <?php } echo $product['price']; ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price">
			<?php echo $product['total']; ?>
		</td>
	</tr>

  <?php if(!empty($product['serials'])) { ?>
    <tr>
      <td bgcolor="<?php echo $row_style_background; ?>">
        Serials for this product:
      </td>
      <td bgcolor="<?php echo $row_style_background; ?>" colspan='2'>
        <?php 
          
          foreach($product['serials'] as $serial) { 
            echo $serial . "<br />";
          }
        ?>
      </td>
    </tr>
  <?php } ?>  

	<?php } ?>
	<?php
	if(isset($vouchers)){
		foreach ($vouchers as $voucher) {
			$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
        <td colspan="2" bgcolor="<?php echo $row_style_background; ?>">
        	<?php echo $voucher['description']; ?>
        	</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price">
			<?php echo $voucher['amount']; ?>
		</td>
	</tr>
	<?php }
	} ?>
</tbody>
<?php if(!empty($totals)){ ?>
<tfoot>
	<?php foreach ($totals as $total) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
		<td bgcolor="<?php echo $row_style_background; ?>" colspan="2" align="right" class="textRight">
			<b><?php echo $total['title']; ?></b>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price">
			<?php echo $total['text']; ?>
		</td>
	</tr>
	<?php } ?>
</tfoot>
<?php } ?>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>
<?php } ?>

<?php if(!empty($instruction)){ ?>
<p class="standard">
	<strong><?php echo $text_new_instruction; ?></strong><br />
	<?php echo $instruction; ?>
</p>
<?php } ?>

{$emailtemplate.content2}
