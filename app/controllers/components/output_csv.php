<?php

class OutputCsvComponent extends Object {
	var $components = array('Selector');
	
	//棚卸明細
	function InventoryDetail($values){
		$depot_total = 0;
		$real_total = 0;
		$out = '棚卸番号,明細番号,倉庫名,倉庫番号,スパン,フェイス,子品番,JAN,帳簿数,実棚数,入力者,入力日時,更新者,更新日時'."\r\n";
		foreach($values as $value){
			extract($value);// InventoryDetail   Depot   Subitem
			$depot_total = $depot_total + $InventoryDetail['depot_quantity'];
			$real_total = $real_total + $InventoryDetail['qty'];
			$out .= $InventoryDetail['inventory_id'].',';
			$out .= $InventoryDetail['id'].',';
			$out .= $Depot['name'].',';
			$out .= $Depot['id'].',';
			$out .= $InventoryDetail['span'].',';
			$out .= $InventoryDetail['face'].',';
			$out .= $Subitem['name'].',';
			$out .= $Subitem['jan'].',';
			$out .= $InventoryDetail['depot_quantity'].',';
			$out .= $InventoryDetail['qty'].',';
			$out .= $InventoryDetail['created_user'].',';
			$out .= $InventoryDetail['created'].',';
			$out .= $InventoryDetail['updated_user'].',';
			$out .= $InventoryDetail['updated']."\r\n";
		}
		$out .= "\r\n";
		$out .= '帳簿数合計:'.$depot_total."\r\n";
		$out .= '実棚数合計:'.$real_total."\r\n";
		return $out;
	}

	//
	function priceTag($Pricetags){
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		$out = array();
		foreach($Pricetags['PricetagDetail'] as $detail){
			$params = array(
				'conditions'=>array('Item.id'=>$detail['Subitem']['item_id']),
				'recursive'=>0,
			);
			$jan = substr($detail['Subitem']['jan'], 0, 12);
			$item = $ItemModel->find('first' ,$params);
			$detail['brand_id'] = $item['Item']['brand_id'];
			$size = $this->Selector->sizeSelector($detail['Subitem']['major_size'], $detail['Subitem']['minority_size']);
			@$out[$detail['brand_id']] .= $jan.',"'.$detail['Subitem']['name'].'","","'.$size.'","'.$detail['Subitem']['name_kana'].'",';
			$out[$detail['brand_id']] .= $item['Item']['price'].','.$detail['quantity']."\n";
		}
		return $out;
	}

	//営業部門（店舗）の佐川e秘伝用のＣＳＶを一括出力
	function ehStore($sections){
		$district = get_district();
		$eh = '';
		foreach($sections as $section){
			if(!empty($section['Section']['district']) and $section['Section']['district'] != 460){
				$eh .= "".','; //依頼主コード
				$eh .= "".','; //部署担当者コード　要らない
				$eh .= "".','; //部署担当者名
				$eh .= $section['Section']['post_code'].','; //届け先郵便番号
				$name1 = mb_substr($section['Section']['name'], 0, 16);
				$name2 = mb_substr($section['Section']['name'], 16, 16);
				$eh .= $name1.','; //届け名1
				$eh .= $name2.','; //届け名2
				$juusho = $district[$section['Section']['district']].$section['Section']['adress_one'].$section['Section']['adress_two'];
				$juusho1 = mb_substr($juusho, 0, 16);
				$juusho2 = mb_substr($juusho, 16, 32);
				$juusho3 = mb_substr($juusho, 32, 48);
				$eh .= "$juusho1".','."$juusho2".',,'; //届け先住所
				$eh .= $section['Section']['tel'].','; //届け先電話番号
				$eh .= "".','; //発送日（出荷日）なし
				$eh .= "".','; //配達指定日
				$eh .= "".','; //代引金額無し
				$eh .= '00,';//時間指定なし
				$eh .= "".',';
				$eh .= ""."\r\n";
			}
		}
		return $eh;
	}

	function users($users){
		$out = 'No,部門,名前,役職,雇用体系,性別,誕生日,血液型,入社,更新日'."\r\n";
		foreach($users as $user){
			$out .= $user['User']['id'].',';
			$out .= $user['Section']['name'].',';
			$out .= $user['User']['name'].',';
			$out .= $user['Post']['name'].',';
			$out .= $user['Employment']['name'].',';
			$out .= $user['User']['sex'].',';
			$out .= $user['User']['birth_day'].',';
			$out .= $user['User']['blood_type'].',';
			$out .= $user['User']['join_day'].',';
			$out .= $user['User']['updated']."\r\n";
		}
		return $out;
	}

