<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <div id='report_form_div' style='vertical-align: top; display: inline-block; width: 300px;'>
    <form id='report_form_div'>

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
          <option value=""></option>
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
        Yes <input type='radio' name='email' value='1' /> | No <input type='radio' name='email' value='0' /><br />
        Customer Has Fax:<br />
        Yes <input type='radio' name='fax' value='1' /> | No <input type='radio' name='fax' value='0' />
        <hr />
        <a onClick="$('input[name=email]').attr('checked',false); return false;">Clear Email</a> | <a onClick="$('input[name=fax]').attr('checked',false); return false;">Clear Fax</a>
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px;margin-bottom: 5px;'>
        Hide TCUSA / TaxCalc Customers?<br />
        Yes <input type='radio' name='tcusa_taxcalc_hide' value='1' /> | No <input type='radio' name='tcusa_taxcalc_hide' value='0' /><hr />
        <a onClick="$('input[name=tcusa_taxcalc_hide]').attr('checked',false); return false;">Clear TCUSA / TaxCalc</a>
      </div>

      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px; margin-bottom: 5px;'>
        Multi-Quantity Customers Only? <input type='radio' name='multiquantity' value='1' /><br />
        Single Quantity Customers Only? <input type='radio' name='multiquantity' value='0' /><hr />
        <a onClick="$('input[name=multiquantity]').attr('checked',false); return false;">Clear Quantity</a>       
      </div>
      <div style='display: block; width: 300px; border: 1px dotted #d3d3d3; vertical-align: top;padding: 5px; margin-bottom: 5px;'>
        Customer Has Software Generated Forms: (<a onClick="$('input[name=software_generated_forms]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='softwere_generated_forms' value='1' /> | No <input type='radio' name='software_generated_forms' value='0' /><br />
        Customer Has AMS Payroll: (<a onClick="$('input[name=ams_payroll]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='ams_payroll' value='1' /> | No <input type='radio' name='ams_payroll' value='0' /><br />
        Customer Has E-File Direct: (<a onClick="$('input[name=efile_direct]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='efile_direct' value='1' /> | No <input type='radio' name='efile_direct' value='0' /><br />
        Customer Has Forms Filer Plus: (<a onClick="$('input[name=forms_filer_plus]').attr('checked',false); return false;">Clear</a>)<br />
        Yes <input type='radio' name='forms_filer_plus' value='1' /> | No <input type='radio' name='forms_filer_plus' value='0' /><br />
      </div>

    </form>
  </div>


</div>
<?php echo $footer; ?>
