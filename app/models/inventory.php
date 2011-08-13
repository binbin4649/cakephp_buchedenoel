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
	
	//stockとinventDetailを全部ごっそりだして、整形して出力する
	function outPutDepot($detail_id, $depot_id){
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	$params = array(
			'conditions'=>array('Stock.depot_id'=>$depot_id, 'Stock.quantity >'=>0),
			'recursive'=>2,
			'contain'=>array('Subitem.Item', 'Depot')
		);
		$stocks = $StockModel->find('all' ,$params);
		
		$params = array(
			'conditions'=>array('InventoryDetail.depot_id'=>$depot_id, 'InventoryDetail.inventory_id'=>$detail_id),
			'recursive'=>-1
		);
		$details = $this->InventoryDetail->find('all' ,$params);
		// array_keysで検索できるように、検索用配列を作っておく
		$jan_list = array();
		foreach($details as $detail){
			$jan_list[] = $detail['InventoryDetail']['jan'];
		}
		$total = array('','','','','','','','合計',0,0,0,0,0,0,0,0,0,0,0,'','','','');
		$output[] = '棚卸id,明細id,倉庫名,倉庫id,スパン,フェイス,子品番,JAN,帳簿数,実棚数,差異,上代,下代,帳簿上代,実棚上代,上代差額,帳簿下代,実棚下代,下代差額,入力者,入力日時,更新者,更新日時';
		foreach($stocks as $stock){
			extract($stock);
			$out = array();
			$out[] = $detail_id;
			$out[] = '';
			$out[] = $Depot['name'];
			$out[] = $Depot['id'];
			$out[] = '';
			$out[] = '';
			$out[] = $Subitem['name'];
			$out[] = $Subitem['jan'];
			$out[] = $Stock['quantity'];
			$qty_total = $this->InventoryDetail->janTotal($Subitem['jan'], $Depot['id'], $detail_id);//棚卸明細の合計
			$out[] = $qty_total;
			$out[] = $Stock['quantity'] - $qty_total;
			$out[] = $Subitem['Item']['price'];
			$out[] = $Subitem['Item']['cost'];
			$stock_price = floor($Stock['quantity'] * $Subitem['Item']['price']);
			$out[] = $stock_price;
			$inventory_price = floor($qty_total * $Subitem['Item']['price']);
			$out[] = $inventory_price;
			$out[] = $stock_price - $inventory_price;
			$stock_cost = floor($Stock['quantity'] * $Subitem['Item']['cost']);
			$out[] = $stock_cost;
			$inventory_cost = floor($qty_total * $Subitem['Item']['cost']);
			$out[] = $inventory_cost;
			$out[] = $stock_cost - $inventory_cost;
			$out[] = $Stock['created_user'];
			$out[] = $Stock['created'];
			$out[] = $Stock['updated_user'];
			$out[] = $Stock['updated'];
			$total = $this->totalTotal($total, $out);
			$output[] = '"'.implode('","', $out).'"';
			//次はinvent_detailを回す
			if($qty_total >= 1){//棚卸があったらね
				$dump_keys = array_keys($jan_list, $Subitem['jan']);
				foreach($dump_keys as $dump_key){
					$out = array();
					$value = $details[$dump_key]['InventoryDetail'];
					$out[] = '';
					$out[] = $value['id'];
					$out[] = '';
					$out[] = '';
					$out[] = $value['span'];
					$out[] = $value['face'];
					$out[] = $Subitem['name'];
					$out[] = $Subitem['jan'];
					$out[] = '';
					$out[] = $value['qty'];
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = $value['created_user'];
					$out[] = $value['created'];
					$out[] = $value['updated_user'];
					$out[] = $value['updated'];
					$details[$dump_key]['InventoryDetail']['flag'] = 1;
					$total = $this->totalTotal($total, $out);
					$output[] = '"'.implode('","', $out).'"';
				}
			}
		}
		//stockで拾えていない分を、detailsから探す
		foreach($details as $detail){
			if(empty($detail['InventoryDetail']['flag'])){
				$params = array(
					'conditions'=>array('Subitem.id'=>$detail['InventoryDetail']['subitem_id']),
					'recursive'=>1
				);
				$subitem = $SubitemModel->find('first' ,$params);
				$out = array();
				$out[] = $detail_id;
				$out[] = '';
				$out[] = $Depot['name'];
				$out[] = $Depot['id'];
				$out[] = '';
				$out[] = '';
				$out[] = $subitem['Subitem']['name'];
				$out[] = $subitem['Subitem']['jan'];
				$out[] = 0;
				$qty_total = $this->InventoryDetail->janTotal($subitem['Subitem']['jan'], $depot_id, $detail_id);//棚卸明細の合計
				$out[] = $qty_total;
				$out[] = 0 - $qty_total;
				$out[] = $subitem['Item']['price'];
				$out[] = $subitem['Item']['cost'];
				$stock_price = 0;
				$out[] = $stock_price;
				$inventory_price = floor($qty_total * $subitem['Item']['price']);
				$out[] = $inventory_price;
				$out[] = $stock_price - $inventory_price;
				$stock_cost = 0;
				$out[] = $stock_cost;
				$inventory_cost = floor($qty_total * $subitem['Item']['cost']);
				$out[] = $inventory_cost;
				$out[] = $stock_cost - $inventory_cost;
				$out[] = '';
				$out[] = '';
				$out[] = '';
				$out[] = '';
				$total = $this->totalTotal($total, $out);
				$output[] = '"'.implode('","', $out).'"';
				$dump_keys = array_keys($jan_list, $subitem['Subitem']['jan']);
				foreach($dump_keys as $dump_key){
					$out = array();
					$value = $details[$dump_key]['InventoryDetail'];
					$out[] = '';
					$out[] = $value['id'];
					$out[] = '';
					$out[] = '';
					$out[] = $value['span'];
					$out[] = $value['face'];
					$out[] = $subitem['Subitem']['name'];
					$out[] = $subitem['Subitem']['jan'];
					$out[] = '';
					$out[] = $value['qty'];
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = $value['created_user'];
					$out[] = $value['created'];
					$out[] = $value['updated_user'];
					$out[] = $value['updated'];
					$total = $this->totalTotal($total, $out);
					$output[] = '"'.implode('","', $out).'"';
				}
			}
		}
		$output[] = '"'.implode('","', $total).'"';
    	$output_csv = '';
		foreach($output as $val){
			$output_csv .= $val."\r\n";
		}
		return $output_csv;
	}
	
	//足して返す 8,9,10,11,12,13,14,15,16,17,18
	function totalTotal($total, $out){
		$total['8'] = $total['8'] + $out['8'];
		$total['9'] = $total['9'] + $out['9'];
		$total['10'] = $total['10'] + $out['10'];
		$total['11'] = $total['11'] + $out['11'];
		$total['12'] = $total['12'] + $out['12'];
		$total['13'] = $total['13'] + $out['13'];
		$total['14'] = $total['14'] + $out['14'];
		$total['15'] = $total['15'] + $out['15'];
		$total['16'] = $total['16'] + $out['16'];
		$total['17'] = $total['17'] + $out['17'];
		$total['18'] = $total['18'] + $out['18'];
		return $total;
	}
	
	//2 stockとinventDetailを全部ごっそりだして、整形して出力する の済んだ奴は表示しないバージョン
	function outPutDepot2($detail_id, $depot_id){
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	$params = array(
			'conditions'=>array('Stock.depot_id'=>$depot_id, 'Stock.quantity >'=>0),
			'recursive'=>2,
			'contain'=>array('Subitem.Item', 'Depot')
		);
		$stocks = $StockModel->find('all' ,$params);
		
		$params = array(
			'conditions'=>array('InventoryDetail.depot_id'=>$depot_id, 'InventoryDetail.inventory_id'=>$detail_id),
			'recursive'=>-1
		);
		$details = $this->InventoryDetail->find('all' ,$params);
		// array_keysで検索できるように、検索用配列を作っておく
		$jan_list = array();
		foreach($details as $detail){
			$jan_list[] = $detail['InventoryDetail']['jan'];
		}
		$total = array('','','','','','','','合計',0,0,0,0,0,0,0,0,0,0,0,'','','','');
		$output[] = '棚卸id,明細id,倉庫名,倉庫id,スパン,フェイス,子品番,JAN,帳簿数,実棚数,差異,上代,下代,帳簿上代,実棚上代,上代差額,帳簿下代,実棚下代,下代差額,入力者,入力日時,更新者,更新日時';
		foreach($stocks as $stock){
			extract($stock);
			$out = array();
			$qty_total = $this->InventoryDetail->janTotal($Subitem['jan'], $Depot['id'], $detail_id);//棚卸明細の合計
			if($qty_total != $Stock['quantity']){
				$out[] = $detail_id;
				$out[] = '';
				$out[] = $Depot['name'];
				$out[] = $Depot['id'];
				$out[] = '';
				$out[] = '';
				$out[] = $Subitem['name'];
				$out[] = $Subitem['jan'];
				$out[] = $Stock['quantity'];
				$out[] = $qty_total;
				$out[] = $Stock['quantity'] - $qty_total;
				$out[] = $Subitem['Item']['price'];
				$out[] = $Subitem['Item']['cost'];
				$stock_price = floor($Stock['quantity'] * $Subitem['Item']['price']);
				$out[] = $stock_price;
				$inventory_price = floor($qty_total * $Subitem['Item']['price']);
				$out[] = $inventory_price;
				$out[] = $stock_price - $inventory_price;
				$stock_cost = floor($Stock['quantity'] * $Subitem['Item']['cost']);
				$out[] = $stock_cost;
				$inventory_cost = floor($qty_total * $Subitem['Item']['cost']);
				$out[] = $inventory_cost;
				$out[] = $stock_cost - $inventory_cost;
				$out[] = $Stock['created_user'];
				$out[] = $Stock['created'];
				$out[] = $Stock['updated_user'];
				$out[] = $Stock['updated'];
				$total = $this->totalTotal($total, $out);
				$output[] = '"'.implode('","', $out).'"';
			}
			//次はinvent_detailを回す
			if($qty_total >= 1){//棚卸があったらね
				$dump_keys = array_keys($jan_list, $Subitem['jan']);
				foreach($dump_keys as $dump_key){
					$out = array();
					$value = $details[$dump_key]['InventoryDetail'];
					if($qty_total != $Stock['quantity']){
						$out[] = '';
						$out[] = $value['id'];
						$out[] = '';
						$out[] = '';
						$out[] = $value['span'];
						$out[] = $value['face'];
						$out[] = $Subitem['name'];
						$out[] = $Subitem['jan'];
						$out[] = '';
						$out[] = $value['qty'];
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = '';
						$out[] = $value['created_user'];
						$out[] = $value['created'];
						$out[] = $value['updated_user'];
						$out[] = $value['updated'];
						$total = $this->totalTotal($total, $out);
						$output[] = '"'.implode('","', $out).'"';
					}
					$details[$dump_key]['InventoryDetail']['flag'] = 1;
				}
			}
		}
		//stockで拾えていない分を、detailsから探す
		foreach($details as $detail){
			if(empty($detail['InventoryDetail']['flag'])){
				$params = array(
					'conditions'=>array('Subitem.id'=>$detail['InventoryDetail']['subitem_id']),
					'recursive'=>1
				);
				$subitem = $SubitemModel->find('first' ,$params);
				$out = array();
				$out[] = $detail_id;
				$out[] = '';
				$out[] = $Depot['name'];
				$out[] = $Depot['id'];
				$out[] = '';
				$out[] = '';
				$out[] = $subitem['Subitem']['name'];
				$out[] = $subitem['Subitem']['jan'];
				$out[] = 0;
				$qty_total = $this->InventoryDetail->janTotal($subitem['Subitem']['jan'], $depot_id, $detail_id);//棚卸明細の合計
				$out[] = $qty_total;
				$out[] = 0 - $qty_total;
				$out[] = $subitem['Item']['price'];
				$out[] = $subitem['Item']['cost'];
				$stock_price = 0;
				$out[] = $stock_price;
				$inventory_price = floor($qty_total * $subitem['Item']['price']);
				$out[] = $inventory_price;
				$out[] = $stock_price - $inventory_price;
				$stock_cost = 0;
				$out[] = $stock_cost;
				$inventory_cost = floor($qty_total * $subitem['Item']['cost']);
				$out[] = $inventory_cost;
				$out[] = $stock_cost - $inventory_cost;
				$out[] = '';
				$out[] = '';
				$out[] = '';
				$out[] = '';
				$total = $this->totalTotal($total, $out);
				$output[] = '"'.implode('","', $out).'"';
				$dump_keys = array_keys($jan_list, $subitem['Subitem']['jan']);
				foreach($dump_keys as $dump_key){
					$out = array();
					$value = $details[$dump_key]['InventoryDetail'];
					$out[] = '';
					$out[] = $value['id'];
					$out[] = '';
					$out[] = '';
					$out[] = $value['span'];
					$out[] = $value['face'];
					$out[] = $subitem['Subitem']['name'];
					$out[] = $subitem['Subitem']['jan'];
					$out[] = '';
					$out[] = $value['qty'];
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = '';
					$out[] = $value['created_user'];
					$out[] = $value['created'];
					$out[] = $value['updated_user'];
					$out[] = $value['updated'];
					$total = $this->totalTotal($total, $out);
					$output[] = '"'.implode('","', $out).'"';
				}
			}
		}
		$output[] = '"'.implode('","', $total).'"';
    	$output_csv = '';
		foreach($output as $val){
			$output_csv .= $val."\r\n";
		}
		return $output_csv;
	}
	
	

}
?>