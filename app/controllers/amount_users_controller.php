<?php
class AmountUsersController extends AppController {

	var $name = 'AmountUsers';
	var $helpers = array('Html', 'Form', 'Javascript', 'Cache');
	var $uses = array('AmountUser', 'User');
	var $cacheAction = array('ranking'=>'7200');//キャッシュ2時間

	function index() {
		$modelName = 'AmountUser';
		$subModel = 'User';
		$sub_id = 'user_id';
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
		$this->AmountUser->recursive = 0;
		$this->set('amountUsers', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountUser.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountUser', $this->AmountUser->read(null, $id));
	}

	function add() {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountUser->create();
			$modelName = 'AmountUser';
			$subModel = 'User';
			$sub_id = 'user_id';
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
			if ($this->AmountUser->save($this->data)) {
				$this->Session->setFlash(__('The AmountUser has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountUser could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountUser', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountUser';
			$subModel = 'User';
			$sub_id = 'user_id';
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
			if ($this->AmountUser->save($this->data)) {
				$this->Session->setFlash(__('The AmountUser has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountUser could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountUser->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountUser', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountUser->del($id)) {
			$this->Session->setFlash(__('AmountUser deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function ranking($id = 2, $key = 3){
		$this->set('ranking_user', $this->AmountUser->ranking_today($id, $key));
	}

}
?>