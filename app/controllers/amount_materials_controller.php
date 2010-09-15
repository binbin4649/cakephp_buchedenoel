<?php
class AmountMaterialsController extends AppController {

	var $name = 'AmountMaterials';
	var $helpers = array('Html', 'Form');
	var $uses = array('AmountMaterial', 'Material');

	function index() {
		$modelName = 'AmountMaterial';
		$subModel = 'Material';
		$sub_id = 'material_id';
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
		$this->AmountMaterial->recursive = 0;
		$this->set('amountMaterials', $this->paginate());
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		$materials = $this->AmountMaterial->Material->find('list');
		$this->set(compact('materials'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountMaterial.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountMaterial', $this->AmountMaterial->read(null, $id));
	}

	function add() {
		$materials = $this->AmountMaterial->Material->find('list');
		$this->set(compact('materials'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountMaterial->create();
			$modelName = 'AmountMaterial';
			$subModel = 'Material';
			$sub_id = 'material_id';
			$value_name = mb_substr($materials[$this->data[$modelName][$sub_id]], 0, 10).':'.$this->data[$modelName][$sub_id];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountMaterial->save($this->data)) {
				$this->Session->setFlash(__('The AmountMaterial has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountMaterial could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$materials = $this->AmountMaterial->Material->find('list');
		$this->set(compact('materials'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountMaterial', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountMaterial';
			$subModel = 'Material';
			$sub_id = 'material_id';
			$modelName = 'AmountMaterial';
			$subModel = 'Material';
			$sub_id = 'material_id';
			$value_name = mb_substr($materials[$this->data[$modelName][$sub_id]], 0, 10).':'.$this->data[$modelName][$sub_id];
			$name = $value_name.'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountMaterial->save($this->data)) {
				$this->Session->setFlash(__('The AmountMaterial has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountMaterial could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountMaterial->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountMaterial', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountMaterial->del($id)) {
			$this->Session->setFlash(__('AmountMaterial deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>