<?php
class TagsItemsController extends AppController {

	var $name = 'TagsItems';

	function index() {
		$this->TagsItem->recursive = 0;
		$this->set('tagsItems', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid TagsItem', true), array('action'=>'index'));
		}
		$this->set('tagsItem', $this->TagsItem->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TagsItem->create();
			if ($this->TagsItem->save($this->data)) {
				$this->flash(__('TagsItem saved.', true), array('action'=>'index'));
			} else {
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid TagsItem', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TagsItem->save($this->data)) {
				$this->flash(__('The TagsItem has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TagsItem->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid TagsItem', true), array('action'=>'index'));
		}
		if ($this->TagsItem->del($id)) {
			$this->flash(__('TagsItem deleted', true), array('action'=>'index'));
		}
	}


}
?>