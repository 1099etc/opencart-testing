{$emailtemplate.content1}

<?php if(isset($customer_group) && $customer_group){ ?>
	<p class="standard">
		<strong><?php echo $text_customer_group; ?></strong> <?php echo $customer_group; ?>
	</p>
<?php } ?>

<?php if(isset($account_approve) && $account_approve){ ?>
<p class="link">
	<?php echo $text_approve; ?><br />
	<span class="icon">&raquo;</span>
	<a href="<?php echo $account_approve; ?>" target="_blank">
		<b><?php echo $account_approve; ?></b>
	</a>
</p>
<?php } ?>

{$emailtemplate.content2}