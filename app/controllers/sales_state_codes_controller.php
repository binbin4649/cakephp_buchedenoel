<?php
class SalesStateCodesController extends AppController {

	var $name = 'SalesStateCodes';
	var $uses = array('SalesStateCode', 'User');

	function index() {
		$cutom_order_approve = get_cutom_order_approve();
		$this->SalesStateCode->recursive = 0;
		$index_datas = $this->paginate();
		$index_exit = array();
		foreach($index_datas as $index_data){
			if(!empty($index_data['SalesStateCode']['cutom_order_approve']))$index_data['SalesStateCode']['cutom_order_approve'] = $cutom_order_approve[$index_data['SalesStateCode']['cutom_order_approve']];
			$index_exit[] = $index_data;
		}
		$this->set('salesStateCodes', $index_exit);
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid SalesStateCode', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('SalesStateCode.id'=>$id),
			'recursive'=>0
		);
		$view_data = $this->SalesStateCode->find('first', $params);
		$cutom_order_approve = get_cutom_order_approve();
		$order_approve = get_order_approve();
		if(!empty($view_data['SalesStateCode']['cutom_order_approve']))$view_data['SalesStateCode']['cutom_order_approve'] = $cutom_order_approve[$view_data['SalesStateCode']['cutom_order_approve']];
		if(!empty($view_data['SalesStateCode']['order_approve']))$view_data['SalesStateCode']['order_approve'] = $order_approve[$view_data['SalesStateCode']['order_approve']];
		$this->set('salesStateCode', $view_data);
	}

	function add() {
		if (!empty($this->data)) {
			$this->SalesStateCode->create();
			if ($this->SalesStateCode->save($this->data)) {
				$id = $this->SalesStateCode->getInsertID();
				$this->redirect('/sales_state_codes/view/'.$id);
			} else {
			}
		}
		$cutom_order_approve = get_cutom_order_approve();
		$order_approve = get_order_approve();

		$this->set(compact('cutom_order_approve', 'order_approve'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid SalesStateCode', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SalesStateCode->save($this->data)) {
				$this->redirect('/sales_state_codes/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SalesStateCode->read(null, $id);
		}
		$cutom_order_approve = get_cutom_order_approve();
		$order_approve = get_order_approve();

		$this->set(compact('cutom_order_approve', 'order_approve'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid SalesStateCode', true), array('action'=>'index'));
		}
		if ($this->SalesStateCode->del($id) == false) {
			$this->redirect('/sales_state_codes/');
		}
	}


}
?>