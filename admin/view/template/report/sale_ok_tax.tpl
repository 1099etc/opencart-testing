<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td>
            </td>
          <td>
            </td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <td class="left"><?php echo $column_web; ?></td>
          <td class="right"><?php echo $column_total; ?></td>
        </thead>
        <tbody>
            <td class="left"><?php echo $column_web; ?></td>
            <td class="right">$<?php echo number_format($web_total,2); ?></td>
        </tbody>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php echo $column_city; ?></td>
            <td class="right"><?php echo $column_shipping; ?></td>
            <td class="right"><?php echo $column_sales; ?></td>
            <td class="right"><?php echo $column_total; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          <tr>
            <td class="left"><?php echo $order['city']; ?></td>
            <td class="right">$<?php echo number_format($order['shipping'],2); ?></td>
            <td class="right">$<?php echo number_format($order['sales'],2); ?></td>
            <td class="right">$<?php echo number_format($order['total'],2); ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td class="center" colspan="5">&nbsp;</td>
          </tr>
          <tr>
            <td class="left">Shipped Totals</td>
            <td class="right">$<?php echo number_format($shipping_total,2); ?></td>
            <td class="right">$<?php echo number_format($sales_total,2); ?></td>
            <td class="right">$<?php echo number_format($grand_total,2); ?></td>
          </tr>
          </tr>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/sale_ok_tax&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'mm-dd-yy'});
	
	$('#date-end').datepicker({dateFormat: 'mm-dd-yy'});
});
//--></script> 
<?php echo $footer; ?>
