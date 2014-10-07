{$emailtemplate.content1}

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
    	<th bgcolor="#ededed" colspan="2"><?php echo $text_order_detail; ?></th>
   	</tr>
</thead>
<tbody>
	<tr>
    	<td bgcolor="#fafafa">
          	<b><?php echo $text_order_id; ?></b> <?php echo $order_id; ?><br />
    		<?php if(!empty($invoice_no)){?><b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br /><?php } ?>
          	<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
          	<b><?php echo $text_new_order_status; ?></b> <?php echo $new_order_status; ?><br />
			<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          	<?php if ($shipping_method) { ?>
          		<b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
          	<?php } ?>
        </td>
        <td bgcolor="#fafafa">
        	<b><?php echo $text_email; ?></b> <a href="mailto:<?php echo $email; ?>" style="color:<?php echo $config['body_link_color']; ?>; word-wrap:break-word;"><?php echo $email; ?></a><br />
          	<b><?php echo $text_telephone; ?></b> <?php echo $telephone; ?><br />
          	<b><?php echo $text_ip; ?></b> <?php echo $ip; ?>
          	<?php if($customer_group){ ?>
          		<br /><b><?php echo $text_customer_group; ?></b> <?php echo $customer_group; ?>
          	<?php } ?>
          	<?php if($affiliate){ ?>
          		<br /><b><?php echo $text_affiliate; ?></b> [#<?php echo $affiliate['affiliate_id']; ?>]
          		<a href="mailto:<?php echo $affiliate['email']; ?>"><?php echo $affiliate['firstname'].' '.$affiliate['lastname']; ?></a>
          	<?php } ?>
        </td>
	</tr>
	<tr>
    	<td bgcolor="#f6f6f6">
    		<p class="address">
        		<strong><?php echo $text_payment_address; ?></strong><br />
        		<?php echo $payment_address; ?>
        	</p>
    	</td>
        <td bgcolor="#f6f6f6">
        	<?php if ($shipping_address) { ?>
        	<p class="address">
        		<strong><?php echo $text_shipping_address; ?></strong><br />
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
        <th width="50%" bgcolor="#ededed"><b><?php echo $text_product; ?></b></th>
        <th width="15%" bgcolor="#ededed" align="right" class="textRight"><b><?php echo $text_price; ?></b></th>
        <th width="20%" bgcolor="#ededed" align="right" class="textRight"><b><?php echo $text_total; ?></b></th>
	</tr>
</thead>
<tbody>
	<?php $i = 0;
	foreach ($products as $product) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
    <tr>
		<td bgcolor="<?php echo $row_style_background; ?>">
			<?php if($product['image']){ ?>
				<img src="<?php echo $product['image']; ?>" alt="" style="float:left; inline:inline; margin-right:5px;" />
			<?php } ?>

			<?php echo $product['name']; ?>

			<?php if(!empty($product['model'])){ ?><br /><b><?php echo $text_model; ?>:</b> <?php echo $product['model']; ?><?php } ?>
			<?php if(!empty($product['sku'])){ ?><br /><b><?php echo $text_sku; ?>:</b> <?php echo $product['sku']; ?><?php } ?>
			<?php if(!empty($product['product_id'])){ ?><br /><b><?php echo $text_id; ?>:</b> <?php echo $product['product_id']; ?><?php } ?>
			<?php if(!empty($product['stock_quantity'])){ ?><br /><b><?php echo $text_stock_quantity; ?>:</b> <span style="color: <?php if($product['stock_quantity'] <= 0) { echo '#FF0000'; } elseif($product['stock_quantity'] <= 5) { echo '#FFA500'; } else { echo '#008000'; }?>"><?php echo $product['stock_quantity']; ?></span><?php } ?>

			<?php if(!empty($product['option'])){ ?>
			<br style="clear:both" />
			<b><?php echo $text_product_options; ?></b>
			<p class="list-product-options">
				<?php foreach ($product['option'] as $option) { ?>
					&raquo; <strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?><?php if($option['price']) echo "&nbsp;(".$option['price'].")" ?><br />
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
	<?php } ?>
	<?php
	if(isset($vouchers)){
		foreach ($vouchers as $voucher) {
			$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
        <td bgcolor="<?php echo $row_style_background; ?>" colspan="2"><?php echo $voucher['description']; ?></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $voucher['amount']; ?></td>
	</tr>
	<?php }
	} ?>
</tbody>
<tfoot>
	<?php foreach ($totals as $total) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
		<td bgcolor="<?php echo $row_style_background; ?>" colspan="2" align="right" class="textRight"><b><?php echo $total['title']; ?></b></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $total['text']; ?></td>
	</tr>
	<?php } ?>
</tfoot>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>

<?php } ?>

<?php if(!empty($order_link)){ ?>
<p class="link">
	<b><?php echo $text_order_link; ?></b><br />
	<span class="icon">&raquo;</span>
	<a href="<?php echo $order_link; ?>" target="_blank">
		<b><?php echo $order_link; ?></b>
	</a>
</p>
<?php } ?>

{$emailtemplate.content2}