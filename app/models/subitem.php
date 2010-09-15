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

	/*　10/1　アニバの場合、重複しまくるので消した。
	var $validate = array(
		'name' => array('rule'=>'isUnique', 'message'=>'品番が重複している可能性があります。')
	);
	*/
	
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}

	function subitemName($subitem_id){
		if(!empty($subitem_id)){
			$params = array(
				'conditions'=>array('Subitem.id'=>$subitem_id),
				'recursive'=>0
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