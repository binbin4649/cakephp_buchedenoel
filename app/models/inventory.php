<?php
class Inventory extends AppModel {

	var $name = 'Inventory';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'InventoryDetail' => array(
			'className' => 'InventoryDetail',
			'foreignKey' => 'inventory_id',
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
	
	//同部門で棚卸中が無いか調べる。無ければTRUE、新しい棚卸を作ってもいいよってこと
	function statusCheck($section_id){
		if(empty($section_id)) return false;
		$params = array(
			'conditions'=>array('Inventory.section_id'=>$section_id, 'Inventory.status'=>1),
		);
		$counter = $this->find('count' ,$params);
		if($counter == 0){
			return true;
		}else{
			return false;
		}
	}
	
	// 倉庫単位で集計して返す
	function viewsTotal($id){
		App::import('Model', 'Section');
    	$SectionModel = new Section();
		$params = array(
			'conditions'=>array('Inventory.id'=>$id),
			'recursive'=>1
		);
		$Inventory = $this->find('first' ,$params);
		if($Inventory){
			$depots = array();
			foreach($Inventory['InventoryDetail'] as $detail){
				if(empty($depots[$detail['depot_id']])) $depots[$detail['depot_id']] = 0;
				$depots[$detail['depot_id']] = $depots[$detail['depot_id']] + $detail['qty'];
			}
		}else{
			return false;
		}
		$section = $SectionModel->viewFind($Inventory['Section']['id']);
		foreach($depots as $depot_id=>$qty){
			foreach($section['Depot'] as $key=>$Depot){
				if($depot_id == $Depot['id']){
					$section['Depot'][$key]['inventory'] = $qty;
					unset($depots[$depot_id]);
				}
			}
		}
		foreach($depots as $depot_id=>$qty){
			$value = array(
				'id'=>$depot_id,
				'inventory'=>$qty
			);
			$section['Depot'][] = $value;
		}
		return $section;
	}
	
	//指定倉庫の在庫を削除して、新しく入れ直す （チェックが入っていたら入れ替えす）
	function InventoryFinish($id, $data){
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	$newDepots = array();//引き金
    	foreach($data['Inventory'] as $depot_id=>$juge){
    		$DepotModel->recursive = -1;
    		if($DepotModel->read(array('id'), $depot_id)){//存在しない倉庫番号は無視
    			if($juge == 1){//全部消す
    				$conditions = array('Stock.depot_id'=>$depot_id);
    				$result = $StockModel->deleteAll($conditions, false);
    				if(!$result){
    					$this->log('error inventory.php 94:'.$depot_id);
    					return false;
    				}
    				$newDepots[] = $depot_id;
    			}
    		}
    	}
		$params = array(
			'conditions'=>array('Inventory.id'=>$id),
			'recursive'=>1
		);
		$Inventory = $this->find('first' ,$params);
		foreach($Inventory['InventoryDetail'] as $detail){
			foreach($newDepots as $newDepot){
				if($newDepot == $detail['depot_id']){
					$StockModel->create();
					$Stock['Stock'] = array(
						'subitem_id'=>$detail['subitem_id'],
						'depot_id'=>$detail['depot_id'],
						'quantity'=>$detail['qty'],
						'created_user'=>1135,
						'updated_user'=>1135,
					);
					if(!$StockModel->save($Stock)){
						$this->log('error inventory.php 117:'.var_dump($Stock));
						return false;
					}
				}
			}
		}
		return true;
		
	}
	

}
?>