<?php
class Company extends AppModel {

	var $name = 'Company';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Billing' => array(
			'className' => 'Billing',
			'foreignKey' => 'billing_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'BrandRate' => array(
			'className' => 'BrandRate',
			'foreignKey' => 'company_id',
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
		'Destination' => array(
			'className' => 'Destination',
			'foreignKey' => 'company_id',
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

	var $hasAndBelongsToMany = array(
		'Grouping' => array(
			'className' => 'Grouping',
			'joinTable' => 'companies_groupings',
			'foreignKey' => 'company_id',
			'associationForeignKey' => 'grouping_id',
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

	function rate($company_id, $brand_id){
		$params = array(
			'conditions'=>array('Company.id'=>$company_id),
			'recursive'=>1
		);
		$company = $this->find('first' ,$params);
		if(!empty($company['BrandRate'])){
			foreach($company['BrandRate'] as $brand_rate){
				if($brand_rate['brand_id'] == $brand_id) {
					return $brand_rate['rate'];
				}
			}
		}
		return $company['Company']['basic_rate'];
	}

}
?>