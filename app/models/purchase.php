<?php
class Purchase extends AppModel {

	var $name = 'Purchase';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Factory' => array(
			'className' => 'Factory',
			'foreignKey' => 'factory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pay' => array(
			'className' => 'Pay',
			'foreignKey' => 'pay_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'purchase_id',
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