<?php
class EmploymentsController extends AppController {

	var $name = 'Employments';
	var $uses = array('Employment', 'Post', 'Section', 'User');

	function index() {
		$this->Employment->recursive = 0;
		$this->paginate = array(
				'limit'=>20,
				'order'=>array('Employment.updated'=>'desc')
			);
		$this->set('employments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Employment', true), array('action'=>'index'));
		}
		$this->set('employment', $this->Employment->read(null, $id));
		$this->set('section', $this->Section->find('list'));
		$this->set('post', $this->Post->find('list'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Employment->create();
			if ($this->Employment->save($this->data)) {
				$id = $this->Employment->getInsertID();
				$this->redirect('/employments/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Employment', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Employment->save($this->data)) {
				$this->redirect('/employments/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Employment->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Employment', true), array('action'=>'index'));
		}
		if ($this->Employment->del($id) == false) {
			$this->flash(__('Employment deleted', true), array('action'=>'index'));
		}
	}

}
?>