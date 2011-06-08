<?php
class AmountSection extends AppModel {

	var $name = 'AmountSection';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	//日別、色々集計
	function dayAmount($section_id){
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
    	$out['stock_qty'] = 0;
    	$out['stock_price'] = 0;
    	$out['stock_cost'] = 0;
    	$out['brand'] = array();
    	$out['type'] = array();
    	$out['property'] = array();
    	
    	$out['in_qty'] = 0;
    	$out['in_total'] = 0;
    	$out['out_qty'] = 0;
    	$out['out_total'] = 0;
    	$out['up_qty'] = 0;
    	$out['up_total'] = 0;
    	$out['down_qty'] = 0;
    	$out['down_total'] = 0;
    	
    	$params = array(
			'conditions'=>array('Depot.section_id'=>$section_id),
			'recursive'=>3,
			'contain'=>array('Section', 'Stock.Subitem.Item'),
		);
		$depots = $DepotModel->find('all' ,$params);
		foreach($depots as $depot){
			foreach($depot['Stock'] as $stock){
				$out['stock_qty'] = $out['stock_qty'] + $stock['quantity'];
				$stock_price = @$stock['Subitem']['Item']['price'] * $stock['quantity'];
				$out['stock_price'] = $out['stock_price'] + $stock_price;
				$cost = $SelectorComponent->costSelector2($stock['subitem_id']);
				$stock_cost = $cost * $stock['quantity'];
				$out['stock_cost'] = $out['stock_cost'] + $stock_cost;
				$brand_id = @$stock['Subitem']['Item']['brand_id'];
				@$out['brand'][$brand_id]['stock_qty'] = $out['brand'][$brand_id]['stock_qty'] + $stock['quantity'];
				@$out['brand'][$brand_id]['stock_price'] = $out['brand'][$brand_id]['stock_price'] + $stock_price;
				@$out['brand'][$brand_id]['stock_cost'] = $out['brand'][$brand_id]['stock_cost'] + $stock_cost;
				$itemtype = @$stock['Subitem']['Item']['itemtype'];
				@$out['type'][$itemtype]['stock_qty'] = $out['type'][$itemtype]['stock_qty'] + $stock['quantity'];
				@$out['type'][$itemtype]['stock_price'] = $out['type'][$itemtype]['stock_price'] + $stock_price;
				@$out['type'][$itemtype]['stock_cost'] = $out['type'][$itemtype]['stock_cost'] + $stock_cost;
				$itemproperty = @$stock['Subitem']['Item']['itemproperty'];
				@$out['property'][$itemproperty]['stock_qty'] = $out['property'][$itemproperty]['stock_qty'] + $stock['quantity'];
				@$out['property'][$itemproperty]['stock_price'] = $out['property'][$itemproperty]['stock_price'] + $stock_price;
				@$out['property'][$itemproperty]['stock_cost'] = $out['property'][$itemproperty]['stock_cost'] + $stock_cost;
			}
		}
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();
		App::import('Model', 'Brand');
    	$BrandModel = new Brand();
    	$brands = $BrandModel->find('list');
		
		if($out['stock_qty'] > 0){
			$value = '総在庫数,'.$out['stock_qty'].','."\r\n";
			$value .= '総在庫上代,'.$out['stock_price'].','."\r\n";
			//$value .= '総在庫下代,'.$out['stock_cost'].','."\r\n";
			$value .= 'ブランド別在庫数量,'."\r\n";
			foreach($out['brand'] as $id=>$val){
				$value .= @$brands[$id].',';
			}
			$value .= "\r\n";
			foreach($out['brand'] as $id=>$val){
				$value .= $val['stock_qty'].',';
			}
			$value .= "\r\n";
			$value .= 'ブランド別上代,'."\r\n";
			foreach($out['brand'] as $id=>$val){
				$value .= @$brands[$id].',';
			}
			$value .= "\r\n";
			foreach($out['brand'] as $id=>$val){
				$value .= $val['stock_price'].',';
			}
			
			$value .= "\r\n";
			$value .= '商品タイプ別在庫数量,'."\r\n";
			foreach($out['type'] as $id=>$val){
				$value .= @$itemtype[$id].',';
			}
			$value .= "\r\n";
			foreach($out['type'] as $id=>$val){
				$value .= $val['stock_qty'].',';
			}
			$value .= "\r\n";
			$value .= '商品タイプ別上代,'."\r\n";
			foreach($out['type'] as $id=>$val){
				$value .= @$itemtype[$id].',';
			}
			$value .= "\r\n";
			foreach($out['type'] as $id=>$val){
				$value .= $val['stock_price'].',';
			}
			
			$value .= "\r\n";
			$value .= '商品属性別在庫数量,'."\r\n";
			foreach($out['property'] as $id=>$val){
				$value .= @$itemproperty[$id].',';
			}
			$value .= "\r\n";
			foreach($out['property'] as $id=>$val){
				$value .= $val['stock_qty'].',';
			}
			$value .= "\r\n";
			$value .= '商品属性別上代,'."\r\n";
			foreach($out['property'] as $id=>$val){
				$value .= @$itemproperty[$id].',';
			}
			$value .= "\r\n";
			foreach($out['property'] as $id=>$val){
				$value .= $val['stock_price'].',';
			}
		}else{
			$value = '';
		}
		$value .= "\r\n";
		$out_val['value'] = $value;
		$out_val['out'] = $out;
		return $out_val;
	}
	
