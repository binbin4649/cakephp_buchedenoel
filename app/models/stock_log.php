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

}
?>