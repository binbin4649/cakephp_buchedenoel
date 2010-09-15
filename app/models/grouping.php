<?php
class Grouping extends AppModel {

	var $name = 'Grouping';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
		'Company' => array(
			'className' => 'Company',
			'joinTable' => 'companies_groupings',
			'foreignKey' => 'grouping_id',
			'associationForeignKey' => 'company_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>