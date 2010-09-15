<?php
class AmountPair extends AppModel {

	var $name = 'AmountPair';

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountPair';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	$params = array(
			'conditions'=>array('Item.id'=>$sale_dateil['SalesDateil']['item_id']),
			'recursive'=>0
		);
		$item = $ItemModel->find('first' ,$params);
		$start_juge = false;
		if(!empty($item['Item']['pair_id'])){
			if($item['Item']['itemproperty'] == 1){
				$item_ladys = $item['Item']['id'];
				$item_mens = $item['Item']['pair_id'];
				$start_juge = true;
			}
			if($item['Item']['itemproperty'] == 2){
				$item_mens = $item['Item']['id'];
				$item_ladys = $item['Item']['pair_id'];
				$start_juge = true;
			}
		}
		if($start_juge){
			$params = array(
				'conditions'=>array('Item.id'=>$item['Item']['pair_id']),
				'recursive'=>0
			);
			$pair = $ItemModel->find('first' ,$params);
			$amount_type = get_amount_type();
			foreach($amount_type as $key=>$value){
				$span = $SalesCsvComponent->amountSpan($sale['Sale']['date'], $key);
				$start_day = $span['start_day'];
				$end_day = $span['end_day'];
				$params = array(
					'conditions'=>array(
						'and'=>array(
							$ModelName.'.amount_type'=>$key,
							$ModelName.'.start_day >='=>$start_day,
							$ModelName.'.end_day <='=>$end_day,
						),
						'or'=>array(
							$ModelName.'.item_ladys'=>$item_ladys,
							$ModelName.'.item_mens'=>$item_mens,
						)),
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
					$Amount[$ModelName]['name'] = $item['Item']['name'].'-'.$pair['Item']['name'].$value.$start_day.'-'.$end_day;
					$Amount[$ModelName]['amount_type'] = $key;
					$Amount[$ModelName]['item_ladys'] = $item_ladys;
					$Amount[$ModelName]['item_mens'] = $item_mens;
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

	//トップ100を出力
	function ranking_best($key){
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
		$Amounts = $this->query("SELECT * FROM amount_pairs WHERE amount_type = '$key' AND start_day >= '$start_day' AND end_day <= '$end_day' ORDER BY CAST(full_amount AS SIGNED) DESC  LIMIT 100;" , $cachequeries = false);
		foreach($Amounts as $amount){
			$params = array(
				'conditions'=>array('Item.id'=>$amount['amount_pairs']['item_ladys']),
				'recursive'=>0
			);
			$ladys = $ItemModel->find('first' ,$params);

			$params = array(
				'conditions'=>array('Item.id'=>$amount['amount_pairs']['item_mens']),
				'recursive'=>0
			);
			$mens = $ItemModel->find('first' ,$params);
			$ladys_id = $ladys['Item']['id'];
			$mens_id = $mens['Item']['id'];

			$Prev = $this->query("SELECT * FROM amount_pairs WHERE amount_type = '$key' AND start_day >= '$start_prev' AND end_day <= '$end_prev' AND item_ladys = '$ladys_id' AND item_mens = '$mens_id' LIMIT 1;" , $cachequeries = false);
			if(!$Prev){
				$Prev[0]['amount_pairs']['full_amount'] = 0;
				$Prev[0]['amount_pairs']['sales_qty'] = 0;
				$prev_percent = 0;
			}else{
				$prev_percent = ($amount['amount_pairs']['full_amount'] / $Prev[0]['amount_pairs']['full_amount']) * 100;
				$prev_percent = (floor($prev_percent * 100)) / 100;
			}
			$Year = $this->query("SELECT * FROM amount_pairs WHERE amount_type = '$key' AND start_day >= '$start_year' AND end_day <= '$end_year' AND item_ladys = '$ladys_id' AND item_mens = '$mens_id' LIMIT 1;" , $cachequeries = false);
			if(!$Year){
				$Year[0]['amount_pairs']['full_amount'] = 0;
				$Year[0]['amount_pairs']['sales_qty'] = 0;
				$year_percent = 0;
			}else{
				$year_percent = ($amount['amount_pairs']['full_amount'] / $Year[0]['amount_pairs']['full_amount']) * 100;
				$year_percent = (floor($year_percent * 100)) / 100;
			}
			$return[] = array(
				'ladys_id'=>$ladys_id,
				'mens_id'=>$mens_id,
				'ladys_name'=>$ladys['Item']['name'],
				'mens_name'=>$mens['Item']['name'],
				'full_amount'=>$amount['amount_pairs']['full_amount'],
				'sales_qty'=>$amount['amount_pairs']['sales_qty'],
				'prev_amount'=>$Prev[0]['amount_pairs']['full_amount'],
				'prev_percent'=>$prev_percent,
				'prev_qty'=>$Prev[0]['amount_pairs']['sales_qty'],
				'year_amount'=>$Year[0]['amount_pairs']['full_amount'],
				'year_percent'=>$year_percent,
				'year_qty'=>$Year[0]['amount_pairs']['sales_qty'],
			);
		}
		return $return;
	}

}
?>