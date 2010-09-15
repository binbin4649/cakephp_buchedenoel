<?php
class AmountItem extends AppModel {

	var $name = 'AmountItem';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountItem';
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
					$ModelName.'.item_id'=>$item['Item']['id']
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
				$Amount[$ModelName]['name'] = $item['Item']['name'].'-'.$item['Item']['id'].$value.$start_day.'-'.$end_day;
				$Amount[$ModelName]['amount_type'] = $key;
				$Amount[$ModelName]['item_id'] = $item['Item']['id'];
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

	//今週のトップ10を出力 レフとメニュー出力
	function top_week(){
		$key = 3;//週次
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Model', 'Item');
    	$ItemModel = new Item();
		$date = date("Ymd",mktime());
		$span = $SalesCsvComponent->amountSpan($date, $key);//今週
		$start_day = $span['start_day'];
		$end_day = $span['end_day'];
		$return = array();
		$Amounts = $this->query("SELECT * FROM amount_items WHERE amount_type = '$key' AND start_day >= '$start_day' AND end_day <= '$end_day' ORDER BY CAST(full_amount AS SIGNED) DESC  LIMIT 10;" , $cachequeries = false);
		foreach($Amounts as $amount){
			$params = array(
				'conditions'=>array('Item.id'=>$amount['amount_items']['item_id']),
				'recursive'=>0
			);
			$item = $ItemModel->find('first' ,$params);
			$return[] = array(
				'id'=>$item['Item']['id'],
				'name'=>$item['Item']['name'],
				'full_amount'=>$amount['amount_items']['full_amount'],
			);
		}
		return $return;
	}


	//トップ100を出力
	function ranking_best($key){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_RANKING, __FUNCTION__, $args);//43200 = 12時間
		}
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Model', 'Item');
    	$ItemModel = new Item();
		$date = date("Ymd",mktime());
		$span = $SalesCsvComponent->amountSpan($date, $key);//今
		$start_day = $span['start_day'];
		$end_day = $span['end_day'];
		$prev_span = $SalesCsvComponent->amountPrevSpan($date, $key);
		$start_prev = $prev_span['start_day'];
		$end_prev = $prev_span['end_day'];
		$prev_year = $SalesCsvComponent->amountPrevYear($date, $key);
		$start_year = $prev_year['start_day'];
		$end_year = $prev_year['end_day'];
		$return = array();
		$Amounts = $this->query("SELECT * FROM amount_items WHERE amount_type = '$key' AND start_day >= '$start_day' AND end_day <= '$end_day' ORDER BY CAST(full_amount AS SIGNED) DESC  LIMIT 100;" , $cachequeries = false);
		foreach($Amounts as $amount){
			$params = array(
				'conditions'=>array('Item.id'=>$amount['amount_items']['item_id']),
				'recursive'=>0
			);
			$item = $ItemModel->find('first' ,$params);
			$item_id = $item['Item']['id'];
			$Prev = $this->query("SELECT * FROM amount_items WHERE amount_type = '$key' AND start_day >= '$start_prev' AND end_day <= '$end_prev' AND item_id = '$item_id' LIMIT 1;" , $cachequeries = false);
			if(!$Prev){
				$Prev[0]['amount_items']['full_amount'] = 0;
				$Prev[0]['amount_items']['sales_qty'] = 0;
				$prev_percent = 0;
			}else{
				$prev_percent = ($amount['amount_items']['full_amount'] / $Prev[0]['amount_items']['full_amount']) * 100;
				$prev_percent = (floor($prev_percent * 100)) / 100;
			}
			$Year = $this->query("SELECT * FROM amount_items WHERE amount_type = '$key' AND start_day >= '$start_year' AND end_day <= '$end_year' AND item_id = '$item_id' LIMIT 1;" , $cachequeries = false);
			if(!$Year){
				$Year[0]['amount_items']['full_amount'] = 0;
				$Year[0]['amount_items']['sales_qty'] = 0;
				$year_percent = 0;
			}else{
				$year_percent = ($amount['amount_items']['full_amount'] / $Year[0]['amount_items']['full_amount']) * 100;
				$year_percent = (floor($year_percent * 100)) / 100;
			}
			$return[] = array(
				'id'=>$item_id,
				'name'=>$item['Item']['name'],
				'full_amount'=>$amount['amount_items']['full_amount'],
				'sales_qty'=>$amount['amount_items']['sales_qty'],
				'prev_amount'=>$Prev[0]['amount_items']['full_amount'],
				'prev_percent'=>$prev_percent,
				'prev_qty'=>$Prev[0]['amount_items']['sales_qty'],
				'year_amount'=>$Year[0]['amount_items']['full_amount'],
				'year_percent'=>$year_percent,
				'year_qty'=>$Year[0]['amount_items']['sales_qty'],
			);
		}
		return $return;
	}


}
?>