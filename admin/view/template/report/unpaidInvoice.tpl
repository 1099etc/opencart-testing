<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>

  <?php

    $startDate = isset($this->request->get['startDate']) ? $startDate = $this->request->get['startDate'] : $startDate = '';
    $endDate   = isset($this->request->get['endDate'])   ? $endDate   = $this->request->get['endDate']   : $endDate = '';

    $dateString = '';

    if((isset($startDate) && isset($endDate)) && ($startDate != '' && $endDate != '') ) {
     $dateString = " and date_added > '" . $startDate . "' and date_added < '" . $endDate . "'";
    }

    $query = "select order_id, total, date_added from `order` where order_paid = 0 and payment_method like '%invoice%' and order_status_id = 5" . $dateString;
    $results = $this->db->query($query);

    $grandTotal = 0;

    echo "<form action='index.php' method='get'>";
    echo "<input type='hidden' name='token' value='". $this->session->data['token'] . "' />";
    echo "<input type='hidden' name='route' value='report/unpaidInvoice' />";
    echo "Start Date : <input type='text' name='startDate' id='startDate' value='" . $startDate . "' /> - ";
    echo "End Date : <input type='text' name='endDate' id='endDate' value='" . $endDate . "' />";
    echo "<input type='submit' value='submit' />";
    echo "</form><br /><br />";

    echo "<table style='border: 1px solid black; padding: 5px;'>";
    echo "<tr><td>Order ID</td><td>Order Total</td><td style='text-align: center'>Order Date</td></tr>";
    foreach($results->rows as $r) {

      $grandTotal = $grandTotal + $r['total'];
      
      echo "<tr><td style='padding: 5px; border: 1px solid #d3d3d3'>";
      echo "<a href='" . $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $r['order_id'], 'SSL') . "'>" . $r['order_id'] . "</a>";
      echo "</td><td style='padding: 5px; border: 1px solid #d3d3d3;text-align: right;'>";
      echo number_format($r['total'], 2, '.', '');
      echo "</td><td style='padding: 5px; border: 1px solid #d3d3d3;text-align: right;'>";
      echo $r['date_added'];
      echo "</td></tr>";

    }
    echo "<tr><td style='padding: 5px;'>Grand Total</td><td style='text-align: right; padding: 5px;'>" . number_format($grandTotal,2,'.','') . "</td><td></td></tr>";
    echo "</table>";

  ?>

</div>
  <script>
    $(function() {
        $( "#startDate" ).datepicker({dateFormat:"yy-mm-dd"});
        $( "#endDate" ).datepicker({dateFormat:"yy-mm-dd"});
    });
  </script>
<?php echo $footer; ?>
