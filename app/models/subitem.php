<?php
class Subitem extends AppModel {

	var $actsAs = array('SoftDeletable');
	var $name = 'Subitem';
	var $belongsTo = array(
		'Item'=> array('className'=>'Item'),
		'Process'=> array('className'=>'Process'),
		'Material'=> array('className'=>'Material')
	);
		var $hasMany = array(
		'Part'=> array('className'=>'Part'),
	);
		

	function subitemName($subitem_id){
		if(!empty($subitem_id)){
			$params = array(
				'conditions'=>array('Subitem.id'=>$subitem_id),
				'recursive'=>-1
			);
			$subitem = $this->find('first' ,$params);
			if($subitem){
				return $subitem['Subitem']['name'];
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	//subitem新規登録（自動）　在庫移動スクリプト用に作ったもの
	function NewSubitem($item_id, $size = NULL, $jan, $name){
		$subitem = array();
		$major_size = get_major_size();
		if(array_key_exists($size, $major_size)){//メジャーサイズだった場合
			$subitem['Subitem']['major_size'] = $size;
		}else{//メジャーサイズじゃなかった場合
			$subitem['Subitem']['major_size'] = 'other';
			$subitem['Subitem']['minority_size'] = $size;
		}
		$subitem['Subitem']['name'] = $name;
		$subitem['Subitem']['item_id'] = $item_id;
		$subitem['Subitem']['jan'] = $jan;
		$subitem['Subitem']['name_kana'] = $size;
		if($this->save($subitem)){
			$subitem['Subitem']['id'] = $this->getLastInsertID();
			return $subitem;
		}else{
			return false;
		}
	}

}
?>