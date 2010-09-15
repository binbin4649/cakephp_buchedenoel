<?php
class AmountDestinationsController extends AppController {

	var $name = 'AmountDestinations';
	var $helpers = array('Html', 'Form');
	var $uses = array('AmountDestination', 'Destination');

	function index() {
		$modelName = 'AmountDestination';
		$subModel = 'Destination';
		$sub_id = 'destination_id';
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
		$this->AmountDestination->recursive = 0;
		$this->set('amountDestinations', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountDestination.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountDestination', $this->AmountDestination->read(null, $id));
	}

	function add() {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountDestination->create();
			$modelName = 'AmountDestination';
			$subModel = 'Destination';
			$sub_id = 'destination_id';
			$params = array(
				'conditions'=>array($subModel.'.id'=>$this->data[$modelName][$sub_id]),
				'recursive'=>0,
			);
			$value = $this->$subModel->find('first' ,$params);
			$value_name = mb_substr($value[$subModel]['name'], 0, 10).$value[$subModel]['id'];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountDestination->save($this->data)) {
				$this->Session->setFlash(__('The AmountDestination has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountDestination could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountDestination', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountDestination';
			$subModel = 'Destination';
			$sub_id = 'destination_id';
			$params = array(
				'conditions'=>array($subModel.'.id'=>$this->data[$modelName][$sub_id]),
				'recursive'=>0,
			);
			$value = $this->$subModel->find('first' ,$params);
			$value_name = mb_substr($value[$subModel]['name'], 0, 10).$value[$subModel]['id'];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountDestination->save($this->data)) {
				$this->Session->setFlash(__('The AmountDestination has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountDestination could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountDestination->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountDestination', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountDestination->del($id)) {
			$this->Session->setFlash(__('AmountDestination deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>