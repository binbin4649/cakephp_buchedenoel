<?php
class Ordering extends AppModel {

	var $name = 'Ordering';

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
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'ordering_id',
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
		'OrderingsDetail' => array(
			'className' => 'OrderingsDetail',
			'foreignKey' => 'ordering_id',
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
	);

	var $validate = array(
		'adjustment' => array(
			'alphanumeric'=>array('rule'=>'alphaNumeric')),
	);
	
	//return=>90だったら、在庫を確認して、在庫を減らす処理。出来なかったらエラーを返す。
	function returnOrdering($details){
		App::import('Model', 'Stock');
	    $StockModel = new Stock();
	    
	    $stock_return = true; //trueなら、在庫があって次は在庫を減らす処理だってことで
		foreach($details as $detail){
			$stock_qty = $StockModel->SubitemDepotTotal($detail['OrderingsDetail']['subitem_id'], $detail['OrderingsDetail']['depot']);
			$return_qty = ereg_replace("[^0-9]", "", $detail['OrderingsDetail']['ordering_quantity']);
			if($return_qty > $stock_qty){
				$stock_return = false;
				return false;
			}
		}
		if($stock_return == true){
			foreach($details as $detail){
				$return_qty = ereg_replace("[^0-9]", "", $detail['OrderingsDetail']['ordering_quantity']);
				$user_id = $detail['OrderingsDetail']['created_user'];
				$subitem_id = $detail['OrderingsDetail']['subitem_id'];
				$depot = $detail['OrderingsDetail']['depot'];
				if($StockModel->Mimus($subitem_id, $depot, $return_qty, $user_id, 5)){
					return true;
				}else{
					return false;
				}
			}
		}
	}
	

}
?>