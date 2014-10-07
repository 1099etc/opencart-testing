<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" />UPS World Ship Report </h1>
    </div>
    <div class="content">
      <form>
        <input type='hidden' name='token' value="<?php echo $this->request->get['token']; ?>" />
        <input type='hidden' name='route' value="<?php echo $this->request->get['route']; ?>" />
      <table class="form">
        <tr>
          <td>Start Date : <input type='text' id='startDate' name='startDate' /></td>
          <td>End Date : <input type='text' id='endDate' name='endDate' /></td>
          <td>Save Report : <input type='checkbox' name='save' id='save' value='1' /></td>
          <td><input type='submit' name='submit' value='Get Report' /></td>
        </tr>
        <tr>
          <td colspan=4>

            <?php
              $i = 0;
              $heading = '';
              $data = '';
              foreach($orders as $oKey => $oVal) {
                foreach($oVal as $k => $v) {

                  if($i == 0) {
                    $heading .= $k . ",";
                  }

                  $data .= $v . ",";
                }
                $data = trim($data, ",");
                $data .= "\n";
                $i = $i + 1;
              }
              $heading = trim($heading, ",");
            ?>
            <textarea style='width: 100%; height: 250px;'><?php echo trim($heading) . "\n" . trim($data); ?></textarea>

          </td>
        </tr>
      </table>
      </form>

      <table class="form">
        <tr>
          <td style='border-bottom: 1px solid black; border-left: 1px solid black;'>ID</td>
          <td style='border-bottom: 1px solid black; border-left: 1px solid black;'>Start Date</td>
          <td style='border-bottom: 1px solid black; border-left: 1px solid black;'>End Date</td>
          <td style='border-bottom: 1px solid black; border-left: 1px solid black;'>OID's</td>
          <td style='border-bottom: 1px solid black; border-left: 1px solid black;width: 100px;'>Action</td>
        </tr>
        <?php foreach($previous_orders->rows as $po) { ?>
          <?php if(isset($po['ups_worldship_id']) && $po['ups_worldship_id'] != '') { ?>
            <tr>
              <td style='border-bottom: 1px solid black; border-left: 1px solid black;'><?php echo $po['ups_worldship_id']; ?></td>
              <td style='border-bottom: 1px solid black; border-left: 1px solid black;'><?php echo date('d M Y', strtotime(str_replace('/','-',$po['startDate']))); ?></td>
              <td style='border-bottom: 1px solid black; border-left: 1px solid black;'><?php echo date('d M Y', strtotime(str_replace('/','-',$po['endDate']))); ?></td>
              <td style='border-bottom: 1px solid black; border-left: 1px solid black;'><?php echo $po['order_ids']; ?></td>
              <td style='border-bottom: 1px solid black; border-left: 1px solid black;'><nobr>
                [ <a href="index.php?route=report/upsworldship&token=<?php echo $this->request->get['token']; ?>&startDate=<?php echo date('m/d/Y', strtotime(str_replace('/','-',$po['startDate']))); ?>&endDate=<?php echo date('m/d/Y', strtotime(str_replace('/','-',$po['endDate']))); ?>">Load Report</a> ]
                [ <a href="index.php?route=report/upsworldship&token=<?php echo $this->request->get['token']; ?>&delete=<?php echo $po['ups_worldship_id']; ?>">Delete Report</a> ]
                </nobr>
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </table>

    </div>
  </div>
</div>
  <script>
  $(function() {
    $( "#startDate" ).datepicker();
    $( "#endDate" ).datepicker();
  });
  </script>

<?php echo $footer; ?>
