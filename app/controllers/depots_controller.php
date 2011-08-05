<?php
class DepotsController extends AppController {

	var $name = 'Depots';
	var $uses = array('Depot', 'Section');

	function index() {
		$conditions = array();
		if(!empty($this->data['Depot']['word'])){
			$seach_word = $this->data['Depot']['word'];
			$conditions['or'] = array(
				'Depot.name LIKE'=>'%'.$seach_word.'%',
				'Section.name LIKE'=>'%'.$seach_word.'%',
				'Depot.id'=>$seach_word
			);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>50,
				'order'=>array('Depot.updated'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>50,
				'order'=>array('Depot.updated'=>'desc')
			);
		}
		$this->Depot->recursive = 0;
		$depots = $this->paginate();
		foreach($depots as $key=>$value){
			$depots[$key]['Section']['name'] = $this->Section->cleaningName($value['Section']['id']);
		}
		$this->set('depots', $depots);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Depot.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('depot', $this->Depot->read(null, $id));
	}

	function add($section_id = null) {
		if (!empty($this->data)) {
			$this->Depot->create();
			if ($this->Depot->save($this->data)) {
				$this->Session->setFlash(__('The Depot has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Depot could not be saved. Please, try again.', true));
			}
		}

		if(!empty($section_id)){
			$params = array(
				'conditions'=>array('Section.id'=>$section_id),
				'recursive'=>0,
				'fields'=>array('Section.name')
			);
			$section = $this->Section->find('first' ,$params);
			$this->set('section', $section);
		}

		$sections = $this->Depot->Section->find('list');
		$this->set(compact('sections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Depot', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Depot->save($this->data)) {
				$this->Session->setFlash(__('The Depot has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Depot could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Depot->read(null, $id);
		}
		$sections = $this->Depot->Section->find('list');
		$this->set(compact('sections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Depot', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Depot->del($id)) {
			$this->Session->setFlash(__('Depot deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function selectid(){
		$this->layout = 'senddata';
		$this->index();
	}


}
?>