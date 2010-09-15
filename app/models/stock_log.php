<?php
class StockLog extends AppModel {

	var $name = 'StockLog';

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'created_user',
			'conditions' => '',
			'fields' => array('User.name'),
			'order' => ''
		),
		'Subitem' => array(
			'className' => 'Subitem',
			'foreignKey' => 'subitem_id',
			'conditions' => '',
			'fields' => array('Subitem.name', 'Subitem.id'),
			'order' => ''
		),
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => array('Depot.section_id', 'Depot.id'),
			'order' => ''
		),
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