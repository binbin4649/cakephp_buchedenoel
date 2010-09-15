<?php
class AmountItemsController extends AppController {

	var $name = 'AmountItems';
	var $helpers = array('Html', 'Form', 'Javascript', 'Cache');
	var $uses = array('AmountItem', 'Item');
	var $cacheAction = array('ranking'=>'7200');//キャッシュ2時間

	function index() {
		$modelName = 'AmountItem';
		$subModel = 'Item';
		$sub_id = 'item_id';
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
		$this->AmountItem->recursive = 0;
		$this->set('amountItems', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountItem', $this->AmountItem->read(null, $id));
	}

	function add() {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountItem->create();
			$modelName = 'AmountItem';
			$subModel = 'Item';
			$sub_id = 'item_id';
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
			if ($this->AmountItem->save($this->data)) {
				$this->Session->setFlash(__('The AmountItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountItem could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountItem';
			$subModel = 'Item';
			$sub_id = 'item_id';
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
			if ($this->AmountItem->save($this->data)) {
				$this->Session->setFlash(__('The AmountItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountItem->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountItem->del($id)) {
			$this->Session->setFlash(__('AmountItem deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function ranking($key = 3){
		$this->set('ranking_bests', $this->AmountItem->ranking_best($key));
		$amount_type = get_amount_type();
		$this->set('key_name', $amount_type[$key]);
	}

}
?>