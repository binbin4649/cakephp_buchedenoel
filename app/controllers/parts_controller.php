<?php
class PartsController extends AppController {

	var $name = 'Parts';
	var $helpers = array("Javascript","Ajax");
	var $uses = array('Item', 'Subitem', 'Part');

	function index() {
		$this->Part->recursive = 0;
		$this->set('parts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Part', true), array('action'=>'index'));
		}
		$part = $this->Part->read(null, $id);
		$this->set('part', $part);
		$params = array(
			'conditions'=>array('Item.id'=>$part['Part']['item_id']),
			'recursive'=>0,
			'fields'=>array('Item.name')
		);
		$item = $this->Item->find('first' ,$params);
		$this->set('item', $item);
	}

	function add($subitem_id = null) {
		if (!empty($this->data)) {
			$result = $this->Item->find('first', array('conditions'=>array('Item.name'=>$this->data['Part']['AutoItemName']),));
			$this->data['Part']['item_id'] = $result['Item']['id'];
			if(empty($this->data['Part']['quantity'])){
				$this->data['Part']['quantity'] = 1;
			}
			//var_dump($result['Item']['id']);
			$this->Part->create();
			if ($this->Part->save($this->data)) {
				//$this->flash(__('Part saved.', true), array('action'=>'index'));
				$this->redirect('/subitems/view/'.$this->data['Part']['subitem_id']);
			} else {
				$subitem_id = $this->data['Part']['subitem_id'];
				$params = array(
					'conditions'=>array('Subitem.id'=>$subitem_id),
					'recursive'=>0,
					'fields'=>array('Subitem.name','Subitem.item_id')
				);
				$subitem = $this->Subitem->find('first' ,$params);
				$params = array(
					'conditions'=>array('item.id'=>$subitem['Subitem']['item_id']),
					'recursive'=>0,
					'fields'=>array('item.name')
				);
				$root_item = $this->Item->find('first' ,$params);
				$supply_code = get_supply_code();
				$this->set(compact('subitem', 'supply_code', 'root_item'));
				$this->Session->setFlash(__('ERROR:たぶん入力された品番が無いからだと思います。これを<a href="/buchedenoel/parts/add/'.$subitem_id.'">クリック</a>してからやり直してください。', true));
			}
		}
		$params = array(
			'conditions'=>array('Subitem.id'=>$subitem_id),
			'recursive'=>0,
			'fields'=>array('Subitem.name','Subitem.item_id')
		);
		$subitem = $this->Subitem->find('first' ,$params);
		$params = array(
			'conditions'=>array('item.id'=>$subitem['Subitem']['item_id']),
			'recursive'=>0,
			'fields'=>array('item.name')
		);
		$root_item = $this->Item->find('first' ,$params);
		$supply_code = get_supply_code();
		//$subitems = $this->Part->Subitem->find('list');
		$this->set(compact('subitem', 'supply_code', 'root_item'));
	}

	function getData(){
		$this->layout = 'ajax';
		//入力データは、$this->dataで参照できる。
		//$this->set("typed",$this->data['Part']['AutoItemName']);
		$params = array(
			'conditions'=>array('Item.name LIKE'=>'%'.$this->data['Part']['AutoItemName'].'%'),
			'recursive'=>0,
			'limit'=>20,
			'order'=>array('Item.name'=>'asc'),
			'fields'=>array('Item.name')
		);
		$result = $this->Item->find('all', $params);
		if(!empty($result)){
			foreach($result as $values){
				$Autoitems[] = $values['Item']['name'];
			}
		}else{
			$Autoitems[] = 'しらんがな';
		}
		//var_dump($Autoitems);
		/*
		//通常は、データベースなどから情報を取得する。
		for($i=0;$i<10;$i++){
			$Autoitems[] = rand(1,9999);
		}
		*/
		$this->set("Autoitems",$Autoitems);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Part', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$result = $this->Item->find('first', array('conditions'=>array('Item.name'=>$this->data['Part']['AutoItemName']),));
			$this->data['Part']['item_id'] = $result['Item']['id'];
			if ($this->Part->save($this->data)) {
				//$this->flash(__('The Part has been saved.', true), array('action'=>'index'));
				$this->redirect('/subitems/view/'.$this->data['Part']['subitem_id']);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Part->read(null, $id);
		}
		$params = array(
			'conditions'=>array('Item.id'=>$this->data['Part']['item_id']),
			'recursive'=>0,
			'fields'=>array('Item.name')
		);
		$item = $this->Item->find('first' ,$params);
		$params = array(
			'conditions'=>array('Subitem.id'=>$this->data['Part']['subitem_id']),
			'recursive'=>0,
			'fields'=>array('Subitem.name','Subitem.item_id')
		);
		$subitem = $this->Subitem->find('first' ,$params);
		$params = array(
			'conditions'=>array('item.id'=>$subitem['Subitem']['item_id']),
			'recursive'=>0,
			'fields'=>array('item.name')
		);
		$root_item = $this->Item->find('first' ,$params);
		$supply_code = get_supply_code();
		//$subitems = $this->Part->Subitem->find('list');
		$this->set(compact('subitem', 'supply_code', 'item', 'root_item'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Part', true), array('action'=>'index'));
		}
		if ($this->Part->del($id)) {
			$this->flash(__('Part deleted', true), array('action'=>'index'));
		}
	}


}
?>