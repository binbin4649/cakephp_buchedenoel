<?php
class AmountItempropertiesController extends AppController {

	var $name = 'AmountItemproperties';
	var $helpers = array('Html', 'Form');

	function index() {
		$modelName = 'AmountItemproperty';
		$subModel = 'Itemproperty';
		$sub_id = 'itemproperty';
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
		$this->AmountItemproperty->recursive = 0;
		$this->set('amountItemproperties', $this->paginate());
		$itemproperty = get_itemproperty();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'itemproperty'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountItemproperty.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountItemproperty', $this->AmountItemproperty->read(null, $id));
	}

	function add() {
		$itemproperty = get_itemproperty();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'itemproperty'));
		if (!empty($this->data)) {
			$this->AmountItemproperty->create();
			$modelName = 'AmountItemproperty';
			$subModel = 'Itemproperty';
			$sub_id = 'itemproperty';
			$name = $itemproperty[$this->data[$modelName][$sub_id]].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountItemproperty->save($this->data)) {
				$this->Session->setFlash(__('The AmountItemproperty has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountItemproperty could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$itemproperty = get_itemproperty();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'itemproperty'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountItemproperty', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountItemproperty';
			$subModel = 'Itemproperty';
			$sub_id = 'itemproperty';
			$name = $itemproperty[$this->data[$modelName][$sub_id]].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountItemproperty->save($this->data)) {
				$this->Session->setFlash(__('The AmountItemproperty has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountItemproperty could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountItemproperty->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountItemproperty', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountItemproperty->del($id)) {
			$this->Session->setFlash(__('AmountItemproperty deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>