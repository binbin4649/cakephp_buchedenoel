<?php
class StonesController extends AppController {

	var $name = 'Stones';

	function index() {
		$conditions = array();
		$modelName = 'Stone';
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
		$this->Stone->recursive = 0;
		$this->set('stones', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Stone', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Stone.id'=>$id),
			'recursive'=>0
		);
		$this->set('stone', $this->Stone->find('first', $params));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Stone->create();
			if ($this->Stone->save($this->data)) {
				$id = $this->Stone->getInsertID();
				$this->redirect('/stones/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Stone', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Stone->save($this->data)) {
				$this->redirect('/stones/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Stone->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Stone', true), array('action'=>'index'));
		}
		if ($this->Stone->del($id) == false) {
			$this->redirect('/stones/');
		}
	}


}
?>