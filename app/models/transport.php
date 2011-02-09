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
	

}
?>