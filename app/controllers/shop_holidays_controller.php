<?php
class ShopHolidaysController extends AppController {

	var $name = 'ShopHolidays';

	function index() {
		$this->ShopHoliday->recursive = 0;
		$this->set('shopHolidays', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ShopHoliday.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('shopHoliday', $this->ShopHoliday->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ShopHoliday->create();
			if ($this->ShopHoliday->save($this->data)) {
				$this->Session->setFlash(__('The ShopHoliday has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ShopHoliday could not be saved. Please, try again.', true));
			}
		}
		$sections = $this->ShopHoliday->Section->find('list');
		$this->set(compact('sections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ShopHoliday', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ShopHoliday->save($this->data)) {
				$this->Session->setFlash(__('The ShopHoliday has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ShopHoliday could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ShopHoliday->read(null, $id);
		}
		$sections = $this->ShopHoliday->Section->find('list');
		$this->set(compact('sections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ShopHoliday', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ShopHoliday->del($id)) {
			$this->Session->setFlash(__('ShopHoliday deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>