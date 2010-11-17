<?php
class InventoryDetail extends AppModel {

	var $name = 'InventoryDetail';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Inventory' => array(
			'className' => 'Inventory',
			'foreignKey' => 'inventory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
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
		)
	);
	
	
	//重複があれば加算、無ければ新規登録
	function newInput($sessions, $user_id){
		foreach($sessions as $session){
			$params = array(
				'conditions'=>array(
					'InventoryDetail.jan'=>$session['subitem_jan'], 
					'InventoryDetail.inventory_id'=>$session['inventory_id'],
					'InventoryDetail.depot_id'=>$session['depot_id'],
					'InventoryDetail.span'=>$session['span'],
					'InventoryDetail.face'=>$session['face'],
				),
				'recursive'=>-1
			);
			$detail = $this->find('first' ,$params);
			if($detail){
				$this->create();
				$detail['InventoryDetail']['qty'] = $detail['InventoryDetail']['qty'] + $session['quantity'];
				$detail['InventoryDetail']['updated_user'] = $user_id;
				if(!$this->save($detail)) return false;
			}else{
				$this->create();
				$detail['InventoryDetail']['qty'] = $session['quantity'];
				$detail['InventoryDetail']['inventory_id'] = $session['inventory_id'];
				$detail['InventoryDetail']['depot_id'] = $session['depot_id'];
				$detail['InventoryDetail']['item_id'] = $session['item_id'];
				$detail['InventoryDetail']['subitem_id'] = $session['subitem_id'];
				$detail['InventoryDetail']['jan'] = $session['subitem_jan'];
				$detail['InventoryDetail']['span'] = $session['span'];
				$detail['InventoryDetail']['face'] = $session['face'];
				$detail['InventoryDetail']['subitem_name'] = $session['subitem_name'];
				$detail['InventoryDetail']['created_user'] = $user_id;
				if(!$this->save($detail)) return false;
			}
		}
		return true;
	}
	
	//在庫情報を追加
	function addStock($details){
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		foreach($details as $key=>$value){
			$params = array(
				'conditions'=>array('Stock.subitem_id'=>$value['Subitem']['id'], 'Stock.depot_id'=>$value['Depot']['id']),
				'recursive'=>-1,
			);
			$stock = $StockModel->find('first' ,$params);
			if($stock){
				$details[$key]['InventoryDetail']['depot_quantity'] = $stock['Stock']['quantity'];
			}else{
				$details[$key]['InventoryDetail']['depot_quantity'] = 0;
			}
			
		}
		return $details;
	}
	
	

}
?>