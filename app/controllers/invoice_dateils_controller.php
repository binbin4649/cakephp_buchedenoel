<?php
class InvoiceDateilsController extends AppController {

	var $name = 'InvoiceDateils';

	function index() {
		$this->InvoiceDateil->recursive = 0;
		$this->set('invoiceDateils', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InvoiceDateil.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('invoiceDateil', $this->InvoiceDateil->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InvoiceDateil->create();
			if ($this->InvoiceDateil->save($this->data)) {
				$this->Session->setFlash(__('The InvoiceDateil has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoiceDateil could not be saved. Please, try again.', true));
			}
		}
		$invoices = $this->InvoiceDateil->Invoice->find('list');
		$sales = $this->InvoiceDateil->Sale->find('list');
		$this->set(compact('invoices', 'sales'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InvoiceDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InvoiceDateil->save($this->data)) {
				$this->Session->setFlash(__('The InvoiceDateil has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InvoiceDateil could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InvoiceDateil->read(null, $id);
		}
		$invoices = $this->InvoiceDateil->Invoice->find('list');
		$sales = $this->InvoiceDateil->Sale->find('list');
		$this->set(compact('invoices','sales'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InvoiceDateil', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InvoiceDateil->del($id)) {
			$this->Session->setFlash(__('InvoiceDateil deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>