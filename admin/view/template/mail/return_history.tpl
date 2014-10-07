{$emailtemplate.content1}

<?php if(!empty($comment)){ ?>
	<p class="standard">
		<strong><?php echo $text_comment; ?></strong><br /><?php echo $comment; ?>
	</p>
<?php } ?>

<?php if(!empty($show_summary)){ ?>
	<table cellpadding="0" cellspacing="0" width="100%" class="table1">
	<thead>
		<tr>
	       	<th bgcolor="#ededed" align="center"><b><?php echo $text_product; ?></b></th>
	       	<th bgcolor="#ededed" align="center"><b><?php echo $text_return; ?></b></th>
	       	<th bgcolor="#ededed" align="center"><b><?php echo $text_opened; ?></b></th>
		</tr>
	</thead>
	<tbody>
	<?php $row_style_background = "#fafafa"; ?>
	    <tr>
			<td bgcolor="<?php echo $row_style_background; ?>">
				<?php echo $name; ?>
				<ul class="list">
					<?php if($model){ ?><li><strong><?php echo $text_model; ?></strong>&nbsp;<?php echo $model; ?></li><?php } ?>
					<?php if($quantity){ ?><li><strong><?php echo $text_quantity; ?></strong>&nbsp;<?php echo $quantity; ?></li><?php } ?>
				</ul>
			</td>
			<td bgcolor="<?php echo $row_style_background; ?>">
				<?php echo $reason; ?>
			</td>
			<td bgcolor="<?php echo $row_style_background; ?>" align="center">
				<?php echo $opened; ?>
			</td>
		</tr>
	</tbody>
	</table>
	
	<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15">&nbsp;</td></tr></table>
<?php } ?>

{$emailtemplate.content2}