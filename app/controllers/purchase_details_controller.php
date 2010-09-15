<?php
class PurchaseDetailsController extends AppController {

	var $name = 'PurchaseDetails';

	function index() {
		$this->PurchaseDetail->recursive = 0;
		$this->set('purchaseDetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PurchaseDetail.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('purchaseDetail', $this->PurchaseDetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PurchaseDetail->create();
			if ($this->PurchaseDetail->save($this->data)) {
				$this->Session->setFlash(__('The PurchaseDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PurchaseDetail could not be saved. Please, try again.', true));
			}
		}
		$purchases = $this->PurchaseDetail->Purchase->find('list');
		$orders = $this->PurchaseDetail->Order->find('list');
		$orderDateils = $this->PurchaseDetail->OrderDateil->find('list');
		$orderings = $this->PurchaseDetail->Ordering->find('list');
		$items = $this->PurchaseDetail->Item->find('list');
		$subitems = $this->PurchaseDetail->Subitem->find('list');
		$this->set(compact('purchases', 'orders', 'orderDateils', 'orderings', 'items', 'subitems'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PurchaseDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PurchaseDetail->save($this->data)) {
				$this->Session->setFlash(__('The PurchaseDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PurchaseDetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PurchaseDetail->read(null, $id);
		}
		$purchases = $this->PurchaseDetail->Purchase->find('list');
		$orders = $this->PurchaseDetail->Order->find('list');
		$orderDateils = $this->PurchaseDetail->OrderDateil->find('list');
		$orderings = $this->PurchaseDetail->Ordering->find('list');
		$items = $this->PurchaseDetail->Item->find('list');
		$subitems = $this->PurchaseDetail->Subitem->find('list');
		$this->set(compact('purchases','orders','orderDateils','orderings','items','subitems'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PurchaseDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PurchaseDetail->del($id)) {
			$this->Session->setFlash(__('PurchaseDetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>