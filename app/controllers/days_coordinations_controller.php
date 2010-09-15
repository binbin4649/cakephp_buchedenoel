<?php
class DaysCoordinationsController extends AppController {

	var $name = 'DaysCoordinations';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->DaysCoordination->recursive = 0;
		$this->set('daysCoordinations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid DaysCoordination', true), array('action'=>'index'));
		}
		$this->set('daysCoordination', $this->DaysCoordination->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->DaysCoordination->create();
			if ($this->DaysCoordination->save($this->data)) {
				$this->flash(__('DaysCoordination saved.', true), array('action'=>'index'));
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid DaysCoordination', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->DaysCoordination->save($this->data)) {
				$this->flash(__('The DaysCoordination has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->DaysCoordination->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid DaysCoordination', true), array('action'=>'index'));
		}
		if ($this->DaysCoordination->del($id)) {
			$this->flash(__('DaysCoordination deleted', true), array('action'=>'index'));
		}
	}
	

}
?>