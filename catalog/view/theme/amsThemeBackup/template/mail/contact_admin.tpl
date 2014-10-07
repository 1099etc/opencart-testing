{$emailtemplate.content1}

<?php if(!empty($user_tracking)): ?>
<table cellpadding="0" cellspacing="0" width="100%" class="table1">
<tbody>
	<?php $i = 0;
	foreach ($user_tracking as $key => $track) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" : "#fafafa";
		if(!empty($track)){ ?>
    <tr>
		<td bgcolor="<?php echo $row_style_background; ?>"><?php echo $key; ?></td>
		<td><?php echo $track; ?></td>
	</tr>
	<?php }
	 } ?>
</tbody>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>
<?php endif; ?>

{$emailtemplate.content2}