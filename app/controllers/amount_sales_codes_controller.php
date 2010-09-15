<?php
class AmountSalesCodesController extends AppController {

	var $name = 'AmountSalesCodes';
	var $helpers = array('Html', 'Form');

	function index() {
		$modelName = 'AmountSalesCode';
		$subModel = 'SalesCode';
		$sub_id = 'sales_code';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName][$sub_id])){
				$conditions[] = array('and'=>array($modelName.'.'.$sub_id=>$this->data[$modelName][$sub_id]));
			}
			if(!empty($this->data[$modelName]['amount_type'])){
				$conditions[] = array('and'=>array($modelName.'.amount_type'=>$this->data[$modelName]['amount_type']));
			}
			if(!empty($this->data[$modelName]['start_day']['year']) and !empty($this->data[$modelName]['start_day']['month']) and !empty($this->data[$modelName]['start_day']['day'])){
				$start_date = $this->data[$modelName]['start_day']['year'].'-'.$this->data[$modelName]['start_day']['month'].'-'.$this->data[$modelName]['start_day']['day'];
				$conditions[] = array('and'=>array($modelName.'.start_day'=>$start_date));
			}
			if(!empty($this->data[$modelName]['end_day']['year']) and !empty($this->data[$modelName]['end_day']['month']) and !empty($this->data[$modelName]['end_day']['day'])){
				$end_date = $this->data[$modelName]['end_day']['year'].'-'.$this->data[$modelName]['end_day']['month'].'-'.$this->data[$modelName]['end_day']['day'];
				$conditions[] = array('and'=>array($modelName.'.end_day'=>$end_date));
			}
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>100,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>array(),
				'limit'=>100,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}
		$this->AmountSalesCode->recursive = 0;
		$this->set('amountSalesCodes', $this->paginate());
		$sales_code = get_sales_code();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'sales_code'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountSalesCode.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountSalesCode', $this->AmountSalesCode->read(null, $id));
	}

	function add() {
		$sales_code = get_sales_code();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'sales_code'));
		if (!empty($this->data)) {
			$this->AmountSalesCode->create();
			$modelName = 'AmountSalesCode';
			$subModel = 'SalesCode';
			$sub_id = 'sales_code';
			$name = $sales_code[$this->data[$modelName][$sub_id]].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountSalesCode->save($this->data)) {
				$this->Session->setFlash(__('The AmountSalesCode has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountSalesCode could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$sales_code = get_sales_code();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'sales_code'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountSalesCode', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountSalesCode';
			$subModel = 'SalesCode';
			$sub_id = 'sales_code';
			$name = $sales_code[$this->data[$modelName][$sub_id]].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountSalesCode->save($this->data)) {
				$this->Session->setFlash(__('The AmountSalesCode has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountSalesCode could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountSalesCode->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountSalesCode', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountSalesCode->del($id)) {
			$this->Session->setFlash(__('AmountSalesCode deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>