<?php
class Purchase extends AppModel {

	var $name = 'Purchase';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Factory' => array(
			'className' => 'Factory',
			'foreignKey' => 'factory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pay' => array(
			'className' => 'Pay',
			'foreignKey' => 'pay_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'purchase_id',
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
	
	//発注データから仕入データを起こす
	//['OrderingsDetail']['stock_quantity'] を考慮していないので、とりあえず返品専用
	function orderingToPurchase($ordering, $details){
		if(empty($ordering['Ordering']['adjustment'])) $ordering['Ordering']['adjustment'] = 0;
		$this->create();
		$purchases = array(
			'purchase_status'=>5, //返品
			'factory_id'     =>$ordering['Ordering']['factory_id'],
			'date'           =>$ordering['Ordering']['date'],
			//'depot_id'       =>0,                                //たぶん使ってない
			'total'          =>$ordering['Ordering']['total'],     //税込み総合計
			'total_tax'      =>$ordering['Ordering']['total_tax'], //税のみの合計
			'adjustment'     =>$ordering['Ordering']['adjustment'],
			//'shipping'       =>0,
			//'remark'         =>'',
			'detail_total'   =>$ordering['Ordering']['dateil_total'], //detail_total = 簡単に言うと税抜き。請求単位とか明細単位に計算する時に使う
			//'pay_id'         =>'',
		);
		$this->save($purchases);
		$purchases_id = $this->getInsertID();
		//detailが保存されない。ログとって検証
		foreach($details as $detail){
			$purchase_details = array();
			$this->PurchaseDetail->create();
			if(empty($detail['OrderingsDetail']['size'])){
				if($detail['OrderingsDetail']['major_size'] == 'other'){
					$size = $detail['OrderingsDetail']['minority_size'];
				}else{
					$size = $detail['OrderingsDetail']['major_size'];
				}
			}else{
				$size = $detail['OrderingsDetail']['size'];
			}
			$purchase_details = array(
				'purchase_id'       =>$purchases_id,
				'order_id'          =>$detail['OrderingsDetail']['order_id'],
				'order_dateil_id'   =>$detail['OrderingsDetail']['order_dateil_id'],
				'ordering_id'       =>$detail['OrderingsDetail']['ordering_id'],
				'ordering_dateil_id'=>$detail['OrderingsDetail']['id'],
				'item_id'           =>$detail['OrderingsDetail']['item_id'],
				'subitem_id'        =>$detail['OrderingsDetail']['subitem_id'],
				'size'              =>$size,
				'bid'               =>$detail['OrderingsDetail']['bid'],
				'quantity'          =>$detail['OrderingsDetail']['ordering_quantity'],
				//'pay_quantity'      =>'',
				//'gram'              =>'',
				'depot'             =>$detail['OrderingsDetail']['depot'], //depot_id
			);
			if(!$this->PurchaseDetail->save($purchase_details)){
				$this->log($purchase_details);
			}
		}
	}

}
?>