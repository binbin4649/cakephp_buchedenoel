<?php
class PricetagDetail extends AppModel {

	var $name = 'PricetagDetail';

	var $belongsTo = array(
		'Pricetag' => array(
			'className' => 'Pricetag',
			'foreignKey' => 'pricetag_id',
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
	);

}
?>