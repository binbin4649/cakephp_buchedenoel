<?php
class TimeCardsController extends AppController {

	var $name = 'TimeCards';

	function index() {
		$this->TimeCard->recursive = 0;
		$this->set('timeCards', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid TimeCard', true), array('action'=>'index'));
		}
		$this->set('timeCard', $this->TimeCard->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TimeCard->create();
			if ($this->TimeCard->save($this->data)) {
				$this->flash(__('TimeCard saved.', true), array('action'=>'index'));
			} else {
			}
		}
		$users = $this->TimeCard->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid TimeCard', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TimeCard->save($this->data)) {
				$this->flash(__('The TimeCard has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TimeCard->read(null, $id);
		}
		$users = $this->TimeCard->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid TimeCard', true), array('action'=>'index'));
		}
		if ($this->TimeCard->del($id)) {
			$this->flash(__('TimeCard deleted', true), array('action'=>'index'));
		}
	}


}
?>