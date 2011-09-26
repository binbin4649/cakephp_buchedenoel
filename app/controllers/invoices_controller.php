<?php
class InvoicesController extends AppController {

	var $name = 'Invoices';
	var $uses = array('Invoice', 'InvoiceDateil', 'Destination');
	var $components = array('Print', 'OutputCsv');

	function index() {
		$modelName = 'Invoice';
		$conditions = array();
		if (!empty($this->data)) {
			if(!empty($this->data[$modelName]['id'])){
				$conditions[] = array('and'=>array($modelName.'.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['billing_id'])){
				$conditions[] = array('and'=>array($modelName.'.billing_id'=>$this->data[$modelName]['billing_id']));
			}
			if(!empty($this->data[$modelName]['invoice_status'])){
				$conditions[] = array('and'=>array($modelName.'.invoice_status'=>$this->data[$modelName]['invoice_status']));
			}
			if(!empty($this->data[$modelName]['start_date'])){
				$conditions[] = array('and'=>array($modelName.'.date >='=>$this->data[$modelName]['start_date']));
			}
			if(!empty($this->data[$modelName]['end_date'])){
				$conditions[] = array('and'=>array($modelName.'.date <='=>$this->data[$modelName]['end_date']));
			}
			if(!empty($this->data[$modelName]['start_payment_day'])){
				$conditions[] = array('and'=>array($modelName.'.payment_day >='=>$this->data[$modelName]['start_payment_day']));
			}
			if(!empty($this->data[$modelName]['end_payment_day'])){
				$conditions[] = array('and'=>array($modelName.'.payment_day <='=>$this->data[$modelName]['end_payment_day']));
			}
			if(!empty($this->data[$modelName]['start_total_day'])){
				$conditions[] = array('and'=>array($modelName.'.total_day >='=>$this->data[$modelName]['start_total_day']));
			}
			if(!empty($this->data[$modelName]['end_total_day'])){
				$conditions[] = array('and'=>array($modelName.'.total_day <='=>$this->data[$modelName]['end_total_day']));
			}
			
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'limit'=>5000,
					'order'=>array($modelName.'.created'=>'desc')
				);
				$invoices = $this->Invoice->find('all' ,$params);
				$output_csv = $this->OutputCsv->invoices($invoices);
				$file_name = 'invoices_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
		}else{
			$conditions = array();
		}
		$this->Invoice->recursive = 0;
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>60,
			'order'=>array('Invoice.created'=>'desc'),
		);
		$invoices = $this->paginate();
		$this->set('invoices', $invoices);
		$invoice_status = get_invoice_status();
		$invoice_type = get_invoice_type();
		$this->set(compact('invoice_status', 'invoice_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Invoice.', true));
			$this->redirect(array('action'=>'index'));
		}
		$invoice = $this->Invoice->searchOne($id);
		/*
		if(!empty($invoice['Invoice']['adjustment'])){
			$invoice['Invoice']['month_total'] = $invoice['Invoice']['month_total'] + $invoice['Invoice']['adjustment'];
		}
		*/
		$this->set('invoice', $invoice);
		$credit_methods = get_credit_methods();
		$invoice_status = get_invoice_status();
		$this->set(compact('invoice_status', 'credit_methods'));
		if(!empty($invoice['Invoice']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/invoice-print/'.$invoice['Invoice']['print_file'].'.php';
			$print_out['file'] = $invoice['Invoice']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
	}

	function invoice_print($id = null){
		$invoice = $this->Invoice->searchOne($id);
/*
pr($invoice);
exit;
		//taxが入っていない明細は「請求単位」であるとみなし、それを足してbillingの端数処理を用い計算する。
		foreach($invoice['InvoiceDateil'] as $key=>$value){
			if($value['tax'] < 1 or !empty($value['tax'])){

			}
		}
*/
		$invoice['Invoice']['updated_user'] = $this->Auth->user('id');
		$file_name = 'invoice_print'.$id.'-'.date('Ymd-His');
		$path = WWW_ROOT.'/files/invoice-print/';
		$print_xml = $this->Print->InvoicePrint($invoice, $file_name);

		file_put_contents($path.$file_name.'.php', $print_xml);
		$invoice['Invoice']['id'] = $id;
		$invoice['Invoice']['print_file'] = $file_name;
		$invoice['Invoice']['invoice_status'] = 2;
		$this->Invoice->save($invoice);
		$this->redirect(array('action'=>'view/'.$id));
	}

	function add() {
		if($this->Invoice->close_sales()){
			$this->Session->setFlash(__('締められる売上を締めました。', true));
			$this->redirect(array('action'=>'index'));
		}else{
			$this->Session->setFlash(__('ERROR:invoice_controller 26', true));
			$this->redirect(array('action'=>'index'));
		}

	}

	function edit($id = null) {
		if (!empty($this->data)) {
			$this->data['Invoice']['total'] = $this->data['Invoice']['sales'] + $this->data['Invoice']['tax'] + $this->data['Invoice']['shipping'] + $this->data['Invoice']['adjustment'];
			$this->data['Invoice']['month_total'] = $this->data['Invoice']['total'] + $this->data['Invoice']['balance_forward'];
			if ($this->Invoice->save($this->data)) {
				$this->Session->setFlash(__('The Invoice has been saved', true));
				$this->redirect(array('controller'=>'invoices', 'action'=>'view/'.$this->data['Invoice']['id']));
			} else {
				$this->Session->setFlash(__('The Invoice could not be saved. Please, try again.', true));
			}
		}
		$invoice = $this->Invoice->searchOne($id);
		$this->set('invoice', $invoice);
		$invoice_status = get_invoice_status();
		$this->set(compact('invoice_status'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Invoice', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Invoice->del($id)) {
			$this->Session->setFlash(__('Invoice deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>