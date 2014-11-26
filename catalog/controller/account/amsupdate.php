<?php 
// This is the AMS Update Controller Module, written by John LeVan for Advanced Micro Solutions.

class ControllerAccountAmsupdate extends Controller { 

  // Set our serial number variable.
  protected $serial;

  // Our index function.
	public function index() {
    // Essentially, we need to check for a serial number, and make sure that if it exists, 
    // it's in uppercase, and then load our page.

    // First, check the get variable, the overwrite it with post
    if(isset($this->request->get['serial'])) {
      $this->serial = $this->request->get['serial'];
    }
    if(isset($this->request->post['serial'])) {
      $this->serial = $this->request->post['serial'];
    }
    else {
      $this->serial = '';
    }
    $this->serial = strtoupper($this->serial);

    // Set the page Title, show the page.
    $this->document->setTitle('AMS Software Updates');
    $this->showPage();

	}

  // This function is to send out the data to the template and display the page.
  public function showPage($errors = '', $files = array(), $serial = '') {
    // Pass in some data to the template, then load the template
    $this->data['serial'] = strtoupper($this->serial);
    $this->data['heading_title'] = 'Software Download';
    $this->data['errors'] = $errors;
    $this->data['files'] = $files;
    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/amsupdate.tpl')) {
      $this->template = $this->config->get('config_template') . '/template/account/amsupdate.tpl';
    } else {
      $this->template = 'default/template/account/amsupdate.tpl';
    }

    $this->children = array(
      'common/column_left',
      'common/column_right',
      'common/content_top',
      'common/content_bottom',
      'common/footer',
      'common/header'
    );

