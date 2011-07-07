<?php
class Stock extends AppModel {

	var $name = 'Stock';

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
	
	//単品管理で、かつ1以上在庫が有ればtrue、それ以外はfalse
	function only1check($subitem_id){
		App::import('Model', 'Subitem');
	    $SubitemModel = new Subitem();
	    $params = array(
			'conditions'=>array('and'=>array('Subitem.id'=>$subitem_id)),
			'recursive'=>0,
			//'fields'=>array('Subitem.stock_code')
		);
		$subitem = $SubitemModel->find('first' ,$params);
	    if($subitem['Item']['stock_code'] != 3) return true;
		$params = array(
			'conditions'=>array('and'=>array('Stock.subitem_id'=>$subitem_id)),
			'recursive'=>-1,
			'fields'=>array('Stock.quantity')
		);
		$stocks = $this->find('all' ,$params);
		$total = 0;
		foreach($stocks as $stock){
			$total = $total + $stock['Stock']['quantity'];
		}
		if($total > 1){
			return false;
		}else{
			return true;
		}
	}
	
	//部門別に、親品番単位で在庫を集計 デフォルト倉庫のみ
	function ItemStocksDefault($item_id, $ac = null){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod('7200', __FUNCTION__, $args);//2時間
		}
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	$out = array();
    	$sections = $SectionModel->defaultList();
    	foreach($sections as $section_id=>$section){
    		$depots = array();
			$depots[]['Depot']['id'] = $section['default_depot'];
			$item_stock = $this->item_stock($depots, $item_id);
			$out[$section_id]['section_name'] = $section['name'];
			$out[$section_id]['qty'] = $item_stock['item_qty'];
			$out[$section_id]['size'] = $item_stock['size'];
    	}
    	return $out;
	}
	
	//部門別に、親品番単位で在庫を集計　デフォルト以外全部
	function ItemStocks($item_id, $ac = null){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod('7200', __FUNCTION__, $args);
		}
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	$out = array();
    	$sections = $SectionModel->defaultList();
    	foreach($sections as $section_id=>$section){
    		$params = array(
				'conditions'=>array('Depot.section_id'=>$section_id, 'Depot.id <>'=>$section['default_depot']),
				'fields'=>array('Depot.id'),
			);
			//$DepotModel->contain('Section.default_depot');
			$depots = $DepotModel->find('all' ,$params);
			$item_stock = $this->item_stock($depots, $item_id);
			$out[$section_id]['section_name'] = $section['name'];
			$out[$section_id]['qty'] = $item_stock['item_qty'];
			$out[$section_id]['size'] = $item_stock['size'];
    	}
    	return $out;
	}
	
	//部門別に、親品番単位で在庫を集計　全倉庫
	function ItemStocksAll($item_id){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod('7200', __FUNCTION__, $args);
		}
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	$out = array();
    	$sections = $SectionModel->defaultList();
    	foreach($sections as $section_id=>$section){
    		$params = array(
				'conditions'=>array('Depot.section_id'=>$section_id),
				'fields'=>array('Depot.id'),
			);
			$depots = $DepotModel->find('all' ,$params);
			$item_stock = $this->item_stock($depots, $item_id);
			$out[$section_id]['section_name'] = $section['name'];
			$out[$section_id]['qty'] = $item_stock['item_qty'];
			$out[$section_id]['size'] = $item_stock['size'];
    	}
    	return $out;
	}
	
	//ItemStocks の子供
	function item_stock($depots, $item_id){
		App::import('Model', 'Subitem');
	    $SubitemModel = new Subitem();
		$item_qty = 0;
	    $size = array();
		$result = array();
		foreach($depots as $depot){
			$params = array(
				'conditions'=>array('Subitem.item_id'=>$item_id),
				'fields'=>array('Subitem.id', 'Subitem.major_size'),
			);
			$SubitemModel->unbindModel(array('hasMany'=>array('Part')));
			$subitems = $SubitemModel->find('all' ,$params);
			foreach($subitems as $subitem){
				$subitem_qty = 0;
				$stock_qty = $this->SubitemDepotTotal($subitem['Subitem']['id'], $depot['Depot']['id']);
				$item_qty = $item_qty + $stock_qty;
				$subitem_qty = $subitem_qty + $stock_qty;
				if(!empty($size[$subitem['Subitem']['major_size']])){
					$size[$subitem['Subitem']['major_size']] = $size[$subitem['Subitem']['major_size']] + $subitem_qty;
				}else{
					$size[$subitem['Subitem']['major_size']] = $subitem_qty;
				}
			}
		}
		$result['item_qty'] = $item_qty;
		$result['size'] = $size;
		return $result;
	}
	
	//その倉庫の、その子品番の在庫数を返す。ItemStocks の孫
	function SubitemDepotTotal($subitem_id, $depot_id){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod('3600', __FUNCTION__, $args);
		}
		$result = 0;
		$params = array(
			'conditions'=>array('and'=>array('Stock.subitem_id'=>$subitem_id, 'Stock.depot_id'=>$depot_id)),
			'recursive'=>0,
			'fields'=>array('Stock.quantity')
		);
		$totals = $this->find('all' ,$params);
		foreach($totals as $total){
			$result = $result + $total['Stock']['quantity'];
		}
		return $result;
	}
	
	//全サイズを横に並べたバージョン、CSV出力用 9/16これが中途半端
	function item_stock_suball($depots, $item_id){
		App::import('Model', 'Subitem');
	    $SubitemModel = new Subitem();
	    App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
		$item_qty = 0;
	    $size = array();
		$result = array();
		foreach($depots as $depot){
			$params = array(
				'conditions'=>array('Subitem.item_id'=>$item_id),
				'fields'=>array('Subitem.id', 'Subitem.major_size', 'Subitem.minority_size'),
			);
			$SubitemModel->unbindModel(array('hasMany'=>array('Part')));
			$subitems = $SubitemModel->find('all' ,$params);
			foreach($subitems as $subitem){
				$stock_qty = $this->SubitemDepotTotal($subitem['Subitem']['id'], $depot['Depot']['id']);
				$item_qty = $item_qty + $stock_qty;
				$select_size = $SelectorComponent->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
				$size[$select_size] = $stock_qty;
			}
		}
		$result['item_qty'] = $item_qty;
		$result['size'] = $size;
		return $result;
	}
	
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
	
	//在庫を増やす
	function Plus($subitem_id, $depot, $quantity, $user_id, $status){
		//20110706 それぞれ値が無かったらfalseを返すように変更
		//直したら、入庫されないとか出庫されない問題の解決の糸口が見えるかもしれない。
		if(empty($subitem_id)) return false;
		if(empty($depot)) return false;
		if(empty($quantity)) return false;
		if(empty($user_id)) return false;
		if(empty($status)) return false;
		
		//DBとも付き合わせれば完璧だが、どうするかな、
		
		App::import('Model', 'Subitem');
		$SubitemModel = new Subitem();
		$params = array(
			'conditions'=>array('Subitem.id'=>$subitem_id),
			'recursive'=>0,
		);
		$SubitemModel->unbindModel(array('belongsTo'=>array('Process', 'Material')));
		$subitem = $SubitemModel->find('first' ,$params);
		if($subitem['Item']['stock_code'] == '2'){ //在庫管理しない、は true、増やさない。
			return true;
		}
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
		//plusと同じ理由で設置
		if(empty($subitem_id)) return false;
		if(empty($depot)) return false;
		if(empty($quantity)) return false;
		if(empty($user_id)) return false;
		if(empty($status)) return false;
		
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