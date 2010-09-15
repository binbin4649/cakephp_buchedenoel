<?php
class BillingsController extends AppController {

	var $name = 'Billings';

	function index() {

	if (!empty($this->data['Billing']['word'])) {
			$seach_word = $this->data['Billing']['word'];
			$conditions['or'] = array(
				'Billing.name LIKE'=>'%'.$seach_word.'%',
				'Billing.address_one LIKE'=>'%'.$seach_word.'%',
				'Billing.tel LIKE'=>'%'.$seach_word.'%'
			);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Billing.updated'=>'desc')
			);
		}else{
			if($this->data['Billing']['trade_type'] == '1'){
				$conditions = array();
			}else{
				$conditions['or'] = array(
					'Billing.trade_type <>'=>'3',
					'Billing.trade_type'=>NULL,
				);
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>20,
				'order'=>array('Billing.updated'=>'desc')
			);
		}

		$total_day = get_total_day();
		$payment_day = get_payment_day();
		$this->Billing->recursive = 0;
		$index_view = $this->paginate();
		$index_out = array();
		foreach($index_view as $index){
			if(!empty($index['Billing']['total_day']))$index['Billing']['total_day'] = $total_day[$index['Billing']['total_day']];
			if(!empty($index['Billing']['payment_day']))$index['Billing']['payment_day'] = $payment_day[$index['Billing']['payment_day']];
			$index_out[] = $index;
		}
		$this->set('billings', $index_out);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Billing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$trade_type = get_trade_type();
		$district = get_district();
		$invoice_type = get_invoice_type();
		$total_day = get_total_day();
		$payment_day = get_payment_day();
		$tax_fraction = get_tax_fraction();
		$view = $this->Billing->read(null, $id);
		if(!empty($view['Billing']['trade_type']))$view['Billing']['trade_type'] = $trade_type[$view['Billing']['trade_type']];
		if(!empty($view['Billing']['total_day']))$view['Billing']['total_day'] = $total_day[$view['Billing']['total_day']];
		if(!empty($view['Billing']['payment_day']))$view['Billing']['payment_day'] = $payment_day[$view['Billing']['payment_day']];
		if(!empty($view['Billing']['invoice_type']))$view['Billing']['invoice_type'] = $invoice_type[$view['Billing']['invoice_type']];
		if(!empty($view['Billing']['district']))$view['Billing']['district'] = $district[$view['Billing']['district']];
		if(!empty($view['Billing']['tax_fraction']))$view['Billing']['tax_fraction'] = $tax_fraction[$view['Billing']['tax_fraction']];
		$this->set('billing', $view);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Billing->create();
			if ($this->Billing->save($this->data)) {
				$this->Session->setFlash(__('The Billing has been saved', true));
				$id = $this->Billing->getInsertID();
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Billing could not be saved. Please, try again.', true));
			}
		}
		$trade_type = get_trade_type();
		$district = get_district();
		$invoice_type = get_invoice_type();
		$total_day = get_total_day();
		$payment_day = get_payment_day();

		$this->set(compact('district', 'invoice_type', 'total_day', 'payment_day', 'trade_type'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Billing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Billing->save($this->data)) {
				$this->Session->setFlash(__('The Billing has been saved', true));
				$this->redirect(array('action'=>'view/'.$id));
			} else {
				$this->Session->setFlash(__('The Billing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Billing->read(null, $id);
		}
		$trade_type = get_trade_type();
		$district = get_district();
		$invoice_type = get_invoice_type();
		$total_day = get_total_day();
		$payment_day = get_payment_day();
		$tax_fraction = get_tax_fraction();
		$this->set(compact('district', 'invoice_type', 'total_day', 'payment_day', 'trade_type', 'tax_fraction'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Billing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Billing->del($id)) {
			$this->Session->setFlash(__('Billing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>