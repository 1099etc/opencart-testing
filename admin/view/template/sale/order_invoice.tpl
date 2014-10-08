<?php

/*
  Invoice and Shipping Label Printing
  By John LeVan
  -------------------------------------------------------------------------------------------------------------------------
  
  Determine whether we are printing invoices or shipping labels.
  Determine how many we are printing.
  Determine whether or not we are notifying the customer.
  
  Invoice:
    Foreach Order -
      Foreach copy we are printing.
    
      1 Serial Number Sold - 
        Invoice Sheet 1 -
          Contains entire order.
          Contains serial number.
        
      2 or more Serial Numbers Sold - 
        Invoice Sheet 1 -
          Contains condensed order.
          Contains NO serial numbers.
        Invoice Sheet 2 and onward - 
          Contains individual product with a serial number.
          Contains the serial number for the product being printed.
        
      Set the processing ID
      Produce the PDF


    
*/


// Determine whether or not we want invoice or shipping labels.
((isset($_REQUEST['shippinglabels'])) && $_REQUEST['shippinglabels'] == 'ship') ? $label = 'ship' : $label = 'invoice';

// Load the serial number stuff so we can generate keycodes for output
$this->load->model('catalog/serial');

// What order would we like to print them in? Cut order, or sequential order? This should default to cut sorting.
(isset($_REQUEST['cut_order']) && $_REQUEST['cut_order'] == 'seq') ? $cut = 'seq' : $cut = 'cut';

// Need to determine whether or not we are printing the Nelco Ads
$data['supressNelco'] = 0;
if(! isset($_REQUEST['supressNelco'])) { $_REQUEST['supressNelco'] = 'false'; }
if($_REQUEST['supressNelco'] == 'true') { $data['supressNelco'] = '1'; }
else { $data['supressNelco'] = '0'; }

$data['notify'] = 0;
if(! isset($_REQUEST['notifyUser'])) { $_REQUEST['notifyUser'] = 'false'; }
if($_REQUEST['notifyUser'] == 'true') {
  $data['notify'] = '1';
}
else { 
  $data['notify'] = '0';
}

usort($orders, function($a, $b) {
  if($a['order_id'] == $b['order_id']) return 0;
  return ($a['order_id'] < $b['order_id']) ? -1 : 1;
});

if($label == 'ship') { 
//  rsort($orders);
}


/*
echo "<pre>";
echo print_r($orders, true);
echo "</pre>";
exit;
*/


