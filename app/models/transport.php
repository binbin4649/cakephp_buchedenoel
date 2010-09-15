<?php
class Transport extends AppModel {

	var $name = 'Transport';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'TransportDateil' => array(
			'className' => 'TransportDateil',
			'foreignKey' => 'transport_id',
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
	/*
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}
	*/
}
?>