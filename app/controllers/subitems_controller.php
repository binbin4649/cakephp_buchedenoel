<?php
class SubitemsController extends AppController {

	var $name = 'Subitems';
	var $uses = array('Subitem' ,'Item');
	var $components = array('JanCode');

	function index() {
		$this->Subitem->recursive = 0;
		$this->set('subitems', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Subitem', true), array('action'=>'index'));
		}
		$subitem = $this->Subitem->read(null, $id);
		$counter = 0;
		foreach($subitem['Part'] as $part){
			$params = array(
				'conditions'=>array('Item.id'=>$part['item_id']),
				'recursive'=>0,
				'fields'=>array('Item.name')
			);
			$itemname = $this->Item->find('first' ,$params);
			$subitem['Part'][$counter]['item_name'] = $itemname['Item']['name'];
			$subitem['Part'][$counter]['item_id'] = $itemname['Item']['id'];
			$counter++;
		}
		$this->set('subitem', $subitem);
	}

	function add($item_id = null) {
		if (!empty($this->data)) {
			$this->Subitem->create();
			$params = array(
				'conditions'=>array('Item.id'=>$this->data['Subitem']['item_id']),
				'recursive'=>0
			);
			$item = $this->Item->find('first' ,$params);
			$jan_code = $this->JanCode->janGenerator($item['Item']['brand_id'], $item['Item']['name'], $this->data['Subitem']['major_size'], $this->data['Subitem']['minority_size']);
			$this->data['Subitem']['jan'] = $jan_code;
			if ($this->Subitem->save($this->data)) {
				//$this->flash(__('Subitem saved.', true), array('action'=>'index'));
				$this->redirect('/items/view/'.$this->data['Subitem']['item_id']);
			} else {
			}
		}
		$params = array(
			'conditions'=>array('Item.id'=>$item_id),
			'recursive'=>0,
			'fields'=>array('Item.name')
		);
		$item = $this->Item->find('first' ,$params);
		$major_size = get_major_size();
		$color = get_color();
		$clarity = get_clarity();
		$cut = get_cut();
		//$items = $this->Subitem->Item->find('list');
		$processes = $this->Subitem->Process->find('list');
		$materials = $this->Subitem->Material->find('list');
		$this->set(compact('processes', 'materials','color','clarity','cut','item', 'major_size'));
		//$this->set(compact('items', 'processes', 'materials','color','clarity','cut','item'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Subitem', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['Subitem']['carat'] = mb_convert_kana($this->data['Subitem']['carat'], 'a', 'UTF-8');
			$this->data['Subitem']['carat'] = ereg_replace("[^0-9.]", "", $this->data['Subitem']['carat']);//半角数字カンマ以外削除
			$this->data['Subitem']['stone_cost'] = mb_convert_kana($this->data['Subitem']['stone_cost'], 'a', 'UTF-8');
			$this->data['Subitem']['stone_cost'] = ereg_replace("[^0-9]", "", $this->data['Subitem']['stone_cost']);//半角数字小数点ドット以外削除
			$this->data['Subitem']['grade_cost'] = mb_convert_kana($this->data['Subitem']['grade_cost'], 'a', 'UTF-8');
			$this->data['Subitem']['grade_cost'] = ereg_replace("[^0-9]", "", $this->data['Subitem']['grade_cost']);//半角数字以外削除
			$this->data['Subitem']['metal_gram'] = mb_convert_kana($this->data['Subitem']['metal_gram'], 'a', 'UTF-8');
			$this->data['Subitem']['metal_gram'] = ereg_replace("[^0-9.]", "", $this->data['Subitem']['metal_gram']);//半角数字小数点ドット以外削除
			$this->data['Subitem']['metal_cost'] = mb_convert_kana($this->data['Subitem']['metal_cost'], 'a', 'UTF-8');
			$this->data['Subitem']['metal_cost'] = ereg_replace("[^0-9]", "", $this->data['Subitem']['metal_cost']);//半角数字以外削除
			if ($this->Subitem->save($this->data)) {
				//$this->flash(__('The Subitem has been saved.', true), array('action'=>'index'));
				$this->redirect('/subitems/view/'.$this->data['Subitem']['id']);
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subitem->read(null, $id);
		}
		$major_size = get_major_size();
		$color = get_color();
		$clarity = get_clarity();
		$cut = get_cut();
		$items = $this->Subitem->Item->find('list');
		$processes = $this->Subitem->Process->find('list');
		$materials = $this->Subitem->Material->find('list');
		$this->set(compact('items','processes','materials','color','clarity','cut', 'major_size'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Subitem', true), array('action'=>'index'));
		}
		if ($this->Subitem->del($id)) {
			$this->flash(__('Subitem deleted', true), array('action'=>'index'));
		}
	}


}
?>