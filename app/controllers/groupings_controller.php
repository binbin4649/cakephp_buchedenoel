<?php
class GroupingsController extends AppController {

	var $name = 'Groupings';

	function index() {
		$this->Grouping->recursive = 0;
		$this->set('groupings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Grouping.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('grouping', $this->Grouping->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Grouping->create();
			if ($this->Grouping->save($this->data)) {
				$this->Session->setFlash(__('The Grouping has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Grouping could not be saved. Please, try again.', true));
			}
		}
		$companies = $this->Grouping->Company->find('list');
		$cancel_flag = get_cancel_flag();
		$this->set(compact('companies', 'cancel_flag'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Grouping', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Grouping->save($this->data)) {
				$this->Session->setFlash(__('The Grouping has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Grouping could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Grouping->read(null, $id);
		}
		$companies = $this->Grouping->Company->find('list');
		$cancel_flag = get_cancel_flag();
		$this->set(compact('companies', 'cancel_flag'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Grouping', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Grouping->del($id)) {
			$this->Session->setFlash(__('Grouping deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>