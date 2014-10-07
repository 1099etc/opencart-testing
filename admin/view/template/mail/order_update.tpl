{$emailtemplate.content1}

<?php if(!empty($customer_id)){ ?>
<p class="link">
	<b><?php echo $text_link; ?></b><br />
	<span class="icon">&raquo;</span>
	<a href="<?php echo $invoice_tracking; ?>" target="_blank">
		<b><?php echo $invoice; ?></b>
	</a>
</p>
<?php } ?>

<?php if(!empty($comment)){ ?>
<p class="standard">
	<?php echo $text_comment; ?>
</p>
<div style="margin-bottom:15px;"><?php echo $comment; ?></div>
<?php } ?>

<?php if(!empty($show_products) || !empty($show_vouchers) || !empty($show_totals)){
	$i = 0; ?>
<table cellpadding="5" cellspacing="0" width="100%" class="table1">
<?php if(!empty($show_products) || !empty($show_vouchers)){ ?>
<thead>
	<tr>
        <th width="50%" bgcolor="#ededed"><b><?php echo $text_product; ?></b></th>
        <th width="25%" bgcolor="#ededed" align="right" class="textRight"><b><?php echo $text_price; ?></b></th>
        <th width="25%" bgcolor="#ededed" align="right" class="textRight"><b><?php echo $text_total; ?></b></th>
	</tr>
</thead>
<tbody>
	<?php 
	foreach ($products as $product) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
    <tr>
		<td bgcolor="<?php echo $row_style_background; ?>" width="1">
			<?php if($product['image']){ ?>
				<img src="<?php echo $product['image']; ?>" width="50" height="50" alt="" style="float: left; display: inline; margin-right: 5px;" />
			<?php } ?>
			<?php echo $product['name']; ?>
			<br /><b><?php echo $text_model; ?></b> <?php echo $product['model']; ?>:

			<?php if(!empty($product['option'])){ ?>
			<br style="clear:both" />
			<p class="list-product-options">
				<?php foreach ($product['option'] as $option) { ?>
					&raquo; <strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?><br />
				<?php } ?>
			</p>
			<?php } ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php if($product['quantity'] > 1) { echo $product['quantity']; ?> <b>x</b> <?php } echo $product['price']; ?></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $product['total']; ?></td>
	</tr>
	<?php } ?>
	<?php if(isset($show_vouchers)){ ?>
	<?php foreach ($vouchers as $voucher) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
        <td colspan="2" bgcolor="<?php echo $row_style_background; ?>"><?php echo $voucher['description']; ?></td>
		<td bgcolor="<?php echo $row_style_background; ?>"><?php echo $voucher['amount']; ?></td>
	</tr>
	<?php } ?>
	<?php } ?>
</tbody>
<?php } ?>
<?php if(!empty($show_totals)){ ?>
<tfoot>
	<?php foreach ($totals as $total) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa"; ?>
	<tr>
		<td bgcolor="<?php echo $row_style_background; ?>" colspan="2" align="right" class="textRight"><b><?php echo $total['title']; ?></b></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight price"><?php echo $total['text']; ?></td>
	</tr>
	<?php } ?>
</tfoot>
<?php } ?>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>
<?php } ?>

<?php if(isset($show_downloads)){ ?>
	<?php foreach ($downloads as $download) { ?>
		<?php if ($download['remaining'] > 0) { ?>
			<p class="link">
				<b><?php echo $text_download; ?></b><br />
				<span class="icon">&raquo;</span>
				<a href="<?php echo $download['href_tracking']; ?>" target="_blank">
					<b><?php echo $download['name']; ?></b>
				</a>
			</p>
		<?php } ?>
	<?php } ?> 
<?php } ?> 

{$emailtemplate.content2}