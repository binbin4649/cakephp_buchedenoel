<?php
class InventoriesController extends AppController {

	var $name = 'Inventories';

	function index() {
		$this->Inventory->recursive = 0;
		$this->set('inventories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Inventory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('inventory', $this->Inventory->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Inventory->create();
			if ($this->Inventory->save($this->data)) {
				$this->Session->setFlash(__('The Inventory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Inventory could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Inventory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Inventory->save($this->data)) {
				$this->Session->setFlash(__('The Inventory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Inventory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Inventory->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Inventory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Inventory->del($id)) {
			$this->Session->setFlash(__('Inventory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>