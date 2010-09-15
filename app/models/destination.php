<?php
class Destination extends AppModel {

	var $name = 'Destination';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'destination_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Sale' => array(
			'className' => 'Sale',
			'foreignKey' => 'destination_id',
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

	function getName($id){
		if(!empty($id)){
			$params = array(
				'conditions'=>array('Destination.id'=>$id),
				'recursive'=>0
			);
			$Destination = $this->find('first' ,$params);
			if($Destination){
				return $Destination['Destination']['name'];
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	function cleener($id){
		if(!empty($id)){
			$params = array(
				'conditions'=>array('Destination.id'=>$id),
				'recursive'=>0
			);
			$result = $this->find('first' ,$params);
			if($result){
				return $id;
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
	
	
	// contact1 のidを受け取って、取引先担当者がいれば返す
	function companyContact($destination_id){
		$params = array(
			'conditions'=>array('Destination.id'=>$destination_id),
			'recursive'=>0
		);
		$result = $this->find('first' ,$params);
		return $result['Company']['user_id'];
	}
}
?>