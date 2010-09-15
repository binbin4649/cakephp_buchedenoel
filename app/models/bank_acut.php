<?php
class BankAcut extends AppModel {

	var $name = 'BankAcut';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Credit' => array(
			'className' => 'Credit',
			'foreignKey' => 'bank_acut_id',
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