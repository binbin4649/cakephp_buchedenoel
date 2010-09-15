<?php
class Pricetag extends AppModel {

	var $name = 'Pricetag';

	var $hasMany = array(
		'PricetagDetail' => array(
			'className' => 'PricetagDetail',
			'foreignKey' => 'pricetag_id',
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

	var $belongsTo = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);


}
?>