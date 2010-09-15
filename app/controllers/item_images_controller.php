<?php
class ItemImagesController extends AppController {

	var $name = 'ItemImages';
	var $components = array ('ImageValidation');
	var $uses = array('ItemImage' ,'Item');

	function index() {
		$this->ItemImage->recursive = 0;
		$this->set('itemImages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid ItemImage', true), array('action'=>'index'));
		}
		$this->set('itemImage', $this->ItemImage->read(null, $id));
	}

	function add($item_id = null) {
		if (!empty($this->data)) {
			$this->ItemImage->create();
			if($this->ItemImage->save($this->data)){
				$img_id = $this->ItemImage->getInsertID();
				$file_name = $img_id.'.jpg';
				$path_name = '/img/itemimage/';
				rename($this->data['ItemImage']['upload_file']['tmp_name'], WWW_ROOT.$path_name.$file_name);
				$this->redirect('/items/view/'.$item_id);
			}else{
			}
			
		}
		$params = array(
			'conditions'=>array('Item.id'=>$item_id),
			'recursive'=>0,
			'fields'=>array('Item.name')
		);
		$item = $this->Item->find('first' ,$params);
		$this->set('item', $item);
	}
	
	
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid ItemImage', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ItemImage->save($this->data)) {
				$this->redirect('/items/view/'.$this->data['ItemImage']['item_id']);
				//$this->flash(__('The ItemImage has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ItemImage->read(null, $id);
		}
		$items = $this->ItemImage->Item->find('list');
		$this->set(compact('items'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid ItemImage', true), array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('ItemImage.id'=>$id),
			'recursive'=>0,
			'fields'=>array('ItemImage.item_id')
		);
		$item_id = $this->ItemImage->find('first', $params);
		if ($this->ItemImage->del($id)) {
			$this->redirect('/items/view/'.$item_id['ItemImage']['item_id']);
		}
	}

}
?>