$hideSerial = $_REQUEST['hideSerial'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Determine if we are printing an invoice or a shipping label. Here we are doing invoices.
// Invoice Assembly
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($label == 'invoice') {

  //--------------------------------------------------------------------------------------------------------------------------------------------
  // Set up the layout and header information.
  //--------------------------------------------------------------------------------------------------------------------------------------------  
  $invoiceHeader = "
  <html>
    <head>
      <title>Invoice</title>
      <style type='text/css'>
        @page { margin: .25in .20in .25in .25in; font-family: verdana; font-weight: bold;  }
        td { vertical-align: top; padding: 0px; margin: 0px; }
        .contentTable { 
          position: relative; 
          width: 100%; 
          height: 49%; 
          padding: 0px; 
          margin: 0px; 
          page-break-after: avoid;
        }
        .headerTable { vertical-align: top; margin: 0px; width: 100%; padding: 0px; }
        .logoBox { vertical-align: top; padding: 0px; }
        .logoBox img { width: 150px; }
        .amsBox { vertical-align: top; white-space: nowrap; font-size: .8em; }
        .shippingBox { vertical-align: top; white-space: nowrap;  font-size: .8em; padding-top: 100px; }
        .amsInfoBox { vertical-align: top; white-space: nowrap; font-size: .8em; width: 25%; }
        .amsInfoBox img { width: 150px; height: 100px; }
        .invoiceBox { vertical-align: top; white-space: nowrap; width: 20%; padding-top: 100px; }
        .invoiceBox table { margin: 0px; padding: 0px; border-collapse: collapse; font-size: .8em; }
        .serialTable { width: 100%; border: 1px solid black; border-collapse: collapse; vertical-align: top; margin-top: 5px; margin-bottom: 5px; }
        .serialBox { width: 50%; text-align: center; border: 1px solid black; font-size: 1em; padding: 3px; }
        .keyBox {width: 50%; text-align: center;  border: 1px solid black; font-size: 1em; padding: 3px; }
        .purchaseTable { width: 100%; border-collapse: separate; border-spacing: 0px; }
        .headings { font-weight:bold; text-align: center; border-bottom: 1px solid black; }
        .headingQTY { width:10%; }
        .headingDescription { width:50%; }
        .headingPrice { width:20%; }
        .headingTotal { width:20%; }
        .lineItem { border-left: 1px solid black; border-bottom: 1px solid black;  text-align: right; padding-left: 5px; padding-right: 5px; }
        .lineQty { }
        .lineDesc { text-align: left; }
        .linePrice { }
        .lineTotal { }
        .lineItem:nth-child(4) { border-right: 1px solid black; }
        .totalHeading { text-align: right; border-bottom: 1px dotted black; width: 50%;}
        .totalsTable { width: 100%; }
        .totals { text-align: right; border-bottom: 1px dotted black; }
        .itemName { text-align: left; }
        .itemQuantity { text-align: center; }
        .nelcoAd { font-size: 1em; vertical-align: middle; }
      </style>
    </head>
    <body>
  ";

  $nelcoText = "<b>Need Compatible Forms?</b><br />";
  $nelcoText .= "Call <a href='http://1099-etc.nelcosolutions.com/'>NELCO</a> at 800.266.4669 or visit<br />";
  $nelcoText .= "<a href='http://1099-etc.nelcosolutions.com/'>http://1099-etc.nelcosolutions.com/</a> to order!";

  $orderPages[] = '';
  unset($orderPages);

  //--------------------------------------------------------------------------------------------------------------------------------------------
  // End of layout and header setup
  //--------------------------------------------------------------------------------------------------------------------------------------------    

  // We are going to loop through each order.

  foreach ($orders as $order) {
    // If we want duplicates, then lets set a variable to 2, otherwise, we only want 1.
    if(isset($_REQUEST['duplicates'])) {
      if($_REQUEST['duplicates'] == 'true') { $wanted = 2; }
      else {  $wanted = 1; }
    }
    else {
      $wanted = 1;
    }

    // We have currently printed 0 of our $wanted total.
    $printed = 0;

   //--------------------------------------------------------------------------------------------------------------------------------------------
   // This is where we can set up some of the template stuff we'll reuse.
   //--------------------------------------------------------------------------------------------------------------------------------------------
   if($order['payment_method'] == 'Check / Money Order Instructions') {
     $order['payment_method'] = 'Check';
   }

   $headerInfo = "
      <!-- START AN INVOICE -->
        <table class='contentTable'>
          <tr>
            <td>
              <table class='headerTable'>
                <tr>
                  <td class='amsInfoBox' colspan='2'>
                    <img src='../images/logo.jpg' style='width:150px' /><br />
                    " . $order['store_name'] . "<br />
                    " . $order['store_address'] . "<br />
                    Sales: (800) 536-1099<br />
                    Support: (405) 340-0697<br />
                    Email: info@1099-etc.com<br />
                    <!-- Tax ID: 73-1270820 -->
                  </td>
                  <td class='shippingBox'>
                    " . str_replace('&AMP;', '&', strtoupper($order['shipping_address'])) . "
                  </td>
                  <td class='invoiceBox'>
                    <table align='right'>
                      <tr><td><nobr>Order ID:</nobr></td><td><nobr>" .  $order['order_id'] . "</nobr></td></tr>
                      <tr><td><nobr>Payment Method:</nobr></td><td><nobr>" . $order['payment_method'] . "</nobr></td></tr>
    ";
      
    if(isset($order['po_number']) && $order['po_number'] != '') {  $headerInfo .= "<tr><td><nobr>Purchase Order:</nobr></td><td><nobr>" . $order['po_number'] . "</nobr></td></tr>"; }

    if((strpos($order['payment_method'], "Invoice") !== false) || (strpos($order['payment_method'], "invoice") !== false)) {
      if(isset($order['invoice_no']) && $order['invoice_no'] != '') {
        $headerInfo .= "<tr><td><nobr>Invoice Number:</nobr></td><td><nobr>" . $order['invoice_no'] . "</nobr></td></tr>"; 
        $headerInfo .= "<tr><td><nobr>Invoice Date:</nobr></td><td><nobr>" . $order['invoice_date'] . "</nobr></td></tr>";
      }
    }
    else {
      $headerInfo .= "<tr><td><nobr>Payment Date:</nobr></td><td><nobr>" . $order['date_added'] . "</nobr></td></tr>";
    }

    $headerInfo .= "

                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        <tr>
      <td>
    ";  

    $footerInfo = "</td>
                  </tr>
                </table>";

    $invoiceFooter = "</body></html>";

    //--------------------------------------------------------------------------------------------------------------------------------------------
    // This is layout information for the products table - purchase table - heading and footer.
    $purchaseTableHeadings  = '';
    $purchaseTableHeadings .= "<table class='purchaseTable'><tr>";
    $purchaseTableHeadings .= "<td class='headings headingQTY'>QTY</td>";
    $purchaseTableHeadings .= "<td class='headings headingDescription'>Description</td>";
    $purchaseTableHeadings .= "<td class='headings headingPrice'>Price</td>";
    $purchaseTableHeadings .= "<td class='headings headingTotal'>Total</td>";
    $purchaseTableHeadings .= "</tr>";
      
    $purchaseTableFooter  = '';
    $purchaseTableFooter .= "</table>";
    //--------------------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------------------
    // Generate the number of items for printing.
    //--------------------------------------------------------------------------------------------------------------------------------------------
    while($printed < $wanted) {
      $firstPageSet = 0;
      $TMPorderPages[] ='';
      unset($TMPorderPages);

      //--------------------------------------------------------------------------------------------------------------------------------------------
      // Determine how many serial numbers we have.
      // 1 Serial Number   - 1 invoice sheet that contains the serial number.
      // 2+ Serial Numbers - 1 Header Sheet with Condensed information and 1 sheet per serial after that.
      //--------------------------------------------------------------------------------------------------------------------------------------------
    
      // This counts the number of serials we have to print invoice sheets for.
      $countSerials = 0;
      $serialCount = 0;
      
      // This is the serial block for the very first serial / keycode ... to be used if we only have 1. We will fill this in shortly.
      $firstSerialBox = '';
      
      // This will be the variable we store our first page in.
      $firstPage = '';
      $firstPurchaseTable = '';
      
      // This will be the variable we store each of our subsequent pages in.
      $subsequentPages = '';
      
      foreach($order['product'] as $p) {
        // Quickly count how many serial numbers we have.
        if(isset($p['serial']) && is_array($p['serial'])) {
          foreach($p['serial'] as $s) {
            $serialCount++;
          }
        } // End SerialCount
      } // End SerialCount

      foreach($order['product'] as $p) {
        if(isset($p['serial']) && is_array($p['serial'])) {
          foreach($p['serial'] as $s) {
            $countSerials++;
            
            //--------------------------------------------------------------------------------------------------------------------------------------
            // Basically, here, we can create each serial page.
            //--------------------------------------------------------------------------------------------------------------------------------------
            
            // Variables to make things easier
            //--------------------------------
            // This assembles the current serial code and the featurecode for the product we are on. 
            // All the featurecodes for the current product will be the same.
            $currentSerial = $s . $p['featurecode'][0]; 
            
            // This generates the keycode for the serial we are on.                                                        
            $currentKeycode = $this->model_catalog_serial->generate_keycode($currentSerial); 
            
            // Lets create the serial box table.
            $serialBox = '';
            $serialBox .= "<table class='serialTable'><tr>";
            $serialBox .= "<td class='serialBox'>Serial # : " . $currentSerial . "</td>";
            $serialBox .= "<td class='keyBox'>Keycode : " . $currentKeycode . "</td>";
            $serialBox .= "</tr></table>";
            
            if($hideSerial == 'true') {
              $serialBox = '';
              $serialBox .= "<table class='serialTable' style='visibility: hidden;'><tr>";
              $serialBox .= "<td class='serialBox'>&nbsp;</td>";
              $serialBox .= "<td class='keyBox'>&nbsp;</td>";
              $serialBox .= "</tr></table>";
            }

            // If this is the first serial number, we need to save this to $firstSerialBox.
            // This will be displayed on the first invoice page, if it is the ONLY serial number in the order.
            if($countSerials == 1) {
              $firstSerialBox = $serialBox;
            }
            
            // Next we need to loop through each of the product options and assemble the purchaseTable for this serial page.

            // Create a few empty variables.
            $w2FormsFilerRowExpanded = '';
            $softwareGeneratedFormsRowExpanded = '';
            $amsPayrollRowExpanded = '';
            $eFileDirectRowExpanded = '';
            $formsFilerPlusRowExpanded = '';

            $w2FormsFilerRowCondensed = '';
            $softwareGeneratedFormsRowCondensed = '';
            $amsPayrollRowCondensed = '';
            $eFileDirectRowCondensed = '';
            $formsFilerPlusRowCondensed = '';

            (float)$formsFilerPrice = substr($p['price'], 1);
            (float)$formsFilerTotal = substr($p['price'], 1);

            foreach($p['option'] as $option) {
            
              // We need to figure out if the user purchased Forms Filer, and if they did, we'll need to parse the options and put them in order.
              if(strpos($p['model'], '1099-FormsFiler')) {
                
                // Here, we need to put the options in order - W-2 / Forms Filer : Software Generated Forms : AMS Payroll : E-File Direct : Forms Filer Plus
                // We will also need to determine their appropriate prices, based on the product quantity.
                
                // We need to generate 2 versions - expanded and condensed.
                // expanded will contain quantity, price, and total.
                if($option['value'] == "No Thank You") {
                  $price = "Not Purchased";
                  $condensedPrice = "Not Purchased";
                  $quantity = '0';
                }
                else {
                  $price = number_format($option['price'], 2, '.','');
                  $condensedPrice = "Purchased";
                  $quantity = $p['quantity'];
                }
                $total = number_format($p['quantity'] * $option['price'], 2, '.', '');
                if($total <= 0) { $total = ''; }

                if($serialCount > 1) {
                  $formsFilerPrice = $formsFilerPrice - $option['price'];  
                  $formsFilerTotal = $formsFilerPrice * $p['quantity'];
                }
                else {
                  $formsFilerPrice = $formsFilerPrice - $option['price'];
                  (float)$pp = substr($p['price'], 1);
                  $totalPrice = number_format($pp * $p['quantity'], 2, '.','');
                  $formsFilerTotal = $totalPrice;
                  $formsFilerTotal = number_format($formsFilerPrice * $p['quantity'], 2, '.', '');
                  
                }
                $formsFilerPrice = number_format($formsFilerPrice, 2, '.', '');

                if(stripos($p['model'], 'upg-') !== false) {
                  $w2FormsFilerRowExpanded = "<tr><td class='lineItem lineQty'>0</td>";
                  $w2FormsFilerRowExpanded .= "<td class='lineItem lineDesc'>W-2 / 1099 Forms Filer</td>";
                  $w2FormsFilerRowExpanded .= "<td class='lineItem linePrice'>Not Purchased</td>";
                  $w2FormsFilerRowExpanded .= "<td class='lineItem lineTotal'></td></tr>";

                  $w2FormsFilerRowCondensed = "<tr><td class='lineItem lineQty'>0</td>";
                  $w2FormsFilerRowCondensed .= "<td class='lineItem lineDesc'>W-2 / 1099 Forms Filer</td>";
                  $w2FormsFilerRowCondensed .= "<td class='lineItem linePrice'>Not Purchased</td>";
                  $w2FormsFilerRowCondensed .= "<td class='lineItem lineTotal'></td></tr>";
                }
                else {
                  $w2FormsFilerRowExpanded = "<tr><td class='lineItem lineQty'>" . $p['quantity'] . "</td>";
                  $w2FormsFilerRowExpanded .= "<td class='lineItem lineDesc'>W-2 / 1099 Forms Filer</td>";
                  $w2FormsFilerRowExpanded .= "<td class='lineItem linePrice'>" . $formsFilerPrice . "</td>";
                  $w2FormsFilerRowExpanded .= "<td class='lineItem lineTotal'>" . $formsFilerTotal . "</td></tr>";

                  $w2FormsFilerRowCondensed = "<tr><td class='lineItem lineQty'></td>";
                  $w2FormsFilerRowCondensed .= "<td class='lineItem lineDesc'>W-2 / 1099 Forms Filer</td>";
                  $w2FormsFilerRowCondensed .= "<td class='lineItem linePrice'>Purchased</td>";
                  $w2FormsFilerRowCondensed .= "<td class='lineItem lineTotal'></td></tr>";
                }

                if($option['name'] == "Software Generated Forms") {
                  $softwareGeneratedFormsRowExpanded  .= "<tr><td class='lineItem lineQty'>" . $quantity . "</td>";
                  $softwareGeneratedFormsRowExpanded  .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $softwareGeneratedFormsRowExpanded  .= "<td class='lineItem linePrice'>" . $price . "</td>";
                  $softwareGeneratedFormsRowExpanded  .= "<td class='lineItem lineTotal'>" . $total . "</td></tr>";

                  $softwareGeneratedFormsRowCondensed .= "<tr><td class='lineItem lineQty'>&nbsp;</td>";
                  $softwareGeneratedFormsRowCondensed .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $softwareGeneratedFormsRowCondensed .= "<td class='lineItem linePrice'>" . $condensedPrice . "</td>";
                  $softwareGeneratedFormsRowCondensed .= "<td class='lineItem lineTotal'>&nbsp;</td></tr>";
                }
                elseif($option['name'] == "AMS Payroll") {
                  $amsPayrollRowExpanded  .= "<tr><td class='lineItem lineQty'>" . $quantity . "</td>";
                  $amsPayrollRowExpanded  .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $amsPayrollRowExpanded  .= "<td class='lineItem linePrice'>" . $price . "</td>";
                  $amsPayrollRowExpanded  .= "<td class='lineItem lineTotal'>" . $total . "</td></tr>";

                  $amsPayrollRowCondensed .= "<tr><td class='lineItem lineQty'></td>";
                  $amsPayrollRowCondensed .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $amsPayrollRowCondensed .= "<td class='lineItem linePrice'>" . $condensedPrice . "</td>";
                  $amsPayrollRowCondensed .= "<td class='lineItem lineTotal'>&nbsp;</td></tr>";
                }

                elseif($option['name'] == "E-File Direct") {
                  $eFileDirectRowExpanded  .= "<tr><td class='lineItem lineQty'>" . $quantity . "</td>";
                  $eFileDirectRowExpanded  .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $eFileDirectRowExpanded  .= "<td class='lineItem linePrice'>" . $price . "</td>";
                  $eFileDirectRowExpanded  .= "<td class='lineItem lineTotal'>" . $total . "</td></tr>";

                  $eFileDirectRowCondensed .= "<tr><td class='lineItem lineQty'></td>";
                  $eFileDirectRowCondensed .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $eFileDirectRowCondensed .= "<td class='lineItem linePrice'>" . $condensedPrice . "</td>";
                  $eFileDirectRowCondensed .= "<td class='lineItem lineTotal'>&nbsp;</td></tr>";
                }
                elseif($option['name'] == "Forms Filer Plus") {
                  $formsFilerPlusRowExpanded  .= "<tr><td class='lineItem lineQty'>" . $quantity . "</td>";
                  $formsFilerPlusRowExpanded  .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $formsFilerPlusRowExpanded  .= "<td class='lineItem linePrice'>" . $price . "</td>";
                  $formsFilerPlusRowExpanded  .= "<td class='lineItem lineTotal'>" . $total . "</td></tr>";

                  $formsFilerPlusRowCondensed .= "<tr><td class='lineItem lineQty'></td>";
                  $formsFilerPlusRowCondensed .= "<td class='lineItem lineDesc'>" . $option['name'] . "</td>";
                  $formsFilerPlusRowCondensed .= "<td class='lineItem linePrice'>" . $condensedPrice . "</td>";
                  $formsFilerPlusRowCondensed .= "<td class='lineItem lineTotal'>&nbsp;</td></tr>";
                } // End of If Option Name

              } // End of if 1099-FormsFiler
            
            } // End of Foreach Product Option

            //--------------------------------------------------------------------------------------------------------------------------------------
            // Now we need to deal with the Totals rows
            //--------------------------------------------------------------------------------------------------------------------------------------
            if(strpos($p['model'], '1099-FormsFiler')&& $serialCount == 1) {
              $totalsBlock = "<tr><td colspan='2' class='nelcoAd'>" . $nelcoText . "</td><td colspan='2'><table class='totalsTable'>";
              foreach($order['total'] as $total) {
                $totalsBlock .= "<tr><td class='totalHeading'>" . $total['title'] . "</td><td class='totals'>" . $total['text'] . "</td></tr>";
              } // End of Foreach Total
              $totalsBlock .= "</table></td></tr>";
            } 
            else {
              $totalsBlock = "<tr><td colspan='2' class='nelcoAd'>";
              if($data['supressNelco'] != 1) {
                $totalsBlock .= $nelcoText;
              }
              $totalsBlock .= "</td><td colspan='2'><table class='totalsTable'><tr><td>&nbsp;</td></tr></table></td></tr>";
            }// End of if 1099-FormsFiler
   
            //--------------------------------------------------------------------------------------------------------------------------------------
            // Page Assembly
            //--------------------------------------------------------------------------------------------------------------------------------------
            if(strpos($p['model'], '1099-FormsFiler') && $serialCount > 1) {
              $subsequentPages = "";
              $subsequentPages .= $headerInfo;
              $subsequentPages .= $serialBox;
              $subsequentPages .= $purchaseTableHeadings;
              $subsequentPages .= $w2FormsFilerRowCondensed;
              $subsequentPages .= $softwareGeneratedFormsRowCondensed;
              $subsequentPages .= $amsPayrollRowCondensed;
              $subsequentPages .= $eFileDirectRowCondensed;
              $subsequentPages .= $formsFilerPlusRowCondensed;
              $subsequentPages .= $totalsBlock;
              $subsequentPages .= $purchaseTableFooter;
              $subsequentPages .= $footerInfo;
              $subsequentPages .= "</td></tr></table>";

              $orderPages[] = $subsequentPages;
            } // End of if 1099-FormsFiler

         } //End of foreach serial 
        } // End of if serial is set and is an array

        //------------------------------------------------------------------------------------------------------------------------------------------
        // Here the product did not contain a serial number.
        //------------------------------------------------------------------------------------------------------------------------------------------


        //------------------------------------------------------------------------------------------------------------------------------------------
        // If there is only 1 serial number being purchased, we can use the expanded purchase table. Otherwise, we use a condensed version.
        if($serialCount == 1) {
          $firstPurchaseTable .= $w2FormsFilerRowExpanded;
          $firstPurchaseTable .= $softwareGeneratedFormsRowExpanded;
          $firstPurchaseTable .= $amsPayrollRowExpanded;
          $firstPurchaseTable .= $eFileDirectRowExpanded;
          $firstPurchaseTable .= $formsFilerPlusRowExpanded;
        }
        else {
          $firstPurchaseTable .= "<tr><td class='lineItem lineQty'>" . $p['quantity'] . "</td>";
          $firstPurchaseTable .= "<td class='lineItem lineDesc'>" . $p['name'] . "</td>";
          $firstPurchaseTable .= "<td class='lineItem linePrice'>" . $p['price'] . "</td>";
          (float)$pp = substr($p['price'], 1);
          $totalPrice = number_format($pp * $p['quantity'], 2, '.','');
          $firstPurchaseTable .= "<td class='lineItem lineTotal'>$" . $totalPrice . "</td></tr>";
        }

      } // End of foreach order product 
  
      $firstPage .= $headerInfo;
      if($serialCount == 1) { $firstPage .= $firstSerialBox; }
      $firstPage .= $purchaseTableHeadings;
      $firstPage .= $firstPurchaseTable;

      //--------------------------------------------------------------------------------------------------------------------------------------
      // Now we need to deal with the Totals rows
      //--------------------------------------------------------------------------------------------------------------------------------------
      $firstPage .= "<tr><td colspan='2' class='nelcoAd'>";
      if($data['supressNelco'] != 1) {
        $firstPage .= $nelcoText;
      }
      $firstPage .="</td><td colspan='2'><table class='totalsTable'>";
      foreach($order['total'] as $total) {
        $firstPage .= "<tr><td class='totalHeading'>" . $total['title'] . "</td><td class='totals'>" . $total['text'] . "</td></tr>";
      } // End of Foreach Total
      $firstPage .= "</table></td></tr>";
      $firstPage .= $purchaseTableFooter;
      $firstPage .= $footerInfo;
      $firstPage .= "</td></tr></table>";


      if($firstPageSet == 1 && $serialCount > 1) {
        $orderPages[] = $subsequentPages;
      }
      elseif($firstPageSet == 0) {
        $orderPages[] = $firstPage;
        $firstPageSet = 1;
      }

      $printed++;
    } // End of While Printed < Wanted

    //--------------------------------------------------------------------------------------------------------------------------------------
    // Order Processing Status ID
    //--------------------------------------------------------------------------------------------------------------------------------------
    $opsid = $this->model_sale_order->getOrderProcessingStatus($order['order_id'])[0]['order_processing_status_id'];
    // Order Status ID
    $osid  = $this->model_sale_order->getOrder($order['order_id'])['order_status_id'];
    // Add the order history
    $data['order_status_id'] = $osid;
    $data['comment'] = 'Invoice has been printed.';
    $data['tracker_url'] = '';
    $data['tracking_numbers'] = '';
    $this->model_sale_order->addOrderHistory($order['order_id'], $data);

    $this->load->model('user/user');
    $user_group_id = $this->model_user_user->getUser($this->user->getId());
    $user_gid = $user_group_id['user_group_id'];

    if($user_gid == '12' || $user_gid == '1') {
      // if opsid is equal to 1, we want to change it to 2.
      switch($opsid) {
        case 1:
          $this->model_sale_order->setOrderProcessingStatus($order['order_id'], '2');
          break;
        case 3:
          $this->model_sale_order->setOrderProcessingStatus($order['order_id'], '5');
          break;
      } // end switch
    } // end if
    //--------------------------------------------------------------------------------------------------------------------------------------

  } // End of Foreach Order

  // Not sure why, but our array needs to be flipped.
  //$orderPages = array_reverse($orderPages);
  $labelsToPrint = $orderPages;
} // End of if - Invoice Assembly.

//------------------------------------------------------------------------------------------------------------------------------------------
// Here we need to print out the shipping labels
//------------------------------------------------------------------------------------------------------------------------------------------

elseif($label == 'ship') {
  $shippingHeader = "<html><head><title>Shipping Label</title>
     <style type='text/css'>
       html, body {
         page-break-after: avoid; 
         page-break-before: avoid; 
       }
       body {
         height: auto;
       }
       .shippingLabel { 
         width:100%; 
         height:99%; 
         top:0; 
         left:0;
         font-size: 15px;
         vertical-align: middle;
         white-space: nowrap;
         page-break-inside: avoid;
         page-break-after: always;
       }

       @page { 
         size: 4in 1.5in;
         margin-left: .2in;
         margin-top: .1in;
         margin-right:.1in;
         margin-bottom: .1in;
       }
       
     </style>
   </head>
   <body>";

  $shippingFooter = "</body></html>";

  // Empty Shipping Label Array
  $shippingLabels[] = '';
  unset($shippingLabels);

  //----------------------------------------------------------------------------------------------------------------------------------------
  // Now we loop through each order
  //----------------------------------------------------------------------------------------------------------------------------------------
  foreach($orders as $order) {
    // If we want duplicates, then lets set a variable to 2, otherwise, we only want 1.
    if(isset($_REQUEST['duplicates'])) {
      if($_REQUEST['duplicates'] == 'true') { $wanted = 2; }
      else {  $wanted = 1; }
    }
    else {
      $wanted = 1;
    }

    $printed = 0;

    // How many serials are in this order. We will need 1 label per serial
    $serialCount = 0;
    foreach($order['product'] as $p) {
      // Quickly count how many serial numbers we have.
      if(isset($p['serial']) && is_array($p['serial'])) {
        foreach($p['serial'] as $s) {
          $serialCount++;
        }
      } // End SerialCount
    } // End SerialCount

    while($printed < $wanted) {
      // Now loop through each product.
      foreach($order['product'] as $p) {

        if(isset($p['serial']) && is_array($p['serial'])) {
          foreach($p['serial'] as $serial) {
            $ship = "<div class='shippingLabel' style='page-break-after: always;'>";
            $ship .= $order['shipping_address'];

            if(isset($p['serial'])) {
              
              $serialPortion = "Serial: " . $serial . $p['featurecode'][0] . " - Key: ";
              $serialPortion .= $this->model_catalog_serial->generate_keycode($serial . $p['featurecode'][0]);
              $ship = preg_replace('#<br />#', ' - ' . $serialPortion . '<br />', $ship, 1);

              $ship = str_replace(' - ' . $serialPortion, '', $ship);

              if($hideSerial == 'true') {
                $serialPortion = '';
              }

              $ship .= '<br />' . $serialPortion;
            } // End of If Serial is set.
  
            $ship .= "</div><br />";
            $ship = str_replace('&amp;', '&', $ship);
            $ship = str_replace('&AMP;', '&', $ship);
            $shippingLabels[] = strtoupper($ship);
          } // End of foreach serial
        } // If isset serial
        else {
          $ship = "<div class='shippingLabel'>";
          $ship .= strtoupper($order['shipping_address']);
          $ship .= "</div>";
          $ship = str_replace('&AMP;', '&', $ship);
          $ship = str_replace('&amp;', '&', $ship);
          $shippingLabels[] = $ship;
        }

      }  // End of Foreach product

      $printed++;
    } // End of while printed < wanted

    //----------------------------------------------------------------------------------------------------------------------------------------
    // Add the Order Processing Status ID and Notify if necessary.
    //----------------------------------------------------------------------------------------------------------------------------------------
    if($label == 'ship') {
      // Order Processing Status ID
      $opsid = $this->model_sale_order->getOrderProcessingStatus($order['order_id'])[0]['order_processing_status_id'];
      // Order Status ID
      $osid  = $this->model_sale_order->getOrder($order['order_id'])['order_status_id'];
      // Add the order history
      $data['order_status_id'] = $osid;
      $data['comment'] = 'Your order is being shipped.';
      $data['tracker_url'] = '';
      $data['tracking_numbers'] = '';
      $this->model_sale_order->addOrderHistory($order['order_id'], $data);

      $this->load->model('user/user');
      $user_group_id = $this->model_user_user->getUser($this->user->getId());
      $user_gid = $user_group_id['user_group_id'];
      if($user_gid == '12' || $user_gid == '1') {
        // if opsid is equal to 1, we want to change it to 3.
        switch($opsid) {
          case 1:
            $this->model_sale_order->setOrderProcessingStatus($order['order_id'], '3');
            break;
          case 2:
            $this->model_sale_order->setOrderProcessingStatus($order['order_id'], '5');
            break;
        }
      }
    }

  } // End of Foreach Order

  $labelsToPrint = $shippingLabels;

} // End of Shipping label

//------------------------------------------------------------------------------------------------------------------------------------------
// Now we make the labels printable.
//------------------------------------------------------------------------------------------------------------------------------------------

$printable = '';

if($cut == 'cut') {
  // Split the array into 2 arrays, then loop through using an index counter, print array1[0], array2[0], array1[1], array2[1], etc...
  // Keep in mind that if cut sorting is chosen and duplicate copies are wanted, printing needs to be sequention. There's not a special order for full page printing.'
  $out1 = array_slice($labelsToPrint, 0, ceil(count($labelsToPrint) / 2));
  $out2 = array_slice($labelsToPrint, ceil(count($labelsToPrint) / 2));
  $counter = 0;
  while($counter <= ceil(count($out1))) {
    if(isset($out1[$counter])) {
      $printable .= $out1[$counter] . "\n";     
    }

    if(isset($out2[$counter])) {
      $printable .= $out2[$counter] . "\n";     
    }
    $counter = $counter + 1;
  }
}
else {
  // Loop through the output array and print each index out in order.
  foreach($labelsToPrint as $index => $invoicePage) {
    if($invoicePage != '') {
      $printable .= $invoicePage ;
    }
  }
}

if($label == 'invoice') {
  $head = $invoiceHeader;
  $foot = $invoiceFooter;
}

if($label == 'ship') {
  $head = $shippingHeader;
  $foot = $shippingFooter;
}

$printable = $head . $printable . $foot;

$printable = trim(preg_replace('/\s\s+/', '', $printable));

set_include_path('/var/www/advancedmicrosolutions.net/www/opencart/dompdf/dompdf');
require_once "dompdf_config.inc.php";
$dompdf = new DOMPDF();

if($label == 'invoice') {
  $dompdf->set_paper('A4');
  $dompdf->load_html(trim($printable));
  $dompdf->render();
  $dompdf->stream('example.pdf', array('Attachment' => 0));
}
elseif($label == 'ship') {
  $dompdf->set_paper('1.5x4', 'landscape');
  $dompdf->load_html(trim($printable));
  $dompdf->render();
  $dompdf->stream('example.pdf', array('Attachment' => 0));
}


?>
