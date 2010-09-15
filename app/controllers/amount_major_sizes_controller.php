<?php
class AmountMajorSizesController extends AppController {

	var $name = 'AmountMajorSizes';
	var $helpers = array('Html', 'Form');

	function index() {
		$modelName = 'AmountMajorSize';
		$subModel = 'majorSize';
		$sub_id = 'major_size';
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
		$this->AmountMajorSize->recursive = 0;
		$this->set('amountMajorSizes', $this->paginate());
		$major_size = get_major_size();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'major_size'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountMajorSize.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountMajorSize', $this->AmountMajorSize->read(null, $id));
	}

	function add() {
		$major_size = get_major_size();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'major_size'));
		if (!empty($this->data)) {
			$this->AmountMajorSize->create();
			$modelName = 'AmountMajorSize';
			$subModel = 'majorSize';
			$sub_id = 'major_size';
			$name = $major_size[$this->data[$modelName][$sub_id]].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountMajorSize->save($this->data)) {
				$this->Session->setFlash(__('The AmountMajorSize has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountMajorSize could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$major_size = get_major_size();
		$amount_type = get_amount_type();
		$this->set(compact('amount_type', 'major_size'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountMajorSize', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountMajorSize';
			$subModel = 'majorSize';
			$sub_id = 'major_size';
			$name = $major_size[$this->data[$modelName][$sub_id]].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountMajorSize->save($this->data)) {
				$this->Session->setFlash(__('The AmountMajorSize has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountMajorSize could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountMajorSize->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountMajorSize', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountMajorSize->del($id)) {
			$this->Session->setFlash(__('AmountMajorSize deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>