	function repairs($repairs){
		$repair_status = get_repair_status();
		$estimate_status = get_estimate_status();
		$out = '"ID","管理番号","品番","サイズ","工場","部門","担当者","状態","見積状態","受付日","店着希望日","工場納期","出荷日","お客様名","修理内容","上代","下代","作成日時","更新日時"'."\r\n";
		foreach($repairs as $repair){
			$out .= '"'.$repair['Repair']['id'].'","';
			$out .= $repair['Repair']['control_number'].'","';
			$out .= $repair['Item']['name'].'","';
			$out .= $repair['Repair']['size'].'","';
			$out .= $repair['Factory']['name'].'","';
			$out .= $repair['Section']['name'].'","';
			$out .= $repair['User']['name'].'","';
			if(!empty($repair['Repair']['status'])) {
				$out .= $repair_status[$repair['Repair']['status']].'","';
			}else{
				$out .= '","';
			}
			if(!empty($repair['Repair']['estimate_status'])){
				$out .= $estimate_status[$repair['Repair']['estimate_status']].'","';
			}else{
				$out .= '","';
			}
			$out .= $repair['Repair']['reception_date'].'","';
			$out .= $repair['Repair']['store_arrival_date'].'","';
			$out .= $repair['Repair']['factory_delivery_date'].'","';
			$out .= $repair['Repair']['shipping_date'].'","';
			$out .= $repair['Repair']['customer_name'].'","';
			$out .= $repair['Repair']['repair_content'].'","';
			$out .= $repair['Repair']['repair_price'].'","';
			$out .= $repair['Repair']['reapir_cost'].'","';
			$out .= $repair['Repair']['created'].'","';
			$out .= $repair['Repair']['updated'].'"'."\r\n";
		}
		return $out;
	}

	//detailを１行単位にして出力。つまりdetailの数だけOrderは同じ
	function orders($orders){
		App::import('Model', 'User');
    	$UserModel = new User();
    	App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
		$order_type = get_order_type();
		$order_status = get_order_status();
		$out = '"受注番号","受注タイプ","受注状態","倉庫","出荷先","イベントNo","スパンNo","受注日","担当者1","担当者2","担当者3","担当者4","お客様名","施設番号","合計金額","商品合計","消費税合計","送料","調整金額","前受金","作成日","作成者","更新日","更新者","親品番","子品番","納期","店着","入荷","出荷","上代単価","受注数量","引当数量","発注数量","売上済数量","刻印"'."\r\n";
		
		//2011-01-18　作り直す予定だった
		//$out = '"","","","","","","","","","","担当者3","担当者4","お客様名","施設番号","合計金額","商品合計","消費税合計","送料","調整金額","前受金","作成日","作成者","更新日","更新者","親品番","子品番","納期","店着","入荷","出荷","上代単価","受注数量","引当数量","発注数量","売上済数量","刻印"'."\r\n";
		//$out = '"日時","店舗名","品番","サイズ","個数","刻印","お客様名","客注番号","受注番号","店着日","備考",';
		//$out .= '"受注タイプ","受注状態","倉庫","出荷先","イベントNo","スパンNo","受注日","担当者1","担当者2","","","","","","","","","","","","","","","","","","","","","","","","",'."\r\n";
		foreach($orders as $order){
			$contact1_name = $UserModel->userName($order['Order']['contact1']);
			$contact2_name = $UserModel->userName($order['Order']['contact2']);
			$contact3_name = $UserModel->userName($order['Order']['contact3']);
			$contact4_name = $UserModel->userName($order['Order']['contact4']);
			$created_user_name = $UserModel->userName($order['Order']['created_user']);
			$updated_user_name = $UserModel->userName($order['Order']['updated_user']);
			foreach($order['OrderDateil'] as $detail){
				$out .= '"'.$order['Order']['id'].'","';
				if(!empty($order['Order']['order_type'])){
					$out .= $order_type[$order['Order']['order_type']].'","';
				}else{
					$out .= '","';
				}
				if(!empty($order['Order']['order_status'])){
					$out .= $order_status[$order['Order']['order_status']].'","';
				}else{
					$out .= '","';
				}
				$out .= $order['Depot']['name'].':'.$order['Depot']['id'].'","';
				$out .= $order['Destination']['name'].':'.$order['Destination']['id'].'","';
				$out .= $order['Order']['events_no'].'","';
				$out .= $order['Order']['span_no'].'","';
				$out .= $order['Order']['date'].'","';
				$out .= $contact1_name.':'.$order['Order']['contact1'].'","';
				$out .= $contact2_name.':'.$order['Order']['contact2'].'","';
				$out .= $contact3_name.':'.$order['Order']['contact3'].'","';
				$out .= $contact4_name.':'.$order['Order']['contact4'].'","';
				$out .= $order['Order']['customers_name'].'","';
				$out .= $order['Order']['partners_no'].'","';
				$out .= $order['Order']['total'].'","';
				$out .= $order['Order']['price_total'].'","';
				$out .= $order['Order']['total_tax'].'","';
				$out .= $order['Order']['shipping'].'","';
				$out .= $order['Order']['adjustment'].'","';
				$out .= $order['Order']['prev_money'].'","';
				$out .= $order['Order']['created'].'","';
				$out .= $created_user_name.':'.$order['Order']['created_user'].'","';
				$out .= $order['Order']['updated'].'","';
				$out .= $updated_user_name.':'.$order['Order']['updated_user'].'","';
				$out .= $ItemModel->itemName($detail['item_id']).'","';
				$out .= $SubitemModel->subitemName($detail['subitem_id']).'","';
				$out .= $detail['specified_date'].'","';
				$out .= $detail['store_arrival_date'].'","';
				$out .= $detail['stock_date'].'","';
				$out .= $detail['shipping_date'].'","';
				$out .= $detail['bid'].'","';
				$out .= $detail['bid_quantity'].'","';
				$out .= $detail['pairing_quantity'].'","';
				$out .= $detail['ordering_quantity'].'","';
				$out .= $detail['sell_quantity'].'","';
				$out .= $detail['marking'].'"'."\r\n";
			}
		}
		return $out;
	}
	
