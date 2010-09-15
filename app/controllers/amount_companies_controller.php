<?php
class AmountCompaniesController extends AppController {

	var $name = 'AmountCompanies';
	var $helpers = array('Html', 'Form');
	var $uses = array('AmountCompany', 'Company');

	function index() {
		$modelName = 'AmountCompany';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['company_id'])){
				$conditions[] = array('and'=>array($modelName.'.company_id'=>$this->data[$modelName]['company_id']));
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
		$this->AmountCompany->recursive = 0;
		$this->set('amountCompanies', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountCompany.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountCompany', $this->AmountCompany->read(null, $id));
	}

	function add() {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountCompany->create();
			$modelName = 'AmountCompany';
			$params = array(
				'conditions'=>array('Company.id'=>$this->data[$modelName]['company_id']),
				'recursive'=>0,
			);
			$value = $this->Company->find('first' ,$params);
			$value_name = $value['Company']['name'];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountCompany->save($this->data)) {
				$this->Session->setFlash(__('The AmountCompany has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountCompany could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountCompany', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountCompany';
			$params = array(
				'conditions'=>array('Company.id'=>$this->data[$modelName]['company_id']),
				'recursive'=>0,
			);
			$value = $this->Company->find('first' ,$params);
			$value_name = $value['Company']['name'];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountCompany->save($this->data)) {
				$this->Session->setFlash(__('The AmountCompany has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountCompany could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountCompany->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountCompany', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountCompany->del($id)) {
			$this->Session->setFlash(__('AmountCompany deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>