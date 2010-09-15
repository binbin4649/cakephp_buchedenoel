<?php
class AmountMajorSize extends AppModel {

	var $name = 'AmountMajorSize';

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountMajorSize';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		if(empty($sale_dateil['SalesDateil']['size'])){
			$sale_dateil['SalesDateil']['size'] = 'other';
		}
		$major_sizes = get_major_size();
		$start_juge = false;
		foreach($major_sizes as $major_size){
			if($major_size == $sale_dateil['SalesDateil']['size']) $start_juge = true;
		}
		if($start_juge){
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
						$ModelName.'.major_size'=>$sale_dateil['SalesDateil']['size']
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
					$Amount[$ModelName]['name'] = $sale_dateil['SalesDateil']['size'].$value.$start_day.'-'.$end_day;
					$Amount[$ModelName]['amount_type'] = $key;
					$Amount[$ModelName]['major_size'] = $sale_dateil['SalesDateil']['size'];
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

}
?>