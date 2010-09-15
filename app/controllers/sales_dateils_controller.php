<?php
class SalesDateilsController extends AppController {

	var $name = 'SalesDateils';

	function index() {
		$this->SalesDateil->recursive = 0;
		$this->set('salesDateils', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SalesDateil.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('salesDateil', $this->SalesDateil->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->SalesDateil->create();
			if ($this->SalesDateil->save($this->data)) {
				$this->Session->setFlash(__('The SalesDateil has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SalesDateil could not be saved. Please, try again.', true));
			}
		}
		$sales = $this->SalesDateil->Sale->find('list');
		$items = $this->SalesDateil->Item->find('list');
		$subitems = $this->SalesDateil->Subitem->find('list');
		$this->set(compact('sales', 'items', 'subitems'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SalesDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SalesDateil->save($this->data)) {
				$this->Session->setFlash(__('The SalesDateil has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SalesDateil could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SalesDateil->read(null, $id);
		}
		$sales = $this->SalesDateil->Sale->find('list');
		$items = $this->SalesDateil->Item->find('list');
		$subitems = $this->SalesDateil->Subitem->find('list');
		$this->set(compact('sales','items','subitems'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SalesDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SalesDateil->del($id)) {
			$this->Session->setFlash(__('SalesDateil deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>