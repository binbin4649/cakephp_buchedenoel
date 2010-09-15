<?php
class MemoData extends AppModel {

	var $actsAs = array('SoftDeletable');
	var $name = 'MemoData';
	var $validate = array(
		'name' => array('notempty'),
		'memo_category_id' => array('notempty'),
		'file' => array(
			'extensions'=>array(
				'rule'=>array('extension', array('gif', 'jpeg', 'jpg', 'png', 'doc', 'xls', 'pdf', 'ppt', 'zip', 'swf'))),
			'alphanumeric'=>array(
				'rule'=>'alphaNumeric')
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'MemoCategory' => array(
			'className' => 'MemoCategory',
			'foreignKey' => 'memo_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
	
	
	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()){
		
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		
		$parameters = compact('conditions', 'fields', 'order', 'limit', 'page');
		$result = $this->find('all', array_merge($parameters, $extra));
		foreach($result as $key=>$value){
			
			$params = array(
				'conditions'=>array('MemoData.reply'=>$value['MemoData']['id']),
				'recursive'=>0
			);
			$reply_count = $this->find('count', $params);
			if($reply_count >= 1) $result[$key]['MemoData']['name'] = '('.$reply_count.')'.$value['MemoData']['name'];
			
		}
	    return $result;
	}
	
	
}
?>