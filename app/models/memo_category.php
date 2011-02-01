<?php
class MemoCategory extends AppModel {

	var $actsAs = array('SoftDeletable');
	var $name = 'MemoCategory';
	var $validate = array(
		'name' => array('notempty'),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'MemoData' => array(
			'className' => 'MemoData',
			'foreignKey' => 'memo_category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}
	
	//get_memo_sections と memoCategoryを連想配列にして返す
	function memoCategoryArray(){
		$memo_cates = array();
		$memo_sections = get_memo_sections();
		foreach($memo_sections as $key=>$value){
			$params = array(
				'conditions'=>array('MemoCategory.memo_sections_id'=>$key),
				'recursive'=>-1,
				//'fields'=>array('User.name')
			);
			$memo_cates[$key] = $this->find('all', $params);
		}
		return $memo_cates;
	}
	
	

}
?>