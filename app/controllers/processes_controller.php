<?php
class ProcessesController extends AppController {

	var $name = 'Processes';

	function index() {
		$this->Process->recursive = 0;
		$this->set('processes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Process', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Process.id'=>$id),
			'recursive'=>0
		);
		$this->set('process', $this->Process->find('first', $params));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Process->create();
			if ($this->Process->save($this->data)) {
				$id = $this->Process->getInsertID();
				$this->redirect('/processes/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Process', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Process->save($this->data)) {
				$this->redirect('/processes/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Process->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Process', true), array('action'=>'index'));
		}
		if ($this->Process->del($id) == false) {
			$this->redirect('/processes/');
		}
	}


}
?>