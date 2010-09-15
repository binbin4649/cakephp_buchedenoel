<?php
class AmountProcessesController extends AppController {

	var $name = 'AmountProcesses';
	var $helpers = array('Html', 'Form');
	var $uses = array('AmountProcess', 'Process');

	function index() {
		$modelName = 'AmountProcess';
		$subModel = 'Process';
		$sub_id = 'process_id';
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
		$this->AmountProcess->recursive = 0;
		$this->set('amountProcesses', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		$processes = $this->AmountProcess->Process->find('list');
		$this->set(compact('processes'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountProcess.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountProcess', $this->AmountProcess->read(null, $id));
	}

	function add() {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		$processes = $this->AmountProcess->Process->find('list');
		$this->set(compact('processes'));
		if (!empty($this->data)) {
			$this->AmountProcess->create();
			$modelName = 'AmountProcess';
			$subModel = 'Process';
			$sub_id = 'process_id';
			$value_name = mb_substr($processes[$this->data[$modelName][$sub_id]], 0, 10).':'.$this->data[$modelName][$sub_id];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountProcess->save($this->data)) {
				$this->Session->setFlash(__('The AmountProcess has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountProcess could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		$processes = $this->AmountProcess->Process->find('list');
		$this->set(compact('processes'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountProcess', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountProcess';
			$subModel = 'Process';
			$sub_id = 'process_id';
			$value_name = mb_substr($processes[$this->data[$modelName][$sub_id]], 0, 10).':'.$this->data[$modelName][$sub_id];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountProcess->save($this->data)) {
				$this->Session->setFlash(__('The AmountProcess has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountProcess could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountProcess->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountProcess', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountProcess->del($id)) {
			$this->Session->setFlash(__('AmountProcess deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>