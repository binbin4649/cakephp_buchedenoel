<?php
class AmountBrand extends AppModel {

	var $name = 'AmountBrand';

	var $belongsTo = array(
		'Brand' => array(
			'className' => 'Brand',
			'foreignKey' => 'brand_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	//集計
	function markIndex($brands, $year = null, $month = null){
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$out = array();
		$last_day = $DateCalComponent->last_day($year, $month);
		for($i = 1; $i <= $last_day; $i++){
			$out[$i] = $this->mark($brands, $year, $month, $i);
		}
		return $out;
	}
	
	//markIndexの子供
	function mark($brands, $year, $month, $day){
		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
		App::import('Model', 'Order');
    	$OrderModel = new Order();
    	$target_date = $year.'-'.$month.'-'.$day;
    	$out = array();
    	foreach($brands as $id=>$name){
    		$out[$id]['name'] = $name;
    		$out[$id]['sales'] = 0;
    		$out[$id]['qty'] = 0;
    		$out[$id]['cost'] = 0;
    	}
    	$params = array(
			'conditions'=>array('Order.date'=>$target_date),
			'recursive'=>2,
		);
		$OrderModel->contain('OrderDateil.Item');
		$orders = $OrderModel->find('all' ,$params);
    	foreach($orders as $order){
    		foreach($order['OrderDateil'] as $detail){
    			$cost = $SelectorComponent->costSelector2($detail['subitem_id']);
    			$out[$detail['Item']['brand_id']]['sales'] = @$out[$detail['Item']['brand_id']]['sales'] + $detail['bid'];
    			$out[$detail['Item']['brand_id']]['qty'] = @$out[$detail['Item']['brand_id']]['qty'] + $detail['bid_quantity'];
    			$out[$detail['Item']['brand_id']]['cost'] = @$out[$detail['Item']['brand_id']]['cost'] + $cost;
    		}
    		
    	}
    	return $out;
	}
	
	
	/*
	function save($data){
		pr($data);
		exit;
	}
	全角英数を半角英数にする
	$b = mb_convert_kana($a, 'a', 'UTF-8');
	数字とプラス　マイナス記号以外を取り除く
	$c = filter_var($b, FILTER_SANITIZE_NUMBER_INT);
	*/

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountBrand';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	$params = array(
			'conditions'=>array('Item.id'=>$sale_dateil['SalesDateil']['item_id']),
			'recursive'=>0
		);
		$item = $ItemModel->find('first' ,$params);
		$amount_type = get_amount_type();
		foreach($amount_type as $key=>$value){
			$span = $SalesCsvComponent->amountSpan($sale['Sale']['date'], $key);
			$start_day = $span['start_day'];
			$end_day = $span['end_day'];
			$params = array(
				'conditions'=>array(
					$ModelName.'.amount_type'=>$key,
					$ModelName.'.start_day >='=>$start_day,
					$ModelName.'.end_day <='=>$end_day,
					$ModelName.'.brand_id'=>$item['Brand']['id']
				),
				'recursive'=>0
			);
			$Amount = $this->find('first' ,$params);
			if($Amount){
				$Amount[$ModelName]['full_amount'] = $Amount[$ModelName]['full_amount'] + $total_moth['total'];
				$Amount[$ModelName]['item_amount'] = $Amount[$ModelName]['item_amount'] + $total_moth['item_price_total'];
				$Amount[$ModelName]['tax_amount'] = $Amount[$ModelName]['tax_amount'] + $total_moth['tax'];
				$Amount[$ModelName]['cost_amount'] = $Amount[$ModelName]['cost_amount'] + $total_moth['total_cost'];
				$Amount[$ModelName]['sales_qty'] = $Amount[$ModelName]['sales_qty'] + $sale_dateil['SalesDateil']['bid_quantity'];
				$this->save($Amount);
				$this->id = null;
			}else{
				$Amount = array();
				$Amount[$ModelName]['name'] = $item['Brand']['name'].'-'.$item['Brand']['id'].$value.$start_day.'-'.$end_day;
				$Amount[$ModelName]['amount_type'] = $key;
				$Amount[$ModelName]['brand_id'] = $item['Brand']['id'];
				$Amount[$ModelName]['start_day'] = $start_day;
				$Amount[$ModelName]['end_day'] = $end_day;
				$Amount[$ModelName]['full_amount'] = $total_moth['total'];
				$Amount[$ModelName]['item_amount'] = $total_moth['item_price_total'];
				$Amount[$ModelName]['tax_amount'] = $total_moth['tax'];
				$Amount[$ModelName]['cost_amount'] = $total_moth['total_cost'];
				$Amount[$ModelName]['sales_qty'] = $sale_dateil['SalesDateil']['bid_quantity'];
				$this->save($Amount);
				$this->id = null;
			}
		}
	}

}
?>