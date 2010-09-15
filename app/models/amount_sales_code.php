<?php
class AmountSalesCode extends AppModel {

	var $name = 'AmountSalesCode';
	var $actsAs	= array('Cache');

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountSalesCode';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	$params = array(
			'conditions'=>array('Depot.id'=>$sale['Sale']['depot_id']),
			'recursive'=>0
		);
		$depot = $DepotModel->find('first' ,$params);
		if(empty($depot['Section']['sales_code'])){
			$depot['Section']['sales_code'] = 4;
		}
		$sales_code = get_sales_code();
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
					$ModelName.'.sales_code'=>$depot['Section']['sales_code']
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
				$Amount[$ModelName]['name'] = $sales_code[$depot['Section']['sales_code']].'-'.$value.$start_day.'-'.$end_day;
				$Amount[$ModelName]['amount_type'] = $key;
				$Amount[$ModelName]['sales_code'] = $depot['Section']['sales_code'];
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

	function today(){
		// CacheBehavior コメントを外せば有効
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod('3600', __FUNCTION__, $args);//3600 = 1時間
		}
		$return = array();
		$ModelName = 'AmountSalesCode';//変更箇所
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		$amount_type = get_amount_type();
		$getValue = get_sales_code();//変更箇所
		$getName = 'sales_code';//変更箇所
		$date = date("Ymd",mktime());
		foreach($amount_type as $key=>$value){
			$span = $SalesCsvComponent->amountSpan($date, $key);
			$prev_span = $SalesCsvComponent->amountPrevSpan($date, $key);
			$prev_year = $SalesCsvComponent->amountPrevYear($date, $key);
			foreach($getValue as $boot_key=>$boot_value){
				$params = array(
					'conditions'=>array(
						$ModelName.'.amount_type'=>$key,
						$ModelName.'.start_day >='=>$span['start_day'],
						$ModelName.'.end_day <='=>$span['end_day'],
						$ModelName.'.'.$getName=>$boot_key
					),
					'recursive'=>0
				);
				$nowAmount = $this->find('first' ,$params);
				if($nowAmount){
					$return[$value][$boot_value]['full_amount'] = $nowAmount[$ModelName]['full_amount'];
				}else{
					$return[$value][$boot_value]['full_amount'] = 0;
				}
				$params = array(
					'conditions'=>array(
						$ModelName.'.amount_type'=>$key,
						$ModelName.'.start_day >='=>$prev_span['start_day'],
						$ModelName.'.end_day <='=>$prev_span['end_day'],
						$ModelName.'.'.$getName=>$boot_key
					),
					'recursive'=>0
				);
				$prevAmount = $this->find('first' ,$params);
				if($prevAmount){
					$return[$value][$boot_value]['prev_amount'] = $prevAmount[$ModelName]['full_amount'];
				}else{
					$return[$value][$boot_value]['prev_amount'] = 0;
				}
				$params = array(
					'conditions'=>array(
						$ModelName.'.amount_type'=>$key,
						$ModelName.'.start_day >='=>$prev_year['start_day'],
						$ModelName.'.end_day <='=>$prev_year['end_day'],
						$ModelName.'.'.$getName=>$boot_key
					),
					'recursive'=>0
				);
				$yearAmount = $this->find('first' ,$params);
				if($yearAmount){
					$return[$value][$boot_value]['year_amount'] = $yearAmount[$ModelName]['full_amount'];
				}else{
					$return[$value][$boot_value]['year_amount'] = 0;
				}
				if($return[$value][$boot_value]['prev_amount'] > 1 and $return[$value][$boot_value]['full_amount'] > 1){
					$return[$value][$boot_value]['prev_percent'] = ($return[$value][$boot_value]['full_amount'] / $return[$value][$boot_value]['prev_amount']) * 100;
					$return[$value][$boot_value]['prev_percent'] = (floor($return[$value][$boot_value]['prev_percent'] * 100)) / 100;
				}else{
					$return[$value][$boot_value]['prev_percent'] = 0;
				}
				if($return[$value][$boot_value]['year_amount'] > 1 and $return[$value][$boot_value]['full_amount'] > 1){
					$return[$value][$boot_value]['year_percent'] = ($return[$value][$boot_value]['full_amount'] / $return[$value][$boot_value]['year_amount']) * 100;
					$return[$value][$boot_value]['year_percent'] = (floor($return[$value][$boot_value]['year_percent'] * 100)) / 100;
				}else{
					$return[$value][$boot_value]['year_percent'] = 0;
				}

			}
		}
		return $return;
	}

	function all_total(){
		$return = array();
		$ModelName = 'AmountSalesCode';//変更箇所
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$amount_type = get_amount_type();
		$sales_code = get_sales_code();//変更箇所
		$date = date("Ymd",mktime());
		$yyyy = date('Y', time());
		$mm = date('m', time());
		$dd = date('d', time());
		foreach($amount_type as $key=>$value){
			$return[$value]['full_amount'] = 0;
			$return[$value]['prev_amount'] = 0;
			$return[$value]['year_amount'] = 0;
			$span = $SalesCsvComponent->amountSpan($date, $key);
			$prev_span = $SalesCsvComponent->amountPrevSpan($date, $key);
			$prev_year = $SalesCsvComponent->amountPrevYear($date, $key);
			foreach($sales_code as $boot_key=>$boot_value){
				$params = array(
					'conditions'=>array(
						$ModelName.'.amount_type'=>$key,
						$ModelName.'.start_day >='=>$span['start_day'],
						$ModelName.'.end_day <='=>$span['end_day'],
						$ModelName.'.sales_code'=>$boot_key
					),
					'recursive'=>0
				);
				$nowAmount = $this->find('first' ,$params);
				if($nowAmount){
					$return[$value]['full_amount'] = $return[$value]['full_amount'] + $nowAmount[$ModelName]['full_amount'];
				}
				$params = array(
					'conditions'=>array(
						$ModelName.'.amount_type'=>$key,
						$ModelName.'.start_day >='=>$prev_span['start_day'],
						$ModelName.'.end_day <='=>$prev_span['end_day'],
						$ModelName.'.sales_code'=>$boot_key
					),
					'recursive'=>0
				);
				$prevAmount = $this->find('first' ,$params);
				if($prevAmount){
					$return[$value]['prev_amount'] = $return[$value]['prev_amount'] + $prevAmount[$ModelName]['full_amount'];
				}
				$params = array(
					'conditions'=>array(
						$ModelName.'.amount_type'=>$key,
						$ModelName.'.start_day >='=>$prev_year['start_day'],
						$ModelName.'.end_day <='=>$prev_year['end_day'],
						$ModelName.'.sales_code'=>$boot_key
					),
					'recursive'=>0
				);
				$yearAmount = $this->find('first' ,$params);
				if($yearAmount){
					$return[$value]['year_amount'] = $return[$value]['year_amount'] + $yearAmount[$ModelName]['full_amount'];
				}
			}
			if($return[$value]['full_amount'] > 1 and $return[$value]['prev_amount'] > 1){
				$return[$value]['prev_percent'] = ($return[$value]['full_amount'] / $return[$value]['prev_amount']) * 100;
				$return[$value]['prev_percent'] = (floor($return[$value]['prev_percent'] * 100)) / 100;
			}else{
				$return[$value]['prev_percent'] = 0;
			}
			if($return[$value]['year_amount'] > 1 and $return[$value]['year_amount'] > 1){
				$return[$value]['year_percent'] = ($return[$value]['full_amount'] / $return[$value]['year_amount']) * 100;
				$return[$value]['year_percent'] = (floor($return[$value]['year_percent'] * 100)) / 100;
			}else{
				$return[$value]['year_percent'] = 0;
			}
		}
		return $return;
	}


}
?>