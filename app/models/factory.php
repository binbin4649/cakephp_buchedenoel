<?php
class Factory extends AppModel {
	
	var $actsAs = array('SoftDeletable');
	var $name = 'Factory';
	var $hasMany = array('Item'=> array('className'=>'Item'));
	
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}
	
	function isName($id){
		$params = array(
			'conditions'=>array('Factory.id'=>$id),
			'recursive'=>0,
			'fields'=>array('Factory.name')
		);
		$factory_name = $this->find('first' ,$params);
		return $factory_name['Factory']['name'];
	}
	
	function cleaningName($id){
		$params = array(
			'conditions'=>array('Factory.id'=>$id),
			'recursive'=>0,
			'fields'=>array('Factory.name')
		);
		$factory = $this->find('first' ,$params);
		$factory_name = $factory['Factory']['name'];
		$factory_name = str_replace('株式会社', '', $factory_name);
		$factory_name = str_replace('有限会社', '', $factory_name);
		$factory_name = trim($factory_name);
		return $factory_name;
	}

}
?>