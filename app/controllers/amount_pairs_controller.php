<?php
class AmountPairsController extends AppController {

	var $name = 'AmountPairs';
	var $helpers = array('Html', 'Form', 'Javascript');
	var $uses = array('AmountPair', 'Item');

	function index() {
		$modelName = 'AmountPair';
		$subModel = 'Item';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['name'])){
				$conditions[] = array('and'=>array($modelName.'.name LIKE'=>'%'.$this->data[$modelName]['name'].'%'));
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
		$this->AmountPair->recursive = 0;
		$this->set('amountPairs', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountPair.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountPair', $this->AmountPair->read(null, $id));
	}

	function add() {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountPair->create();
			$modelName = 'AmountPair';
			$subModel = 'Item';
			$params = array(
				'conditions'=>array($subModel.'.id'=>$this->data[$modelName]['item_ladys']),
				'recursive'=>0,
			);
			$itemLadys = $this->$subModel->find('first' ,$params);
			$params = array(
				'conditions'=>array($subModel.'.id'=>$this->data[$modelName]['item_mens']),
				'recursive'=>0,
			);
			$itemMens = $this->$subModel->find('first' ,$params);
			$value_name = $itemLadys['Item']['name'].'-'.$itemMens['Item']['name'];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountPair->save($this->data)) {
				$this->Session->setFlash(__('The AmountPair has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountPair could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountPair', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountPair';
			$subModel = 'Item';
			$params = array(
				'conditions'=>array($subModel.'.id'=>$this->data[$modelName]['item_ladys']),
				'recursive'=>0,
			);
			$itemLadys = $this->$subModel->find('first' ,$params);
			$params = array(
				'conditions'=>array($subModel.'.id'=>$this->data[$modelName]['item_mens']),
				'recursive'=>0,
			);
			$itemMens = $this->$subModel->find('first' ,$params);
			$value_name = $itemLadys['Item']['name'].'-'.$itemMens['Item']['name'];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountPair->save($this->data)) {
				$this->Session->setFlash(__('The AmountPair has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountPair could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountPair->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountPair', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountPair->del($id)) {
			$this->Session->setFlash(__('AmountPair deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function ranking($key = 3){
		$this->set('ranking_bests', $this->AmountPair->ranking_best($key));
		$amount_type = get_amount_type();
		$this->set('key_name', $amount_type[$key]);
	}

}
?>