	function OrderDateil($values){
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Model', 'User');
    	$UserModel = new User();
		$order_type = get_order_type();
		$out = '"ID","区分","売上ID","取置ID","部門ID","部門名","品番ID","品番名","入力日","店着日","出荷日","入力担当者ID","入力担当者名","備考","ブランドID","工場ID","上代","子品番名"'."\r\n";
		foreach($values as $value){
			$out .= '"'.$value['OrderDateil']['id'].'","';
			$out .= $value['Order']['id'].'","';
			if(!empty($value['OrderDateil']['order_type'])){
				$out .= $order_type[$value['OrderDateil']['order_type']].'","';
			}else{
				$out .= '","';
			}
			$out .= $value['OrderDateil']['transport_dateil_id'].'","';
			$out .= $value['Order']['section_id'].'","';
			$section_name = $SectionModel->cleaningName($value['Order']['section_id']);
			$out .= $section_name.'","';
			$out .= $value['Item']['id'].'","';
			$out .= $value['Item']['name'].'","';
			$out .= $value['OrderDateil']['created'].'","';
			$out .= $value['OrderDateil']['store_arrival_date'].'","';
			$out .= $value['OrderDateil']['shipping_date'].'","';
			$out .= $value['OrderDateil']['created_user'].'","';
			$user = $UserModel->findById($value['OrderDateil']['created_user']);
			$out .= $user['User']['name'].'","';
			$out .= $value['OrderDateil']['sub_remarks'].'","';
			$out .= $value['Item']['brand_id'].'","';
			$out .= $value['Item']['factory_id'].'","';
			$out .= $value['Item']['price'].'","';
			$out .= $value['Subitem']['name'].'"'."\r\n";
		}
		return $out;
	}