	function markIndex($section_id = null, $year = null, $month = null){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(86400, __FUNCTION__, $args);//24時間
		}
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
   		$month_total = 0; //売上月トータル
   		$month_incomplete = 0; //未完月トータル
   		$month_plan = 0; //予算合計
   		$month_mark = 0; //目標合計
   		$month_plan_avg = 0; //平均予算達成率
		$month_mark_avg = 0; //平均目標達成率
   		$out = array();
		$last_day = $DateCalComponent->last_day($year, $month);
		$days = array();
		for($i = 1; $i <= $last_day; $i++){
			$mark = $this->mark($section_id, $year, $month, $i);
			$out['days'][] = $mark;
			$month_plan_avg = $month_plan_avg + $mark['plan_achieve_rate'];
			$month_mark_avg = $month_mark_avg + $mark['mark_achieve_rate'];
			$month_total = $month_total + $mark['sales_total'];
			$month_incomplete = $month_incomplete + $mark['incomplete_total'];
			$month_plan = $month_plan + $mark['plan'];
			$month_mark = $month_mark + $mark['mark'];
		}
		//$out['month_plan_avg'] = @floor($month_plan_avg / date('d'));
		//$out['month_mark_avg'] = @floor($month_mark_avg / date('d'));
		$out['month_plan_avg'] = @floor(($month_total / $month_plan) * 100);
		$out['month_mark_avg'] = @floor(($month_total / $month_mark) * 100);
		$out['month_total'] = $month_total;
		$out['month_incomplete'] = $month_incomplete;
		$out['month_plan'] = $month_plan;
		$out['month_mark'] = $month_mark;
		return $out;
	}
	
	// year month day を受け取って、売上金額、未完金額、売上予算、目標、達成率を返す 
	// amount を計算してsave & return
	function mark($section_id, $year, $month, $day){
		/*
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		*/
		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
		App::import('Model', 'Order');
    	$OrderModel = new Order();
    	App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
    	$incomplete_total = 0; //未完金額合計
    	$sales_total = 0; //売上金額合計
    	$guest_qty = 0; //客数
    	$score_qty = 0; //点数
    	$cost_total = 0; //コスト合計
    	$target_date = $year.'-'.$month.'-'.$day;
    	
    	if(AMOUNT_LANDING == TRUE){
    		
    	}else{
	    	$params = array(
				'conditions'=>array('Order.section_id'=>$section_id, 'Order.date'=>$target_date),
				'recursive'=>1,
			);
			$OrderModel->contain('OrderDateil');
			$orders = $OrderModel->find('all' ,$params);
			foreach($orders as $order){
				if($order['Order']['order_status'] == 1 or $order['Order']['order_status'] == 2 or $order['Order']['order_status'] == 3){
					$sales_total = $sales_total + $order['Order']['total'];
					$incomplete_total = $incomplete_total + $order['Order']['total'];
					$guest_qty++;
					foreach($order['OrderDateil'] as $detail){
						$score_qty = $score_qty + $detail['bid_quantity'];
						$cost = $SelectorComponent->costSelector2($detail['subitem_id']);
						$cost_total = $cost_total + $cost;
					}
				}elseif($order['Order']['order_status'] == 4){
					$sales_total = $sales_total + $order['Order']['total'];
					$guest_qty++;
					foreach($order['OrderDateil'] as $detail){
						$score_qty = $score_qty + $detail['bid_quantity'];
						$cost = $SelectorComponent->costSelector2($detail['subitem_id']);
						$cost_total = $cost_total + $cost;
					}
				}else{
					//集計しない
				}
			}
		}
		
    	$params = array(
			'conditions'=>array(
				'AmountSection.section_id'=>$section_id,
				'AmountSection.start_day'=>$target_date, 
				'AmountSection.end_day'=>$target_date
			),
			'recursive'=>0,
			'fields'=>array('AmountSection.plan', 'AmountSection.mark', 'AmountSection.id', 'AmountSection.addsub')
		);
		$AmountSection = $this->find('first' ,$params);
		//var_dump($params);
		if($AmountSection){
			$final_total = $AmountSection['AmountSection']['addsub'] + $sales_total;
		}else{
			$AmountSection['AmountSection']['section_id'] = $section_id;
			$AmountSection['AmountSection']['start_day'] = $target_date;
			$AmountSection['AmountSection']['end_day'] = $target_date;
			$final_total = $sales_total;
			$AmountSection['AmountSection']['plan'] = 0;
			$AmountSection['AmountSection']['mark'] = 0;
			$AmountSection['AmountSection']['addsub'] = 0;
		}
		$AmountSection['AmountSection']['full_amount'] = $sales_total;
		$AmountSection['AmountSection']['guest_qty'] = $guest_qty;
		$AmountSection['AmountSection']['sales_qty'] = $score_qty;
		$AmountSection['AmountSection']['cost_amount'] = $cost_total;
		$this->create();
    	$this->save($AmountSection);
    	$result['guest_qty'] = $guest_qty;
    	$result['score_qty'] = $score_qty;
    	$result['cost_total'] = $cost_total;
    	$result['year'] = $year;
    	$result['month'] = $month;
    	$result['day'] = $day;
    	$result['youbi'] = $DateCalComponent->this_youbi($year, $month, $day);
    	$result['section_id'] = $section_id;
    	$result['sales_total'] = $final_total;
    	$result['incomplete_total'] = $incomplete_total;
    	$result['plan'] = $AmountSection['AmountSection']['plan'];
    	$result['mark'] = $AmountSection['AmountSection']['mark'];
    	$result['addsub'] = $AmountSection['AmountSection']['addsub'];
    	if($result['addsub'] > 0) $sales_total = $sales_total + $result['addsub'];
    	$result['plan_achieve_rate'] = @floor(($sales_total / $AmountSection['AmountSection']['plan']) * 100);
    	$result['mark_achieve_rate'] = @floor(($sales_total / $AmountSection['AmountSection']['mark']) * 100);
    	//$result['plan_achieve_rate'] = @floor(($AmountSection['AmountSection']['plan'] / $sales_total) * 100);
    	//$result['mark_achieve_rate'] = @floor(($AmountSection['AmountSection']['mark'] / $sales_total) * 100);
    	return $result;
	}
	
	//plan と mark を保存するだけなんだけど、汎用的にしてある（手抜き）
	function saveMark($value){
		$this->create();
		$target_date = $value['year'].'-'.$value['month'].'-'.$value['day'];
		$params = array(
			'conditions'=>array(
				'AmountSection.section_id'=>$value['section_id'],
				'AmountSection.start_day'=>$target_date, 
				'AmountSection.end_day'=>$target_date
			),
			'recursive'=>0,
		);
		$AmountSection = $this->find('first' ,$params);
		if($AmountSection){
			$AmountSection['AmountSection']['plan'] = $value['plan'];
			$AmountSection['AmountSection']['mark'] = $value['mark'];
			$AmountSection['AmountSection']['addsub'] = $value['addsub'];
		}
		$this->save($AmountSection);
	}

	function csv($sale, $sale_dateil, $total_moth){
		$ModelName = 'AmountSection';
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	$params = array(
			'conditions'=>array('Depot.id'=>$sale['Sale']['depot_id']),
			'recursive'=>0
		);
		$depot = $DepotModel->find('first' ,$params);
		//
		$out_gt_qty = 0;
		$cleaningkit_qty = 0;
		$kokuin_qty = 0;
		$itemproperty1_qty = 0;
		$itemproperty2_qty = 0;
		$itemproperty3_qty = 0;
		$itemproperty4_qty = 0;
		$itemproperty5_qty = 0;
		$itemproperty1_amount = 0;
		$itemproperty2_amount = 0;
		$itemproperty3_amount = 0;
		$itemproperty4_amount = 0;
		$itemproperty5_amount = 0;
		$itemtype1_qty = 0;
		$itemtype2_qty = 0;
		$itemtype3_qty = 0;
		$itemtype4_qty = 0;
		$itemtype5_qty = 0;
		$itemtype6_qty = 0;
		$itemtype7_qty = 0;
		$itemtype8_qty = 0;
		$itemtype9_qty = 0;
		$itemtype10_qty = 0;
		$itemtype99_qty = 0;
		$itemtype1_amount = 0;
		$itemtype2_amount = 0;
		$itemtype3_amount = 0;
		$itemtype4_amount = 0;
		$itemtype5_amount = 0;
		$itemtype6_amount = 0;
		$itemtype7_amount = 0;
		$itemtype8_amount = 0;
		$itemtype9_amount = 0;
		$itemtype10_amount = 0;
		$itemtype99_amount = 0;
		//ブランドがSELECT以外の時だけqtyを代入。SELECTの時は0を。
		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	$params = array(
			'conditions'=>array('Item.id'=>$sale_dateil['SalesDateil']['item_id']),
			'recursive'=>0
		);
		$item = $ItemModel->find('first' ,$params);
		if($item['Item']['brand_id'] != '5') $out_gt_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		//アイテムが刻印だった場合はqtyを代入、ジャない場合は0
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	$params = array(
			'conditions'=>array('Subitem.id'=>$sale_dateil['SalesDateil']['subitem_id']),
			'recursive'=>0
		);
		$subitem = $SubitemModel->find('first' ,$params);
		if($SalesCsvComponent->kokuin_juge($subitem['Subitem']['jan'])) $kokuin_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		//アイテムがクリーニングキットだった場合はqtyを代入、じゃない場合は0
		if($SalesCsvComponent->cleaningkit_juge($subitem['Subitem']['jan'])) $cleaningkit_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		//
		if($item['Item']['itemproperty'] == '1') $itemproperty1_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemproperty'] == '2') $itemproperty2_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemproperty'] == '3') $itemproperty3_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemproperty'] == '4') $itemproperty4_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemproperty'] == '5') $itemproperty5_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemproperty'] == '1') $itemproperty1_amount = $total_moth['total'];
		if($item['Item']['itemproperty'] == '2') $itemproperty2_amount = $total_moth['total'];
		if($item['Item']['itemproperty'] == '3') $itemproperty3_amount = $total_moth['total'];
		if($item['Item']['itemproperty'] == '4') $itemproperty4_amount = $total_moth['total'];
		if($item['Item']['itemproperty'] == '5') $itemproperty5_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '1') $itemtype1_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '2') $itemtype2_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '3') $itemtype3_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '4') $itemtype4_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '5') $itemtype5_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '6') $itemtype6_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '7') $itemtype7_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '8') $itemtype8_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '9') $itemtype9_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '10') $itemtype10_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '99') $itemtype99_qty = $sale_dateil['SalesDateil']['bid_quantity'];
		if($item['Item']['itemtype'] == '1') $itemtype1_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '2') $itemtype2_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '3') $itemtype3_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '4') $itemtype4_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '5') $itemtype5_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '6') $itemtype6_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '7') $itemtype7_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '8') $itemtype8_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '9') $itemtype9_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '10') $itemtype10_amount = $total_moth['total'];
		if($item['Item']['itemtype'] == '99') $itemtype99_amount = $total_moth['total'];
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
					$ModelName.'.section_id'=>$depot['Section']['id']
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
				$Amount[$ModelName]['out_gt_qty'] = $Amount[$ModelName]['out_gt_qty'] + $out_gt_qty;
				$Amount[$ModelName]['kokuin_qty'] = $Amount[$ModelName]['kokuin_qty'] + $kokuin_qty;
				$Amount[$ModelName]['cleaningkit_qty'] = $Amount[$ModelName]['cleaningkit_qty'] + $cleaningkit_qty;
				$Amount[$ModelName]['itemproperty1_qty'] = $Amount[$ModelName]['itemproperty1_qty'] + $itemproperty1_qty;
				$Amount[$ModelName]['itemproperty2_qty'] = $Amount[$ModelName]['itemproperty2_qty'] + $itemproperty2_qty;
				$Amount[$ModelName]['itemproperty3_qty'] = $Amount[$ModelName]['itemproperty3_qty'] + $itemproperty3_qty;
				$Amount[$ModelName]['itemproperty4_qty'] = $Amount[$ModelName]['itemproperty4_qty'] + $itemproperty4_qty;
				$Amount[$ModelName]['itemproperty5_qty'] = $Amount[$ModelName]['itemproperty5_qty'] + $itemproperty5_qty;
				$Amount[$ModelName]['itemproperty1_amount'] = $Amount[$ModelName]['itemproperty1_amount'] + $itemproperty1_amount;
				$Amount[$ModelName]['itemproperty2_amount'] = $Amount[$ModelName]['itemproperty2_amount'] + $itemproperty2_amount;
				$Amount[$ModelName]['itemproperty3_amount'] = $Amount[$ModelName]['itemproperty3_amount'] + $itemproperty3_amount;
				$Amount[$ModelName]['itemproperty4_amount'] = $Amount[$ModelName]['itemproperty4_amount'] + $itemproperty4_amount;
				$Amount[$ModelName]['itemproperty5_amount'] = $Amount[$ModelName]['itemproperty5_amount'] + $itemproperty5_amount;
				$Amount[$ModelName]['itemtype1_qty'] = $Amount[$ModelName]['itemtype1_qty'] + $itemtype1_qty;
				$Amount[$ModelName]['itemtype2_qty'] = $Amount[$ModelName]['itemtype2_qty'] + $itemtype2_qty;
				$Amount[$ModelName]['itemtype3_qty'] = $Amount[$ModelName]['itemtype3_qty'] + $itemtype3_qty;
				$Amount[$ModelName]['itemtype4_qty'] = $Amount[$ModelName]['itemtype4_qty'] + $itemtype4_qty;
				$Amount[$ModelName]['itemtype5_qty'] = $Amount[$ModelName]['itemtype5_qty'] + $itemtype5_qty;
				$Amount[$ModelName]['itemtype6_qty'] = $Amount[$ModelName]['itemtype6_qty'] + $itemtype6_qty;
				$Amount[$ModelName]['itemtype7_qty'] = $Amount[$ModelName]['itemtype7_qty'] + $itemtype7_qty;
				$Amount[$ModelName]['itemtype8_qty'] = $Amount[$ModelName]['itemtype8_qty'] + $itemtype8_qty;
				$Amount[$ModelName]['itemtype9_qty'] = $Amount[$ModelName]['itemtype9_qty'] + $itemtype9_qty;
				$Amount[$ModelName]['itemtype10_qty'] = $Amount[$ModelName]['itemtype10_qty'] + $itemtype10_qty;
				$Amount[$ModelName]['itemtype99_qty'] = $Amount[$ModelName]['itemtype99_qty'] + $itemtype99_qty;
				$Amount[$ModelName]['itemtype1_amount'] = $Amount[$ModelName]['itemtype1_amount'] + $itemtype1_amount;
				$Amount[$ModelName]['itemtype2_amount'] = $Amount[$ModelName]['itemtype2_amount'] + $itemtype2_amount;
				$Amount[$ModelName]['itemtype3_amount'] = $Amount[$ModelName]['itemtype3_amount'] + $itemtype3_amount;
				$Amount[$ModelName]['itemtype4_amount'] = $Amount[$ModelName]['itemtype4_amount'] + $itemtype4_amount;
				$Amount[$ModelName]['itemtype5_amount'] = $Amount[$ModelName]['itemtype5_amount'] + $itemtype5_amount;
				$Amount[$ModelName]['itemtype6_amount'] = $Amount[$ModelName]['itemtype6_amount'] + $itemtype6_amount;
				$Amount[$ModelName]['itemtype7_amount'] = $Amount[$ModelName]['itemtype7_amount'] + $itemtype7_amount;
				$Amount[$ModelName]['itemtype8_amount'] = $Amount[$ModelName]['itemtype8_amount'] + $itemtype8_amount;
				$Amount[$ModelName]['itemtype9_amount'] = $Amount[$ModelName]['itemtype9_amount'] + $itemtype9_amount;
				$Amount[$ModelName]['itemtype10_amount'] = $Amount[$ModelName]['itemtype10_amount'] + $itemtype10_amount;
				$Amount[$ModelName]['itemtype99_amount'] = $Amount[$ModelName]['itemtype99_amount'] + $itemtype99_amount;
				$this->save($Amount);
				$this->id = null;
			}else{
				$Amount = array();
				$Amount[$ModelName]['name'] = $depot['Section']['name'].'-'.$depot['Section']['id'].$value.$start_day.'-'.$end_day;
				$Amount[$ModelName]['amount_type'] = $key;
				$Amount[$ModelName]['section_id'] = $depot['Section']['id'];
				$Amount[$ModelName]['start_day'] = $start_day;
				$Amount[$ModelName]['end_day'] = $end_day;
				$Amount[$ModelName]['full_amount'] = $total_moth['total'];
				$Amount[$ModelName]['item_amount'] = $total_moth['item_price_total'];
				$Amount[$ModelName]['tax_amount'] = $total_moth['tax'];
				$Amount[$ModelName]['cost_amount'] = $total_moth['total_cost'];
				$Amount[$ModelName]['sales_qty'] = $sale_dateil['SalesDateil']['bid_quantity'];
				$Amount[$ModelName]['out_gt_qty'] = $out_gt_qty;
				$Amount[$ModelName]['kokuin_qty'] = $kokuin_qty;
				$Amount[$ModelName]['cleaningkit_qty'] = $cleaningkit_qty;
				$Amount[$ModelName]['itemproperty1_qty'] = $itemproperty1_qty;
				$Amount[$ModelName]['itemproperty2_qty'] = $itemproperty2_qty;
				$Amount[$ModelName]['itemproperty3_qty'] = $itemproperty3_qty;
				$Amount[$ModelName]['itemproperty4_qty'] = $itemproperty4_qty;
				$Amount[$ModelName]['itemproperty5_qty'] = $itemproperty5_qty;
				$Amount[$ModelName]['itemproperty1_amount'] = $itemproperty1_amount;
				$Amount[$ModelName]['itemproperty2_amount'] = $itemproperty2_amount;
				$Amount[$ModelName]['itemproperty3_amount'] = $itemproperty3_amount;
				$Amount[$ModelName]['itemproperty4_amount'] = $itemproperty4_amount;
				$Amount[$ModelName]['itemproperty5_amount'] = $itemproperty5_amount;
				$Amount[$ModelName]['itemtype1_qty'] = $itemtype1_qty;
				$Amount[$ModelName]['itemtype2_qty'] = $itemtype2_qty;
				$Amount[$ModelName]['itemtype3_qty'] = $itemtype3_qty;
				$Amount[$ModelName]['itemtype4_qty'] = $itemtype4_qty;
				$Amount[$ModelName]['itemtype5_qty'] = $itemtype5_qty;
				$Amount[$ModelName]['itemtype6_qty'] = $itemtype6_qty;
				$Amount[$ModelName]['itemtype7_qty'] = $itemtype7_qty;
				$Amount[$ModelName]['itemtype8_qty'] = $itemtype8_qty;
				$Amount[$ModelName]['itemtype9_qty'] = $itemtype9_qty;
				$Amount[$ModelName]['itemtype10_qty'] = $itemtype10_qty;
				$Amount[$ModelName]['itemtype99_qty'] = $itemtype99_qty;
				$Amount[$ModelName]['itemtype1_amount'] = $itemtype1_amount;
				$Amount[$ModelName]['itemtype2_amount'] = $itemtype2_amount;
				$Amount[$ModelName]['itemtype3_amount'] = $itemtype3_amount;
				$Amount[$ModelName]['itemtype4_amount'] = $itemtype4_amount;
				$Amount[$ModelName]['itemtype5_amount'] = $itemtype5_amount;
				$Amount[$ModelName]['itemtype6_amount'] = $itemtype6_amount;
				$Amount[$ModelName]['itemtype7_amount'] = $itemtype7_amount;
				$Amount[$ModelName]['itemtype8_amount'] = $itemtype8_amount;
				$Amount[$ModelName]['itemtype9_amount'] = $itemtype9_amount;
				$Amount[$ModelName]['itemtype10_amount'] = $itemtype10_amount;
				$Amount[$ModelName]['itemtype99_amount'] = $itemtype99_amount;
				$this->save($Amount);
				$this->id = null;
			}
		}
	}

	//section_idを1つ受け取って、部門ごとに出す
	function section_today($section_id){
		$return = array();
		$ModelName = 'AmountSection';//変更箇所
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Model', 'Section');
    	$SectionModel = new Section();
		$amount_type = get_amount_type();
		$params = array(
			'conditions'=>array('Section.id'=>$section_id),
			'recursive'=>0
		);
		$section = $SectionModel->find('first' ,$params);
		$getName = 'section_id';//変更箇所
		$boot_key = $section['Section']['id'];
		$boot_value = $section['Section']['name'];
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


	function ranking_today($sales_code, $key){
		$return = array();
		$ModelName = 'AmountSection';//変更箇所
		App::import('Component', 'SalesCsv');
		$SalesCsvComponent = new SalesCsvComponent();
		App::import('Model', 'Section');//変更箇所
    	$SectionModel = new Section();//変更箇所
		$params = array(
			'conditions'=>array(
				'Section.sales_code'=>$sales_code//変更箇所
			),
			'recursive'=>0
		);
		$getValue = $SectionModel->find('list' ,$params);//変更箇所
		$getName = 'section_id';//変更箇所
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
			//前との比較％
			if($return[$boot_value][$value]['prev_amount'] > 1 and $return[$boot_value][$value]['full_amount'] > 1){
				$return[$boot_value][$value]['prev_percent'] = ($return[$boot_value][$value]['full_amount'] / $return[$boot_value][$value]['prev_amount']) * 100;
				$return[$boot_value][$value]['prev_percent'] = (floor($return[$boot_value][$value]['prev_percent'] * 100)) / 100;
			}else{
				$return[$boot_value][$value]['prev_percent'] = 0;
			}
			//昨年同との比較%
			if($return[$boot_value][$value]['year_amount'] > 1 and $return[$boot_value][$value]['full_amount'] > 1){
				$return[$boot_value][$value]['year_percent'] = ($return[$boot_value][$value]['full_amount'] / $return[$boot_value][$value]['year_amount']) * 100;
				$return[$boot_value][$value]['year_percent'] = (floor($return[$boot_value][$value]['year_percent'] * 100)) / 100;
			}else{
				$return[$boot_value][$value]['year_percent'] = 0;
			}
			$return[$boot_value][$value]['cleaningkit_percent'] = 0;
			$return[$boot_value][$value]['kokuin_percent'] = 0;
			$return[$boot_value][$value]['ring_percent'] = 0;
			$return[$boot_value][$value]['neck_percent'] = 0;
			$return[$boot_value][$value]['pair_percent'] = 0;
			$return[$boot_value][$value]['other_percent'] = 0;
			if($nowAmount[$ModelName]['sales_qty'] >= 1){
				//クリーニングキット比率
				if($nowAmount[$ModelName]['cleaningkit_qty'] >= 1) $return[$boot_value][$value]['cleaningkit_percent'] = floor(($nowAmount[$ModelName]['cleaningkit_qty'] / $nowAmount[$ModelName]['out_gt_qty']) * 100);
				//刻印比率
				if($nowAmount[$ModelName]['kokuin_qty'] >= 1 and $nowAmount[$ModelName]['itemtype1_qty'] >= 1) $return[$boot_value][$value]['kokuin_percent'] = floor(($nowAmount[$ModelName]['kokuin_qty'] / $nowAmount[$ModelName]['itemtype1_qty']) * 100);
				//リング比率
				if($nowAmount[$ModelName]['itemtype1_qty'] >= 1) $return[$boot_value][$value]['ring_percent'] = floor(($nowAmount[$ModelName]['itemtype1_qty'] / $nowAmount[$ModelName]['sales_qty']) * 100);
				//ネック比率
				if($nowAmount[$ModelName]['itemtype2_qty'] >= 1) $return[$boot_value][$value]['neck_percent'] = floor(($nowAmount[$ModelName]['itemtype2_qty'] / $nowAmount[$ModelName]['sales_qty']) * 100);
				//その他比率
				$return[$boot_value][$value]['other_percent'] = 100 - ($return[$boot_value][$value]['ring_percent'] + $return[$boot_value][$value]['neck_percent']);
				//ペア比率
				if($nowAmount[$ModelName]['itemproperty1_qty'] >= 1 and $nowAmount[$ModelName]['itemproperty2_qty'] >= 1) $return[$boot_value][$value]['pair_percent'] = floor((($nowAmount[$ModelName]['itemproperty1_qty'] + $nowAmount[$ModelName]['itemproperty2_qty']) / $nowAmount[$ModelName]['sales_qty']) * 100);
			}
		}
		return $return;
	}

	//今週のトップ10を出力
	function top_week(){
		$key = 3;//週次
		App::import('Component', 'SalesCsv');
   		$SalesCsvComponent = new SalesCsvComponent();
   		App::import('Model', 'Section');
    	$SectionModel = new Section();
		$date = date("Ymd",mktime());
		$span = $SalesCsvComponent->amountSpan($date, $key);//今週
		$start_day = $span['start_day'];
		$end_day = $span['end_day'];
		$return = array();
		//sales_codeが1、営業部門（店舗）だけを抽出し、クエリーを作る。
		$params = array(
			'conditions'=>array('Section.sales_code'=>1),
			'recursive'=>0
		);
		$sections = $SectionModel->find('all' ,$params);
		$query = "SELECT * FROM amount_sections WHERE amount_type = '$key' AND start_day >= '$start_day' AND end_day <= '$end_day' AND (";
		$counter = 0;
		foreach($sections as $sec){
			$sec_id = $sec['Section']['id'];
			if($counter == 0){
				$query .= " section_id = '$sec_id'";
			}else{
				$query .= " OR section_id = '$sec_id'";
			}
			$counter++;
		}
		$query .= ") ORDER BY CAST(full_amount AS SIGNED) DESC  LIMIT 10;";
		$Amounts = $this->query($query , $cachequeries = false);
		foreach($Amounts as $amount){
			$params = array(
				'conditions'=>array('Section.id'=>$amount['amount_sections']['section_id']),
				'recursive'=>0
			);
			$section = $SectionModel->find('first' ,$params);
			$return[] = array(
				'id'=>$section['Section']['id'],
				'name'=>$section['Section']['name'],
				'full_amount'=>$amount['amount_sections']['full_amount'],
			);
		}
		return $return;
	}



}
?>