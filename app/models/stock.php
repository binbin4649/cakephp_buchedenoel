<?php
class Stock extends AppModel {

	var $name = 'Stock';
	//var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Subitem' => array(
			'className' => 'Subitem',
			'foreignKey' => 'subitem_id',
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
		)
	);
	
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
	
	//部門別に、親品番単位で在庫を集計
	function ItemStocks($item_id){
		/*
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		*/
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	$out = array();
    	$sections = $SectionModel->cleaningList();
    	foreach($sections as $section_id=>$section_name){
    		$item_qty = 0;
    		$size = array();
    		$params = array(
				'conditions'=>array('Depot.section_id'=>$section_id),
				'fields'=>array('Depot.id'),
			);
			$DepotModel->contain('Section.default_depot');
			$depots = $DepotModel->find('all' ,$params);
			foreach($depots as $depot){
				$params = array(
					'conditions'=>array('Subitem.item_id'=>$item_id),
					'fields'=>array('Subitem.id', 'Subitem.major_size'),
				);
				$SubitemModel->unbindModel(array('hasMany'=>array('Part')));
				$subitems = $SubitemModel->find('all' ,$params);
				foreach($subitems as $subitem){
					$subitem_qty = 0;
					$params = array(
						'conditions'=>array('Stock.subitem_id'=>$subitem['Subitem']['id'], 'Stock.depot_id'=>$depot['Depot']['id']),
						'recursive'=>0,
						'fields'=>array('Stock.quantity'),
					);
					$stocks = $this->find('all' ,$params);
					foreach($stocks as $stock){
						$item_qty = $item_qty + $stock['Stock']['quantity'];
						$subitem_qty = $subitem_qty + $stock['Stock']['quantity'];
					}
					//pr($subitem_qty);
					//$out[$section_id]['size'][$subitem['Subitem']['major_size']] = $subitem_qty;
					if(!empty($size[$subitem['Subitem']['major_size']])){
						$size[$subitem['Subitem']['major_size']] = $size[$subitem['Subitem']['major_size']] + $subitem_qty;
					}else{
						$size[$subitem['Subitem']['major_size']] = $subitem_qty;
					}
				}
			}
			$out[$section_id]['section_name'] = $section_name;
			$out[$section_id]['qty'] = $item_qty;
			$out[$section_id]['default_depot'] = $depot['Section']['default_depot'];
			$out[$section_id]['size'] = $size;
    	}
    	return $out;
	}
	
	
	//親品番単位で在庫数を計算
	//ページネーション忘れてた、また今度
	/*
	function ItemStocks($item_id = null, $limit = 100){
		
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	
    	if(!empty($item_id)){
    		$item_id = mb_convert_kana($item_id, 'a', 'UTF-8');
			$item_id = ereg_replace("[^0-9]", "", $item_id);//半角数字以外を削除
    		$conditions = array('Item.id'=>$item_id);
    	}elseif(!empty($item_name)){
    		$item_name = trim($item_name);
    		$conditions = array('Item.name LIKE'=>'%'.$item_name.'%');
    	}else{
    		return false;
    	}
		$params = array(
			'conditions'=>$conditions,
			'limit'=>$limit,
			'fields'=>array('Item.id', 'Item.name'),
		);
		$ItemModel->contain('Subitem.id', 'Subitem.name');
		$items = $ItemModel->find('all' ,$params);
		$sections = $SectionModel->find('list');
			
		foreach($items as $item_key=>$item){
			$item_qty = 0;
			foreach($item['Subitem'] as $subitem_key=>$subitem){
				$section_name = '';
				$section_default_depot = '';
				$conditions = array();
				if($section_id == null){
					
					pr($sections);
					$conditions = array('Stock.subitem_id'=>$subitem['id']);
				}else{
					$conditions['and'] = array('Stock.subitem_id'=>$subitem['id']);
					$section_id = mb_convert_kana($section_id, 'a', 'UTF-8');
					$section_id = ereg_replace("[^0-9]", "", $section_id);//半角数字以外を削除
					$params = array(
						'conditions'=>array('Depot.section_id'=>$section_id),
						'fields'=>array('Depot.id'),
					);
					$DepotModel->contain('Section.name', 'Section.id', 'Section.default_depot');
					$depots = $DepotModel->find('all' ,$params);
					foreach($depots as $depot){
						$conditions['and']['or'][] = array('Stock.depot_id'=>$depot['Depot']['id']);
						$section_name = $depot['Section']['name'];
						$section_default_depot = $depot['Section']['default_depot'];
					}
				}
				$params = array(
					'conditions'=>$conditions,
					'recursive'=>0,
					'fields'=>array('Stock.quantity'),
				);
				$stocks = $this->find('all' ,$params);
				foreach($stocks as $stock){
					$item_qty = $item_qty + $stock['Stock']['quantity'];
				}
			}
			$items[$item_key]['Item']['item_qty'] = $item_qty;
			$items[$item_key]['Item']['section_name'] = $section_name;
			$items[$item_key]['Item']['section_id'] = $section_id;
			$items[$item_key]['Item']['section_default_depot'] = $section_default_depot;
		}
		
		return $items;
	}
	*/
	
	//1倉庫の在庫数を計算する
	function DepotTotal($depot_id){
		$return = 0;
		$this->unbindModel(array('belongsTo'=>array('Subitem', 'Depot')));
		$params = array(
			'conditions'=>array('and'=>array('Stock.quantity >'=>0, 'Stock.depot_id'=>$depot_id)),
			'recursive'=>0,
		);
		$depot_totals = $this->find('all' ,$params);
		foreach($depot_totals as $depot_total){
			$return = $return + $depot_total['Stock']['quantity'];
		}
		return $return;
	}
	
	//その倉庫の、その子品番の在庫数を返す
	function SubitemDepotTotal($subitem_id, $depot_id){
		$result = 0;
		$params = array(
			'conditions'=>array('and'=>array('Stock.subitem_id'=>$subitem_id, 'Stock.depot_id'=>$depot_id)),
			'recursive'=>0,
		);
		$totals = $this->find('all' ,$params);
		foreach($totals as $total){
			$result = $result + $total['Stock']['quantity'];
		}
		return $result;
	}

	//在庫を増やす
	function Plus($subitem_id, $depot, $quantity, $user_id, $status){
		App::import('Model', 'StockLog');
    	$StockLogModel = new StockLog();
		$params = array(
			'conditions'=>array('and'=>array('Stock.subitem_id'=>$subitem_id, 'Stock.depot_id'=>$depot)),
			'recursive'=>0,
		);
		$stock_check = $this->find('first' ,$params);
		if($stock_check){
			$this->create();
			$this->id = $stock_check['Stock']['id'];
			$stock['quantity'] = $stock_check['Stock']['quantity'] + $quantity;
			$stock['updated_user'] = $user_id;
			$this->save($stock);
		}else{
			$this->create();
			$stock['subitem_id'] = $subitem_id;
			$stock['depot_id'] = $depot;
			$stock['quantity'] = $quantity;
			$stock['created_user'] = $user_id;
			$this->save($stock);
		}
		$stocklog['StockLog']['subitem_id'] = $subitem_id;
		$stocklog['StockLog']['depot_id'] = $depot;
		$stocklog['StockLog']['quantity'] = $quantity;
		$stocklog['StockLog']['plus'] = $status;
		$stocklog['StockLog']['created_user'] = $user_id;
		return $StockLogModel->save($stocklog);
	}

	//在庫を減らす
	function Mimus($subitem_id, $depot, $quantity, $user_id, $status){
		App::import('Model', 'StockLog');
    	$StockLogModel = new StockLog();
    	$params = array(
			'conditions'=>array('and'=>array('Stock.subitem_id'=>$subitem_id, 'Stock.depot_id'=>$depot)),
			'recursive'=>0,
		);
		$stock_check = $this->find('first' ,$params);
		if($stock_check){
			if($stock_check['Stock']['quantity'] >= $quantity){
				$this->create();
				$this->id = $stock_check['Stock']['id'];
				$stock['quantity'] = $stock_check['Stock']['quantity'] - $quantity;
				$stock['updated_user'] = $user_id;
				$this->save($stock);

				$stocklog['StockLog']['subitem_id'] = $subitem_id;
				$stocklog['StockLog']['depot_id'] = $depot;
				$stocklog['StockLog']['quantity'] = $quantity;
				$stocklog['StockLog']['mimus'] = $status;
				$stocklog['StockLog']['created_user'] = $user_id;
				$StockLogModel->save($stocklog);
				return true;
			}else{
				return false;
			}
		}else{
			App::import('Model', 'Subitem');
			$SubitemModel = new Subitem();
			$params = array(
				'conditions'=>array('Subitem.id'=>$subitem_id),
				'recursive'=>0,
			);
			$SubitemModel->unbindModel(array('belongsTo'=>array('Process', 'Material')));
			$subitem = $SubitemModel->find('first' ,$params);
			if($subitem['Item']['stock_code'] == '2'){ //在庫管理しない、は true
				return true;
			}else{
				return false;
			}
		}
	}

	function stockConfirm($subitem_id, $depot, $quantity){
		$result = stock_confirm($subitem_id, $depot, $quantity);
		return $result;
	}

}
//クラス外

//在庫があるかどうかの確認関数
function stock_confirm($subitem_id, $depot, $quantity){
	App::import('Model', 'Subitem');
	$SubitemModel = new Subitem();
	$params = array(
		'conditions'=>array('Subitem.id'=>$subitem_id),
		'recursive'=>0,
	);
	$SubitemModel->unbindModel(array('belongsTo'=>array('Process', 'Material')));
	$subitem = $SubitemModel->find('first' ,$params);
	if($subitem['Item']['stock_code'] == '2'){ //在庫管理しない、は true
		return true;
	}
	App::import('Model', 'Stock');
    $StockModel = new Stock();
	$params = array(
		'conditions'=>array('and'=>array('Stock.subitem_id'=>$subitem_id, 'Stock.depot_id'=>$depot)),
		'recursive'=>0,
	);
	$stock_check = $StockModel->find('first' ,$params);
	if($stock_check){
		if($stock_check['Stock']['quantity'] >= $quantity){
			return true;
		}else{
			return false;
		}
	}
}



?>