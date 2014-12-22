<?php
class ControllerReportReorder extends Controller {
	public function index() {     
		$this->language->load('report/reorder');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_ordered_year'])) {
			$filter_ordered_year = $this->request->get['filter_ordered_year'];
		} else {
			$filter_ordered_year = '';
		}

		if (isset($this->request->get['filter_didnt_order_year'])) {
			$filter_didnt_order_year = $this->request->get['filter_didnt_order_year'];
		} else {
			$filter_didnt_order_year = '';
		}
				
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = '';
		}
		
	  if (isset($this->request->get['filter_fax'])) {
			$filter_fax = $this->request->get['filter_fax'];
		} else {
			$filter_fax = '';
		}

    if (isset($this->request->get['filter_taxcalc_hide'])) {
			$filter_taxcalc_hide = $this->request->get['filter_taxcalc_hide'];
		} else {
			$filter_taxcalc_hide = '';
		}
	
    if (isset($this->request->get['filter_pr_hide'])) {
			$filter_pr_hide = $this->request->get['filter_pr_hide'];
		} else {
			$filter_pr_hide = '';
		}
	  
    if (isset($this->request->get['filter_multiquantity'])) {
			$filter_multiquantity = $this->request->get['filter_multiquantity'];
		} else {
			$filter_multiquantity = '';
		}
	  
    if (isset($this->request->get['filter_software_generated_forms'])) {
			$filter_software_generated_forms = $this->request->get['filter_software_generated_forms'];
		} else {
			$filter_software_generated_forms = '';
		}
	  
    if (isset($this->request->get['filter_ams_payroll'])) {
			$filter_ams_payroll = $this->request->get['filter_ams_payroll'];
		} else {
			$filter_ams_payroll = '';
		}
	  
    if (isset($this->request->get['filter_efile_direct'])) {
			$filter_efile_direct = $this->request->get['filter_efile_direct'];
		} else {
			$filter_efile_direct = '';
		}
	  
    if (isset($this->request->get['filter_forms_filer_plus'])) {
			$filter_forms_filer_plus = $this->request->get['filter_forms_filer_plus'];
		} else {
			$filter_forms_filer_plus = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['filter_ordered_year'])) {
			$url .= '&filter_ordered_year=' . $this->request->get['filter_ordered_year'];
		}
		
		if (isset($this->request->get['filter_didnt_order_year'])) {
			$url .= '&filter_didnt_order_year=' . $this->request->get['filter_didnt_order_year'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
	  
    if (isset($this->request->get['filter_fax'])) {
			$url .= '&filter_fax=' . $this->request->get['filter_fax'];
		}

	  if (isset($this->request->get['filter_taxcalc_hide'])) {
			$url .= '&filter_taxcalc_hide=' . $this->request->get['filter_taxcalc_hide'];
		}

	  if (isset($this->request->get['filter_pr_hide'])) {
			$url .= '&filter_pr_hide=' . $this->request->get['filter_pr_hide'];
		}


	  if (isset($this->request->get['filter_multiquantity'])) {
			$url .= '&filter_multiquantity=' . $this->request->get['filter_multiquantity'];
		}

	  if (isset($this->request->get['filter_software_generated_forms'])) {
			$url .= '&filter_software_generated_forms=' . $this->request->get['filter_software_generated_forms'];
		}

	  if (isset($this->request->get['filter_ams_payroll'])) {
			$url .= '&filter_ams_payroll=' . $this->request->get['filter_ams_payroll'];
		}

	  if (isset($this->request->get['filter_efile_direct'])) {
			$url .= '&filter_efile_direct=' . $this->request->get['filter_efile_direct'];
		}

	  if (isset($this->request->get['filter_forms_filer_plus'])) {
			$url .= '&filter_forms_filer_plus=' . $this->request->get['filter_forms_filer_plus'];
		}


		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/reorder', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/reorder');
		
		$this->data['orders'] = array();
		
		$data = array(
			'filter_ordered_year'	     => $filter_ordered_year, 
			'filter_didnt_order_year'	     => $filter_didnt_order_year,
      'filter_email'      => $filter_email,
      'filter_fax'      => $filter_fax,
      'filter_taxcalc_hide'      => $filter_taxcalc_hide,
      'filter_pr_hide'      => $filter_pr_hide,
      'filter_multiquantity'      => $filter_multiquantity,
      'filter_software_generated_forms'      => $filter_software_generated_forms,
      'filter_ams_payroll'      => $filter_ams_payroll,
      'filter_efile_direct'      => $filter_efile_direct,
      'filter_forms_filer_plus'      => $filter_forms_filer_plus
		);
				
		
		$this->data['orders'] = array();
		
		$this->data['orders'] = $this->model_report_reorder->getOrderTotals($data);
		
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_total'] = $this->language->get('column_total');
		
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_new_only'] = $this->language->get('entry_new_only');	
		
		$this->data['button_filter'] = $this->language->get('button_filter');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['groups'] = array();

    $this->data['download_url'] =  $this->url->link('report/reorder', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_year'),
			'value' => 'year',
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_month'),
			'value' => 'month',
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_week'),
			'value' => 'week',
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_day'),
			'value' => 'day',
		);
	  if(isset($this->request->get['download']) && $this->request->get['download'] == 'Y')
    {

      //der("Cache-Control: public");
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=reorder.csv");
      header("Content-Type: application/octet-stream; "); 
      header("Content-Transfer-Encoding: binary");
      $output = fopen('php://output', 'w');

      // output the column headings
      fputcsv($output, array('SERIAL', 'XFAX', 'FAX', 'PHONE', 'PHONE2', 'EMAIL', 'CNAME', 'NAME', 'FIRM', 'ADDR', 'CSZ', 'QTY1', 'EXT1', 'QTY2', 'EXT2', 'QTY3', 'EXT3', 'QTY4', 'EXT4', 'QTY5', 'EXT5', 'SUBTOTL'), "\t");

      // loop over the rows, outputting them
      foreach ($this->data['orders'] as $row) 
      {
        fputcsv($output, $row, "\t");
      }
    }
    else
    {
		$pagination = new Pagination();
		$pagination->total = 0;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/reorder', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'report/reorder.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
    }
	}
}
?>
