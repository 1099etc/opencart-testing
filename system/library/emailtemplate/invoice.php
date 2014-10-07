<?php 
/**
 * PDf Invoice part of email template extension
 *
 * @author: Ben Johnson, opencart-templates
 * @email: info@opencart-templates.co.uk
 * @website: http://www.opencart-templates.co.uk
 *
 */

# CONFIG in: library/shared/tcpdf/config
require_once(DIR_SYSTEM . 'library/shared/tcpdf/tcpdf.php');
require_once(DIR_SYSTEM . 'library/shared/tcpdf/include/tcpdf.EasyTable.php');
require_once(DIR_SYSTEM . 'library/shared/tcpdf/include/tcpdf.PDFImage.php');

class EmailTemplateInvoice extends TCPDF_EasyTable {
	var $data = array();

	/**
	 * Sets PDF Config
	 *
	 * @param array $data
	 * @return invoicePdf
	 */
	public function Build($data) {
		$this->data = $data;

		# Set PDF protection (encryption)
		$this->SetProtection(array('modify', 'copy'), '', null, 1, null);

		# Set document meta-information
		$this->SetAuthor('opencart-templates');
		$this->SetCreator('tdpdf');
		$this->SetSubject($this->data['store']['config_name']);
		$this->SetTitle($this->data['store']['config_name']);
		//$this->SetKeywords();

		# Set font
		$this->AddFont('dejavusans', '', 'dejavusans');
		$this->SetFont('dejavusans', '', 7);
		$this->SetTextColor(0, 0, 0);

		# Set default monospaced font
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		# Set margins
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);

