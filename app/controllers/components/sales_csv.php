<?php
class SalesCsvComponent extends Object {
	
	//部門別売上集計してCSV出力
	//とりあえず直営店だけ
	function storeSales(){
		App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
   		$year = date('Y');
   		$month = date('m');
   		$day = date('d');
    	$days = $DateCalComponent->last_day($year, $month);
    	$d = 1;
    	
    	//はじめ//////////////////////////////////////売上金額
    	$rankings = array();
    	$out = '直営店売上集計,'.$year.'年'.$month.'月,'."\r\n";
    	$out .= '部門,';
    	while($days >= $d){
    		$out .= $d.'日,';
    		$d++;
    	}
		$out .= '店別合計'."\r\n";
		$sections = $SectionModel->amountSectionList();
		$total = array();
		$all_total = 0;
		foreach($sections as $section_id=>$section_name){
			$section_total = 0;
			$i = array();
			$amounts = $AmountSectionModel->markIndex($section_id, $year, $month);
			foreach($amounts['days'] as $day){
				@$total[$day['day']] = $total[$day['day']] + $day['sales_total'];
				$i[] = $day['sales_total'];
				$section_total = $section_total + $day['sales_total'];
				$all_total = $all_total + $day['sales_total'];
			}
			$out .= $section_name.',';
			$out .= implode(',', $i);
			$out .= ','.$section_total."\r\n";
			$rankings[$section_id] = $section_total;
		}
		$out .= '日計,';
		$out .= implode(',', $total);
		$out .= ','.$all_total."\r\n";
		$out .= "\r\n";
		$out .= '売上ランキング,';
		$out .= "\r\n";
		$out .= '部門,';
		arsort($rankings);
		foreach($rankings as $section_id=>$ranking){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '金額,';
		foreach($rankings as $section_id=>$ranking){
			$out .= $ranking.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($rankings as $section_id=>$ranking){
			$out .= $rank.',';
			$rank++;
		}
		
		
		$out .= "\r\n";
		$out .= "\r\n";
		////////////////////////////////////////客数
		$rankings = array();
		$out .= '直営店客数集計,'.$year.'年'.$month.'月,'."\r\n";
    	$out .= '部門,';
    	$days = $DateCalComponent->last_day($year, $month);
    	$d = 1;
    	while($days >= $d){
    		$out .= $d.'日,';
    		$d++;
    	}
		$out .= '店別合計'."\r\n";
		$sections = $SectionModel->amountSectionList();
		$total = array();
		$all_total = 0;
		foreach($sections as $section_id=>$section_name){
			$section_total = 0;
			$i = array();
			$amounts = $AmountSectionModel->markIndex($section_id, $year, $month);
			foreach($amounts['days'] as $day){
				@$total[$day['day']] = $total[$day['day']] + $day['guest_qty'];
				$i[] = $day['guest_qty'];
				$section_total = $section_total + $day['guest_qty'];
				$all_total = $all_total + $day['guest_qty'];
			}
			$out .= $section_name.',';
			$out .= implode(',', $i);
			$out .= ','.$section_total."\r\n";
			$rankings[$section_id] = $section_total;
		}
		
		$out .= '日計,';
		$out .= implode(',', $total);
		$out .= ','.$all_total."\r\n";
		$out .= "\r\n";
		$out .= '客数ランキング,';
		$out .= "\r\n";
		$out .= '部門,';
		arsort($rankings);
		foreach($rankings as $section_id=>$ranking){
			$out .= $sections[$section_id].',';
		}
		$out .= "\r\n";
		$out .= '客数,';
		foreach($rankings as $section_id=>$ranking){
			$out .= $ranking.',';
		}
		$out .= "\r\n";
		$out .= '順位,';
		$rank = 1;
		foreach($rankings as $section_id=>$ranking){
			$out .= $rank.',';
			$rank++;
		}
		
		$out .= "\r\n";
		$out .= "\r\n";
		////////////////////////////////////////ブランド集計
		App::import('Model', 'AmountBrand');
    	$AmountBrandModel = new AmountBrand();
    	App::import('Model', 'Brand');
    	$BrandModel = new Brand();
    	$brands = $BrandModel->find('list');
		
		$out .= 'ブランド別売上,'.$year.'年'.$month.'月,'."\r\n";
    	$out .= 'ブランド,';
    	$days = $DateCalComponent->last_day($year, $month);
    	$d = 1;
    	while($days >= $d){
    		$out .= $d.'日,';
    		$d++;
    	}
		$out .= '合計'."\r\n";
		
		$total = array();
		$all_total = 0;
		$amounts = $AmountBrandModel->markIndex($brands, $year, $month);
		foreach($brands as $brand_id=>$brand_name){
			$brand_total = 0;
			$out .= $brand_name.',';
			foreach($amounts as $day=>$amount){
				$out .= $amount[$brand_id]['sales'].',';
				$brand_total = $brand_total + $amount[$brand_id]['sales'];
			}
			$out .= $brand_total."\r\n";
		}
		
		
		$out .= "\r\n";
		$out .= "\r\n";
		////////////////////////////////////////店舗別
		$out .= '部門別集計,'.$year.'年'.$month.'月'.$day.'日,'."\r\n";
		$out .= "\r\n";
		$stock_qty = 0;
		$stock_price = 0;
    	$sections = $SectionModel->amountSectionList2();
    	foreach($sections as $section_id=>$section_name){
    		$out .= $section_name."\r\n";
    		$out_val = $AmountSectionModel->dayAmount($section_id);
    		$out .= $out_val['value'];
    		$stock_qty = $stock_qty + $out_val['out']['stock_qty'];
			$stock_price = $stock_price + $out_val['out']['stock_price'];
    		$out .= "\r\n";
    	}
		
		$out .= "\r\n";
		$out .= '全社合計'."\r\n";
		$out .= '在庫数,'.$stock_qty."\r\n";
		$out .= '在庫上代,'.$stock_price."\r\n";
		
		////////////////////////////////////////出力部
		$file_name = 'store_sales'.date('Ymd-His').'.csv';
		$path = WWW_ROOT.'/files/store_sales/';
		$output_csv = mb_convert_encoding($out, 'SJIS', 'UTF-8');
		file_put_contents($path.$file_name, $output_csv);
		
		
	}
	
	function inSales($file_name){
		ignore_user_abort(true);
		set_time_limit(0);
		ini_set('memory_limit', '512M');
		$path = WWW_ROOT.DS.'files'.DS.'prepare'.DS;

		App::import('Model', 'Item');
    	$ItemModel = new Item();
    	App::import('Model', 'Sale');
    	$SaleModel = new Sale();
    	App::import('Model', 'SalesDateil');
    	$SalesDateilModel = new SalesDateil();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Destination');
    	$DestinationModel = new Destination();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();

    	App::import('Component', 'StratCsv');
   		$StratCsvComponent = new StratCsvComponent();
   		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();

   		App::import('Model', 'AmountBrand');
    	$AmountBrandModel = new AmountBrand();
    	App::import('Model', 'AmountCompany');
    	$AmountCompanyModel = new AmountCompany();
    	App::import('Model', 'AmountDepot');
    	$AmountDepotModel = new AmountDepot();
    	App::import('Model', 'AmountDestination');
    	$AmountDestinationModel = new AmountDestination();
    	App::import('Model', 'AmountFactory');
    	$AmountFactoryModel = new AmountFactory();
    	App::import('Model', 'AmountItem');
    	$AmountItemModel = new AmountItem();
    	App::import('Model', 'AmountItemproperty');
    	$AmountItempropertyModel = new AmountItemproperty();
    	App::import('Model', 'AmountItemtype');
    	$AmountItemtypeModel = new AmountItemtype();
    	App::import('Model', 'AmountMajorSize');
    	$AmountMajorSizeModel = new AmountMajorSize();
    	App::import('Model', 'AmountMaterial');
    	$AmountMaterialModel = new AmountMaterial();
    	App::import('Model', 'AmountPair');
    	$AmountPairModel = new AmountPair();
    	App::import('Model', 'AmountProcess');
    	$AmountProcessModel = new AmountProcess();
    	App::import('Model', 'AmountSalesCode');
    	$AmountSalesCodeModel = new AmountSalesCode();
    	App::import('Model', 'AmountSalesStateCode');
    	$AmountSalesStateCodeModel = new AmountSalesStateCode();
    	App::import('Model', 'AmountSection');
    	$AmountSectionModel = new AmountSection();
    	App::import('Model', 'AmountStone');
    	$AmountStoneModel = new AmountStone();
    	App::import('Model', 'AmountUser');
    	$AmountUserModel = new AmountUser();

		$file_stream = file_get_contents($path.$file_name);
		$file_stream = mb_convert_encoding($file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
		unlink($path.$file_name);
		$rename_opne = fopen($path.$file_name, 'w');
		$result = fwrite($rename_opne, $file_stream);
		fclose($rename_opne);
		$file_open = fopen($path.$file_name, 'r');

		while($row = fgetcsv($file_open)){
			if($row[0] == '売上伝票No') continue;
			$item_name = trim($row[51]);
			$params = array(
				'conditions'=>array('Item.name'=>$item_name),
				'recursive'=>0,
			);
			$item = $ItemModel->find('first' ,$params);
			if(!$item){//itemが無かったら保存
				$item = '';
				//$sj12_zen = mb_convert_kana($row[58], 'K', 'UTF-8'); //新マスターダンプ対応のため、お蔵入り
				$item['Item']['stone_id'] = $StratCsvComponent->masterDump('Stone', $row[58]);//ルースのid
				$item['Item']['material_id'] = $StratCsvComponent->masterDump('Material', $row[56]);//マテリアルのid
				$item['Item']['price'] = floor($row[67]);//上代 切捨て整数化floor
				$item['Item']['cost'] = floor($row[71]);//在庫原価
				/*新マスターダンプ対応のため、お蔵入り
				if(!empty($row[62])){
					$pre_sj36 = mb_convert_kana($row[62], 'K', 'UTF-8');
				}else{
					$pre_sj36 = '';
				}
				*/
				$item['Item']['factory_id'] = $StratCsvComponent->masterDump('Factory', $row[62]);//工場のid
				$item['Item']['brand_id'] = $StratCsvComponent->masterDump('Brand', $row[60]);//ブランドのid
				$item['Item']['title'] = $row[49];
				if($item['Item']['brand_id'] == 10 or $item['Item']['brand_id'] == 11 or $item['Item']['brand_id'] == 12){
					$stock_code = 3;
				}else{
					$stock_code = 1;
				}
				$item['Item']['stock_code'] = $stock_code;
				$item['Item']['name'] = $item_name;
				$result = $ItemModel->save($item);
				if(!$result) $this->log('Item save error : item_name:'.$item_name, LOG_ERROR);
				$item['Item']['id'] = $ItemModel->getInsertID();
				$ItemModel->id = null;
			}

			$sale = array();
			$sale_dateil = array();
			$sale_id = '';
			$start_juge = true;
			$params = array(
				'conditions'=>array('Sale.old_system_no'=>$row[0]),
				'recursive'=>0,
			);
			$sale = $SaleModel->find('first' ,$params);
			if($sale){//old_noがあったら、次にdetailを探す。detailでもあったら無視する。
				$params = array(
					'conditions'=>array('and'=>array('SalesDateil.old_system_line'=>$row[1], 'SalesDateil.sale_id'=>$sale['Sale']['id'])),
					'recursive'=>0,
				);
				$sale_dateil = $SalesDateilModel->find('first' ,$params);
				if($sale_dateil) $start_juge = false;
			}
			if($StratCsvComponent->selectCustom($row[47])){//客注品番ははじく
				$start_juge = false;
			}
			if($start_juge){
				if(!$sale){ //saleが無ければ新規登録する
					//初めは全て請求済みにする。saleにold_system_noを設け、請求書を見ながら1つずつステータスを印刷済みに変えて請求書を発行する。
					if($row[3] == '卸売上'){
						$sale['Sale']['sale_type'] = '1';//卸売上
						$sale['Sale']['sale_status'] = '3';//請求済
					}elseif($row[3] == '卸返品'){
						$sale['Sale']['sale_type'] = '1';//卸売上
						$sale['Sale']['sale_status'] = '4';//赤伝
					}elseif($row[3] == '売上'){
						$sale['Sale']['sale_type'] = '2';//通常売上
						$sale['Sale']['sale_status'] = '7';//通常売上
					}elseif($row[3] == '売返'){
						$sale['Sale']['sale_type'] = '2';//通常売上
						$sale['Sale']['sale_status'] = '4';//赤伝
					}
					$params = array(
						'conditions'=>array('Depot.old_system_no'=>$row[4]),
						'recursive'=>0,
					);
					$depot = $DepotModel->find('first' ,$params);
					if(!$depot){//なかったらJOKERで
						$params = array(
							'conditions'=>array('Depot.id'=>1047),
							'recursive'=>0,
						);
						$depot = $DepotModel->find('first' ,$params);
					}
					$sale['Sale']['depot_id'] = $depot['Depot']['id'];
					if(!empty($row[40])){//得意先CDが入っていたら出荷先登録
						$destination_old_system_no = $row[40].'-'.$row[41];
						$params = array(
							'conditions'=>array('Destination.old_system_no'=>$destination_old_system_no),
							'recursive'=>0,
						);
						$destination = $DestinationModel->find('first' ,$params);
						if($destination){
							$sale['Sale']['destination_id'] = $destination['Destination']['id'];
							if(!empty($destination['Company']['user_id'])){
								$sale['Sale']['contact1'] = $destination['Company']['user_id'];
							}
						}else{
							$sale['Sale']['destination_id'] = '';
						}
					}else{
						$sale['Sale']['destination_id'] = '';
					}
					$sale['Sale']['date'] = $row[6];
					if(empty($sale['Sale']['contact1'])){
						$sale['Sale']['contact1'] = $StratCsvComponent->oldContact($row[10], $row[6]);
					}
					$sale['Sale']['contact2'] = $StratCsvComponent->oldContact($row[13], $row[6]);
					$sale['Sale']['contact3'] = $StratCsvComponent->oldContact($row[16], $row[6]);
					$sale['Sale']['contact4'] = $StratCsvComponent->oldContact($row[19], $row[6]);
					$total_moth = $StratCsvComponent->totalMoth($row, $sale['Sale']['sale_status']);
					$sale['Sale']['total'] = $total_moth['total'];
					$sale['Sale']['item_price_total'] = $total_moth['item_price_total'];
					$sale['Sale']['tax'] = $total_moth['tax'];
					$sale['Sale']['remark'] = $row[46];
					$sale['Sale']['old_system_no'] = $row[0];
				}else{//$saleがあったら金額を加算
					$total_moth = $StratCsvComponent->totalMoth($row, $sale['Sale']['sale_status']);
					$sale['Sale']['total'] = (int)$total_moth['total'] + (int)$sale['Sale']['total'];
					$sale['Sale']['item_price_total'] = (int)$total_moth['item_price_total'] + (int)$sale['Sale']['item_price_total'];
					$sale['Sale']['tax'] = (int)$total_moth['tax'] + (int)$sale['Sale']['tax'];
					$sale['Sale']['id'] = $sale['Sale']['id'];
				}
				$result = $SaleModel->save($sale);
				if(!$result) $this->log('Sales save error : sales_csv.php 123', LOG_ERROR);
				$sale_id = $SaleModel->getInsertID();
				$SaleModel->id = null;
				//詳細登録開始
				$sale_dateil['SalesDateil']['sale_id'] = $sale_id;
				$params = array(
					'conditions'=>array('Subitem.jan'=>$row[47]),
					'recursive'=>0,
				);
				$subitem = $SubitemModel->find('first' ,$params);
				if(!$subitem){
					$subitem = '';
					//子品番を新規登録
					$subitem['Subitem']['minority_size'] = '';
					$subitem['Subitem']['major_size'] = $StratCsvComponent->baseMajorSize(trim($row[52]));
					if($subitem['Subitem']['major_size'] == 'other'){
						$subitem['Subitem']['minority_size'] = trim($row[52]);
					}
					$subitem['Subitem']['item_id'] = $item['Item']['id'];
					$subitem['Subitem']['jan'] = $row[47];
					$subitem['Subitem']['name_kana'] = $row[58];
					$subitem['Subitem']['cost'] = floor($row[71]);
					$item_name = trim($row[51]);
					$subitem_sub_name = substr($row[52], 1, 2);
					$subitem['Subitem']['name'] = $StratCsvComponent->sjSubItemName($subitem_sub_name, $item_name);
					$SubitemModel->save($subitem);
					$subitem['Subitem']['id'] = $SubitemModel->getInsertID();
					$SubitemModel->id = null;
				}
				$size = $SelectorComponent->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
				$sale_dateil['SalesDateil']['item_id'] = $subitem['Subitem']['item_id'];
				$sale_dateil['SalesDateil']['subitem_id'] = $subitem['Subitem']['id'];
				$sale_dateil['SalesDateil']['size'] = $size;
				$sale_dateil['SalesDateil']['bid'] = $total_moth['bid'];
				$sale_dateil['SalesDateil']['bid_quantity'] = $total_moth['bid_quantity'];
				$sale_dateil['SalesDateil']['cost'] = $total_moth['cost'];
				$sale_dateil['SalesDateil']['tax'] = $total_moth['dateil_tax'];
				$sale_dateil['SalesDateil']['ex_bid'] = $total_moth['ex_bid'];
				$sale_dateil['SalesDateil']['old_system_line'] = $row[1];
				if($SalesDateilModel->save($sale_dateil)){
					$SalesDateilModel->id = null;
					$AmountBrandModel->csv($sale, $sale_dateil, $total_moth);
					$AmountCompanyModel->csv($sale, $sale_dateil, $total_moth);
					$AmountDepotModel->csv($sale, $sale_dateil, $total_moth);
					$AmountDestinationModel->csv($sale, $sale_dateil, $total_moth);
					$AmountFactoryModel->csv($sale, $sale_dateil, $total_moth);
					$AmountItemModel->csv($sale, $sale_dateil, $total_moth);
					$AmountItempropertyModel->csv($sale, $sale_dateil, $total_moth);
					$AmountItemtypeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountMajorSizeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountMaterialModel->csv($sale, $sale_dateil, $total_moth);
					$AmountPairModel->csv($sale, $sale_dateil, $total_moth);
					$AmountProcessModel->csv($sale, $sale_dateil, $total_moth);
					$AmountSalesCodeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountSalesStateCodeModel->csv($sale, $sale_dateil, $total_moth);
					$AmountSectionModel->csv($sale, $sale_dateil, $total_moth);
					$AmountStoneModel->csv($sale, $sale_dateil, $total_moth);
					$AmountUserModel->csv($sale, $sale_dateil, $total_moth);
				}else{
					$this->log('SalesDateil save error : prepare.php 183', LOG_ERROR);
					$SalesDateilModel->id = null;
				}
			}//strat_juge の終わり
		}//foreach終わり
		fclose($file_open);
		$result = unlink($path.$file_name);
		return memory_get_usage();
		//return $result;
	}

	//日付から年次、月次、週次、日次の範囲日付を返す
	function amountSpan($date, $key){
		$return = array();
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		if($key == 4){//日次
			$start_day = $date;
			$end_day = $date;
		}elseif($key == 3){//週次
			$this_week = $DateCalComponent->this_week($yyyy, $mm, $dd);
			$start_day = $this_week['start_day'];
			$end_day = $this_week['end_day'];
		}elseif($key == 2){//月次
			$month = (int)$mm;
			$last_day = $DateCalComponent->last_day($yyyy, $month);
			$start_day = $yyyy.$mm.'01';
			$end_day = $yyyy.$mm.$last_day;
		}elseif($key == 1){//年次
			$start_day = $yyyy.'0101';
			$end_day = $yyyy.'1231';
		}
		$return['start_day'] = str_replace('-', '', $start_day);
		$return['end_day'] = str_replace('-', '', $end_day);
		return $return;
	}

	//日付から前年、前月、前週、前日の範囲日付を返す
	function amountPrevSpan($date, $key){
		$return = array();
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		if($key == 4){//前日
			$start_day = $DateCalComponent->controll_day($date, 1);
			$end_day = $DateCalComponent->controll_day($date, 1);
		}elseif($key == 3){//前週
			$this_week = $DateCalComponent->this_week($yyyy, $mm, $dd);
			$start_day = $DateCalComponent->controll_day($this_week['start_day'], 7);
			$end_day = $DateCalComponent->controll_day($this_week['end_day'], 7);
		}elseif($key == 2){//前月
			$month = (int)$mm;
			$prev_month = $DateCalComponent->prev_month($yyyy, $month);
			$last_day = $DateCalComponent->last_day($prev_month['year'], $prev_month['month']);
			$start_day = $prev_month['year'].$prev_month['month'].'01';
			$end_day = $prev_month['year'].$prev_month['month'].$last_day;
		}elseif($key == 1){//前年
			$prev_year = (int)$yyyy -1;
			$start_day = $prev_year.'0101';
			$end_day = $prev_year.'1231';
		}
		$return['start_day'] = str_replace('-', '', $start_day);
		$return['end_day'] = str_replace('-', '', $end_day);
		return $return;
	}

	//日付から前年、前年同月、前年同週、前年同日の範囲日付を返す
	function amountPrevYear($date, $key){
		$return = array();
		App::import('Component', 'DateCal');
   		$DateCalComponent = new DateCalComponent();
		$date = str_replace('-', '', $date);
		$yyyy = substr($date, 0, 4);
		$mm = substr($date, 4, 2);
		$dd = substr($date, 6, 2);
		$prev_year = (int)$yyyy -1;
		if($key == 4){//前年同日
			$start_day = $prev_year.$mm.$dd;
			$end_day = $prev_year.$mm.$dd;
		}elseif($key == 3){//前年同週
			$this_week = $DateCalComponent->this_week($prev_year, $mm, $dd);
			$start_day = $this_week['start_day'];
			$end_day = $this_week['end_day'];
		}elseif($key == 2){//前年同月
			$month = (int)$mm;
			$last_day = $DateCalComponent->last_day($prev_year, $month);
			$start_day = $prev_year.$month.'01';
			$end_day = $prev_year.$month.$last_day;
		}elseif($key == 1){//前年
			$start_day = $prev_year.'0101';
			$end_day = $prev_year.'1231';
		}
		$return['start_day'] = str_replace('-', '', $start_day);
		$return['end_day'] = str_replace('-', '', $end_day);
		return $return;
	}

	//刻印品番かどうか？＿判断する
	function kokuin_juge($item){
		$juge = false;
		if($item == '9000000005006') $juge = true;
		if($item == '9000000006003') $juge = true;
		if($item == '9000000007000') $juge = true;
		if($item == '9000000008007') $juge = true;
		return $juge;
	}

	function cleaningkit_juge($item){
		$juge = false;
		if($item == '5000144390000') $juge = true;
		if($item == '5000144170008') $juge = true;
		if($item == '5000144180007') $juge = true;
		if($item == '5000109940004') $juge = true;
		if($item == '5000109930005') $juge = true;
		if($item == '5000144210001') $juge = true;
		if($item == '5000144200002') $juge = true;
		if($item == '5000144190006') $juge = true;
		return $juge;
	}

	//在庫移動プログラム　旧(型番別在庫.CSV)　→　新　古いやつ、基本的に使わない
	function inStock($path, $file_name){
		$old_system_no = $file_name;
		$file_name = $file_name.'.CSV';
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Item');
    	$ItemModel = new Item();
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		$is_depot = false;
		$params = array(
			'conditions'=>array('Depot.old_system_no'=>$old_system_no),
			'recursive'=>0
		);
		$is_depot = $DepotModel->find('first' ,$params);
		if($is_depot){
			$sj_file_stream = file_get_contents($path.$file_name);
			$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$sj_rename_opne = fopen($path.$file_name, 'w');
			$result = fwrite($sj_rename_opne, $sj_file_stream);
			fclose($sj_rename_opne);
			$sj_opne = fopen($path.$file_name, 'r');
			$csv_header = fgetcsv($sj_opne);
			while($sj_row = fgetcsv($sj_opne)){
				$StockModel->create();
				$subitem = array();
				$params = array(
					'conditions'=>array('Subitem.jan'=>$sj_row[8]),
					'recursive'=>0
				);
				$subitem = $SubitemModel->find('first' ,$params);
				if(!$subitem){//なかった場合
					$params = array(
						'conditions'=>array('Item.name'=>$sj_row[0]),
						'recursive'=>0
					);
					$item = $ItemModel->find('first' ,$params);
					if(!$item){//なかった場合
						$item = $ItemModel->NewItem($sj_row[0], $sj_row[7], $sj_row[5]);
					}
					$subitem = $SubitemModel->NewSubitem($item['Item']['id'], $sj_row[3], $sj_row[8], $sj_row[0]);
				}
				$qty = floor($sj_row[10]);
				$StockModel->Plus($subitem['Subitem']['id'], $is_depot['Depot']['id'], $qty, 1135, 2);
			}
			fclose($sj_opne);
			$result = unlink($path.$file_name);
			return memory_get_usage();
		}else{
			return 'not depot';
		}
	}
	
	//在庫移動プログラム　旧(ZAIKO.CSV)　→　新　こちらが新しい方、
	function inStock2($path, $file_name){
		$old_system_no = $file_name;
		$file_name = $file_name.'.CSV';
		App::import('Model', 'Depot');
    	$DepotModel = new Depot();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'Item');
    	$ItemModel = new Item();
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		$is_depot = false;
		$params = array(
			'conditions'=>array('Depot.old_system_no'=>$old_system_no),
			'recursive'=>0
		);
		$is_depot = $DepotModel->find('first' ,$params);
		if($is_depot){
			$sj_file_stream = file_get_contents($path.$file_name);
			$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
			$sj_rename_opne = fopen($path.$file_name, 'w');
			$result = fwrite($sj_rename_opne, $sj_file_stream);
			fclose($sj_rename_opne);
			$sj_opne = fopen($path.$file_name, 'r');
			$csv_header = fgetcsv($sj_opne);
			while($sj_row = fgetcsv($sj_opne)){
				$subitem_jan = trim($sj_row[2]);
				$subitem_size = trim($sj_row[6]);
				$item_name = trim($sj_row[5]);
				$item_title = trim($sj_row[3]);
				$item_brand = trim($sj_row[14]);
				$subitem_cost = floor($sj_row[19]);
				$subitem_kana = trim($sj_row[12]);
				$qty = floor($sj_row[17]);
				$stock_code = '';
				$StockModel->create();
				$subitem = array();
				$params = array(
					'conditions'=>array('Subitem.jan'=>$subitem_jan),
					'recursive'=>0
				);
				$subitem = $SubitemModel->find('first' ,$params);
				if(!$subitem){//なかった場合
					$params = array(
						'conditions'=>array('Item.name'=>$item_name),
						'recursive'=>-1,
					);
					$item = $ItemModel->find('first' ,$params);
					if(!$item){//なかった場合
						$item = $ItemModel->NewItem($item_name, $item_title, $item_brand);//品番、タイトル、ブランド名
					}
					$subitem = $SubitemModel->NewSubitem($item['Item']['id'], $subitem_size, $subitem_jan, $item_name, $subitem_kana);//item_id、サイズ、JAN、品番
				}
				if(!empty($subitem['Item']['stock_code'])) $stock_code = $subitem['Item']['stock_code'];
				if(!empty($item['Item']['stock_code'])) $stock_code = $item['Item']['stock_code'];
				if($stock_code == '3'){
					$save_value = array();
					$SubitemModel->create();
					$save_value['Subitem']['cost'] = $subitem_cost;
					$save_value['Subitem']['id'] = $subitem['Subitem']['id'];
					$SubitemModel->save($save_value);
				}
				$result = $StockModel->Plus($subitem['Subitem']['id'], $is_depot['Depot']['id'], $qty, 1135, 2);
				
			}
			fclose($sj_opne);
			$result = unlink($path.$file_name);
			return memory_get_usage();
		}else{
			return 'not depot';
		}
	}
	
	
	//コストが0以下だったら、CSVの原価を入れとく
	function reTryCost($path, $file_name){
		$file_name = $file_name.'.CSV';
		App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
   		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
		App::import('Model', 'Item');
    	$ItemModel = new Item();
		
		$sj_file_stream = file_get_contents($path.$file_name);
		$sj_file_stream = mb_convert_encoding($sj_file_stream, 'UTF-8', 'ASCII,JIS,EUC-JP,SJIS');
		$sj_rename_opne = fopen($path.$file_name, 'w');
		$result = fwrite($sj_rename_opne, $sj_file_stream);
		fclose($sj_rename_opne);
		$sj_opne = fopen($path.$file_name, 'r');
		$csv_header = fgetcsv($sj_opne);
		while($sj_row = fgetcsv($sj_opne)){
			$subitem_cost = floor($sj_row[19]);
			$subitem_jan = trim($sj_row[2]);
			$params = array(
				'conditions'=>array('Subitem.jan'=>$subitem_jan),
				'recursive'=>0
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$cost = $SelectorComponent->costSelector2($subitem['Subitem']['id']);
			if(empty($cost)){
				$save_value = array();
				$ItemModel->create();
				$save_value['Item']['cost'] = $subitem_cost;
				$save_value['Item']['id'] = $subitem['Item']['id'];
				$ItemModel->save($save_value);
			}
		}
		fclose($sj_opne);
		return unlink($path.$file_name);
	}



}
?>