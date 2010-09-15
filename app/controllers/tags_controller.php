<?php
class TagsController extends AppController {

	var $name = 'Tags';

	function index() {
		$this->Tag->recursive = 0;
		$this->set('tags', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Tag', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Tag.id'=>$id),
			'recursive'=>0
		);
		$view_data = $this->Tag->find('first', $params);
		$this->set('tag', $view_data);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Tag->create();
			if ($this->Tag->save($this->data)) {
				$id = $this->Tag->getInsertID();
				$this->redirect('/tags/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Tag', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tag->save($this->data)) {
				$this->redirect('/tags/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tag->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Tag', true), array('action'=>'index'));
		}
		if ($this->Tag->del($id)) {
			$this->redirect('/tags/');
		}
	}


}
?>