    $this->response->setOutput($this->render());

  }

  public function submit() {
    $this->data['serial'] = $this->serial;

    $files = array();

    isset($this->request->get['serialSearch']) ? $serialSearch = strtoupper($this->request->get['serialSearch']) : $serialSearch = '';
    $errors = '';

    // Need to add a few more checks here.
    // First, check validity of the serial number or if it's empty.
    if(isset($serialSearch) && ($serialSearch != 'demo' && $serialSearch != 'Demo')) {
      $this->load->model('catalog/serial');
      $validSerials = trim($this->model_catalog_serial->validSerialNOJSON($serialSearch));
      if($validSerials != 'true') {
        $errors = '<li>' . $validSerials . '</li>';
      }
    }
    elseif(!isset($serialSearch) || $serialSearch == '') {
      $errors = '<li>Error: ND4 - The serial number was empty. Please submit a valid serial number.</li>';
    }

    if(isset($serialSearch) && ($serialSearch != 'demo' && $serialSearch != 'Demo')) {
      $featurecodes = substr($this->request->get['serialSearch'],-3,3);
      $serialcode   = substr($this->request->get['serialSearch'], 0,5);

      $this->load->model('account/amsupdate');

      $status_id = $this->model_account_amsupdate->getSerialOrderStatusID($serialcode);
      if($status_id != '5') { // If the serial is not on a "complete" order....
        // Need to add a message for preordered files based on stock status.
        $stock_status = $this->model_account_amsupdate->getSerialProductStock($serialcode);
        $model = $this->model_account_amsupdate->getSerialProductModel($serialcode);
        if(strpos($model, '-1099-FormsFiler') !== false && $stock_status == 8) {
          $SWyear = substr($model, 0, 4);
          $errors .= '<li>Notice: You have pre-ordered the ' . $SWyear . ' software, which will be released by early January. You will receive an email notification when the software is available.</li>';
        }
        else {
          $errors .= '<li>Error: ND8 - The serial you submitted is unavailable.</li>';
        }
        $this->showPage($errors, '', $this->serial);
      }
      else {
        $featurecodes = strtoupper($featurecodes);
        $getDL = $this->model_account_amsupdate->getDownloads($serialcode, $featurecodes);

        if(!empty($getDL)) { 
          foreach($getDL as $DL) {
            $files[] = array(
              'download_id'=> $DL['download_id'],
              'filename'   => $DL['filename'],
              'mask'       => $DL['mask'],
              'name'       => $DL['name'],
              'date_added' => $DL['date_added'],
              'notes'      => html_entity_decode($DL['notes']),
              'version'    => $DL['version'],
              'serialcode' => $serialcode
            );
            // .= implode('<br />',$DL) . "<hr />"; 
          }
        }
        else { 
          if($serialSearch != '') {
            // Need to add a message for preordered files based on stock status.
            $stock_status = $this->model_account_amsupdate->getSerialProductStock($serialcode);
            $model = $this->model_account_amsupdate->getSerialProductModel($serialcode);

            if(strpos($model, '-1099-FormsFiler') !== false && $stock_status == 8) {
              $SWyear = substr($model, 0, 4);
              $errors .= '<li>Notice: You have pre-ordered the ' . $SWyear . ' software, which will be released by early January. You will receive an email notification when the software is available.</li>';
            }
            else {
              $errors .= '<li>Error: ND1 - The serial you submitted does not have any downloads available.</li>';
            }
          }
        }
      } // If serialSearch != Demo
    }
    else {
      $this->load->model('account/amsupdate');
      $getDL = $this->model_account_amsupdate->getDownload(12);
      if(is_array($getDL)) {
        foreach($getDL as $DL) {
          $files[] = array(
            'download_id'=> '12',
            'filename'   => 'demo.exe',
            'mask'       => 'Demo.exe',
            'name'       => 'Demo',
            'date_added' => date('d M Y'),
            'notes'      => 'Demo',
            'version'    => '',
            'serialcode' => 'Demo'
          );
        // .= implode('<br />',$DL) . "<hr />";
        }
      }
      else {
        if($serialSearch != '') {
          $errors .= '<li>Error: ND2 - The serial you submitted does not have any downloads available.</li>';
        }
      }
    }
// Need to check the database for the serial and display the files associated with the product that was purchased.

    $this->showPage($errors,$files, $this->serial);
  }


  public function download($download_id = '', $s = '') {  
    isset($this->request->get['download_id']) ? $download_id = $this->request->get['download_id'] : $download_id = '';

    if(($this->serial != '' && $download_id != '') || $download_id == 12 || $download_id != '') {
      if($download_id == 12 && $this->serial == '') { $this->serial = 'demo'; }

      if($this->serial != '') {
        $serialcode = substr($this->serial, 0, 5);
      }
      else { $serialcode = ''; }

      $this->load->model('account/amsupdate');
      $downloadInfo = $this->model_account_amsupdate->getDownload($download_id);
      $filename = $downloadInfo['filename'];
      $mask     = $downloadInfo['mask'];
      $link = '<a href="https://shop.1099-etc.com/download/' . $filename . '">Download</a>';
      $file = 'download/' . $filename;
      $mask = basename($mask);

      if (!headers_sent()) {
        if (file_exists($file)) {

          // Let's log the visit....
          require(dirname(__FILE__) . '/rb.php');

          //Second, we need to setup the database
          R::setup('mysql:host=localhost;dbname=opencart','opencartuser','opencartpass');

          // Create a redbean...
          $log = R::dispense('redbeanlogdownloads');

          // Process the data being submitted for sanitization
          foreach ($_SERVER as $key => $value){
            $log->$key = $value;
            R::store($log);
          }
          foreach ($_REQUEST as $key => $value){
            $log->$key = $value;
            R::store($log);
          }
          foreach ($_POST as $key => $value){
            $log->$key = $value;
            R::store($log);
          }
          foreach ($_GET as $key => $value){
            $log->$key = $value;
            R::store($log);
          }
          foreach ($_ENV as $key => $value){
            $log->$key = $value;
            R::store($log);
          }
          
          $localVariables = array();
          $localVariables['maskName'] = $mask;
          $localVariables['fileName'] = $file;
          $localVariables['dateTime'] = date('Y-m-d H:i:s');
          
          foreach ($localVariables as $key => $value){
            $log->$key = $value;
            R::store($log);
          }

          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
          header('Expires: 0');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          header('Pragma: public');
          header('Content-Length: ' . filesize($file));
          if (ob_get_level()) ob_end_clean();
          readfile($file, 'rb');
          exit;
        } else {
          exit('Error: Could not find file ' . $file . '!');
        }
      } else {
        exit('Error: Headers already sent out!');
      }
    }
    else {
      $this->showPage('There was a problem obtaining the download you requested. Please try again.'); 
    }

  }


}
?>
