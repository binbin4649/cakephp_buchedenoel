<?php
class Ordering extends AppModel {

	var $name = 'Ordering';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Factory' => array(
			'className' => 'Factory',
			'foreignKey' => 'factory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'ordering_id',
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
		'OrderingsDetail' => array(
			'className' => 'OrderingsDetail',
			'foreignKey' => 'ordering_id',
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
	);

	var $validate = array(
		'adjustment' => array(
			'alphanumeric'=>array('rule'=>'alphaNumeric')),
	);

}
?>