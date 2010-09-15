<?php
class Pay extends AppModel {

	var $name = 'Pay';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Factory' => array(
			'className' => 'Factory',
			'foreignKey' => 'factory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Purchase' => array(
			'className' => 'Purchase',
			'foreignKey' => 'pay_id',
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

	function paysBlance(){
		$params = array(
			'conditions'=>array('Pay.pay_status'=>2),
			'recursive'=>0,
		);
		$pays = $this->find('all' ,$params);
		$blance_total = 0;
		foreach($pays as $pay){
			$blance_total = $blance_total + $pay['Pay']['total'] + $pay['Pay']['adjustment'];
		}
		return $blance_total;
	}



}


?>