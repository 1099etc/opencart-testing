<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" />Nelco Weekly Report</h1>
    </div>
    <div class="content">
      <form>
        <input type='hidden' name='token' value="<?php echo $this->request->get['token']; ?>" />
        <input type='hidden' name='route' value="<?php echo $this->request->get['route']; ?>" />
        <table class="form">
          <tr>
            <td colspan=3>
              If you do not select a start and end date, the report will default to using the last week of data.
            </td>
          </tr>
          <tr>
            <td>Start Date : <input type='text' id='startDate' name='startDate' /></td>
            <td>End Date : <input type='text' id='endDate' name='endDate' /></td>
            <td><input type='submit' name='submit' value='Get Report' /></td>
          </tr>
          <tr>
            <td colspan=3>
              <textarea style='width: 100%; height: 400px;'>
<?php foreach($orders->rows as $o) { 
echo '"' . $o['key'] . '",'; 
echo '"' . $o['featurecode'] . '",'; 
echo '"' . $o['firstYear'] . '",'; 
echo '"' . $o['lastname'] . '",'; 
echo '"' . $o['firstname'] . '",'; 
echo '"' . $o['payment_company'] . '",'; 
echo '"' . $o['payment_address'] . '",'; 
echo '"' . $o['payment_city'] . '",'; 
echo '"' . $o['payment_zone'] . '",'; 
echo '"' . $o['payment_postcode'] . '",'; 
echo '"' . $o['telephone'] . '",'; 
echo '"' . $o['telephone2'] . '",'; 
echo '"' . $o['fax'] . '",'; 
echo '"' . $o['email'] . '",'; 
echo '"' . $o['date_added'] . '"'; 
echo "\n";
}
?>
              </textarea>
            </td>
          </tr>
        </table>
      </form>

  <script>
  $(function() {
    $( "#startDate" ).datepicker();
    $( "#endDate" ).datepicker();
  });
  </script>




    </div>
  </div>
</div>
<?php echo $footer; ?>
