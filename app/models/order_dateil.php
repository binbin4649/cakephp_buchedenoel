<?php
class OrderDateil extends AppModel {

	var $name = 'OrderDateil';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
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
		'TransportDateil' => array(
			'className' => 'TransportDateil',
			'foreignKey' => 'transport_dateil_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'OrderingsDetail' => array(
			'className' => 'OrderingsDetail',
			'foreignKey' => 'order_dateil_id',
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
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'order_dateil_id',
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

	var $validate = array(
		'pairing_quantity' => array(
			'rule' => 'numeric'
		),
		'ordering_quantity' => array(
			'rule' => 'numeric'
		),
		'sell_quantity' => array(
			'rule' => 'numeric'
		),
	);

/*
	var $validate = array(
		'specified_date' => array(
			'rule' => 'date',
			'message' => '「YYYY-MM-DD」で入力してください。',
		),
		'store_arrival_date' => array(
			'rule' => 'date',
			'message' => '「YYYY-MM-DD」で入力してください。',
		),
		'stock_date' => array(
			'rule' => 'date',
			'message' => '「YYYY-MM-DD」で入力してください。',
		),
		'shipping_date' => array(
			'rule' => 'date',
			'message' => '「YYYY-MM-DD」で入力してください。',
		)
	);
*/
	/*
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}
	*/

}
?>