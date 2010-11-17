<?php
class InventoriesController extends AppController {

	var $name = 'Inventories';
	var $helpers = array('Html', 'Form');
//	var $uses = array('Inventory');

	function index() {
		$this->paginate = array(
			'conditions'=>array(),
			'limit'=>50,
			'order'=>array('Inventory.updated'=>'desc')
		);
		$this->set('inventories', $this->paginate());
		$this->set('status', get_inventory_status());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Inventory.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		if(!empty($this->data)){
			$result = $this->Inventory->InventoryFinish($id, $this->data);
			//終了処理を隠す
			//resultファイルとか出力できるといいかもねー
			if($result){
				$this->Inventory->create();
				$data['Inventory']['id'] = $id;
				$data['Inventory']['status'] = 2;
				$this->Inventory->save($data);
			}
		}
		
		$params = array(
			'conditions'=>array('Inventory.id'=>$id),
			'recursive'=>0,
			'contain'=>array('Section')
		);
		$Inventory = $this->Inventory->find('first' ,$params);
		$this->set('inventory', $Inventory);
		$this->set('depots', $this->Inventory->viewsTotal($id));
		$this->set('status', get_inventory_status());
	}

//	viewは消した ←あるじゃん？
	function add() {
		$section_id = $this->Auth->user('section_id');
		if($this->Inventory->statusCheck($section_id)){//同部門で棚卸中が無いか調べる
			$this->Inventory->create();
			$data['Inventory']['section_id'] = $section_id;
			$data['Inventory']['status'] = 1;
			$this->Inventory->save($data);
			//同部門で移動中があったら警告する
			
		}else{
			$this->Session->setFlash(__('ERROR:現在、棚卸中の為、新しい棚卸は追加できません。', true));
		}
		$this->redirect(array('action'=>'index'));
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
		$sections = $this->Inventory->Section->find('list');
		$this->set(compact('sections'));
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