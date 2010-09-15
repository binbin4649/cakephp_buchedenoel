<?php
class MaterialsController extends AppController {

	var $name = 'Materials';

	function index() {
	$conditions = array();
		$modelName = 'Material';
		if (!empty($this->data[$modelName]['word'])) {
			$seach_word = $this->data[$modelName]['word'];
			$conditions['or'] = array($modelName.'.id'=>$seach_word, $modelName.'.name LIKE'=>'%'.$seach_word.'%');
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>30,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>30,
				'order'=>array($modelName.'.created'=>'desc')
			);
		}
		$this->Material->recursive = 0;
		$this->set('materials', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Material', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Material.id'=>$id),
			'recursive'=>0
		);
		$this->set('material', $this->Material->find('first', $params));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Material->create();
			if ($this->Material->save($this->data)) {
				$id = $this->Material->getInsertID();
				$this->redirect('/materials/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Material', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Material->save($this->data)) {
				$this->redirect('/materials/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Material->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Material', true), array('action'=>'index'));
		}
		if ($this->Material->del($id) == false) {
			$this->redirect('/materials/');
		}
	}


}
?>