<?php
class ControllerReportNelcoweekly extends Controller {
	public function index() {     

    if(isset($this->request->get['startDate']) && $this->request->get['startDate'] != '')  { $startDate = date('Y-m-d', strtotime($this->request->get['startDate'])); } else {
      if(isset($this->request->post['startDate']) && $this->request->post['startDate'] != '') { $startDate = date('Y-m-d', strtotime($this->request->post['startDate'])); } else {
        $startDate = date('Y-m-d', strtotime("-1 week"));
      }
    }

    if(isset($this->request->get['endDate']) && $this->request->get['endDate'] != '')  { $endDate = date('Y-m-d', strtotime($this->request->get['endDate'])); } else {
      if(isset($this->request->post['endDate']) && $this->request->post['endDate'] != '') { $endDate = date('Y-m-d', strtotime($this->request->post['endDate'])); } else {
        $endDate = date('Y-m-d');
      }
    }

    $this->load->model('report/nelcoweekly');				 

    $this->data['orders'] = $this->model_report_nelcoweekly->getNelcoWeekly($startDate, $endDate);


    $url = '';
    $this->data['breadcrumbs'] = array();

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $this->data['breadcrumbs'][] = array(
      'text'      => 'Nelco Weekly Report',
      'href'      => $this->url->link('report/nelcoweekly', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      'separator' => ' :: '
    );

		$this->template = 'report/nelcoweekly.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	
  }
}
?>
