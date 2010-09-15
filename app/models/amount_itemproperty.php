<?php
class AmountItemproperty extends AppModel {

	var $name = 'AmountItemproperty';

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountItemproperty';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	$params = array(
			'conditions'=>array('Item.id'=>$sale_dateil['SalesDateil']['item_id']),
			'recursive'=>0
		);
		$item = $ItemModel->find('first' ,$params);
		if(empty($item['Item']['itemproperty'])){
			$item['Item']['itemproperty'] = 5;
		}
		$itemproperty = get_itemproperty();
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
					$ModelName.'.itemproperty'=>$item['Item']['itemproperty']
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
				$Amount[$ModelName]['name'] = $itemproperty[$item['Item']['itemproperty']].'-'.$item['Item']['itemproperty'].$value.$start_day.'-'.$end_day;
				$Amount[$ModelName]['amount_type'] = $key;
				$Amount[$ModelName]['itemproperty'] = $item['Item']['itemproperty'];
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