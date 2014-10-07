{$emailtemplate.content1}

<?php if(isset($order_status)){ ?>
<p class="standard">
	<b><?php echo $text_update_order_status; ?></b><br />
	<?php echo $order_status; ?>
</p>
<?php } ?>

<?php if ($customer_id && isset($order_url)) { ?>
<p class="link">
	<b><?php echo $text_update_link; ?></b><br />
	<span>&raquo;</span>
	<a href="<?php echo $order_url_tracking; ?>" target="_blank">
		<b><?php echo $order_url; ?></b>
	</a>
</p>
<?php } ?>

<?php if($comment){ ?>
<p class="standard">
	<b><?php echo $text_update_comment; ?></b><br />
	<?php echo $comment; ?>
</p>
<?php } ?>

{$emailtemplate.content2}
