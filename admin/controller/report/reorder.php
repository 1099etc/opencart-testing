<?php
class ControllerReportReorder extends Controller {
	public function index() {     

//    $this->load->model('report/nelcoweekly');				 

//    $this->data['orders'] = $this->model_report_nelcoweekly->getNelcoWeekly($startDate, $endDate);


    $url = '';
    $this->data['breadcrumbs'] = array();

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $this->data['breadcrumbs'][] = array(
      'text'      => 'Reorder Report Generation',
      'href'      => $this->url->link('report/reorder', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      'separator' => ' :: '
    );

		$this->template = 'report/reorder.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	
  }
}
?>