		# Set auto page breaks
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		# Image scale
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);

		# Table options
		$this->SetTableOptions();

		return $this;
	}

	/**
	 * Main method responsible for drawing the sections onto the page
	 * Group products into page(s)?
	 *
	 * @return invoicePdf
	 */
	public function Draw(){
		$this->AddPage();		
		$storedY = $this->AddLogo();	
			
		$stored1Y = $this->AddOrderDetails($storedY);				
		$stored2Y = $this->AddCompanyDetails();
						
		$storedY = $this->AddAddress(($stored2Y > $stored1Y) ? $stored2Y : $stored1Y);	
		$this->setY($storedY);
		
		$this->AddProducts($this->data['order']['products']);		
		$this->AddVouchers($this->data['order']['vouchers']);		
		$this->AddTotals($this->data['order']['totals']);
		
		$this->AddInvoiceText($this->data['config']['invoice_text']);

		return $this;
	}

	protected function AddProducts($products){
		$this->SetTableOptions();
		$w1 = $this->GetInnerPageWidth()/100;
		$this->SetCellWidths(array($w1*35, $w1*20, $w1*15, $w1*15, $w1*15));

		$rows = array();
		foreach($products as $product){
			$rows[] = array(
				'<a href="'.$product['url'].'" style="text-decoration:none; color:#000000;">'.$product['name'].'</a>' . $product['option'],
				$product['model'],
				$product['quantity'],
				$product['price'],
				$product['total']
			);
		}

		$this->EasyTable($rows, array(
			$this->getLanguage('column_product'),
			$this->getLanguage('column_model'),
			$this->getLanguage('column_quantity'),
			$this->getLanguage('column_price'),
			$this->getLanguage('column_total')
		));
	}

	protected function AddVouchers($vouchers){
		$this->SetTableOptions();
		$w1 = $this->GetInnerPageWidth()/100;
		$this->SetCellWidths(array($w1*35, $w1*20, $w1*15, $w1*15, $w1*15));

		$rows = array();
		foreach($vouchers as $voucher){
			$rows[] = array(
				$voucher['description'],
				'',
				1,
				$voucher['amount'],
				$voucher['amount']
			);
		}

		$this->EasyTable($rows);
	}

	protected function AddTotals($totals){
		$this->SetTableOptions();
		$w1 = $this->GetInnerPageWidth()/100;
		$this->SetCellWidths(array($w1*85, $w1*15));
		$this->SetFillColor(255,255,255);
		$this->SetCellAlignment(array('R','R'));
		$rows = array();
		foreach($totals as $total){
			$rows[] = array(
				$total['title'],
				$total['text']
			);
		}
		$this->EasyTable($rows);
	}


	/**
	 * Add Order Details
	 */
	protected function AddOrderDetails($storedY){
		$w = 20;
		$h = 4;
		$x = PDF_MARGIN_LEFT;
		$y = ($this->y>$storedY) ? $this->y : $storedY;
		$this->SetY($y);
		$this->SetFont('dejavusans', 'B', 9);
		$this->SetCellPaddings(0, 1, 0, 1);
		
		foreach(array( # Get max width
			'text_date_added',
			'text_order_id',
			'text_invoice_no',
			'text_payment_method',
			'text_shipping_method'
		) as $var){
			$_w = $this->GetStringWidth($this->getLanguage($var));
			if($_w > $w) $w = $_w + 1;
		}
		
		$this->SetX($x);
		$this->Cell($w, $h, $this->getLanguage('text_date_added'), 0, 1, 'L');
		
		if($this->data['order']['invoice_no']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->getLanguage('text_invoice_no'), 0, 1, 'L');
		}
		
		$this->SetX($x);
		$this->Cell($w, $h, $this->getLanguage('text_order_id'), 0, 1, 'L');
		
		$this->SetX($x);
		$this->Cell($w, $h, $this->getLanguage('text_payment_method'), 0, 1, 'L');
		
		$this->SetX($x);
		$this->Cell($w, $h, $this->getLanguage('text_shipping_method'), 0, 1, 'L');
		
		$this->SetFont('dejavusans','', 9);
		$this->SetY($y);
		$x = $x+$w;
		$w = 0;

		$this->SetX($x);
		$this->Cell($w, $h, $this->data['order']['date_added'], 0, 1, 'L');
		
		if($this->data['order']['invoice_no']){
			$this->SetX($x);
			$this->Cell($w, $h, $this->data['order']['invoice_prefix'] . $this->data['order']['invoice_no'], 0, 1, 'L');
		}
				
		$this->SetX($x);
		$this->Cell($w, $h, $this->data['order']['order_id'], 0, 1, 'L');
				
		$this->SetX($x);
		$this->Cell($w, $h, $this->data['order']['payment_method'], 0, 1, 'L');
				
		$this->SetX($x);
		$this->Cell($w, $h, $this->data['order']['shipping_method'], 0, 1, 'L');
			
		return $this->getY();
	}

	/**
	 * Add Address
	 */
	protected function AddAddress($storedY){
		$this->SetFillColor($this->data['config']['invoice_color']);
		$this->SetTextColor(255, 255, 255);
		$this->SetDrawColor(162, 162, 162);
		$this->SetLineWidth(0.1);
		$this->SetFont('dejavusans', 'B', 10);

		$y = (($this->y>$storedY) ? $this->y : $storedY)+3;
		$x = PDF_MARGIN_LEFT;
		$w = 95.5;
		$h = 9;
		$this->SetY($y);

		$this->SetX($x);
		$this->setCellPaddings(4, 2, '', 1);			
		$this->Cell($w, $h, $this->getLanguage('text_to'), 'TB', 0, 'L', true);
		
		$x2 = $this->GetX();
		$this->Cell($w, $h, $this->getLanguage('text_ship_to'), 'TB', 1, 'L', true);

		$this->SetFont('dejavusans','', 10);
		$this->SetTextColor(60, 60, 60);
		$this->setCellPadding(0);
		$w = $w-5.5;
		$h = $h-5;
		$y = $this->y+2;

		$txt = str_ireplace(array("<br />","<br>","<br/>"), "\r\n", $this->data['order']['payment_address']);		
		$this->MultiCell($w, $h, $txt, 0, 'L', false, 1, $x+4, $y);
		$storedY = $this->getY();
				
		$txt = str_ireplace(array("<br />","<br>","<br/>"), "\r\n", $this->data['order']['shipping_address']);
		$this->MultiCell($w, $h, $txt, 0, 'L', false, 1, $x2+4, $y);
		$stored2Y = $this->getY();
		
		if($this->data['order']['payment_company_id'] || $this->data['order']['payment_tax_id']){
			$storedY += 2;
		}
		
		if($this->data['order']['payment_company_id']){
			$this->SetY($storedY);
			$this->SetX($x+4);
			$txt = $this->getLanguage('text_company_id');
			$w2 = $this->GetStringWidth($txt);			
			$this->Cell($w2+1, $h, $txt, 0, 0, 'L');
	
			$this->Cell(20, $h, $this->data['order']['payment_company_id'], 0, 1, 'L');
			
			$storedY = $this->getY();
		}
		
		if($this->data['order']['payment_tax_id']){
			$this->SetY($storedY);
			$this->SetX($x+4);
			$txt = $this->getLanguage('text_tax_id');
			$w2 = $this->GetStringWidth($txt);			
			$this->Cell($w2+1, $h, $txt, 0, 0, 'L');
	
			$this->Cell(20, $h, $this->data['order']['payment_tax_id'], 0, 1, 'L');
			
			$storedY = $this->getY();
		}

		return (($stored2Y>$storedY)?$stored2Y:$storedY)+4;
	}

	/**
	 * Add Invoice Text
	 */
	protected function AddInvoiceText($html){
		$html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
		$this->Ln(5);
		$this->SetFont('dejavusans','', 10);
		$this->SetTextColor(0, 0, 0);
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);
	}

	/**
	 * Add Logo
	 */
	protected function AddLogo(){
		if($this->data['config']['invoice_logo']){		
			$logo = DIR_IMAGE . $this->data['config']['invoice_logo'];
			
			if(file_exists($logo)){
				$this->Image($logo, PDF_MARGIN_LEFT, PDF_MARGIN_TOP, $this->data['config']['invoice_logo_width'], 0, '', $this->data['store']['config_url'], 'N');
			}
		}
		
		return $this->GetY()+3;
	}

	protected function AddCompanyDetails(){
		$txt = $this->data['store']['config_name'];
		$this->SetFont('dejavusans', 'B', 24);
		$this->SetTextColor($this->data['config']['invoice_heading_color']);
		$w = 98;
		$h = $this->getStringHeight($w, $txt);
		$x = $this->w-($w+PDF_MARGIN_RIGHT);
		$y = PDF_MARGIN_TOP;
		$cnt = $this->Multicell($w, $h, $txt, 0, 'R', false, 1, $x, $y);
		$this->Link($x, $y, $w, $h*$cnt, $this->data['store']['config_url'], 0);

		$w = 90;
		$x = $this->w-($w+PDF_MARGIN_RIGHT);
		$this->SetFont('dejavusans', '', 9);
		$this->SetTextColor(60, 60, 60);
		$this->Multicell($w, 4, $this->data['store']['config_address'], 0, 'R', false, 1, $x);

		if($this->data['store']['config_telephone']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->getLanguage('text_telephone').' '.$this->data['store']['config_telephone'], 0, 1, 'R');
		}
		if($this->data['store']['config_fax']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->getLanguage('text_fax').' '.$this->data['store']['config_fax'], 0, 1, 'R');
		}
		if($this->data['store']['config_email']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->data['store']['config_email'], 0, 1, 'R', false, 'mailto:'.$this->data['store']['config_email']);
		}
		if($this->data['store']['config_url']){
			$this->SetX($x);
			$this->Cell($w, 5, $this->data['store']['config_url'], 0, 1, 'R', false, $this->data['store']['config_url']);
		}
		return $this->y;
	}

	/**
	 *
	 * @see tFPDF::Header()
	 */
	function Header(){

	}

	protected function setTableOptions(){
		$this->SetLineWidth(0.1);
		$this->SetCellPaddings(1.5, 2, 1, 2);
		$this->SetCellAlignment(array('L', 'L', 'R', 'R', 'R'));
		$this->SetCellFillStyle(2);
		$this->SetHeaderCellsFillColor($this->data['config']['invoice_color']);
		$this->SetFillColor(247, 247, 247);
		$this->SetDrawColor(150, 150, 150);
		$this->SetTableHeaderPerPage(true);
		$this->SetHeaderCellsFontColor(255, 255, 255);
		$this->SetFillImageCell(false);
	}

	/**
	 * Get language text
	 * @param $key
	 */
	public function getLanguage($key) {
		if (isset($this->l[$key])) {
			return $this->l[$key];
		}
		return '';
	}

	/**
	 * @see TCPDF::Footer()
	 */
	function Footer(){
		$this->SetY($this->y);
		$this->SetFont('dejavusans', '', 7);
		$w_page = isset($this->l['text_paging']) ? $this->l['text_paging'] : 'Page %s of %s';
		if (empty($this->pagegroups)) {
			$html = sprintf($w_page, $this->getAliasNumPage(), $this->getAliasNbPages());
		} else {
			$html = sprintf($w_page, $this->getPageNumGroupAlias(), $this->getPageGroupAlias());
		}
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);
	}

	function GetInnerPageWidth(){
		return $this->getPageWidth()-(PDF_MARGIN_LEFT+PDF_MARGIN_RIGHT);
	}

	/**
	 * Overload to allow HEX color
	 * @see TCPDF::SetDrawColor()
	 */
	function SetDrawColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name=''){
		if($col1[0] == '#'){
			list($col1, $col2, $col3) = $this->_hex2rbg($col1);
		}
		return parent::SetDrawColor($col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Overload to allow HEX color
	 * @see TCPDF::SetTextColor()
	 */
	function SetTextColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name=''){
		if($col1[0] == '#'){
			list($col1, $col2, $col3) = $this->_hex2rbg($col1);
		}
		return parent::SetTextColor($col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Overload to allow HEX color
	 * @see FPDF::SetFillColor()
	 */
	function SetFillColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name=''){
		if($col1[0] == '#'){
			list($col1, $col2, $col3) = $this->_hex2rbg($col1);
		}
		return parent::SetFillColor($col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Overload to allow HEX color
	 * @see TCPDF_EasyTable::SetHeaderCellsFillColor()
	 */
	function SetHeaderCellsFillColor($R, $G=-1, $B=-1){
		if($R[0] == '#'){
			list($R, $G, $B) = $this->_hex2rbg($R);
		}
		return parent::SetHeaderCellsFillColor($R, $G, $B);
	}

	/**
	 * Overload to allow HEX color
	 * @see TCPDF_EasyTable::SetCellFontColor()
	 */
	function SetCellFontColor($R, $G=-1, $B=-1){
		if($R[0] == '#'){
			list($R, $G, $B) = $this->_hex2rbg($R);
		}
		return parent::SetCellFontColor($R, $G, $B);
	}

	# HEX to RGB
	function _hex2rbg($hex){
		$hex = substr($hex, 1);
		if(strlen($hex) == 6){
			list($col1, $col2, $col3) = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
		} elseif(strlen($hex) == 3) {
			list($col1, $col2, $col3) = array($hex[0].$hex[0], $hex[1].$hex[1], $hex[2].$hex[2]);
		} else {
			return false;
		}
		return array(hexdec($col1), hexdec($col2), hexdec($col3));
	}

	# pixel -> millimeter in 72 dpi
	function _px2mm($px){
		return $px*25.4/72;
	}

}