	//支払一覧
	function pays($pays){
		$pay_status = get_pay_status();
		$pay_way_type = get_pay_way_type();
		$out = '"ID","工場・仕入先","状態","請求書番号","支払方法","実行日","締日","支払日","合計金額","消費税","調整金額","作成日時","更新日時"'."\r\n";
		foreach($pays as $pay){
			$out .= '"'.$pay['Pay']['id'].'","';
			$out .= $pay['Factory']['name'].'","';
			if(!empty($pay['Pay']['pay_status'])) {
				$out .= $pay_status[$pay['Pay']['pay_status']].'","';
			}else{
				$out .= '","';
			}
			$out .= $pay['Pay']['partner_no'].'","';
			if(!empty($pay['Pay']['pay_way_type'])) {
				$out .= $pay_way_type[$pay['Pay']['pay_way_type']].'","';
			}else{
				$out .= '","';
			}
			$out .= $pay['Pay']['date'].'","';
			$out .= $pay['Pay']['total_day'].'","';
			$out .= $pay['Pay']['payment_day'].'","';
			$out .= $pay['Pay']['total'].'","';
			$out .= $pay['Pay']['tax'].'","';
			$out .= $pay['Pay']['adjustment'].'","';
			$out .= $pay['Pay']['created'].'","';
			$out .= $pay['Pay']['updated'].'"'."\r\n";
		}
		return $out;
	}

	//出荷一覧
	function shippinglist($details){
		App::import('Model', 'Destination');
    	$DestinationModel = new Destination();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
		$order_status = get_order_status();
		$out = '"出荷日","状態","受注番号","出荷先","倉庫","子品番","単価","出荷数","受注数","引当数","発注数","刻印"'."\r\n";
		foreach($details as $detail){
			$out .= '"'.$detail['OrderDateil']['shipping_date'].'","';
			if(!empty($detail['Order']['order_status'])) {
				$out .= $order_status[$detail['Order']['order_status']].'","';
			}else{
				$out .= '","';
			}
			$out .= $detail['Order']['id'].'","';
			$destination_name = $DestinationModel->getName($detail['Order']['destination_id']);
			if($destination_name){
				$out .= $destination_name.':'.$detail['Order']['destination_id'].'","';
			}else{
				$out .= '","';
			}
			$depot_name = $DepotModel->getName($detail['Order']['depot_id']);
			if($depot_name){
				$out .= $depot_name.':'.$detail['Order']['depot_id'].'","';
			}else{
				$out .= '","';
			}
			$out .= $detail['Subitem']['name'].'","';
			$out .= $detail['Item']['price'].'","';
			$shipping_qty = $detail['OrderDateil']['bid_quantity'] - $detail['OrderDateil']['sell_quantity'];
			$out .= $shipping_qty.'","';
			$out .= $detail['OrderDateil']['bid_quantity'].'","';
			$out .= $detail['OrderDateil']['pairing_quantity'].'","';
			$out .= $detail['OrderDateil']['ordering_quantity'].'","';
			$out .= $detail['OrderDateil']['marking'].'"'."\r\n";
		}
		return $out;
	}

	//請求一覧
	function invoices($invoices){
		$invoice_status = get_invoice_status();
		$out = '"請求書番号","状態","部門","請求先","請求日","締め日","支払日","前回請求額","前回入金額","繰越残高","今月売上額","今月消費税","今月調整額","今月送料","今月合計","今月請求額","作成日時"'."\r\n";
		foreach($invoices as $invoice){
			$out .= '"'.$invoice['Invoice']['id'].'","';
			if(!empty($invoice['Invoice']['invoice_status'])) {
				$out .= $invoice_status[$invoice['Invoice']['invoice_status']].'","';
			}else{
				$out .= '","';
			}
			$out .= $invoice['Section']['name'].':'.$invoice['Section']['id'].'","';
			$out .= $invoice['Billing']['name'].':'.$invoice['Billing']['id'].'","';
			$out .= $invoice['Invoice']['date'].'","';
			$out .= $invoice['Invoice']['total_day'].'","';
			$out .= $invoice['Invoice']['payment_day'].'","';
			$out .= $invoice['Invoice']['previous_invoice'].'","';
			$out .= $invoice['Invoice']['previous_deposit'].'","';
			$out .= $invoice['Invoice']['balance_forward'].'","';
			$out .= $invoice['Invoice']['sales'].'","';
			$out .= $invoice['Invoice']['tax'].'","';
			$out .= $invoice['Invoice']['adjustment'].'","';
			$out .= $invoice['Invoice']['shipping'].'","';
			$out .= $invoice['Invoice']['total'].'","';
			$out .= $invoice['Invoice']['month_total'].'","';
			$out .= $invoice['Invoice']['created'].'"'."\r\n";
		}
		return $out;
	}

