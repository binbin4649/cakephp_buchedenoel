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
	function NewSubitem($item_id, $size = NULL, $jan, $name , $kana){
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
		$subitem['Subitem']['name_kana'] = $kana;
		$this->create();
		if($this->save($subitem)){
			$subitem['Subitem']['id'] = $this->getLastInsertID();
			return $subitem;
		}else{
			return false;
		}
	}
	
	//cost(総平均原価)を 型番別在庫.CSV の在庫金額に差替える
	//なんだけど、ついでにsubitemとitemの存在確認＆登録も行い、Subitemを返す
	function costReplace($sj_row){
		$params = array(
			'conditions'=>array('Subitem.jan'=>$sj_row[8]),
			'recursive'=>-1
		);
		$subitem = $this->find('first' ,$params);
		if(!$subitem){//subitemなかった場合
			$params = array(
				'conditions'=>array('Item.name'=>$sj_row[0]),
				'recursive'=>-1
			);
			$item = $this->Item->find('first' ,$params);
			if(!$item){//itemなかった場合
				$item = $this->Item->NewItem($sj_row[0], $sj_row[7], $sj_row[5]);
			}
			$subitem = $this->NewSubitem($item['Item']['id'], $sj_row[3], $sj_row[8], $sj_row[0], NULL);
		}
		$this->create();
		$subitem['Subitem']['cost'] = floor($sj_row[11] / $sj_row[10]);
		if($this->save($subitem)){
			return $subitem;
		}else{
			return false;
		}
	}
	
	

}
?>