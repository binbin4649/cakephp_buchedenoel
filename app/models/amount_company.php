<?php
class AmountCompany extends AppModel {

	var $name = 'AmountCompany';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountCompany';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Destination');
    	$DestinationModel = new Destination();
    	if(!empty($sale['Sale']['destination_id'])){
    		$params = array(
				'conditions'=>array('Destination.id'=>$sale['Sale']['destination_id']),
				'recursive'=>0
			);
			$destination = $DestinationModel->find('first' ,$params);
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
						$ModelName.'.company_id'=>$destination['Company']['id']
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
					$Amount[$ModelName]['name'] = $destination['Company']['name'].'-'.$destination['Company']['id'].$value.$start_day.'-'.$end_day;
					$Amount[$ModelName]['amount_type'] = $key;
					$Amount[$ModelName]['company_id'] = $destination['Company']['id'];
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