	//入金一覧
	function credits($credits){
		$credit_methods = get_credit_methods();
		$out = '"入金番号","請求番号","請求先","請求日","支払方法","入金口座","入金金額","振込手数料","相殺金額","調整金額","消込金額","作成日時","備考"'."\r\n";
		foreach($credits as $credit){
			$out .= '"'.$credit['Credit']['id'].'","';
			$out .= $credit['Credit']['invoice_id'].'","';
			$out .= $credit['Billing']['name'].':'.$credit['Billing']['id'].'","';
			$out .= $credit['Credit']['date'].'","';
			if(!empty($credit['Credit']['credit_methods'])) {
				$out .= $credit_methods[$credit['Credit']['credit_methods']].'","';
			}else{
				$out .= '","';
			}
			$out .= $credit['BankAcut']['name'].':'.$credit['BankAcut']['id'].'","';
			$out .= $credit['Credit']['deposit_amount'].'","';
			$out .= $credit['Credit']['transfer_fee'].'","';
			$out .= $credit['Credit']['offset_amount'].'","';
			$out .= $credit['Credit']['adjustment'].'","';
			$out .= $credit['Credit']['reconcile_amount'].'","';
			$out .= $credit['Credit']['created'].'","';
			$out .= $credit['Credit']['remark'].'"'."\r\n";
		}
		return $out;
	}

	//在庫一覧
	function stocks($stocks){
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();
		$out = '"子品番ID","子品番名","JAN","倉庫ID","倉庫名","ブランドID","属性","タイプ","在庫数","価格","在庫金額上代","在庫金額下代","加工コスト","支給品コスト","原価","carat","color","clarity","cut",';
		$out .= '"鑑定書番号","受注番号","基本サイズ","基本サイズ外","石コスト","地金コスト","地金重さ","鑑定書コスト","部門ID","店舗番号（旧倉庫番号）"'."\r\n";
		foreach($stocks as $stock){
			$cost = $this->Selector->costSelector2($stock['Subitem']['id']);
			$zaiko_total = $stock['Subitem']['Item']['price'] * $stock['Stock']['quantity'];
			$zaiko_cost = $cost * $stock['Stock']['quantity'];
			
			$out .= '"'.$stock['Stock']['subitem_id'].'","';
			$out .= $stock['Subitem']['name'].'","';
			$out .= $stock['Subitem']['jan'].'","';
			$out .= $stock['Stock']['depot_id'].'","';
			$out .= $stock['Depot']['name'].'","';
			$out .= $stock['Subitem']['Item']['brand_id'].'","';
			$out .= @$itemproperty[$stock['Subitem']['Item']['itemproperty']].'","';
			$out .= @$itemtype[$stock['Subitem']['Item']['itemtype']].'","';
			$out .= $stock['Stock']['quantity'].'","';
			$out .= $stock['Subitem']['Item']['price'].'","';
			$out .= $zaiko_total.'","';
			$out .= $zaiko_cost.'","';
			$out .= $stock['Subitem']['labor_cost'].'","';
			$out .= $stock['Subitem']['supply_full_cost'].'","';
			$out .= $cost.'","';
			$out .= $stock['Subitem']['carat'].'","';
			$out .= $stock['Subitem']['color'].'","';
			$out .= $stock['Subitem']['clarity'].'","';
			$out .= $stock['Subitem']['cut'].'","';
			$out .= $stock['Subitem']['grade_report'].'","';
			$out .= $stock['Subitem']['selldata_id'].'","';
			$out .= $stock['Subitem']['major_size'].'","';
			$out .= $stock['Subitem']['minority_size'].'","';
			$out .= $stock['Subitem']['stone_cost'].'","';
			$out .= $stock['Subitem']['metal_cost'].'","';
			$out .= $stock['Subitem']['metal_gram'].'","';
			$out .= $stock['Subitem']['grade_cost'].'","';
			$out .= $stock['Depot']['section_id'].'","';
			$out .= $stock['Depot']['old_system_no'].'"'."\r\n";
		}
		return $out;
	}
	
