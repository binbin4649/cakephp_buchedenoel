<?php
class StockRevision extends AppModel {

	var $name = 'StockRevision';

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
			'fields' => array('Subitem.name', 'Subitem.id', 'Subitem.item_id'),
			'order' => ''
		),
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => array('Depot.section_id', 'Depot.id', 'Depot.name'),
			'order' => ''
		),
	);

	var $validate = array(
		'stock_change' => VALID_NOT_EMPTY,
		'reason_type'=> VALID_NOT_EMPTY,
		'depot_id'=> VALID_NOT_EMPTY,
		'subitem_id'=> VALID_NOT_EMPTY,
	);

}
?>