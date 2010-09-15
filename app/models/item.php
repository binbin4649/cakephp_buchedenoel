<?php
class Item extends AppModel {
	
	var $actsAs = array('SoftDeletable', 'Containable');
	var $name = 'Item';
	var $belongsTo = array(
		'Factory'=>array('className'=>'Factory'),
		'Brand'=>array('className'=>'Brand'),
		'SalesStateCode'=>array('className'=>'SalesStateCode'),
		'Process'=>array('className'=>'Process'),
		'Material'=>array('className'=>'Material'),
		'Stone'=>array('className'=>'Stone')
	);
	var $hasMany = array(
		'Subitem'=> array('className'=>'Subitem', 'order'=>'Subitem.name asc'),
		'ItemImage'=> array('className'=>'ItemImage')
	);
	var $hasAndBelongsToMany = array('Tag'=>array(
		'className'=>'Tag',
		'joinTable'=>'tags_items',
		'foreignKey'=>'item_id',
		'associationForeignKey'=>'tag_id',
		'conditions'=>'',
		'order'=>'',
		'limit'=>'',
		'unique'=>true,
	));

	var $validate = array(
		'name' => array('rule'=>'isUnique', 'message'=>'品番が重複している可能性があります。'),
		'pair_id'=>array(
			'rule'=>'itemDumpingCheck',
			'message'=>'Error:既に登録されている。または、同じ品番は登録できません。',
		),
	);
	

	function itemDumpingCheck($data){
		//nullはtrue
		//var_dump($data['pair_id']);
		if(isset($data['pair_id'])){
			//登録される品番と同じだったらfalse
			if($this->data['Item']['id'] == $data['pair_id']) return false;
			//登録済みと同じだったらtrue
			$params = array(
				'conditions'=>array('Item.id'=>$this->data['Item']['id']),
				'recursive'=>0,
				'fields'=>array('Item.pair_id')
			);
			$pair = $this->find('first', $params);
			if($pair['Item']['pair_id'] == $data['pair_id']) return true;
			//同じpair_idが登録されていたらtrue
			$params = array(
				'conditions'=>array('Item.pair_id'=>$data['pair_id']),
				'recursive'=>0
			);
			$count = $this->find('count', $params);
			if($count == 0){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}

	}

	function itemName($item_id){
		if(!empty($item_id)){
			$params = array(
				'conditions'=>array('Item.id'=>$item_id),
				'recursive'=>0,
				'fields'=>array('Item.name'),
			);
			$item = $this->find('first' ,$params);
			if($item){
				return $item['Item']['name'];
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	//新規登録
	function NewItem($name, $title, $brand_name){
		App::import('Model', 'Brand');
    	$BrandModel = new Brand();
		$item = array();
		$item['Item']['name'] = $name;
		$params = array(
			'conditions'=>array('Brand.name'=>$brand_name),
			'recursive'=>0
		);
		$brand = $BrandModel->find('first' ,$params);
		if($brand){//ブランドがあったら
			$item['Item']['brand_id'] = $brand['Brand']['id'];
		}else{//ブランドが無かった場合
			$brand['Brand']['id'] = NULL;
			$brand['Brand']['name'] = $brand_name;
			$BrandModel->save($brand);
			$brand['Brand']['id'] = $BrandModel->getLastInsertID();
			$item['Item']['brand_id'] = $brand['Brand']['id'];
		}
		$item['Item']['title'] = $title;
		if($this->save($item)){
			$item['Item']['id'] = $this->getLastInsertID();
			return $item;
		}else{
			return false;
		}
	}




}
?>