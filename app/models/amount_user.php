<?php
class AmountUser extends AppModel {

	var $name = 'AmountUser';
	var $actsAs	= array('Cache');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountUser';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'User');
    	$UserModel = new User();
    	if(!empty($sale['Sale']['contact1'])){
    		$params = array(
				'conditions'=>array('User.id'=>$sale['Sale']['contact1']),
				'recursive'=>0
			);
			$user = $UserModel->find('first' ,$params);
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
						$ModelName.'.user_id'=>$user['User']['id']
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
					$Amount[$ModelName]['name'] = $user['User']['name'].'-'.$user['User']['id'].$value.$start_day.'-'.$end_day;
					$Amount[$ModelName]['amount_type'] = $key;
					$Amount[$ModelName]['user_id'] = $user['User']['id'];
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


	//user_idを1つ受け取って、個人ごとに出す
	function user_today($user_id){
		$return = array();
		$ModelName = 'AmountUser';//変更箇所
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Model', 'User');//変更箇所
    	$UserModel = new User();//変更箇所
		$amount_type = get_amount_type();
		$params = array(
			'conditions'=>array('User.id'=>$user_id),
			'recursive'=>0
		);
		$user = $UserModel->find('first' ,$params);
		$getName = 'user_id';//変更箇所
		$boot_key = $user['User']['id'];//変更箇所
		$boot_value = $user['User']['name'];//変更箇所
		$date = date("Ymd",mktime());
		foreach($amount_type as $key=>$value){
			$span = $SalesCsvComponent->amountSpan($date, $key);
			$prev_span = $SalesCsvComponent->amountPrevSpan($date, $key);
			$prev_year = $SalesCsvComponent->amountPrevYear($date, $key);
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
				$return[$boot_value][$value]['full_amount'] = $nowAmount[$ModelName]['full_amount'];
			}else{
				$return[$boot_value][$value]['full_amount'] = 0;
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
				$return[$boot_value][$value]['prev_amount'] = $prevAmount[$ModelName]['full_amount'];
			}else{
				$return[$boot_value][$value]['prev_amount'] = 0;
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
				$return[$boot_value][$value]['year_amount'] = $yearAmount[$ModelName]['full_amount'];
			}else{
				$return[$boot_value][$value]['year_amount'] = 0;
			}
			if($return[$boot_value][$value]['prev_amount'] > 1 and $return[$boot_value][$value]['full_amount'] > 1){
				$return[$boot_value][$value]['prev_percent'] = ($return[$boot_value][$value]['full_amount'] / $return[$boot_value][$value]['prev_amount']) * 100;
				$return[$boot_value][$value]['prev_percent'] = (floor($return[$boot_value][$value]['prev_percent'] * 100)) / 100;
			}else{
				$return[$boot_value][$value]['prev_percent'] = 0;
			}
			if($return[$boot_value][$value]['year_amount'] > 1 and $return[$boot_value][$value]['full_amount'] > 1){
				$return[$boot_value][$value]['year_percent'] = ($return[$boot_value][$value]['full_amount'] / $return[$boot_value][$value]['year_amount']) * 100;
				$return[$boot_value][$value]['year_percent'] = (floor($return[$boot_value][$value]['year_percent'] * 100)) / 100;
			}else{
				$return[$boot_value][$value]['year_percent'] = 0;
			}
		}
		return $return;
	}

	//今週のトップ10を出力
	function top_week(){
		$key = 3;//週次
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Model', 'User');
    	$UserModel = new User();
		$date = date("Ymd",mktime());
		$span = $SalesCsvComponent->amountSpan($date, $key);//今週
		$start_day = $span['start_day'];
		$end_day = $span['end_day'];
		$return = array();
		$Amounts = $this->query("SELECT * FROM amount_users WHERE amount_type = '$key' AND start_day >= '$start_day' AND end_day <= '$end_day' ORDER BY CAST(full_amount AS SIGNED) DESC  LIMIT 10;" , $cachequeries = false);
		foreach($Amounts as $amount){
			$params = array(
				'conditions'=>array('User.id'=>$amount['amount_users']['user_id']),
				'recursive'=>0
			);
			$user = $UserModel->find('first' ,$params);
			$return[] = array(
				'id'=>$user['User']['id'],
				'name'=>$user['User']['name'],
				'full_amount'=>$amount['amount_users']['full_amount'],
			);
		}
		return $return;
	}

	//一覧
	function ranking_today($access_authority, $key){
		// CacheBehavior
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY_RANKING - 900, __FUNCTION__, $args);//3600 = 1時間
		}
		$return = array();
		$ModelName = 'AmountUser';//変更箇所
		App::import('Component', 'SalesCsv');
		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'User');//変更箇所
    	$UserModel = new User();//変更箇所
		$params = array(
			'conditions'=>array(
				'User.access_authority'=>$access_authority,//変更箇所
				'User.duty_code <>'=>30,//変更箇所
			),
			'recursive'=>0
		);
		$getValue = $UserModel->find('list' ,$params);//変更箇所
		$getName = 'user_id';//変更箇所
		$date = date("Ymd",mktime());
		$amount_type = get_amount_type();
		$value = $amount_type[$key];

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
				$return[$boot_value][$value]['full_amount'] = $nowAmount[$ModelName]['full_amount'];
			}else{
				$return[$boot_value][$value]['full_amount'] = 0;
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
				$return[$boot_value][$value]['prev_amount'] = $prevAmount[$ModelName]['full_amount'];
			}else{
				$return[$boot_value][$value]['prev_amount'] = 0;
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
				$return[$boot_value][$value]['year_amount'] = $yearAmount[$ModelName]['full_amount'];
			}else{
				$return[$boot_value][$value]['year_amount'] = 0;
			}
			if($return[$boot_value][$value]['prev_amount'] > 1 and $return[$boot_value][$value]['full_amount'] > 1){
				$return[$boot_value][$value]['prev_percent'] = ($return[$boot_value][$value]['full_amount'] / $return[$boot_value][$value]['prev_amount']) * 100;
				$return[$boot_value][$value]['prev_percent'] = (floor($return[$boot_value][$value]['prev_percent'] * 100)) / 100;
			}else{
				$return[$boot_value][$value]['prev_percent'] = 0;
			}
			if($return[$boot_value][$value]['year_amount'] > 1 and $return[$boot_value][$value]['full_amount'] > 1){
				$return[$boot_value][$value]['year_percent'] = ($return[$boot_value][$value]['full_amount'] / $return[$boot_value][$value]['year_amount']) * 100;
				$return[$boot_value][$value]['year_percent'] = (floor($return[$boot_value][$value]['year_percent'] * 100)) / 100;
			}else{
				$return[$boot_value][$value]['year_percent'] = 0;
			}
		}
		return $return;
	}


}
?>