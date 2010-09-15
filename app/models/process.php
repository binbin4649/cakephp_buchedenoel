<?php
class Process extends AppModel {
	
	var $actsAs = array('SoftDeletable');
	var $name = 'Process';
	var $hasMany = array('Item'=> array('className'=>'Item'));
	
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}

}
?>