<?php
class BankAcutsController extends AppController {

	var $name = 'BankAcuts';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->BankAcut->recursive = 0;
		$this->set('bankAcuts', $this->paginate());
		$account_type = get_account_type();
		$this->set(compact('account_type'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid BankAcut.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('bankAcut', $this->BankAcut->read(null, $id));
		$account_type = get_account_type();
		$this->set(compact('account_type'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->BankAcut->create();
			if ($this->BankAcut->save($this->data)) {
				$this->Session->setFlash(__('The BankAcut has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The BankAcut could not be saved. Please, try again.', true));
			}
		}
		$account_type = get_account_type();
		$this->set(compact('account_type'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid BankAcut', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->BankAcut->save($this->data)) {
				$this->Session->setFlash(__('The BankAcut has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The BankAcut could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BankAcut->read(null, $id);
		}
		$account_type = get_account_type();
		$this->set(compact('account_type'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for BankAcut', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->BankAcut->del($id)) {
			$this->Session->setFlash(__('BankAcut deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>