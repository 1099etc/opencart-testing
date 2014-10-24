<?php
class ControllerReportUnpaidInvoice extends Controller {
	public function index() {     

    $url = '';
    $this->data['breadcrumbs'] = array();

    $this->data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $this->data['breadcrumbs'][] = array(
      'text'      => 'Unpaid Invoice Orders',
      'href'      => $this->url->link('report/unpaidInvoice', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      'separator' => ' :: '
    );

		$this->template = 'report/unpaidInvoice.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	
  }
}
?>
