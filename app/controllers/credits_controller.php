<?php
class CreditsController extends AppController {

	var $name = 'Credits';
	var $uses = array('Credit', 'Billing', 'Invoice');
	var $components = array('OutputCsv');

	function index() {
		$modelName = 'Credit';
		$conditions = array();
		if (!empty($this->data)) {
			if(!empty($this->data[$modelName]['id'])){
				$conditions[] = array('and'=>array($modelName.'.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['billing_id'])){
				$conditions[] = array('and'=>array($modelName.'.billing_id'=>$this->data[$modelName]['billing_id']));
			}
			if(!empty($this->data[$modelName]['invoice_id'])){
				$conditions[] = array('and'=>array($modelName.'.invoice_id'=>$this->data[$modelName]['invoice_id']));
			}
			if(!empty($this->data[$modelName]['start_date'])){
				$conditions[] = array('and'=>array($modelName.'.date >='=>$this->data[$modelName]['start_date']));
			}
			if(!empty($this->data[$modelName]['end_date'])){
				$conditions[] = array('and'=>array($modelName.'.date <='=>$this->data[$modelName]['end_date']));
			}
			if(!empty($this->data[$modelName]['start_created'])){
				$conditions[] = array('and'=>array($modelName.'.created >='=>$this->data[$modelName]['start_created'].' 00:00:00'));
			}
			if(!empty($this->data[$modelName]['end_created'])){
				$conditions[] = array('and'=>array($modelName.'.created <='=>$this->data[$modelName]['end_created'].' 23:59:59'));
			}
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'limit'=>5000,
					'order'=>array($modelName.'.created'=>'desc')
				);
				$credits = $this->Credit->find('all' ,$params);
				$output_csv = $this->OutputCsv->credits($credits);
				$file_name = 'credits_csv'.date('Ymd-His').'.csv';
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

		$this->Credit->recursive = 0;
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>60,
			'order'=>array('Credit.created'=>'desc'),
		);
		$credits = $this->paginate();
		$this->set('credits', $credits);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Credit.', true));
			$this->redirect(array('action'=>'index'));
		}
		$credit = $this->Credit->read(null, $id);

		$params = array(
			'conditions'=>array('Billing.id'=>$credit['Credit']['billing_id']),
			'recursive'=>0
		);
		$Billing = $this->Billing->find('first' ,$params);
		$credit['Credit']['billing_name'] = $Billing['Billing']['name'];
		$this->set('credit', $credit);
		$credit_methods = get_credit_methods();
		$bankAcuts = $this->Credit->BankAcut->find('list');
		$this->set(compact('credit_methods', 'bankAcuts'));
	}

	function add($ac = null) {
		if($ac == 'add'){
			$session_read = $this->Session->read('Credit');
			//$billing_invoices = $this->Invoice->novelInvoice($session_read['Credit']['billing_id']);
			if ($this->Credit->save($session_read)) {
				$this->Session->delete("Credit");
				$credit_id = $this->Credit->getInsertID();
				$this->Session->setFlash(__('The Credit has been saved', true));
				$this->redirect(array('action'=>'view/'.$credit_id));
			}else{
				$this->Session->setFlash(__('ERROR:credits_controller 30', true));
				$this->redirect(array('action'=>'add'));
			}
		}
		if (!empty($this->data)) {
			$status = 0;
			$params = array(
				'conditions'=>array('Billing.id'=>$this->data['Credit']['billing_id']),
				'recursive'=>0
			);
			$Billing = $this->Billing->find('first' ,$params);
			//$billing_invoices = $this->Invoice->novelInvoice($this->data['Credit']['billing_id']);
			if($Billing){
				$this->data['Credit']['billing_name'] = $Billing['Billing']['name'];
				$status++;
			}else{
				//$this->data['Credit']['billing_name'] = 'そんな請求先は無い、もしくはその請求先に対する請求書が発行されていません。';
				$this->data['Credit']['billing_name'] = 'そんな請求先はありません。';
			}
			if(!empty($this->data['Credit']['deposit_amount'])) $status++;
			if(!empty($this->data['Credit']['reconcile_amount'])) $status++;
			$this->data['Credit']['status'] = $status;
			$this->Session->write("Credit", $this->data);
			$this->set('add_confirm', $this->data);
		}
		$credit_methods = get_credit_methods();
		$bankAcuts = $this->Credit->BankAcut->find('list');
		$this->set(compact('credit_methods', 'bankAcuts'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Credit', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The Credit has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Credit']['id']));
			} else {
				$this->Session->setFlash(__('The Credit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Credit->read(null, $id);
		}
		$credit_methods = get_credit_methods();
		$bankAcuts = $this->Credit->BankAcut->find('list');
		$this->set(compact('credit_methods', 'bankAcuts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Credit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Credit->del($id)) {
			$this->Session->setFlash(__('Credit deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>