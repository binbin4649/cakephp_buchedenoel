<?php
class OrderingsDetail extends AppModel {

	var $name = 'OrderingsDetail';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Ordering' => array(
			'className' => 'Ordering',
			'foreignKey' => 'ordering_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OrderDateil' => array(
			'className' => 'OrderDateil',
			'foreignKey' => 'order_dateil_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id',
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
		),
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'ordering_dateil_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}
?>