	//親品番をベースに部門別に出力
	function item_stocks($stocks, $item){
		$out = '"'.$item['name'].'","'.$item['id'].'"'."\r\n";
		$out .= '"部門","合計","#1","#3","#5","#7","#9","#11","#13","#15","#17","#19","#21","40cm","50cm","other"'."\r\n";
		$total = array('1'=>0, '3'=>0, '5'=>0, '7'=>0, '9'=>0, '11'=>0, '13'=>0, '15'=>0, '17'=>0, '19'=>0, '21'=>0, '40'=>0, '50'=>0, 'other'=>0, 'total'=>0);
		foreach($stocks as $section_id=>$stock){
			$out .= '"'.$stock['section_name'].':'.$section_id.'","';
			$out .= $stock['qty'].'","';
			$total['total'] = $total['total'] + $stock['qty'];
			if(!empty($stock['size']['#1'])){
				$out .= $stock['size']['#1'].'","';
				$total['1'] = $total['1'] + $stock['size']['#1'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#3'])){
				$out .= $stock['size']['#3'].'","';
				$total['3'] = $total['3'] + $stock['size']['#3'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#5'])){
				$out .= $stock['size']['#5'].'","';
				$total['5'] = $total['5'] + $stock['size']['#5'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#7'])){
				$out .= $stock['size']['#7'].'","';
				$total['7'] = $total['7'] + $stock['size']['#7'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#9'])){
				$out .= $stock['size']['#9'].'","';
				$total['9'] = $total['9'] + $stock['size']['#9'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#11'])){
				$out .= $stock['size']['#11'].'","';
				$total['11'] = $total['11'] + $stock['size']['#11'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#13'])){
				$out .= $stock['size']['#13'].'","';
				$total['13'] = $total['13'] + $stock['size']['#13'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#15'])){
				$out .= $stock['size']['#15'].'","';
				$total['15'] = $total['15'] + $stock['size']['#15'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#17'])){
				$out .= $stock['size']['#17'].'","';
				$total['17'] = $total['17'] + $stock['size']['#17'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#19'])){
				$out .= $stock['size']['#19'].'","';
				$total['19'] = $total['19'] + $stock['size']['#19'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['#21'])){
				$out .= $stock['size']['#21'].'","';
				$total['21'] = $total['21'] + $stock['size']['#21'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['40cm'])){
				$out .= $stock['size']['40cm'].'","';
				$total['40'] = $total['40'] + $stock['size']['40cm'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['50cm'])){
				$out .= $stock['size']['50cm'].'","';
				$total['50'] = $total['50'] + $stock['size']['50cm'];
			}else{
				$out .= '","';
			}
			if(!empty($stock['size']['other'])){
				$out .= $stock['size']['other'].'"'."\r\n";
				$total['other'] = $total['other'] + $stock['size']['other'];
			}else{
				$out .= '"'."\r\n";
			}
		}
		$out .= '"合計","'.$total['total'].'","'.$total['1'].'","'.$total['3'].'","'.$total['5'].'","'.$total['7'].'","'.$total['9'].'","'.$total['11'].'","'.$total['13'].'","'.$total['15'].'","'.$total['17'].'","'.$total['19'].'","'.$total['21'].'","'.$total['40'].'","'.$total['50'].'","'.$total['other'].'"'."\r\n";
		return $out;
	}

	//移動一覧
	function Transport($value){
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	$transport_status = get_transport_status();
    	$layaway_type = get_layaway_type();
		//$out = '"移動番号ID","子品番名","JAN","親品番名","上代","コスト","出庫数","入庫数","出庫倉庫","入庫倉庫","移動状況","出荷予定日","着荷予定日","取置状況","取置担当者",';
		//$out = '"","","","","","","","","","","","","","","",';
		$out = '"入力日時","部門（店舗）","親品番名","サイズ","個数","","","","取置番号","店着日","備考","子品番名","JAN","上代","コスト",';
		$out .= '"出庫数","入庫数","出庫倉庫","入庫倉庫","移動状況","出荷予定日","取置状況","取置担当者"'."\r\n";
		foreach($value as $val){
			foreach($val['TransportDateil'] as $detail){
				$params = array(
					'conditions'=>array('Subitem.id'=>$detail['subitem_id']),
					'recursive'=>0,
				);
				$SubitemModel->unbindModel(array('belongsTo'=>array('Process', 'Material')));
				$subitem = $SubitemModel->find('first' ,$params);
				$section_name = $DepotModel->sectionMarge($val['Transport']['in_depot']);
				$size = $this->Selector->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
				$cost = $this->Selector->costSelector($subitem['Item']['id'], $subitem['Subitem']['cost']);
				$out .= '"'.$val['Transport']['created'].'","';
				$out .= $section_name['section_name'].'","';
				$out .= $subitem['Item']['name'].'","';
				$out .= $size.'","';
				$out .= $detail['out_qty'].'","';
				$out .= '","'; //元刻印
				$out .= '","'; //元お客様名
				$out .= '","'; //元客注番号
				$out .= $val['Transport']['id'].'","';
				$out .= $val['Transport']['arrival_date'].'","';
				$out .= $val['Transport']['remark'].'","';
				$out .= $subitem['Subitem']['name'].'","';
				$out .= $subitem['Subitem']['jan'].'","';
				$out .= $subitem['Item']['price'].'","';
				$out .= $cost.'","';
				$out .= $detail['out_qty'].'","';
				$out .= $detail['in_qty'].'","';
				$out .= $val['Transport']['out_depot'].'","';
				$out .= $val['Transport']['in_depot'].'","';
				if(!empty($val['Transport']['transport_status'])){
					$out .= $transport_status[$val['Transport']['transport_status']].'","';
				}else{
					$out .= '","';
				}
				$out .= $val['Transport']['delivary_date'].'","';
				if(!empty($val['Transport']['layaway_type'])){
					$out .= $layaway_type[$val['Transport']['layaway_type']].'","';
				}else{
					$out .= '","';
				}
				$out .= $val['Transport']['layaway_user'].'"'."\r\n";
			}
		}
		return $out;
	}

	//在庫修正履歴
	function StockRevisions($StockRevisions){
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		$reason_type = get_reason_type();
		$stock_change =get_stock_change();
		$plus_qty = 0;
		$minus_qty = 0;
		$plus_price = 0;
		$minus_price = 0;
		$out = '"ID","子品番名","子品番番号","上代（税抜）","倉庫名","倉庫番号","数量","増減","修正区分","理由詳細","ユーザー","ユーザー番号","登録日"'."\r\n";
		foreach($StockRevisions as $StockRevision){
			$params = array(
				'conditions'=>array('Item.id'=>$StockRevision['Subitem']['item_id']),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
			$out .= '"'.$StockRevision['StockRevision']['id'].'","';
			$out .= $StockRevision['Subitem']['name'].'","';
			$out .= $StockRevision['StockRevision']['subitem_id'].'","';
			$out .= $item['Item']['price'].'","';
			$out .= $StockRevision['Depot']['name'].'","';
			$out .= $StockRevision['StockRevision']['depot_id'].'","';
			$out .= $StockRevision['StockRevision']['quantity'].'","';
			if(!empty($StockRevision['StockRevision']['stock_change'])) {
				$out .= $stock_change[$StockRevision['StockRevision']['stock_change']].'","';
			}else{
				$out .= '","';
			}
			if(!empty($StockRevision['StockRevision']['reason_type'])) {
				$out .= $reason_type[$StockRevision['StockRevision']['reason_type']].'","';
			}else{
				$out .= '","';
			}
			$out .= $StockRevision['StockRevision']['reason'].'","';
			$out .= $StockRevision['User']['name'].'","';
			$out .= $StockRevision['StockRevision']['created_user'].'","';
			$out .= $StockRevision['StockRevision']['created'].'"'."\r\n";
			$total_price = $item['Item']['price'] * $StockRevision['StockRevision']['quantity'];
			if($StockRevision['StockRevision']['stock_change'] == '1'){ //増
				$plus_qty = $StockRevision['StockRevision']['quantity'] + $plus_qty;
				$plus_price = $total_price + $plus_price;
			}elseif($StockRevision['StockRevision']['stock_change'] == '2'){ //減
				$minus_qty = $StockRevision['StockRevision']['quantity'] + $minus_qty;
				$minus_price = $total_price + $minus_price;
			}
		}
		$diff_qty = $plus_qty - $minus_qty;
		$diff_price = $plus_price - $minus_price;
		$out .= "\r\n".'"増合計数","'.$plus_qty.'"';
		$out .= "\r\n".'"増合計金額","'.$plus_price.'"';
		$out .= "\r\n".'"減合計数","'.$minus_qty.'"';
		$out .= "\r\n".'"減合計金額","'.$minus_price.'"';
		$out .= "\r\n".'"差異数","'.$diff_qty.'"';
		$out .= "\r\n".'"差金額","'.$diff_price.'"'."\r\n";
		return $out;
	}

	//商品一覧
	function items($items){
		$stock_code = get_stock_code();
		$order_approve = get_order_approve();
		$cutom_order_approve = get_cutom_order_approve();
		$trans_approve = get_trans_approve();
		$atelier_trans_approve = get_atelier_trans_approve();
		$percent_code = get_percent_code();
		$sales_sum_code = get_sales_sum_code();
		$itemproperty = get_itemproperty();
		$itemtype = get_itemtype();
		$unit = get_unit();

		$out = '"id","品番","ブランド","工場","上代","在庫管理区分","販売状況","加工","素材","石","石（その他）","石（スペック）","メッセージ刻印",';
		$out .= '"メッセージ刻印（訳）","販売開始時期","販売終了時期","寸法","重さ","寸法基準単位","発注可否","客注可否","客注日数","修理日数","サイズ直し可否","チェーン品番","アトリエサイズ直し可否","工賃",';
		$out .= '"支給金額合計","原価","掛率区分","売上計上区分","画像ファイル名","ペアid","品名","商品タイプ","基本サイズ","基本サイズ外","商品属性"'."\r\n";

		foreach($items as $item){
			$out .= '"'.$item['Item']['id'].'","';
			$out .= $item['Item']['name'].'","';
			$out .= $item['Brand']['name'].'","';
			$out .= $item['Factory']['name'].'","';
			$out .= $item['Item']['price'].'","';
			if(!empty($item['Item']['stock_code'])){
				$out .= $stock_code[$item['Item']['stock_code']].'","';
			}else{
				$out .= '","';
			}
			$out .= $item['SalesStateCode']['name'].'","';
			$out .= $item['Process']['name'].'","';
			$out .= $item['Material']['name'].'","';
			$out .= $item['Stone']['name'].'","';
			$out .= $item['Item']['stone_other'].'","';
			$out .= $item['Item']['stone_spec'].'","';
			$out .= $item['Item']['message_stamp'].'","';
			$out .= $item['Item']['message_stamp_ja'].'","';
			$out .= $item['Item']['release_day'].'","';
			$out .= $item['Item']['order_end_day'].'","';
			$out .= $item['Item']['demension'].'","';
			$out .= $item['Item']['weight'].'","';
			if(!empty($item['Item']['unit'])){
				$out .= $unit[$item['Item']['unit']].'","';
			}else{
				$out .= '","';
			}
			if(!empty($item['Item']['order_approve'])){
				$out .= $order_approve[$item['Item']['order_approve']].'","';
			}else{
				$out .= '","';
			}
			if(!empty($item['Item']['cutom_order_approve'])){
				$out .= $cutom_order_approve[$item['Item']['cutom_order_approve']].'","';
			}else{
				$out .= '","';
			}
			$out .= $item['Item']['custom_order_days'].'","';
			$out .= $item['Item']['repair_days'].'","';
			if(!empty($item['Item']['trans_approve'])){
				$out .= $trans_approve[$item['Item']['trans_approve']].'","';
			}else{
				$out .= '","';
			}
			$out .= $item['Item']['in_chain'].'","';
			if(!empty($item['Item']['atelier_trans_approve'])){
				$out .= $atelier_trans_approve[$item['Item']['atelier_trans_approve']].'","';
			}else{
				$out .= '","';
			}
			$out .= $item['Item']['labor_cost'].'","';
			$out .= $item['Item']['supply_full_cost'].'","';
			$out .= $item['Item']['cost'].'","';
			if(!empty($item['Item']['percent_code'])){
				$out .= $percent_code[$item['Item']['percent_code']].'","';
			}else{
				$out .= '","';
			}
			if(!empty($item['Item']['sales_sum_code'])){
				$out .= $sales_sum_code[$item['Item']['sales_sum_code']].'","';
			}else{
				$out .= '","';
			}
			if(!empty($item['Item']['itemimage_id'])){
				$out .= $item['Item']['itemimage_id'].'.jpg","';
			}else{
				$out .= '","';
			}
			$out .= $item['Item']['pair_id'].'","';
			$out .= $item['Item']['title'].'","';
			if(!empty($item['Item']['itemtype'])){
				$out .= $itemtype[$item['Item']['itemtype']].'","';
			}else{
				$out .= '","';
			}
			$out .= $item['Item']['basic_size'].'","';
			$out .= $item['Item']['order_size'].'","';
			if(!empty($item['Item']['itemproperty'])){
				$out .= $itemproperty[$item['Item']['itemproperty']].'"';
			}else{
				$out .= '"';
			}
			$out .= "\r\n";
		}
		return $out;
	}


}

?>