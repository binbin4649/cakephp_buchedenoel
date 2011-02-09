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
	
	//transport_dateil_id をもらって、['Transport']['layaway_type'] を1に戻す。取消だから。
	function detailToLayaway1($detail_id){
		$transport = array();
		$params = array(
			'conditions'=>array('TransportDateil.id'=>$detail_id),
			'recursive'=>0
		);
		$value = $this->find('first' ,$params);
		$this->Transport->create();
		$transport['Transport'] = $value['Transport'];
		$transport['Transport']['layaway_type'] = 1;
		$transport['Transport']['in_depot'] = null;
		return $this->Transport->save($transport);
	}
	
}
?>