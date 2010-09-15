<?php
class TransportDateil extends AppModel {

	var $name = 'TransportDateil';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Transport' => array(
			'className' => 'Transport',
			'foreignKey' => 'transport_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subitem' => array(
			'className' => 'Subitem',
			'foreignKey' => 'subitem_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'OrderDateil' => array(
			'className' => 'OrderDateil',
			'foreignKey' => 'transport_dateil_id',
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

	function Finish($transport_id){
		$params = array(
			'conditions'=>array('TransportDateil.transport_id'=>$transport_id),
			'recursive'=>0,
		);
		$TransportDateil = $this->find('all' ,$params);
		$jugement = true;
		foreach($TransportDateil as $Dateil){
			if($Dateil['TransportDateil']['pairing_quantity'] != $Dateil['TransportDateil']['in_qty']) $jugement = false;
		}
		return $jugement;
	}
}
?>