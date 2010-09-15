<?php
class PurchaseDetail extends AppModel {

	var $name = 'PurchaseDetail';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Purchase' => array(
			'className' => 'Purchase',
			'foreignKey' => 'purchase_id',
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
		'Ordering' => array(
			'className' => 'Ordering',
			'foreignKey' => 'ordering_id',
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
		)
	);

}
?>