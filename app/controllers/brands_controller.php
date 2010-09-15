<?php
class BrandsController extends AppController {

	var $name = 'Brands';
	var $uses = array('Brand', 'User');

	function index() {
		$this->Brand->recursive = 0;
		$this->set('brands', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Brand', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Brand.id'=>$id),
			'recursive'=>0
		);
		$view_data = $this->Brand->find('first', $params);
		$this->set('brand', $view_data);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Brand->create();
			if ($this->Brand->save($this->data)) {
				$id = $this->Brand->getInsertID();
				$this->redirect('/brands/view/'.$id);
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Brand', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Brand->save($this->data)) {
				$this->redirect('/brands/view/'.$id);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Brand->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Brand', true), array('action'=>'index'));
		}
		if ($this->Brand->del($id) == false) {
			$this->redirect('/brands/');
		}
	}

}
?>