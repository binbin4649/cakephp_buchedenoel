<?php
class MemoCategoriesController extends AppController {

	var $name = 'MemoCategories';

	function index() {
		$out = array();
		$memo_sections = get_memo_sections();
		$this->MemoCategory->recursive = 0;
		$memo_categories = $this->paginate();
		foreach($memo_categories as $memo_category){
			if(!empty($memo_category['MemoCategory']['memo_sections_id']))$memo_category['MemoCategory']['memo_sections_id'] = $memo_sections[$memo_category['MemoCategory']['memo_sections_id']];
			$out[] = $memo_category;
		}
		$this->set('memoCategories', $out);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid MemoCategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$memo_sections = get_memo_sections();
		$memo_category = $this->MemoCategory->read(null, $id);
		if(!empty($memo_category['MemoCategory']['memo_sections_id']))$memo_category['MemoCategory']['memo_sections_id'] = $memo_sections[$memo_category['MemoCategory']['memo_sections_id']];
		$this->set('memoCategory', $memo_category);
	}

	function add() {
		if (!empty($this->data)) {
			$this->MemoCategory->create();
			if ($this->MemoCategory->save($this->data)) {
				$this->Session->setFlash(__('The MemoCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The MemoCategory could not be saved. Please, try again.', true));
			}
		}
		$memo_sections = get_memo_sections();
		$this->set(compact('memo_sections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid MemoCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->MemoCategory->save($this->data)) {
				$this->Session->setFlash(__('The MemoCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The MemoCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->MemoCategory->read(null, $id);
		}
		$memo_sections = get_memo_sections();
		$this->set(compact('memo_sections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for MemoCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->MemoCategory->del($id) == false) {
			$this->Session->setFlash(__('MemoCategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


}
?>