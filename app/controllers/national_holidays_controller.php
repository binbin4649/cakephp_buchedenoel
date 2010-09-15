<?php
class NationalHolidaysController extends AppController {

	var $name = 'NationalHolidays';

	function index() {
		$this->NationalHoliday->recursive = 0;
		$this->set('nationalHolidays', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid NationalHoliday.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('nationalHoliday', $this->NationalHoliday->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->NationalHoliday->create();
			if ($this->NationalHoliday->save($this->data)) {
				$this->Session->setFlash(__('The NationalHoliday has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NationalHoliday could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid NationalHoliday', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->NationalHoliday->save($this->data)) {
				$this->Session->setFlash(__('The NationalHoliday has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NationalHoliday could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NationalHoliday->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for NationalHoliday', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->NationalHoliday->del($id)) {
			$this->Session->setFlash(__('NationalHoliday deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>