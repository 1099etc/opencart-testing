<?php 
class ControllerAccountSoftwareRegistration extends Controller {
	private $error = array();
	  
  	public function index() {

      if(isset($this->request->get['serial'])) {
        $serial = $this->request->get['serial'];
      }
      else {
        $serial = '';
      }
/*
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/softwareregistration&serial=' . $serial, '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	}
*/
	  	$this->document->setTitle('Software Registration');
		  $this->showPage('',$serial);
  	}
 
    protected function showPage($errors = '', $serial = '', $selectedStates = array(),$comments = '') {
      if($serial == '') {
        if(isset($this->request->get['serial'])) {
          $serial = $this->request->get['serial'];
        }
        else {
          if(isset($this->request->post['serial'])) {
            $serial = $this->request->post['serial'];
          }
        }
      }

      $this->load->model('account/softwareregistration');
      $states[] = $this->model_account_softwareregistration->getStates();

      $this->data['states'] = $states;
      $this->data['selectedStates'] = $selectedStates;
      $this->data['comments'] = $comments;
      $this->data['errors'] = $errors;
      $this->data['action'] = '?route=account/softwareregistration/submit';
      $this->data['heading_title'] = 'Software Registration';
      $this->data['serial'] = $serial;


      if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/software_registration.tpl')) {
        $this->template = $this->config->get('config_template') . '/template/account/software_registration.tpl';
      } else {
        $this->template = 'default/template/account/software_registration.tpl';
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

      // Lets make sure we have a serial and that it's valid.
      if(isset($this->request->post['serial'])) {
        $this->load->model('catalog/serial');
        $validSerials = trim($this->model_catalog_serial->validSerialNOJSON($this->request->post['serial']));
        if($validSerials != 'true') {
          $errors = $validSerials;
        }
        else { 
          $errors = '';
        }
      }
      else {
        $errors = 'The serial number was empty. Please submit a valid serial number.';
      } 

      // Need to check the database for a valid serial entry.

      $featurecodes = substr($this->request->post['serial'],-3,3);
      $serialcode   = substr($this->request->post['serial'],0,5);
   
      // Need to check to make sure that the serial has not yet been registered
      $this->load->model('account/softwareregistration');
      $exists = $this->model_account_softwareregistration->serialPurchased($serialcode, $featurecodes);
      if(!$exists) {
        if(strlen($this->request->post['serial']) != 8) {
          $errors = 'The serial number you submitted was incorrect. Please submit a valid 8 character serial number.';
        }
        else {
          $errors = 'The serial you have entered has not been purchased.';
        }
      }      

      $registered = $this->model_account_softwareregistration->isRegistered($serialcode, $featurecodes);
      if($registered) {
        $errors = 'The serial you entered is already registered.';
      }

      // Compile the states listing.
      if(isset($this->request->post['states'])) {
        foreach($this->request->post['states'] as $state) {
          $states[] = $state;
        }

        $customer_id = $this->model_account_softwareregistration->getCustomerIDfromSerial($serialcode, $featurecodes);
        if(isset($this->request->post['states'])) { $this->model_account_softwareregistration->editCustomerPayrollStates($customer_id, $this->request->post['states']); }

      }
      else {
        $states = array();
      }
   
      if(isset($this->request->post['comments'])) {
        $comments = $this->request->post['comments'];
      }
      else {
        $comments = '';
      }

      // Serial was valid and we should be good to go.
      if($errors == '') {
        $this->model_account_softwareregistration->addRegistration($serialcode, $featurecodes, $states, $comments);

        if($comments != '' && isset($comments)) {
          $from = "Software Registration <no-reply@1099-etc.com>";
          $subject = "Software Registration for Serial Number " . $serialcode . $featurecodes;
          $message  = "Serial - " . $serialcode . $featurecodes . "\n\n";
          $message .= "Payroll States - \n" . implode(", ",$states) . "";
          $message .= "\n\nComments - \n" . $comments . "\n";
          mail("registration@1099-etc.com", $subject, $message, "From: " . $from . "\n");
        }

        $this->showPage("Thank you for registering.");
//        $this->redirect($this->url->link('account/account', '', 'SSL'));        

/*
        $getRegistration = $this->model_account_softwareregistration->showRegistration($serialcode, $featurecodes);
        $g = implode('<br />',$getRegistration);
        $this->showPage($g ,$serialcode, $states, $comments);
*/    }
      else {
        $this->showPage($errors,$this->request->post['serial'], $states, $comments);
      }
    }




}
?>
