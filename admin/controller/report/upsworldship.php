<?php
class ControllerReportUpsworldship extends Controller {
	public function index() {     
    $this->load->model('report/upsworldship');

    $save = 0;

    if(isset($this->request->get['save']) && $this->request->get['save'] == 1) {
      $save = 1;
    }
    elseif(isset($this->request->post['save']) && $this->request->post['save'] == 1) {
      $save = 1;
    }
    else {
      $save = 0;
    }

    if(isset($this->request->get['startDate']) && $this->request->get['startDate'] != '')  { $startDate = date('Y-m-d', strtotime($this->request->get['startDate'])); } else {
      if(isset($this->request->post['startDate']) && $this->request->post['startDate'] != '') { $startDate = date('Y-m-d', strtotime($this->request->post['startDate'])); } else {
        $startDate = $this->model_report_upsworldship->getLastEndDate();
      }
    }

    if(isset($this->request->get['endDate']) && $this->request->get['endDate'] != '')  { $endDate = date('Y-m-d', strtotime($this->request->get['endDate'])); } else {
      if(isset($this->request->post['endDate']) && $this->request->post['endDate'] != '') { $endDate = date('Y-m-d', strtotime($this->request->post['endDate'])); } else {
        $endDate = date('Y-m-d h:i:s');
      }
    }

    if(isset($this->request->get['delete']) && $this->request->get['delete'] != '') {
      $this->model_report_upsworldship->deleteReport($this->request->get['delete']);
    }

    $this->data['orders'] = $this->model_report_upsworldship->getUPSOrders($startDate, $endDate, $save);

    $this->data['previous_orders'] = $this->model_report_upsworldship->listPreviousReports();

    $url = '';
    $this->data['breadcrumbs'] = array();

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $this->data['breadcrumbs'][] = array(
      'text'      => 'UPS World Ship Report',
      'href'      => $this->url->link('report/upsworldship', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      'separator' => ' :: '
    );

		$this->template = 'report/upsworldship.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	
  }

   
 

}
?>
