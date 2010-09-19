<?php
class AmountBrandsController extends AppController {

	var $name = 'AmountBrands';
	var $helpers = array('Html', 'Form');
	
	
	function index() {
		$modelName = 'AmountBrand';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['brand_id'])){
				$conditions[] = array('and'=>array($modelName.'.brand_id'=>$this->data[$modelName]['brand_id']));
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
		$this->AmountBrand->recursive = 0;
		$this->set('amountBrands', $this->paginate());
		$brands = $this->AmountBrand->Brand->find('list');
		$this->set(compact('brands'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid AmountBrand.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('amountBrand', $this->AmountBrand->read(null, $id));
	}

	function add() {
		$brands = $this->AmountBrand->Brand->find('list');
		$this->set(compact('brands'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!empty($this->data)) {
			$this->AmountBrand->create();
			//name生成
			$modelName = 'AmountBrand';
			$name = $brands[$this->data[$modelName]['brand_id']].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountBrand->save($this->data)) {
				$this->Session->setFlash(__('The AmountBrand has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountBrand could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$brands = $this->AmountBrand->Brand->find('list');
		$this->set(compact('brands'));
		$amount_type = get_amount_type();
		$this->set(compact('amount_type'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid AmountBrand', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$modelName = 'AmountBrand';
			$name = $brands[$this->data[$modelName]['brand_id']].'-'.$amount_type[$this->data[$modelName]['amount_type']].'-';
			$name .= $this->data[$modelName]['start_day']['year'].$this->data[$modelName]['start_day']['month'].$this->data[$modelName]['start_day']['day'].'-';
			$name .= $this->data[$modelName]['end_day']['year'].$this->data[$modelName]['end_day']['month'].$this->data[$modelName]['end_day']['day'];
			$this->data[$modelName]['name'] = $name;
			if ($this->AmountBrand->save($this->data)) {
				$this->Session->setFlash(__('The AmountBrand has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The AmountBrand could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->AmountBrand->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AmountBrand', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->AmountBrand->del($id)) {
			$this->Session->setFlash(__('AmountBrand deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>