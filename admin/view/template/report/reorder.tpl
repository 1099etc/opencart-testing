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
		<div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px;margin-bottom: 5px;'>
        Customers who ordered: 
        <select name='ordered_year'>
          <?php
            $currentYear = date("Y");
            while($currentYear != 1999) {
              echo "<option value=" . $currentYear . ">" . $currentYear . "</option>";
              $currentYear = $currentYear - 1;
            }
          ?>
        </select>
        <br />
        Customers who didn't order:
        <select name='didnt_order_year'>
          <?php
            $currentYear = date("Y");
            while($currentYear != 1999) {
              echo "<option value=" . $currentYear . ">" . $currentYear . "</option>";
              $currentYear = $currentYear - 1;
            }
          ?>
        </select>
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px;margin-bottom: 5px;'>
        Customer Has Email:<br />
        Yes <input type='radio' name='email' value='Y' /> | No <input type='radio' name='email' value='N' /><br />
        Customer Has Fax:<br />
        Yes <input type='radio' name='fax' value='Y' /> | No <input type='radio' name='fax' value='N' />
        <hr />
        <a onClick="$('input[name=email]').attr('checked',false); return false;">Clear Email</a> | <a onClick="$('input[name=fax]').attr('checked',false); return false;">Clear Fax</a>
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px;margin-bottom: 5px;'>
        Hide TCUSA / TaxCalc Customers?<br />
        Yes <input type='radio' name='taxcalc_hide' value='Y' /> | No <input type='radio' name='taxcalc_hide' value='N' /><hr />
        <a onClick="$('input[name=taxcalc_hide]').attr('checked',false); return false;">Clear TCUSA / TaxCalc</a>
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px; margin-bottom: 5px;'>
        Multi-Quantity Customers Only? <input type='radio' name='multiquantity' value='Y' /><br />
        Single Quantity Customers Only? <input type='radio' name='multiquantity' value='N' /><hr />
        <a onClick="$('input[name=multiquantity]').attr('checked',false); return false;">Clear Quantity</a>       
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px;margin-bottom: 5px;'>
        Hide Puerto Rico?<br />
        Yes <input type='radio' name='pr_hide' value='Y' /> | No <input type='radio' name='pr_hide' value='N' /><hr />
        <a onClick="$('input[name=pr_hide]').attr('checked',false); return false;">Clear Puerto Rico</a>
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px; margin-bottom: 5px;'>
      <b>Ignore these for the time being. They do not work but will be made functional soon.</b><br>
        Customer Has Software Generated Forms: (<a onClick="$('input[name=software_generated_forms]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='softwere_generated_forms' value='Y' /> | No <input type='radio' name='software_generated_forms' value='N' /><br />
        Customer Has AMS Payroll: (<a onClick="$('input[name=ams_payroll]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='ams_payroll' value='Y' /> | No <input type='radio' name='ams_payroll' value='N' /><br />
        Customer Has E-File Direct: (<a onClick="$('input[name=efile_direct]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='efile_direct' value='Y' /> | No <input type='radio' name='efile_direct' value='N' /><br />
        Customer Has Forms Filer Plus: (<a onClick="$('input[name=forms_filer_plus]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='forms_filer_plus' value='Y' /> | No <input type='radio' name='forms_filer_plus' value='N' /><br />
      </div>
	  
         <a onclick="filter();" class="button"><?php echo $button_filter; ?></a>

         <br><br>

         <a href="<?php echo $download_url ?>&download=Y" class="button">Download</a>
         
      <table class="list">
        <thead>
          <td class="left">Serial</td>
          <td class="left">XFax</td>
          <td class="left">Fax</td>
          <td class="left">Phone</td>
          <td class="left">Phone2</td>
          <td class="left">Email</td>
          <td class="left">CName</td>
          <td class="left">Name</td>
          <td class="left">Firm</td>
          <td class="left">Addr</td>
          <td class="left">CSZ</td>
          <td class="left">QTY1</td>
          <td class="left">EXT1</td>
          <td class="left">QTY2</td>
          <td class="left">EXT2</td>
          <td class="left">QTY3</td>
          <td class="left">EXT3</td>
          <td class="left">QTY4</td>
          <td class="left">EXT4</td>
          <td class="left">QTY5</td>
          <td class="left">EXT5</td>
          <td class="left">SUBTOTL</td>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          <tr>
            <td class="left"><?php echo $order['serial']; ?></td>
            <td class="left"><?php echo $order['xfax']; ?></td>
            <td class="left"><?php echo $order['fax']; ?></td>
            <td class="left"><?php echo $order['phone']; ?></td>
            <td class="left"><?php echo $order['phone2']; ?></td>
            <td class="left"><?php echo $order['email']; ?></td>
            <td class="left"><?php echo $order['cname']; ?></td>
            <td class="left"><?php echo $order['name']; ?></td>
            <td class="left"><?php echo $order['company']; ?></td>
            <td class="left"><?php echo $order['addr']; ?></td>
            <td class="left"><?php echo $order['csz']; ?></td>
            <td class="left"><?php echo $order['qty1']; ?></td>
            <td class="left"><?php echo $order['ext1']; ?></td>
            <td class="left"><?php echo $order['qty2']; ?></td>
            <td class="left"><?php echo $order['ext2']; ?></td>
            <td class="left"><?php echo $order['qty3']; ?></td>
            <td class="left"><?php echo $order['ext3']; ?></td>
            <td class="left"><?php echo $order['qty4']; ?></td>
            <td class="left"><?php echo $order['ext4']; ?></td>
            <td class="left"><?php echo $order['qty5']; ?></td>
            <td class="left"><?php echo $order['ext5']; ?></td>
            <td class="left"><?php echo $order['subtotl']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/reorder&token=<?php echo $token; ?>';
	
	var filter_ordered_year = $('select[name=\'ordered_year\']').attr('value');
	if (filter_ordered_year) {
		url += '&filter_ordered_year=' + encodeURIComponent(filter_ordered_year);
	}

	var filter_didnt_order_year = $('select[name=\'didnt_order_year\']').attr('value');
	if (filter_didnt_order_year) {
		url += '&filter_didnt_order_year=' + encodeURIComponent(filter_didnt_order_year);
	}

	var filter_email = $('input[name=\'email\']:checked').val();
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent($('input[name=\'email\']:checked').val());
	}

  var filter_fax = $('input[name=\'fax\']:checked').val();
	if (filter_fax) {
		url += '&filter_fax=' + encodeURIComponent($('input[name=\'fax\']:checked').val());
	}

  var filter_taxcalc_hide = $('input[name=\'taxcalc_hide\']:checked').val();
	if (filter_taxcalc_hide) {
		url += '&filter_taxcalc_hide=' + encodeURIComponent($('input[name=\'taxcalc_hide\']:checked').val());
    
	}
 
  var filter_pr_hide = $('input[name=\'pr_hide\']:checked').val();
	if (filter_pr_hide) {
		url += '&filter_pr_hide=' + encodeURIComponent($('input[name=\'pr_hide\']:checked').val());
    
	}
  
  var filter_multiquantity = $('input[name=\'multiquantity\']:checked').val();
  
	if (filter_multiquantity) {
		url += '&filter_multiquantity=' + encodeURIComponent($('input[name=\'multiquantity\']:checked').val());
    
	}
  
  var filter_software_generated_forms = $('input[name=\'software_generated_forms\']:checked').val();
  
	if (filter_software_generated_forms) {
		url += '&filter_software_generated_forms=' + encodeURIComponent($('input[name=\'software_generated_forms\']:checked').val());
    
	}
  
  var filter_ams_payroll = $('input[name=\'ams_payroll\']:checked').val();
  
	if (filter_ams_payroll) {
		url += '&filter_ams_payroll=' + encodeURIComponent($('input[name=\'ams_payroll\']:checked').val());
    
	}
  
  var filter_efile_direct = $('input[name=\'efile_direct\']:checked').val();
  
	if (filter_efile_direct) {
		url += '&filter_efile_direct=' + encodeURIComponent($('input[name=\'efile_direct\']:checked').val());
    
	}
  
  var filter_forms_filer_plus = $('input[name=\'forms_filer_plus\']:checked').val();
  
	if (filter_forms_filer_plus) {
		url += '&filter_forms_filer_plus=' + encodeURIComponent($('input[name=\'forms_filer_plus\']:checked').val());
    
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
